<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Check for a successful database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém os dados do usuário da sessão
$user = $_SESSION['user'];
$id = $user['id'];
$nome = $user['nome'];
$sql = "
    SELECT c.nome AS curso, m.data_conclusao
    FROM matricula, historico_academico m
    JOIN curso c ON m.curso_id = c.id
    WHERE m.aluno_id = ?";
    
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $curso = $row['curso'];
    $data_conclusao = $row['data_conclusao'];
} else {
    // Tratar o caso onde não há matrícula encontrada
    $curso = "Curso não encontrado";
    $data_conclusao = "Data não encontrada";
}

// Incluir a biblioteca DomPDF
require '../../vendor/autoload.php'; // Use isso se instalou com Composer
use Dompdf\Dompdf;
use Dompdf\Options;

// Cria uma instância de DomPDF com configurações
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Para carregar imagens externas
$dompdf = new Dompdf($options);

// Função para gerar Certificado
function gerarCertificado($nome, $curso, $data_conclusao) {
    global $dompdf;

    $html = "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Certificado</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; margin: 0; font-family: 'Poppins', sans-serif; }
            .certificate-container { background: #fff; border: 4px solid #e4c38a; border-radius: 10px; width: 90%; max-width: 800px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); padding: 20px; overflow: hidden; position: relative; }
            .certificate-header { display: flex; align-items: flex-start; width: 100%; }
            .institution-logo { width: 60px; height: auto; margin: 0 auto 15px; display: block; }
            .institution-name { font-size: 24px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e4c38a; padding-bottom: 8px; margin-bottom: 20px; }
            .certificate-title { font-size: 32px; font-weight: 700; color: #d4af37; letter-spacing: 2px; text-transform: uppercase; margin: 15px 0; }
            .certificate-text { font-size: 16px; color: #555; margin: 8px 0; }
            .student-name, .course-name { font-size: 22px; font-weight: 600; text-transform: capitalize; margin: 12px 0; color: #0e0e0e; }
            .signature-section { display: flex; justify-content: space-around; align-items: center; margin-top: 15px; border-top: 1px solid #e4c38a; padding-top: 40px; }
            .signature { text-align: center; width: 150px; }
            .sign-line { width: 100%; border-bottom: 2px solid #333; margin-bottom: 8px; }
            .certificate-container::before { content: ''; position: absolute; top: -8px; left: -8px; right: -8px; bottom: -8px; border: 2px solid rgba(228, 195, 138, 0.5); z-index: -1; border-radius: 15px; }
        </style>
    </head>
    <body>
        <div class='certificate-container'>
            <div class='certificate-header'>
                <img src='../css/img/Group 4.png' alt='Institution Logo' class='institution-logo'>
                <h1 class='institution-name'>Instituição[Nome]</h1>
                <h2 class='certificate-title'>Certificado de Conclusão</h2>
                <p class='certificate-text'>Este certificado é concedido a</p>
                <h3 class='student-name'>$nome</h3>
                <p class='certificate-text'>por concluir com sucesso o curso de</p>
                <h3 class='course-name'>$curso</h3>
                <p class='certificate-text'>em $data_conclusao</p>
            </div>
            <div class='signature-section'>
                <div class='signature'>
                    <p class='sign-line'></p>
                    <p>Assinatura do Diretor</p>
                </div>
                <div class='signature'>
                    <p class='sign-line'></p>
                    <p>Assinatura do Aluno</p>
                </div>
            </div>
        </div>
    </body>
    </html>";

    // Carregar o HTML no DomPDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("certificado.pdf", ["Attachment" => false]); // Attachment => false para abrir no navegador
}

// Função para gerar Declaração de Matrícula
function gerarDeclaracaoMatricula($nome, $curso) {
    global $dompdf;

    $html = "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Declaração de Matrícula</title>
        <style>
            /* Estilos semelhantes aos do certificado */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; margin: 0; font-family: 'Poppins', sans-serif; }
            .certificate-container { background: #fff; border: 4px solid #e4c38a; border-radius: 10px; width: 90%; max-width: 800px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); padding: 20px; overflow: hidden; position: relative; }
            .institution-name { font-size: 24px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e4c38a; padding-bottom: 8px; margin-bottom: 20px; }
            .certificate-title { font-size: 32px; font-weight: 700; color: #d4af37; letter-spacing: 2px; text-transform: uppercase; margin: 15px 0; }
            .certificate-text { font-size: 16px; color: #555; margin: 8px 0; }
            .course-name { font-size: 22px; font-weight: 600; text-transform: capitalize; margin: 12px 0; color: #0e0e0e; }
            .signature-section { display: flex; justify-content: space-around; align-items: center; margin-top: 15px; border-top: 1px solid #e4c38a; padding-top: 40px; }
            .signature { text-align: center; width: 150px; }
            .sign-line { width: 100%; border-bottom: 2px solid #333; margin-bottom: 8px; }
        </style>
    </head>
    <body>
        <div class='certificate-container'>
            <h1 class='institution-name'>Instituição[Nome]</h1>
            <h2 class='certificate-title'>Declaração de Matrícula</h2>
            <p>Declaro que $nome está devidamente matriculado no curso de</p>
            <h3 class='course-name'>$curso</h3>
            <p>e encontra-se em situação regular.</p>
            <div class='signature-section'>
                <div class='signature'>
                    <p class='sign-line'></p>
                    <p>Assinatura do Diretor</p>
                </div>
            </div>
        </div>
    </body>
    </html>";

    // Carregar o HTML no DomPDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("declaracao_matricula.pdf", ["Attachment" => false]);
}

// Função para gerar Declaração de Frequência
function gerarDeclaracaoFrequencia($nome, $curso) {
    global $dompdf;

    $html = "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Declaração de Frequência</title>
        <style>
            /* Estilos semelhantes aos anteriores */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5; margin: 0; font-family: 'Poppins', sans-serif; }
            .certificate-container { background: #fff; border: 4px solid #e4c38a; border-radius: 10px; width: 90%; max-width: 800px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); padding: 20px; overflow: hidden; position: relative; }
            .institution-name { font-size: 24px; font-weight: 700; color: #333; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e4c38a; padding-bottom: 8px; margin-bottom: 20px; }
            .certificate-title { font-size: 32px; font-weight: 700; color: #d4af37; letter-spacing: 2px; text-transform: uppercase; margin: 15px 0; }
            .certificate-text { font-size: 16px; color: #555; margin: 8px 0; }
            .course-name { font-size: 22px; font-weight: 600; text-transform: capitalize; margin: 12px 0; color: #0e0e0e; }
            .signature-section { display: flex; justify-content: space-around; align-items: center; margin-top: 15px; border-top: 1px solid #e4c38a; padding-top: 40px; }
            .signature { text-align: center; width: 150px; }
            .sign-line { width: 100%; border-bottom: 2px solid #333; margin-bottom: 8px; }
        </style>
    </head>
    <body>
        <div class='certificate-container'>
            <h1 class='institution-name'>Instituição[Nome]</h1>
            <h2 class='certificate-title'>Declaração de Frequência</h2>
            <p>Declaro que $nome está frequentando o curso de</p>
            <h3 class='course-name'>$curso</h3>
            <p>e possui a frequência regular.</p>
            <div class='signature-section'>
                <div class='signature'>
                    <p class='sign-line'></p>
                    <p>Assinatura do Diretor</p>
                </div>
            </div>
        </div>
    </body>
    </html>";

    // Carregar o HTML no DomPDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("declaracao_frequencia.pdf", ["Attachment" => false]);
}

// Exemplo de uso
// Para gerar um certificado, declaração de matrícula ou declaração de frequência, chame a função correspondente
gerarCertificado($nome, $curso, $data_conclusao); // Altere a função conforme necessário
//gerarDeclaracaoMatricula($nome, $curso);
//gerarDeclaracaoFrequencia($nome, $curso);
?>

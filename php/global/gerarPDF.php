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
$stmt->bind_param("i", $id);
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

// Incluir a biblioteca TCPDF
require_once('../../vendor/autoload.php');
use TCPDF;

// Função para gerar o PDF do certificado usando TCPDF
function gerarCertificado($nome, $curso, $data_conclusao) {
    $pdf = new TCPDF();
    $pdf->AddPage();
    
    $html = "
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; }
        .certificate-container { border: 4px solid #e4c38a; padding: 20px; }
        .certificate-title { font-size: 24px; color: #d4af37; font-weight: bold; }
        .student-name { font-size: 20px; font-weight: bold; color: #333; }
        .course-name { font-size: 18px; font-weight: normal; color: #555; }
        .signature-section { margin-top: 30px; display: flex; justify-content: space-between; }
        .signature { text-align: center; width: 150px; }
        .sign-line { border-top: 1px solid #333; }
    </style>
    <div class='certificate-container'>
        <h1 class='certificate-title'>Certificado de Conclusão</h1>
        <p>Este certificado é concedido a</p>
        <h2 class='student-name'>$nome</h2>
        <p>por concluir com sucesso o curso de</p>
        <h3 class='course-name'>$curso</h3>
        <p>em $data_conclusao</p>
        <div class='signature-section'>
            <div class='signature'>
                <div class='sign-line'></div>
                <p>Assinatura do Diretor</p>
            </div>
            <div class='signature'>
                <div class='sign-line'></div>
                <p>Assinatura do Aluno</p>
            </div>
        </div>
    </div>";

    // Carregar o conteúdo HTML no TCPDF
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('certificado.pdf', 'I'); // 'I' para abrir no navegador
}

// Função para gerar o PDF da Declaração de Matrícula usando TCPDF
function gerarDeclaracaoMatricula($nome, $curso) {
    $pdf = new TCPDF();
    $pdf->AddPage();

    $html = "
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; }
        .certificate-container { border: 4px solid #e4c38a; padding: 20px; }
        .certificate-title { font-size: 24px; color: #d4af37; font-weight: bold; }
        .student-name { font-size: 20px; font-weight: bold; color: #333; }
        .course-name { font-size: 18px; font-weight: normal; color: #555; }
        .signature { text-align: center; margin-top: 50px; }
        .sign-line { border-top: 1px solid #333; width: 100px; margin: 0 auto; }
    </style>
    <div class='certificate-container'>
        <h1 class='certificate-title'>Declaração de Matrícula</h1>
        <p>Declaro que <strong>$nome</strong> está devidamente matriculado no curso de</p>
        <h3 class='course-name'>$curso</h3>
        <p>e encontra-se em situação regular.</p>
        <div class='signature'>
            <div class='sign-line'></div>
            <p>Assinatura do Diretor</p>
        </div>
    </div>";

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('declaracao_matricula.pdf', 'I');
}

// Função para gerar o PDF da Declaração de Frequência usando TCPDF
function gerarDeclaracaoFrequencia($nome, $curso) {
    $pdf = new TCPDF();
    $pdf->AddPage();

    $html = "
    <style>
        body { font-family: 'Poppins', sans-serif; text-align: center; }
        .certificate-container { border: 4px solid #e4c38a; padding: 20px; }
        .certificate-title { font-size: 24px; color: #d4af37; font-weight: bold; }
        .student-name { font-size: 20px; font-weight: bold; color: #333; }
        .course-name { font-size: 18px; font-weight: normal; color: #555; }
        .signature { text-align: center; margin-top: 50px; }
        .sign-line { border-top: 1px solid #333; width: 100px; margin: 0 auto; }
    </style>
    <div class='certificate-container'>
        <h1 class='certificate-title'>Declaração de Frequência</h1>
        <p>Declaro que <strong>$nome</strong> está frequentando o curso de</p>
        <h3 class='course-name'>$curso</h3>
        <p>e possui a frequência regular.</p>
        <div class='signature'>
            <div class='sign-line'></div>
            <p>Assinatura do Diretor</p>
        </div>
    </div>";

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('declaracao_frequencia.pdf', 'I');
}
gerarDeclaracaoFrequencia($nome, $curso);
gerarDeclaracaoMatricula($nome, $curso);
gerarCertificado($nome, $curso, $data_conclusao);


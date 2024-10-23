<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Certifique-se de que o PHPMailer esteja configurado corretamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome = $_POST['nome-completo'];
    $telefone = $_POST['telefone'];
    $emailAluno = $_POST['email'];
    $rm = $_POST['rm'];
    $curso = $_POST['curso'];
    $mensagem = $_POST['mensagem'];

    // Verificar se o arquivo foi enviado
    $arquivo = $_FILES['arquivo']['tmp_name'] ?? null;

    // Configurações do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'arthurhenriquegoesrodrigues@gmail.com'; // Atualize com seu email
        $mail->Password   = 'Arthur11.';          // Atualize com sua senha ou senha de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remetente
        $mail->setFrom($emailAluno, $nome);

        // Conectar ao banco de dados
        $conn = new mysqli('localhost', 'root', '', 'sam');
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Capturar e-mails do diretor e coordenador
        $emails = [];

        // Buscar e-mails da tabela diretor
        $sqlDiretor = "SELECT email FROM diretor";
        $resultDiretor = $conn->query($sqlDiretor);
        if ($resultDiretor->num_rows > 0) {
            while ($row = $resultDiretor->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        }

        // Buscar e-mails da tabela coordenador
        $sqlCoordenador = "SELECT email FROM coordenador";
        $resultCoordenador = $conn->query($sqlCoordenador);
        if ($resultCoordenador->num_rows > 0) {
            while ($row = $resultCoordenador->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        }

        // Adicionar os destinatários
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        // Adicionar o arquivo se houver
        if ($arquivo) {
            $mail->addAttachment($arquivo, $_FILES['arquivo']['name']);
        }

        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = 'Solicitação de ajuda acadêmica';
        $mail->Body    = "
            <h3>Solicitação de Ajuda do Aluno</h3>
            <p><strong>Nome:</strong> $nome</p>
            <p><strong>Telefone:</strong> $telefone</p>
            <p><strong>Email:</strong> $emailAluno</p>
            <p><strong>RM:</strong> $rm</p>
            <p><strong>Curso:</strong> $curso</p>
            <p><strong>Mensagem:</strong> $mensagem</p>
        ";

        // Enviar o email
        $mail->send();
        echo "<script>
            alert('Sua solicitação foi enviada com sucesso.');
            window.location.href = '../../pages/aluno/suporte.php';
        </script>";
    } catch (Exception $e) {
        echo "<script>
            alert('Erro ao enviar a solicitação. Tente novamente.');
            window.location.href = '../../pages/aluno/suporte.php';
        </script>";
    }
}

<?php
// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Certifique-se de que o PHPMailer esteja configurado corretamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome = isset($_POST['nome-completo']) ? $_POST['nome-completo'] : '';
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $emailAluno = isset($_POST['email']) ? $_POST['email'] : '';
    $rm = isset($_POST['rm']) ? $_POST['rm'] : '';
    $curso = isset($_POST['curso']) ? $_POST['curso'] : '';
    $mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : '';

    // Verificar se o arquivo foi enviado e se há erros
    $arquivo = $_FILES['arquivo']['tmp_name'] ?? null;
    if ($arquivo && $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        die('Erro ao fazer upload do arquivo.');
    }

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

        // Capturar e-mails de diretores e coordenadores da tabela usuarios
        $emails = [];

        // Buscar e-mails dos diretores e coordenadores
        $sqlUsuarios = "SELECT email FROM usuarios WHERE cargo IN ('diretor', 'coordenador')";
        $resultUsuarios = $conn->query($sqlUsuarios);

        // Verificação para garantir que a consulta retornou e-mails
        if ($resultUsuarios && $resultUsuarios->num_rows > 0) {
            while ($row = $resultUsuarios->fetch_assoc()) {
                $emails[] = $row['email'];
            }
        } else {
            throw new Exception('Nenhum e-mail encontrado para diretores ou coordenadores.');
        }

        // Verificar se há e-mails para enviar
        if (empty($emails)) {
            throw new Exception('Não há e-mails de destinatários para enviar a solicitação.');
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
        // Capturar e exibir o erro específico
        echo "<script>
            alert('Erro: " . $e->getMessage() . "');
            window.location.href = '../../pages/aluno/suporte.php';
        </script>";
    }
}

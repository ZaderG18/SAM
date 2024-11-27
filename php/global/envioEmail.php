<?php
// Incluir o autoload do Composer
require 'vendor/autoload.php';

// Criar uma nova instância do PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();

try {
    // Configurações do servidor SMTP
    $mail->isSMTP(); // Definindo que usaremos o SMTP
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Gmail
    $mail->SMTPAuth = true; // Habilita autenticação SMTP
    $mail->Username = 'seuemail@gmail.com'; // Seu e-mail
    $mail->Password = 'suasenha'; // Sua senha (ou senha de aplicativo)
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // Criptografia TLS
    $mail->Port = 587; // Porta para SMTP com TLS

    // Remetente e destinatário
    $mail->setFrom('seuemail@gmail.com', 'Seu Nome'); // Defina o seu e-mail e nome
    $mail->addAddress('destinatario@dominio.com', 'Nome do Destinatário'); // Defina o e-mail do destinatário

    // Conteúdo do e-mail
    $mail->isHTML(true); // Define que o conteúdo será em HTML
    $mail->Subject = 'Assunto do E-mail'; // Assunto do e-mail
    $mail->Body    = 'Este é o corpo do e-mail <b>em HTML</b>'; // Corpo do e-mail em HTML
    $mail->AltBody = 'Este é o corpo do e-mail em formato texto simples'; // Corpo do e-mail em texto simples

    // Enviar e-mail
    if ($mail->send()) {
        echo 'E-mail enviado com sucesso!';
    } else {
        echo 'Erro ao enviar e-mail: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Erro ao enviar o e-mail: ', $mail->ErrorInfo;
}
?>

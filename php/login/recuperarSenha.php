<?php
// Declarando variáveis para conectar ao banco de dados.
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao servidor MySQL com MySQLi.
$conn = new mysqli($host, $username, $password, $dbName);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para enviar e-mails
function enviarEmailRecuperacao($email, $token) {
    $reset_link = "http://localhost/SAM/pages/login/ResetarSenha.php?token=" . $token;
    mail($email, "Redefinir sua senha", "Clique aqui para redefinir sua senha: $reset_link");
}

$tables = ['aluno', 'professor', 'coordenador', 'diretor'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $found = false; // Para verificar se encontramos o e-mail em alguma tabela

        foreach ($tables as $table) {
            // Verifica se o e-mail existe na tabela atual
            $stmt = $conn->prepare("SELECT id FROM $table WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $found = true;
                // Se o e-mail foi encontrado, gera o token e atualiza
                $token = bin2hex(random_bytes(50));
                $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

                // Atualiza o banco de dados com o token e a data de expiração
                $stmt = $conn->prepare("UPDATE $table SET reset_token = ?, reset_expires = ? WHERE email = ?");
                $stmt->bind_param("sss", $token, $expires_at, $email);
                $stmt->execute();

                // Envia o e-mail com o link para redefinição de senha
                enviarEmailRecuperacao($email, $token);
                echo "<script> alert('Um e-mail foi enviado com as instruções para redefinir sua senha.');
                window.location.href='../../pages/login/EsqueceuSenha.html'; </script>";
                break; // Não precisa continuar verificando outras tabelas
            }
        }

        if (!$found) {
            echo "<script> alert('E-mail não encontrado!');
            window.location.href='../../pages/login/EsqueceuSenha.html'; </script>";
        }
    } elseif (isset($_POST['token']) && isset($_POST['new_password'])) {
        $token = $_POST['token'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        foreach ($tables as $table) {
            // Verifica se o token é válido e se ainda não expirou
            $stmt = $conn->prepare("SELECT id FROM $table WHERE reset_token = ? AND reset_expires > NOW()");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Atualiza a senha e remove o token e data de expiração
                $stmt = $conn->prepare("UPDATE $table SET senha = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
                $stmt->bind_param("ss", $new_password, $token);
                $stmt->execute();

                echo "<script> alert('Senha redefinida com sucesso!').window.location.href = '../../pages/login/checkpass.html';</script>";
                break; // Senha redefinida com sucesso
            }
        }

        echo "<script> alert('Link de redefinição inválido ou expirado.').window.location.href = '../../pages/login/checkpass.html';</script>";
    }
}
?>

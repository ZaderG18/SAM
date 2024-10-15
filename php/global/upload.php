<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações de conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID do usuário está na sessão
if (!isset($_SESSION['user']['id'])) {
    die("Usuário não autenticado.");
}

$user = $_SESSION['user'];
$id = $user['id']; // ID do usuário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Filtrando os dados de entrada
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $genero = filter_var($_POST['genero'], FILTER_SANITIZE_STRING);
    $estado_civil = filter_var($_POST['estado_civil'], FILTER_SANITIZE_STRING);
    $data_nascimento = filter_var($_POST['data_nascimento'], FILTER_SANITIZE_STRING);
    $nacionalidade = filter_var($_POST['nacionalidade'], FILTER_SANITIZE_STRING);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_STRING);
    $RM = filter_var($_POST['RM'], FILTER_SANITIZE_STRING);
    $curso = filter_var($_POST['curso'], FILTER_SANITIZE_STRING);
    $nome_emergencia = filter_var($_POST['nome_emergencia'], FILTER_SANITIZE_STRING);
    $parentesco_emergencia = filter_var($_POST['parentesco_emergencia'], FILTER_SANITIZE_STRING);
    $telefone_emergencia = filter_var($_POST['telefone_emergencia'], FILTER_SANITIZE_STRING);
    $email_emergencia = filter_var($_POST['email_emergencia'], FILTER_SANITIZE_EMAIL);

    // Verifica se todos os campos obrigatórios estão preenchidos
    if (!empty($nome) && !empty($telefone) && !empty($email) && !empty($genero) && !empty($estado_civil) && !empty($data_nascimento) && !empty($nacionalidade) && !empty($endereco) && !empty($curso)) {
        // Atualiza os dados do aluno
        $sql = "UPDATE aluno SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ?, estado_civil = ?, nome_emergencia = ?, parentesco_emergencia = ?, telefone_emergencia = ?, email_emergencia = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssssi", $nome, $telefone, $email, $endereco, $curso, $data_nascimento, $genero, $estado_civil, $nome_emergencia, $parentesco_emergencia, $telefone_emergencia, $email_emergencia, $id);

        if ($stmt->execute()) {
            echo "<script> alert('Dados do aluno atualizados com sucesso!');</script>";
        } else {
            echo "<script> alert('Erro ao atualizar os dados do aluno: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script> alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }

    // Processa o upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTemp = file_get_contents($_FILES['foto']['tmp_name']);
        $fotoTipo = mime_content_type($_FILES['foto']['tmp_name']);

        // Valida o tipo de arquivo (apenas imagens permitidas)
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fotoTipo, $tiposPermitidos)) {
            // Atualiza o campo 'foto' no banco de dados com o conteúdo binário
            $sqlFoto = "UPDATE aluno SET foto = ?, foto_tipo = ? WHERE id = ?";
            $stmtFoto = $conn->prepare($sqlFoto);
            $stmtFoto->bind_param("bsi", $fotoTemp, $fotoTipo, $id);

            if ($stmtFoto->execute()) {
                echo "<script> alert('Foto do aluno atualizada com sucesso!');</script>";
            } else {
                echo "<script> alert('Erro ao atualizar a foto do aluno: " . $stmtFoto->error . "');</script>";
            }
            $stmtFoto->close();
        } else {
            echo "<script> alert('Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.');</script>";
        }
    }

    // Redireciona a página para evitar reenvio do formulário
    echo "<script>setTimeout(function() { window.location.href = '../../pages/aluno/configuracoes.php'; }, 2000);</script>";
}
?>

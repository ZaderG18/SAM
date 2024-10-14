<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$id = $user['id']; // ID do usuário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $curso = $_POST['curso'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];

    // Atualiza os dados do aluno
    $sql = "UPDATE aluno SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nome, $telefone, $email, $endereco, $curso, $data_nascimento, $genero, $id);

    if ($stmt->execute()) {
        echo "<script> alert('Dados do aluno atualizados com sucesso!');</script>";
    } else {
        echo "<script> alert('Erro ao atualizar os dados do aluno: " . $stmt->error . "');</script>";
    }

    // Processa o upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = '../../assets/img/uploads/';

        // Verifica se o diretório existe, caso contrário, cria
        if (!is_dir($fotoPasta)) {
            mkdir($fotoPasta, 0777, true);
        }

        // Valida o tipo de arquivo (apenas imagens)
        $fotoTipo = mime_content_type($fotoTemp);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fotoTipo, $tiposPermitidos)) {
            // Gera um nome único para a foto
            $fotoNovoNome = uniqid() . '_' . $fotoNome;
            $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;

            // Move a foto para o diretório
            if (move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                // Atualiza o campo 'foto' no banco de dados
                $sqlFoto = "UPDATE aluno SET foto = ? WHERE id = ?";
                $stmtFoto = $conn->prepare($sqlFoto);
                $stmtFoto->bind_param("si", $fotoNovoNome, $id);

                if ($stmtFoto->execute()) {
                    echo "<script> alert('Foto do aluno atualizada com sucesso!');</script>";
                } else {
                    echo "<script> alert('Erro ao atualizar a foto do aluno: " . $stmtFoto->error . "');</script>";
                }
                $stmtFoto->close();
            } else {
                echo "<script> alert('Erro no upload da foto.');</script>";
            }
        } else {
            echo "<script> alert('Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.');</script>";
        }
    }

    // Após tudo, redireciona a página
    echo "<script> window.location.href = '../../pages/aluno/configuracoes.php'; </script>";

    $stmt->close();
}

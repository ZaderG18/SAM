<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Falha em fazer a conexão". $conn->connect_error);
}

if (isset($_POST["submit"])){
    if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK){
        $foto = file_get_contents($_FILES["foto"]["tpm_name"]);

        $userId = $_SESSION['user_id'];
        $sql = "INSERT INTO fotos (foto, user_id) VALUES ('$foto', '$userId')";

        $stmt =  $conn->prepare($sql);
$stmt->bind_param("bi",$foto, $userId);

if ($stmt->execute()) {
    echo "<script>
        alert('Foto de perfil atualizada com sucesso!');
        window.location.href = '../pages/aluno/configuracoes.php';
        </script>
    ";
}
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
   // $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : null;
    $curso = isset($_POST['curso']) ? $_POST['curso'] : null;
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;

    // Prepara o SQL para atualizar os dados do aluno
    $sql = "UPDATE aluno 
            SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $nome,  $telefone, $email, $endereco, $curso, $data_nascimento, $genero, $id);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "Dados do aluno atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados do aluno: " . $stmt->error;
    }

    // Fecha a declaração e conexão
    $stmt->close();
    $conn->close();
}

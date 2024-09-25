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
        window.location.href = '../../pages/aluno/configuracoes.php';
        </script>
    ";
}
    }
}
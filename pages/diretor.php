<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once '../php/funcao.php';
$user = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../scss/home.scss">
</head>
<body>
    
</body>
</html>
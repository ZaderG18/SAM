<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$user = $_SESSION['user'] ?? null;
$id = $user['id'] ?? null;

if ($id === null) {
    die("User ID is not set");
}

try {
    $sql = "SELECT foto FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fotoNome);
    $stmt->fetch();
    $stmt->close();

    $fotoCaminho = !empty($fotoNome) ? "../../assets/img/uploads/" . $fotoNome : "../../assets/img/logo.jpg";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
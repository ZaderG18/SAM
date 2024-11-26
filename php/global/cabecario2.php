<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}

// Inicia a sessão, se ainda não iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
$id = $user['id'];

// ** Recupera a foto do usuário ** //
$sqlFoto = "SELECT foto FROM usuarios WHERE id = ?"; // Ajuste a tabela conforme necessário
$stmtFoto = $conn->prepare($sqlFoto);

if (!$stmtFoto) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

// Associa o ID e executa a consulta
$stmtFoto->bind_param("i", $id);
$stmtFoto->execute();
$stmtFoto->bind_result($fotoNome);
$stmtFoto->fetch();
$stmtFoto->close();

// Define o caminho da foto ou uma imagem padrão
if (!empty($fotoNome)) {
    $fotoCaminho = "../../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../../assets/img/logo.jpg"; // Imagem padrão
}

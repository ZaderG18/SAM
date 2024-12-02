<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";

$conn = new mysqli($host, $username, $password, $dbname);

// Configuração de charset para evitar problemas com caracteres especiais
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

function obterNotificacoes($conn, $userId, $apenasNaoLidas = false) {
    $sql = "SELECT id, titulo, mensagem, data_criacao, lida, imagem, link 
            FROM notificacoes 
            WHERE user_id = ?";
    
    if ($apenasNaoLidas) {
        $sql .= " AND lida = 0";
    }
    
    $sql .= " ORDER BY data_criacao DESC";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        die("Erro na execução da consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $notificacoes = [];
    
    while ($row = $result->fetch_assoc()) {
        $notificacoes[] = $row;
    }
    
    $stmt->close();
    return $notificacoes;
}
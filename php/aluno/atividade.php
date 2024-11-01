<?php
// Configurações de conexão
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o ID da atividade foi passado pela URL ou formulário
if (isset($_GET['atividade_id'])) {
    $atividade_id = intval($_GET['atividade_id']);

    // Consulta a atividade específica
    $sql = "SELECT titulo, data_vencimento, hora_vencimento, descricao FROM atividade WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $atividade_id);
    $stmt->execute();
    $stmt->bind_result($titulo, $data_vencimento, $hora_vencimento, $descricao);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "ID da atividade não fornecido.";
    exit;
}

// Formatação das datas, caso seja necessário
$data_vencimento_formatada = date("d de F de Y", strtotime($data_vencimento));
?>
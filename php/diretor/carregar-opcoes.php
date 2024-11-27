<?php
$enquete_id = isset($_GET['enquete_id']) ? (int) $_GET['enquete_id'] : 0;

if ($enquete_id > 0) {
    $conn = new mysqli('localhost', 'root', '', 'enquetes');

    if ($conn->connect_error) {
        die("Erro ao conectar: " . $conn->connect_error);
    }

    $sql = "SELECT id, texto FROM opcoes WHERE enquete_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquete_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $opcoes = [];
    while ($row = $result->fetch_assoc()) {
        $opcoes[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($opcoes);
}
?>

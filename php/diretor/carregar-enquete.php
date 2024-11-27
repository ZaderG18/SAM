<?php
header('Content-Type: application/json');

$enquete_id = isset($_GET['enquete_id']) ? (int) $_GET['enquete_id'] : 0;

if ($enquete_id > 0) {
    $conn = new mysqli('localhost', 'root', '', 'samm');

    if ($conn->connect_error) {
        echo json_encode(["error" => "Erro ao conectar ao banco de dados."]);
        exit;
    }

    // Busca a enquete
    $sql = "SELECT titulo, descricao FROM enquetes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquete_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $enquete = $result->fetch_assoc();

    if ($enquete) {
        // Busca as opções da enquete
        $sql = "SELECT id, texto FROM opcoes WHERE enquete_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $enquete_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $opcoes = [];
        while ($row = $result->fetch_assoc()) {
            $opcoes[] = $row;
        }

        $enquete['opcoes'] = $opcoes;
        echo json_encode($enquete);
    } else {
        echo json_encode(["error" => "Enquete não encontrada."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "ID da enquete inválido."]);
}
?>

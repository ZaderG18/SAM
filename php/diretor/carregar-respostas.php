<?php
header('Content-Type: application/json');

// Verifica se o ID da enquete foi passado
$enquete_id = isset($_GET['enquete_id']) ? (int) $_GET['enquete_id'] : 0;

if ($enquete_id > 0) {
    $conn = new mysqli('localhost', 'root', '', 'samm');

    if ($conn->connect_error) {
        echo json_encode(["error" => "Erro ao conectar ao banco de dados."]);
        exit;
    }

    // Busca enquete
    $sql = "SELECT titulo, descricao FROM enquetes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $enquete = $result->fetch_assoc();

    if ($enquete) {
        // Busca opções e votos
        $sql = "SELECT o.id, o.texto, COUNT(r.opcao_id) AS votos 
                FROM opcoes o 
                LEFT JOIN respostas r ON o.id = r.opcao_id 
                WHERE o.enquete_id = ? 
                GROUP BY o.id";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $enquete_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $opcoes = [];
        while ($row = $result->fetch_assoc()) {
            // Busca usuários que votaram nesta opção
            $sqlUsuarios = "SELECT u.nome 
                            FROM respostas r 
                            JOIN usuarios u ON r.usuario_id = u.id 
                            WHERE r.opcao_id = ?";
            $stmtUsuarios = $conn->prepare($sqlUsuarios);
            $stmtUsuarios->bind_param("i", $row['id']);
            $stmtUsuarios->execute();
            $resultUsuarios = $stmtUsuarios->get_result();

            $usuarios = [];
            while ($usuario = $resultUsuarios->fetch_assoc()) {
                $usuarios[] = $usuario['nome'];
            }

            $row['usuarios'] = $usuarios;
            $opcoes[] = $row;
        }

        // Busca comentários
        $sql = "SELECT u.nome AS usuario, c.texto 
                FROM comentarios c 
                JOIN usuarios u ON c.usuario_id = u.id 
                WHERE c.enquete_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $enquete_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comentarios = [];
        while ($row = $result->fetch_assoc()) {
            $comentarios[] = $row;
        }

        $enquete['opcoes'] = $opcoes;
        $enquete['comentarios'] = $comentarios;

        echo json_encode($enquete);
    } else {
        echo json_encode(["error" => "Enquete não encontrada."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "ID da enquete inválido."]);
}

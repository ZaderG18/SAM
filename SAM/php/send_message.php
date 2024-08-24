<?php
session_start();
include('processamento.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user_id'];
    $receptor_id = $_POST['receptor_id'];
    $mensagem = $_POST['mensagem'];

    if (empty($mensagem)) {
        echo json_encode(['sucesso' => false, 'messagem' => 'A mensagem não pode estar vazia']);
        exit;
    }

    $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id);

    if ($stmt->execute()) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'messagem' => 'Erro ao enviar a mensagem']);
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
include('processamento.php'); // Certifique-se de que este arquivo faz a conexão com o banco de dados.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user_id']; // ID do remetente
    $receptor_id = $_POST['receptor_id']; // Corrigido: o operador `-` foi substituído por `=`
    $mensagem = $_POST['mensagem'];

    // Verificar se a mensagem e o receptor_id não estão vazios
    if (!empty($mensagem) && !empty($receptor_id)) {
        $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id);
        if ($stmt->execute()) {
            echo "Mensagem enviada com sucesso!";
        } else {
            echo "Erro ao enviar a mensagem: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Mensagem ou receptor não pode ser vazio!";
    }
}

$usuario_atual_id = $_SESSION['user_id'];

$sql = "SELECT mensagens_chat.mensagem, usuarios.username
        FROM mensagens_chat
        JOIN usuarios ON mensagens_chat.user_id = usuarios.id
        WHERE mensagens_chat.receptor_id = ? OR mensagens_chat.user_id = ?
        ORDER BY mensagens_chat.data_envio DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_atual_id, $usuario_atual_id);
$stmt->execute();
$result = $stmt->get_result();

$mensagens = [];
while ($row = $result->fetch_assoc()) {
    $mensagens[] = $row;
}
echo json_encode($mensagens);
header('Location:../mensagens.html');
?>

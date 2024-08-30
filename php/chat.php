<?php
// Inclui o arquivo 'processamento.php' que deve estabelecer a conexão com o banco de dados.
include('processamento.php'); 

// Verifica se o método de solicitação é POST.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user_id']; // Obtém o ID do usuário que está enviando a mensagem da sessão.
    $receptor_id = $_POST['receptor_id']; // Obtém o ID do receptor da mensagem a partir do POST.
    $mensagem = $_POST['mensagem']; // Obtém o conteúdo da mensagem a partir do POST.

    // Verifica se a mensagem e o receptor_id não estão vazios.
    if (!empty($mensagem) && !empty($receptor_id)) {
        // Prepara a consulta SQL para inserir a nova mensagem na tabela 'mensagens_chat'.
        $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql); // Prepara a declaração.
        $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id); // Liga os parâmetros à declaração.
        if ($stmt->execute()) {
            echo "Mensagem enviada com sucesso!"; // Mensagem de sucesso.
        } else {
            echo "Erro ao enviar a mensagem: " . $stmt->error; // Mensagem de erro em caso de falha.
        }
        $stmt->close(); // Fecha a declaração.
    } else {
        echo "Mensagem ou receptor não pode ser vazio!"; // Mensagem de erro se a mensagem ou o receptor estiver vazio.
    }
}

// Obtém o ID do usuário atual da sessão.
$usuario_atual_id = $_SESSION['user_id'];

// Prepara a consulta SQL para buscar mensagens enviadas e recebidas pelo usuário atual.
$sql = "SELECT mensagens_chat.mensagem, usuarios.username
        FROM mensagens_chat
        JOIN usuarios ON mensagens_chat.user_id = usuarios.id
        WHERE mensagens_chat.receptor_id = ? OR mensagens_chat.user_id = ?
        ORDER BY mensagens_chat.data_envio DESC";

// Prepara a declaração para a consulta.
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_atual_id, $usuario_atual_id); // Liga os parâmetros à declaração.
$stmt->execute(); // Executa a declaração.
$result = $stmt->get_result(); // Obtém o resultado da execução da declaração.

$mensagens = []; // Cria um array para armazenar as mensagens.
while ($row = $result->fetch_assoc()) {
    $mensagens[] = $row; // Adiciona cada mensagem ao array.
}

// Codifica o array de mensagens em formato JSON e exibe.
echo json_encode($mensagens);

// Redireciona para a página de mensagens após o processamento.
header('Location:../mensagens.html');
?>

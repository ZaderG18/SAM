<?php
// Inicia a sessão
session_start();

// Declarando variáveis para conectar ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao servidor MySQL
$conn = new mysqli($host, $username, $password);

// Verifica se houve erro na conexão com o servidor MySQL
if ($conn->connect_error) {
    die("Erro ao conectar ao servidor de banco de dados: " . $conn->connect_error);
}

// Criando o banco de dados 'SAM' se ele não existir
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    // Banco de dados criado com sucesso
} else {
    die("Erro ao criar banco de dados: " . $conn->error);
}

// Reestabelece a conexão ao banco de dados específico 'SAM'
$conn->select_db($dbName);

// Verifica se houve erro na conexão com o banco de dados específico
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verifica se o método de solicitação é POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $remetente_id = $_SESSION['user_id']; // Obtém o ID do usuário que está enviando a mensagem da sessão
    $receptor_id = filter_input(INPUT_POST, 'receptor_id', FILTER_SANITIZE_NUMBER_INT); // Obtém o ID do receptor da mensagem a partir do POST
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING); // Obtém o conteúdo da mensagem a partir do POST

    // Verifica se a mensagem e o receptor_id não estão vazios
    if (!empty($mensagem) && !empty($receptor_id)) {
        // Prepara a consulta SQL para inserir a nova mensagem na tabela 'mensagens_chat'
        $sql = "INSERT INTO mensagens_chat (user_id, mensagem, receptor_id) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) { // Prepara a declaração
            $stmt->bind_param("isi", $remetente_id, $mensagem, $receptor_id); // Liga os parâmetros à declaração
            if ($stmt->execute()) {
                echo "Mensagem enviada com sucesso!"; // Mensagem de sucesso
            } else {
                echo "Erro ao enviar a mensagem: " . $stmt->error; // Mensagem de erro em caso de falha
            }
            $stmt->close(); // Fecha a declaração
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    } else {
        echo "Mensagem ou receptor não pode ser vazio!"; // Mensagem de erro se a mensagem ou o receptor estiver vazio
    }
}

// Obtém o ID do usuário atual da sessão
$usuario_atual_id = $_SESSION['user_id'];

// Prepara a consulta SQL para buscar mensagens enviadas e recebidas pelo usuário atual
$sql = "SELECT mensagens_chat.mensagem, usuarios.username
        FROM mensagens_chat
        JOIN usuarios ON mensagens_chat.user_id = usuarios.id
        WHERE mensagens_chat.receptor_id = ? OR mensagens_chat.user_id = ?
        ORDER BY mensagens_chat.data_envio DESC";

// Prepara a declaração para a consulta
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ii", $usuario_atual_id, $usuario_atual_id); // Liga os parâmetros à declaração
    $stmt->execute(); // Executa a declaração
    $result = $stmt->get_result(); // Obtém o resultado da execução da declaração

    $mensagens = []; // Cria um array para armazenar as mensagens
    while ($row = $result->fetch_assoc()) {
        $mensagens[] = $row; // Adiciona cada mensagem ao array
    }

    // Codifica o array de mensagens em formato JSON e exibe
    header('Content-Type: application/json');
    echo json_encode($mensagens);
    $stmt->close(); // Fecha a declaração
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

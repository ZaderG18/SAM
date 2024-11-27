<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para converter horário para 12h AM/PM
function convertTo12h($time) {
    return date('g:i a', strtotime($time)); // Converte para formato 12h com AM/PM
}

// Função para garantir que o horário esteja no formato 24h
function convertTo24h($time) {
    return date('H:i', strtotime($time)); // Converte para formato 24h
}

// Verificar a ação via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    if ($acao === 'criar') {
        // Criar evento
        $nome = $_POST['nome'];
        $data_evento = $_POST['data_evento'];
        $horario_inicio = convertTo24h($_POST['horario_inicio']);
        $horario_fim = convertTo24h($_POST['horario_fim']);

        $stmt = $conn->prepare("INSERT INTO eventos (nome, data_evento, horario_inicio, horario_fim) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $nome, $data_evento, $horario_inicio, $horario_fim);

        echo $stmt->execute() ? "Evento criado com sucesso!" : "Erro ao criar evento: " . $stmt->error;

    } elseif ($acao === 'editar') {
        // Editar evento
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $data_evento = $_POST['data_evento'];
        $horario_inicio = convertTo24h($_POST['horario_inicio']);
        $horario_fim = convertTo24h($_POST['horario_fim']);

        $stmt = $conn->prepare("UPDATE eventos SET nome=?, data_evento=?, horario_inicio=?, horario_fim=? WHERE id=?");
        $stmt->bind_param('ssssi', $nome, $data_evento, $horario_inicio, $horario_fim, $id);

        echo $stmt->execute() ? "Evento atualizado com sucesso!" : "Erro ao atualizar evento: " . $stmt->error;

    } elseif ($acao === 'deletar') {
        // Deletar evento
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM eventos WHERE id=?");
        $stmt->bind_param('i', $id);

        echo $stmt->execute() ? "Evento deletado com sucesso!" : "Erro ao deletar evento: " . $stmt->error;
    }

    exit;
}
?>

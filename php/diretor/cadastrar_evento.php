<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date']; // Captura a data do evento
    $event_time_from = $_POST['event_time_from'];
    $event_time_to = $_POST['event_time_to'];

    $sql = "INSERT INTO evento (nome, data_evento, horario_inicio, horario_fim) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('ssss', $event_name, $event_date, $event_time_from, $event_time_to);
        $result = $stmt->execute(); // Executa a inserção e retorna true ou false

        echo json_encode(["success" => $result]);
        
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
?>

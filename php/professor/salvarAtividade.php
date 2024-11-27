<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário
    $atividade_id = $_POST['id'];
    $conteudo = $_POST['conteudo'];
    $data_vencimento = $_POST['data_vencimento'];

    // Atualiza a atividade no banco de dados
    $query = "UPDATE atividades SET conteudo = ?, data_vencimento = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind dos parâmetros
    $stmt->bind_param('ssi', $conteudo, $data_vencimento, $atividade_id); // 's' para string, 'i' para inteiro

    // Executa a query
    if ($stmt->execute()) {
        echo "Atividade atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a atividade.";
    }
}
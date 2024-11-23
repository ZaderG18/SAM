<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'username', '', 'sam');
if ($conn->connect_error) {
    die(json_encode(['error' => $conn->connect_error]));
}

// Array para armazenar os resultados das duas consultas
$response = [
    'progresso_academico' => [],
    'desempenho_turmas' => [],
];

// Consulta para progresso acadêmico
$queryProgresso = "SELECT disciplina, progresso FROM progresso_academico";
$resultProgresso = $conn->query($queryProgresso);

if ($resultProgresso && $resultProgresso->num_rows > 0) {
    while ($row = $resultProgresso->fetch_assoc()) {
        $response['progresso_academico'][] = $row;
    }
}

// Consulta para desempenho de turmas
$queryDesempenho = "SELECT turma, media FROM desempenho_turmas";
$resultDesempenho = $conn->query($queryDesempenho);

if ($resultDesempenho && $resultDesempenho->num_rows > 0) {
    while ($row = $resultDesempenho->fetch_assoc()) {
        $response['desempenho_turmas'][] = $row;
    }
}

// Retornar JSON com os dois conjuntos de dados
echo json_encode($response);

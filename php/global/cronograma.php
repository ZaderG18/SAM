<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta para buscar todas as aulas do cronograma
$query = "SELECT horario, dia, disciplina FROM cronograma";
$result = $conn->query($query);

$data = [];

// Organiza os resultados em um array associativo para facilitar o agrupamento por horário e dia
while ($row = $result->fetch_assoc()) {
    $horario = $row['horario'];
    $dia = $row['dia'];
    $disciplina = $row['disciplina'];
    
    if (!isset($data[$horario])) {
        $data[$horario] = ['Segunda' => '', 'Terça' => '', 'Quarta' => '', 'Quinta' => '', 'Sexta' => ''];
    }
    $data[$horario][$dia] = $disciplina;
}

// Ordena os horários para manter uma ordem correta na tabela
$horariosOrdenados = array_keys($data);
sort($horariosOrdenados);

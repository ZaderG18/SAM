<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
session_status() === PHP_SESSION_NONE && session_start();

// ID do aluno (pegando da sessão)
$user = $_SESSION['user'];
$alunoId = $user['id'];

include '../global/gerarPDF.php';

// Verifica se foi passado o módulo via POST
$frequencias = [];
if (isset($_POST['modulo'])) {
    $modulo = $_POST['modulo'];

    // Obtendo as frequências do aluno
    $frequencias = buscarFrequencias($conn, $alunoId, $modulo);
}

// Função para buscar as frequências do aluno
function buscarFrequencias($conn, $alunoId, $modulo) {
    $sql = "SELECT d.nome AS disciplina, f.aulas_dadas, f.faltas, f.frequencia, f.frequencia_total
            FROM frequencia f
            JOIN disciplina d ON f.disciplina_id = d.id
            WHERE f.aluno_id = ? AND f.modulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $alunoId, $modulo);
    $stmt->execute();
    $result = $stmt->get_result();
    $frequencias = [];
    while ($row = $result->fetch_assoc()) {
        $frequencias[] = $row;
    }
    $stmt->close();
    return $frequencias;
}
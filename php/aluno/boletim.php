<?php
// Verifica se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicie a sessão apenas se ainda não estiver ativa
}
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

function getNotas($alunoId, $moduloId) {
    global $conn; // Conexão com o banco de dados
    $query = "
        SELECT n.*, d.nome_disciplina AS disciplina
        FROM notas n
        JOIN disciplina d ON n.disciplina_id = d.id
        WHERE n.aluno_id = ? AND n.modulo_id = ?
    ";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    $stmt->bind_param("ii", $alunoId, $moduloId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getModulos() {
    global $conn;
    $query = "SELECT * FROM modulos"; // Obter todos os módulos
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Verificar se o usuário está autenticado
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    die("Usuário não está autenticado.");
}

// Obter o ID do aluno
$alunoId = $_SESSION['user']['id'];

// Obter módulos
$modulos = getModulos();

// Verificar se um módulo foi selecionado
$selectedModule = isset($_GET['modulo']) ? (int)$_GET['modulo'] : 1; // Definindo um módulo padrão se nenhum for passado
$notas = getNotas($alunoId, $selectedModule); // Obter notas do módulo selecionado
?>

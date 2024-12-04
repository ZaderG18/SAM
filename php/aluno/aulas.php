<?php
// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obter o ID da matéria da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $materia_id = intval($_GET['id']);
} else {
    die("ID da matéria inválido.");
}

// Obtendo os dados da matéria
list($descricao_materia, $progresso) = getMateria($conn, $materia_id); // Chamada para obter descrição e progresso
$atividades = getAtividades($conn, $materia_id);
$pendentes = getAtividadesPendentes($conn, $materia_id);
$feedbacks = getFeedbacks($conn, $materia_id);
$materiais = getMateriaisComplementares($conn, $materia_id);
$tutores = getTutores($conn, $materia_id);

// Função para obter a descrição da matéria e o progresso
function getMateria($conn, $materia_id,  $descricao = false, $progresso = false) {
    $sql = "SELECT descricao, progresso FROM materias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $stmt->bind_result($descricao, $progresso);
    $stmt->fetch();
    $stmt->close();
    return [$descricao, $progresso]; // Retorna descrição e progresso
}

// Função para obter atividades
function getAtividades($conn, $materia_id) {
    $sql = "SELECT id, titulo FROM atividade WHERE aluno_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $atividades = [];
    while ($row = $result->fetch_assoc()) {
        $atividades[] = $row;
    }
    $stmt->close();
    return $atividades;
}

// Função para obter atividades pendentes
function getAtividadesPendentes($conn, $materia_id) {
    $sql = "SELECT id, titulo FROM atividade WHERE aluno_id = ? AND status = 'pendente'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pendentes = [];
    while ($row = $result->fetch_assoc()) {
        $pendentes[] = $row;
    }
    $stmt->close();
    return $pendentes;
}

// Função para obter feedbacks do professor
function getFeedbacks($conn, $materia_id) {
    $sql = "SELECT atividade.titulo, feedback.feedback 
            FROM feedback 
            JOIN atividade ON feedback.atividade_id = atividade.id 
            WHERE atividade.aluno_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $feedbacks = [];
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
    $stmt->close();
    return $feedbacks;
}

// Função para obter materiais complementares
function getMateriaisComplementares($conn, $materia_id) {
    $sql = "SELECT titulo, link FROM materiais_complementares WHERE materias_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $materiais = [];
    while ($row = $result->fetch_assoc()) {
        $materiais[] = $row;
    }
    $stmt->close();
    return $materiais;
}

// Função para obter tutores
function getTutores($conn, $materia_id) {
    $sql = "SELECT nome, email FROM tutores WHERE materia_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tutores = [];
    while ($row = $result->fetch_assoc()) {
        $tutores[] = $row;
    }
    $stmt->close();
    return $tutores;
}

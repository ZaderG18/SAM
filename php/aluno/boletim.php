<?php
// Verifica se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicie a sessão apenas se ainda não estiver ativa
}

// Configuração do banco de dados
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para obter o curso do aluno
function getCurso($conn, $cursoId) {
    $query = "SELECT * FROM curso WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erro ao preparar a consulta de curso: " . $conn->error);
    }
    $stmt->bind_param("i", $cursoId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_assoc() : [];
}

// Função para obter a turma do aluno
function getTurma($conn, $turmaId) {
    $query = "SELECT * FROM turma WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erro ao preparar a consulta de turma: " . $conn->error);
    }
    $stmt->bind_param("i", $turmaId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_assoc() : [];
}

// Função para obter notas
function getNotas($conn, $id, $moduloId) {
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
    $stmt->bind_param("ii", $id, $moduloId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Função para obter módulos
function getModulos($conn) {
    $query = "SELECT * FROM modulo";
    $result = $conn->query($query);
    if (!$result) {
        die("Erro na consulta de módulos: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}


// Obter dados do curso e da turma
$curso = getCurso($conn, $cursoId);
$turma = getTurma($conn, $turmaId);

// Obter módulos e notas do aluno
$modulos = getModulos($conn);
$selectedModule = isset($_GET['modulo']) ? (int)$_GET['modulo'] : 1;
$notas = getNotas($conn, $id, $selectedModule);

// Função para calcular a situação
function calcularSituacao($nota1, $nota2) {
    if (is_null($nota1) || is_null($nota2)) {
        return 'Dados insuficientes';
    }
    $media = ($nota1 + $nota2) / 2;
    return $media >= 5 ? 'Aprovado' : 'Reprovado';
}

// Atualizando o loop para gerar os modais corretamente
$modals = [];
$sql = "SELECT * FROM modulo";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $modalId = strtolower(str_replace(' ', '-', $row['nome_modulo'])); // Defina o modalId corretamente
        $modals[] = [
            'id' => $modalId,
            'titulo' => $row['nome_modulo'],
            'criterio' => isset($row['criterio']) ? explode(';', $row['criterio']) : []
        ];
    }
}


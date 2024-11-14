<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao === 'carregarFiltros') {
    carregarFiltros();
} elseif ($acao === 'carregarAlunos') {
    carregarAlunos();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    marcarPresenca();
}

// Função para carregar turmas e disciplinas
function carregarFiltros() {
    global $conn;

    $turmas = [];
    $materias = [];

    // Buscar turmas
    $resultTurma = $conn->query("SELECT id, nome FROM turma");
    while ($turma = $resultTurma->fetch_assoc()) {
        $turmas[] = $turma;
    }

    // Buscar disciplinas
    $resultMateria = $conn->query("SELECT id, nome_disciplina FROM disciplina");
    while ($materia = $resultMateria->fetch_assoc()) {
        $materias[] = $materia;
    }

    echo json_encode(['turmas' => $turmas, 'materias' => $materias]);
}

// Função para carregar alunos de acordo com os filtros
function carregarAlunos() {
    global $conn;
    $turmaId = isset($_GET['turma']) ? $_GET['turma'] : '';
    $materiaId = isset($_GET['materia']) ? $_GET['materia'] : '';

    $stmt = $conn->prepare("SELECT id, nome FROM aluno WHERE turma_id = ? AND materia_id = ?");
    $stmt->bind_param("ii", $turmaId, $materiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $alunos = [];
    while ($aluno = $result->fetch_assoc()) {
        $alunos[] = $aluno;
    }

    echo json_encode($alunos);
}

// Função para marcar presença no banco de dados
function marcarPresenca() {
    global $conn;
    $data = json_decode(file_get_contents('php://input'), true);

    $alunoId = $data['alunoId'];
    $presente = $data['presente'];
    $observacao = $data['observacao'];

    $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, presente, observacao) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $alunoId, $presente, $observacao);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>

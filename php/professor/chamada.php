<?php

// Habilitar a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Conectar ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Função para carregar turmas
function carregarTurmas($conn) {
    $result = $conn->query("SELECT id, nome FROM turma ORDER BY nome ASC");
    $turmas = [];
    while ($row = $result->fetch_assoc()) {
        $turmas[] = $row;
    }
    return $turmas;
}

// Função para carregar disciplinas
function carregarMaterias($conn) {
    $result = $conn->query("SELECT id, nome_disciplina FROM disciplina ORDER BY nome_disciplina ASC");
    $materias = [];
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }
    return $materias;
}

function carregarAlunos($conn, $turmaId, $materiaId) {
    // Verificando os valores
    echo "turmaId: " . $turmaId . "<br>";
    echo "materiaId: " . $materiaId . "<br>";
    
    // Preparando a consulta com placeholders (?)
    $stmt = $conn->prepare("SELECT a.id, a.matricula 
                            FROM aluno a 
                            INNER JOIN matricula m ON a.id = m.aluno_id 
                            WHERE m.turma_id = ? AND m.materia_id = ?");
    
    // Verifique se o statement foi preparado corretamente
    if (!$stmt) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit;
    }

    // Vinculando os parâmetros
    $stmt->bind_param("ii", $turmaId, $materiaId);
    
    // Executando a consulta
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifique se a consulta retornou resultados
    if ($result->num_rows > 0) {
        $alunos = [];
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }
        return $alunos;
    } else {
        echo "Nenhum aluno encontrado para esta turma e matéria.";
        return [];
    }
}
// Função para marcar presença
function marcarPresenca($conn, $id, $presente, $observacao) {
    // Inserir ou atualizar a presença do aluno
    $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, presente, observacao) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE presente = VALUES(presente), observacao = VALUES(observacao)");
    $stmt->bind_param("iis", $id, $presente, $observacao);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

// Carregar turmas e matérias
$turmas = carregarTurmas($conn);
$materias = carregarMaterias($conn);

// Inicializar variáveis
$turmaId = isset($_GET['turma']) ? $_GET['turma'] : '';
$materiaId = isset($_GET['materia']) ? $_GET['materia'] : '';
$alunos = [];

// Carregar alunos se turma e matéria forem selecionadas
if ($turmaId && $materiaId) {
    $alunos = carregarAlunos($conn, $turmaId, $materiaId);
}

// Marcar presença
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcarPresenca'])) {
    $id = $_POST['alunoId'];
    $presente = $_POST['presente'];
    $observacao = $_POST['observacao'];

    if (marcarPresenca($conn, $id, $presente, $observacao)) {
        echo "<p>Presença registrada com sucesso!</p>";
    } else {
        echo "<p>Erro ao registrar presença.</p>";
    }
}

// Função para carregar filtros
function carregarFiltros($conn) {
    $turmas = mysqli_query($conn, "SELECT id, nome FROM turma");
    $materias = mysqli_query($conn, "SELECT id, nome_disciplina FROM disciplina");
    return [$turmas, $materias];
}

list($turmas, $materias) = carregarFiltros($conn);

// Carregar alunos com base nos filtros selecionados
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['turma'], $_GET['materia'])) {
    $turmaId = $_GET['turma'];
    $materiaId = $_GET['materia'];
    $turno = $_GET['turno'];
    $periodo = $_GET['periodo'];
    $periodoDia = $_GET['periodo-dia'];
    $data = $_GET['filtro-dia'];

    // Consulta para obter os alunos
    $query = "SELECT a.id, a.nome 
              FROM aluno a 
              INNER JOIN matricula m ON a.id = m.aluno_id
              WHERE m.turma_id = '$turmaId' AND m.materia_id = '$materiaId'";
    $resultado = mysqli_query($conn, $query);
    $alunos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

// Marcar presença via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alunoId'])) {
    $id = $_POST['alunoId'];
    $presente = $_POST['presente'];
    $observacao = $_POST['observacao'];
    $data = date('Y-m-d');

    // Inserir ou atualizar a presença no banco de dados
    $sql = "INSERT INTO frequencia (aluno_id, presente, observacao, data) 
            VALUES ('$id', '$presente', '$observacao', '$data') 
            ON DUPLICATE KEY UPDATE presente = '$presente', observacao = '$observacao'";
    mysqli_query($conn, $sql);
}
?>
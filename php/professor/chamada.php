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

// Função para carregar todos os alunos
function carregarAlunos($conn) {
    $query = "
        SELECT a.id, a.nome, f.presenca, f.observacao 
        FROM usuarios a 
        LEFT JOIN frequencia f ON f.aluno_id = a.id 
        WHERE a.cargo = 'aluno'
        ORDER BY a.nome ASC";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}
// Função para marcar presença
function marcarPresenca($conn, $id, $presente, $observacao) {
    // Inserir ou atualizar a presença do aluno
    $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, presenca, observacao) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE presenca = VALUES(presenca), observacao = VALUES(observacao)");
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
$alunos = carregarAlunos($conn);


// Marcar presença
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcarPresenca'])) {
    $id = $_POST['id'];
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
              FROM usuarios a 
              INNER JOIN matricula m ON a.id = m.aluno_id
              WHERE m.turma_id = '$turmaId' AND m.id = '$materiaId' AND a.cargo = 'aluno'";
    $resultado = mysqli_query($conn, $query);
    $alunos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcarPresenca'])) {
    $id = $_POST['alunoId'];  // ID do aluno
    $presente = $_POST['presente'];  // 1 para presente, 0 para ausente
    $observacao = $_POST['observacao'];  // Observação (se fornecida)
    $data = date('Y-m-d');  // Data atual

    // Verifica se a presença já foi registrada para o aluno na data
    $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, presenca, observacao, data) 
                            VALUES (?, ?, ?, ?) 
                            ON DUPLICATE KEY UPDATE presenca = VALUES(presenca), observacao = VALUES(observacao)");
    $stmt->bind_param("iiss", $id, $presente, $observacao, $data);

    if ($stmt->execute()) {
        echo "<p>Presença registrada com sucesso!</p>";
    } else {
        echo "<p>Erro ao registrar presença.</p>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    // Verifica se há dados de presença
    if (!empty($_POST['aluno_id']) && !empty($_POST['presenca'])) {
        foreach ($_POST['aluno_id'] as $index => $alunoId) {
            $presenca = $_POST['presenca'][$alunoId];
            $observacao = $_POST['observacao'][$alunoId] ?? '';

            // Atualizar ou inserir a presença no banco de dados
            $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, presenca, observacao, data) 
                                    VALUES (?, ?, ?, ?) 
                                    ON DUPLICATE KEY UPDATE presenca = ?, observacao = ?");
            $stmt->bind_param("iisssi", $alunoId, $presenca, $observacao, date('Y-m-d'), $presenca, $observacao);
            $stmt->execute();
        }

        echo "<p>Chamada salva com sucesso!</p>";
    }
}

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    header("Location: ../../index.html");
    exit();
}

$user = $_SESSION['user'];
$aluno_id = $user['id'];

// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para informações do aluno
$sqlAluno = "SELECT nome, RM FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sqlAluno);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$stmt->bind_result($nomeAluno, $RM);
$stmt->fetch();
$stmt->close();

// Consulta para buscar as notas do aluno a partir da tabela `notas`
$sqlNotas = "SELECT disciplina_id, nota_media FROM notas WHERE aluno_id = ?";
$stmtNotas = $conn->prepare($sqlNotas);
if (!$stmtNotas) {
    die("Erro na preparação da consulta de notas: " . $conn->error);
}
$stmtNotas->bind_param("i", $aluno_id);
$stmtNotas->execute();
$resultNotas = $stmtNotas->get_result();

$notas = [];
while ($row = $resultNotas->fetch_assoc()) {
    $notas[] = $row;
}
$stmtNotas->close();

// Consulta para disciplinas, faltas, notas e status
$sqlDisciplinas = "SELECT disciplina_id, semestre, faltas, nota, status FROM historico_academico WHERE aluno_id = ?";
$stmtDisciplinas = $conn->prepare($sqlDisciplinas);
$stmtDisciplinas->bind_param("i", $aluno_id);
$stmtDisciplinas->execute();
$resultDisciplinas = $stmtDisciplinas->get_result();

$disciplinas = [];
while ($row = $resultDisciplinas->fetch_assoc()) {
    $disciplinas[] = $row;
}
$stmtDisciplinas->close();

// Consulta para buscar as notas do aluno e calcular a média geral
$sqlMediaGeral = "SELECT AVG(nota_media) AS media_geral FROM notas WHERE aluno_id = ?";
$stmtMediaGeral = $conn->prepare($sqlMediaGeral);
$stmtMediaGeral->bind_param("i", $aluno_id);
$stmtMediaGeral->execute();
$resultMediaGeral = $stmtMediaGeral->get_result()->fetch_assoc();
$media_geral = $resultMediaGeral['media_geral'];
$stmtMediaGeral->close();

// Consultas para total de disciplinas e disciplinas concluídas
$query_total = "SELECT COUNT(*) AS total FROM historico_academico WHERE aluno_id = ?";
$query_concluidas = "SELECT COUNT(*) AS concluidas FROM historico_academico WHERE aluno_id = ? AND status IN ('aprovado', 'reprovado')";

$stmt_total = $conn->prepare($query_total);
$stmt_total->bind_param("i", $aluno_id);
$stmt_total->execute();
$total_disciplinas = $stmt_total->get_result()->fetch_assoc()['total'];
$stmt_total->close();

$stmt_concluidas = $conn->prepare($query_concluidas);
$stmt_concluidas->bind_param("i", $aluno_id);
$stmt_concluidas->execute();
$disciplinas_concluidas = $stmt_concluidas->get_result()->fetch_assoc()['concluidas'];
$stmt_concluidas->close();

$progresso = $total_disciplinas > 0 ? ($disciplinas_concluidas / $total_disciplinas) * 100 : 0;

// Consulta para disciplinas pendentes
$query_pendentes = "SELECT COUNT(*) AS pendentes FROM historico_academico WHERE aluno_id = ? AND status = 'pendente'";
$stmt_pendentes = $conn->prepare($query_pendentes);
$stmt_pendentes->bind_param("i", $aluno_id);
$stmt_pendentes->execute();
$disciplinas_pendentes = $stmt_pendentes->get_result()->fetch_assoc()['pendentes'];
$stmt_pendentes->close();

// Cálculo do prazo estimado de conclusão
$ano_atual = date("Y");
$prazo_conclusao = $disciplinas_pendentes <= 3 ? "Dezembro de $ano_atual" : "Dezembro de " . ($ano_atual + 1);

// Filtragem dinâmica de disciplinas por semestre e status
$semestre = $_GET['semestre'] ?? 'todos';
$status = $_GET['status'] ?? 'todas';

$sql = "SELECT disciplina_id, semestre, faltas, nota, status FROM historico_academico WHERE aluno_id = ?";
if ($semestre !== 'todos') $sql .= " AND semestre = ?";
if ($status !== 'todas') $sql .= " AND status = ?";

$stmt = $conn->prepare($sql);
if ($semestre === 'todos' && $status === 'todas') {
    $stmt->bind_param("i", $aluno_id);
} elseif ($semestre !== 'todos' && $status === 'todas') {
    $stmt->bind_param("is", $aluno_id, $semestre);
} elseif ($semestre === 'todos' && $status !== 'todas') {
    $stmt->bind_param("is", $aluno_id, $status);
} else {
    $stmt->bind_param("iss", $aluno_id, $semestre, $status);
}
$stmt->execute();
$result = $stmt->get_result();

// Inicializa $historico como um array vazio
$historico = [];

// Consulta para pegar as informações de módulos, semestres e status do histórico acadêmico
$sql = "SELECT semestre, status 
        FROM historico_academico 
        WHERE aluno_id = ?
        ORDER BY semestre ASC"; // Ordena por semestre em ordem ascendente

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $ano = explode('.', $row['semestre'])[0]; // Pega o ano a partir do semestre (ex: '2021.1' => '2021')
    $historico[$ano][] = [
        'semestre' => $row['semestre'], 
        'status' => $row['status']
    ];
}
$stmt->close();

// Verifica se $historico tem dados antes de usar no foreach
if (!empty($historico)) {
    foreach ($historico as $ano => $semestres) {
        // Código para processar e exibir os semestres e status de cada ano
    }
}


?>

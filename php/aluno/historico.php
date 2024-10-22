<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    // Redireciona para a página de login, se o usuário não estiver logado
    header("Location: ../../index.html");
    exit();
}

$user = $_SESSION['user']; // Pegando os dados do usuário logado
$aluno_id = $user['id']; // Definindo o id do aluno a partir dos dados da sessão

// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Código de início da sessão e verificação de login...

// Conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para pegar as informações gerais do aluno
$sqlAluno = "SELECT nome, RM, nota_id FROM aluno WHERE id = ?";
$stmt = $conn->prepare($sqlAluno);
if (!$stmt) {
    die("Erro na preparação da consulta de aluno: " . $conn->error);
}
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$stmt->bind_result($nomeAluno, $RM, $mediaGeral);
$stmt->fetch();
$stmt->close();

// Consulta para pegar as disciplinas, faltas, notas e status
$sqlDisciplinas = "SELECT disciplina_id, semestre, faltas, nota, status FROM historico_academico WHERE aluno_id = ?";
$stmtDisciplinas = $conn->prepare($sqlDisciplinas);
if (!$stmtDisciplinas) {
    die("Erro na preparação da consulta de disciplinas: " . $conn->error);
}
$stmtDisciplinas->bind_param("i", $aluno_id);
$stmtDisciplinas->execute();
$resultDisciplinas = $stmtDisciplinas->get_result();

// Pegar todas as disciplinas do aluno
$disciplinas = [];
while ($row = $resultDisciplinas->fetch_assoc()) {
    $disciplinas[] = $row;
}

$stmtDisciplinas->close();
// Consulta para contar as disciplinas concluídas (aprovadas ou reprovadas) e o total de disciplinas
$query_total = "SELECT COUNT(*) AS total FROM historico_academico WHERE aluno_id = ?";
$query_concluidas = "SELECT COUNT(*) AS concluidas 
                    FROM historico_academico 
                    WHERE aluno_id = ? AND status IN ('aprovado', 'reprovado')";

$stmt_total = $conn->prepare($query_total);
$stmt_total->bind_param("i", $aluno_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_disciplinas = $result_total->fetch_assoc()['total'];

$stmt_concluidas = $conn->prepare($query_concluidas);
$stmt_concluidas->bind_param("i", $aluno_id);
$stmt_concluidas->execute();
$result_concluidas = $stmt_concluidas->get_result();
$disciplinas_concluidas = $result_concluidas->fetch_assoc()['concluidas'];

// Calcula o progresso
if ($total_disciplinas > 0) {
    $progresso = ($disciplinas_concluidas / $total_disciplinas) * 100;
} else {
    $progresso = 0;
}


// Consulta para contar as disciplinas pendentes
$query_pendentes = "SELECT COUNT(*) AS pendentes 
                    FROM historico_academico 
                    WHERE aluno_id = ? AND status = 'pendente'";

$stmt_pendentes = $conn->prepare($query_pendentes);
$stmt_pendentes->bind_param("i", $aluno_id);
$stmt_pendentes->execute();
$result_pendentes = $stmt_pendentes->get_result();
$disciplinas_pendentes = $result_pendentes->fetch_assoc()['pendentes'];

// 2. Calcular o prazo estimado de conclusão
// Exemplo de lógica dinâmica: se o aluno tiver menos de 3 disciplinas pendentes, estima-se a conclusão até o final do ano atual; caso contrário, será no próximo ano.

$ano_atual = date("Y"); // Ano atual
$mes_atual = date("n");  // Mês atual

if ($disciplinas_pendentes <= 3) {
    $prazo_conclusao = "Dezembro de " . $ano_atual;
} else {
    $prazo_conclusao = "Dezembro de " . ($ano_atual + 1); // Projeta para o próximo ano
}
// Pegando os valores dos filtros enviados via GET
$semestre = isset($_GET['semestre']) ? $_GET['semestre'] : 'todos';
$status = isset($_GET['status']) ? $_GET['status'] : 'todas';

// Construção da query SQL dinâmica
$sql = "SELECT disciplina_id, semestre, faltas, nota, status 
        FROM historico_academico 
        WHERE aluno_id = ?";

// Adicionar filtros à consulta
if ($semestre !== 'todos') {
    $sql .= " AND semestre = ?";
}
if ($status !== 'todas') {
    $sql .= " AND status = ?";
}

// Preparar a consulta
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

// Consulta para pegar as informações de módulos, semestres e status do histórico acadêmico
$sql = "SELECT semestre, status 
        FROM historico_academico 
        WHERE aluno_id = ?
        ORDER BY semestre ASC"; // Ordena por semestre em ordem ascendente

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();

$historico = [];
while ($row = $result->fetch_assoc()) {
    $ano = explode('.', $row['semestre'])[0]; // Pega o ano a partir do semestre (ex: '2021.1' => '2021')
    $historico[$ano][] = [
        'semestre' => $row['semestre'], // Corrigir para usar 'semestre' ao invés de 'modulo'
        'status' => $row['status']
    ];
}
// Consulta para pegar os semestres únicos que o aluno estudou
$sqlSemestres = "SELECT DISTINCT semestre FROM historico_academico WHERE aluno_id = ? ORDER BY semestre ASC";
$stmtSemestres = $conn->prepare($sqlSemestres);
$stmtSemestres->bind_param("i", $aluno_id);
$stmtSemestres->execute();
$resultSemestres = $stmtSemestres->get_result();

$semestres = [];
while ($row = $resultSemestres->fetch_assoc()) {
    $semestres[] = $row['semestre']; // Adiciona o semestre ao array
}
$stmtSemestres->close();

// Consulta para pegar os status únicos (aprovado, reprovado, pendente)
$sqlStatus = "SELECT DISTINCT status FROM historico_academico WHERE aluno_id = ?";
$stmtStatus = $conn->prepare($sqlStatus);
$stmtStatus->bind_param("i", $aluno_id);
$stmtStatus->execute();
$resultStatus = $stmtStatus->get_result();

$statusOptions = [];
while ($row = $resultStatus->fetch_assoc()) {
    $statusOptions[] = $row['status']; // Adiciona o status ao array
}
$stmtStatus->close();


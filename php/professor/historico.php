<?php
// Conectar ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Consulta para preencher os selects de Turma
$turmas = $conn->query("SELECT id, nome FROM turma");
$bimestres = ["1º Bimestre", "2º Bimestre", "3º Bimestre", "4º Bimestre"];
$turnos = ["Manhã", "Tarde", "Noite"];
$periodos = ["1º Período", "2º Período", "3º Período"];

// Dados gerais da turma
$turmaDados = $conn->query("SELECT AVG(nota) AS media_turma FROM notas");
$turmaCritica = $conn->query("SELECT COUNT(*) AS disciplinas_criticas FROM disciplinas WHERE taxa_reprovacao > 20");
$alunosCriticos = $conn->query("SELECT COUNT(*) AS alunos_criticos FROM usuarios a 
    JOIN notas n ON a.id_aluno = n.aluno_id 
    WHERE n.nota < 5");

// Alunos
$alunos = $conn->query("SELECT id, nome FROM usuarios WHERE cargo = 'aluno'");

// Se for selecionado um aluno, realizar a consulta de desempenho
if (isset($_GET['id'])) {
    $alunoSelecionadoId = (int)$_GET['id'];
    $alunoResumo = $conn->query("SELECT * FROM usuarios WHERE cargo = 'aluno' AND id = $alunoSelecionadoId");
    $desempenhoDisciplinas = $conn->query("SELECT d.nome_disciplina, n.nota, f.qtd_faltas, 
        CASE WHEN n.nota >= 5 THEN 'Aprovado' ELSE 'Reprovado' END AS status
        FROM disciplinas d
        JOIN notas n ON d.id_disciplina = n.disciplina_id
        JOIN faltas f ON d.id_disciplina = f.disciplina_id
        WHERE n.aluno_id = $alunoSelecionadoId");
}

// Consultar alertas de faltas e recomendações de recuperação
$result_alertas = $conn->query("SELECT a.nome_disciplina, al.nome_aluno FROM faltas f
    JOIN usuarios al ON f.aluno_id = al.id_aluno
    JOIN disciplinas a ON f.disciplina_id = a.id_disciplina
    WHERE f.qtd_faltas > 10");

$result_recomendacoes = $conn->query("SELECT a.nome_disciplina, al.nome_aluno FROM notas n
    JOIN usuarios al ON n.aluno_id = al.id_aluno
    JOIN disciplinas a ON n.disciplina_id = a.id_disciplina
    WHERE n.nota < 5");
// Calcular o progresso do aluno (exemplo: média das notas)
if (isset($alunoSelecionadoId)) {
    $sqlProgresso = "SELECT AVG(nota) AS media FROM notas WHERE aluno_id = ?";
    $stmtProgresso = $conn->prepare($sqlProgresso);
    $stmtProgresso->bind_param("i", $alunoSelecionadoId);
    $stmtProgresso->execute();
    $resultProgresso = $stmtProgresso->get_result();
    $progresso = $resultProgresso->fetch_assoc()['media'] * 20; // Ajustar a multiplicação conforme necessário
    $stmtProgresso->close();
}

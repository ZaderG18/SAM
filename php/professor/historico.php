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
$turmaDados = $conn->query("SELECT AVG(nota) AS media_turma FROM avaliacao");
$turmaCritica = $conn->query("SELECT COUNT(*) AS disciplinas_criticas FROM disciplina WHERE taxa_reprovacao > 20");
$alunosCriticos = $conn->query("SELECT COUNT(*) AS alunos_criticos FROM usuarios a 
    JOIN notas n ON a.id = n.aluno_id 
    WHERE n.nota_media < 5");

// Alunos
$alunos = $conn->query("SELECT id, nome FROM usuarios WHERE cargo = 'aluno'");

// Se for selecionado um aluno, realizar a consulta de desempenho
if (isset($_GET['id'])) {
    $alunoSelecionadoId = (int)$_GET['id'];
    $alunoResumo = $conn->query("SELECT nome, rm, media_geral, disciplinas_pendentes, prazo_estimado FROM usuarios WHERE cargo = 'aluno' AND id = $alunoSelecionadoId");
    
    if ($alunoResumo && $alunoResumo->num_rows > 0) {
        $resumo = $alunoResumo->fetch_assoc();
    } else {
        $resumo = null; // Garantir que $resumo exista, mas como null se não houver resultado.
    }
} else {
    $resumo = null;
}

// Consultar alertas de faltas e recomendações de recuperação
$result_alertas = $conn->query("SELECT a.nome_disciplina, al.nome FROM frequencia f
    JOIN usuarios al ON f.aluno_id = al.id
    JOIN disciplina a ON f.disciplina_id = a.id
    WHERE f.faltas > 10 AND al.cargo = 'aluno'");

$result_recomendacoes = $conn->query("SELECT a.nome_disciplina, al.nome FROM notas n
    JOIN usuarios al ON n.aluno_id = al.id
    JOIN disciplina a ON n.disciplina_id = a.id
    WHERE n.nota_media < 5 AND al.cargo = 'aluno'");
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

// Obter o progresso médio da turma
$turmaProgresso = $conn->query("SELECT AVG(progresso) AS progresso_medio FROM turma");
$progressoMédio = 0;

if ($turmaProgresso && $turmaProgresso->num_rows > 0) {
    $progressoMédio = round($turmaProgresso->fetch_assoc()['progresso_medio']);
}

// Inicialize a variável para garantir que não está indefinida
$desempenhoDisciplinas = null;

// Se for selecionado um aluno, realizar a consulta de desempenho
if (isset($_GET['id'])) {
    $alunoSelecionadoId = (int)$_GET['id'];

    // Realizar a consulta apenas se um aluno foi selecionado
    $desempenhoDisciplinas = $conn->query("
        SELECT d.nome_disciplina, n.nota_media, f.faltas, 
        CASE 
            WHEN n.nota_media >= 7 THEN 'Aprovado' 
            ELSE 'Reprovado' 
        END AS status
        FROM disciplina d
        JOIN notas n ON d.id_disciplina = n.disciplina_id
        JOIN frequencia f ON d.id_disciplina = f.disciplina_id
        WHERE n.aluno_id = $alunoSelecionadoId
    ");
}
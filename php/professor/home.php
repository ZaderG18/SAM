<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Suponha que o ID do professor esteja armazenado na sessão
$professor_id = $_SESSION['user']['id'];

// Consulta para obter os dados do professor
$sql = "SELECT nome, genero, RM, email, telefone, foto FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se os dados foram encontrados
if ($result->num_rows > 0) {
    $professor = $result->fetch_assoc();
    $fotoCaminho = "../../assets/img/uploads/" . $professor['foto'];
} else {
    echo "Nenhum professor encontrado.";
}

$stmt->close();

// Definir denominação de acordo com o gênero do professor
if (isset($professor)) {
    $genero = $professor['genero'];
    if ($genero === 'masculino') {
        $denominacao = "Professor";
    } elseif ($genero === 'feminino') {
        $denominacao = "Professora";
    } else {
        $denominacao = "Professor(a)";
    }
}

// Seção: Tarefas Pendentes
$sqlTarefas = "SELECT COUNT(*) as total_tarefas FROM atividade WHERE professor_id = ? AND status = 'pendente'";
$stmtTarefas = $conn->prepare($sqlTarefas);
$stmtTarefas->bind_param("i", $professor_id);
$stmtTarefas->execute();
$resultTarefas = $stmtTarefas->get_result();
$totalTarefas = $resultTarefas->fetch_assoc()['total_tarefas'];
$stmtTarefas->close();

// Seção: Atualizações (consideradas como mensagens novas)
$sqlAtualizacoes = "SELECT COUNT(*) as total_atualizacoes FROM atualizacoes WHERE professor_id = ? ORDER BY data_atualizacao DESC";
$stmtAtualizacoes = $conn->prepare($sqlAtualizacoes);
$stmtAtualizacoes->bind_param("i", $professor_id);
$stmtAtualizacoes->execute();
$resultAtualizacoes = $stmtAtualizacoes->get_result();
$totalAtualizacoes = $resultAtualizacoes->fetch_assoc()['total_atualizacoes'];
$stmtAtualizacoes->close();


// Seção: Horário de Aula
$sqlHorario = "
    SELECT h.dia_semana, d.nome_disciplina AS disciplina, h.hora_inicio, h.hora_fim
    FROM horario h
    JOIN disciplina d ON h.disciplina_id = d.id
    WHERE h.professor_id = ?";
$stmtHorario = $conn->prepare($sqlHorario);
$stmtHorario->bind_param("i", $professor_id);
$stmtHorario->execute();
$resultHorario = $stmtHorario->get_result();
$stmtHorario->close();

// Seção: Chamadas Pendentes
$sqlChamadas = "SELECT turma_id, disciplina_id FROM frequencia WHERE professor_id = ? AND status = 'pendente'";
$stmtChamadas = $conn->prepare($sqlChamadas);
$stmtChamadas->bind_param("i", $professor_id);
$stmtChamadas->execute();
$resultChamadas = $stmtChamadas->get_result();
$stmtChamadas->close();

// Seção: Atualizações Recentes
$sqlAtualizacoesRecentes = "SELECT descricao, data_atualizacao FROM atualizacoes WHERE professor_id = ? ORDER BY data_atualizacao DESC LIMIT 5";
$stmtAtualizacoesRecentes = $conn->prepare($sqlAtualizacoesRecentes);
$stmtAtualizacoesRecentes->bind_param("i", $professor_id);
$stmtAtualizacoesRecentes->execute();
$resultAtualizacoesRecentes = $stmtAtualizacoesRecentes->get_result();
$stmtAtualizacoesRecentes->close();


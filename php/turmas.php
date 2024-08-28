<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
// Função para atribuir um aluno a uma turma
function atribuirTurma($conn, $aluno_id, $turma_id) {
    // Verificar se o aluno já está matriculado em uma turma
    $sqlCheck = "SELECT * FROM matricula WHERE aluno_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $aluno_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // Atualizar a turma do aluno existente
        $sqlUpdate = "UPDATE matricula SET turma_id = ? WHERE aluno_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ii", $turma_id, $aluno_id);
        if ($stmtUpdate->execute()) {
            return "Turma do aluno atualizada com sucesso!";
        } else {
            return "Erro ao atualizar a turma: " . $stmtUpdate->error;
        }
    } else {
        // Inserir nova matrícula
        $sqlInsert = "INSERT INTO matricula (aluno_id, turma_id) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ii", $aluno_id, $turma_id);
        if ($stmtInsert->execute()) {
            return "Aluno atribuído à turma com sucesso!";
        } else {
            return "Erro ao atribuir aluno à turma: " . $stmtInsert->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['escolher_turma'])) {
    $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
    $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

    if (!$aluno_id || !$turma_id) {
        die("Selecione um aluno e uma turma válidos.");
    }

    $message = atribuirTurma($conn, $aluno_id, $turma_id);

    // Exibe uma mensagem e redireciona
    echo "<script>alert('$message'); window.location.href = 'escolher_turma.php';</script>";
    exit;
}

// Função para obter turmas atribuídas
function getTurmasAtribuidas($conn) {
    $sql = "SELECT m.id, a.nome AS aluno_nome, t.disciplina AS turma_nome 
            FROM matricula m
            JOIN aluno a ON m.aluno_id = a.id
            JOIN turma t ON m.turma_id = t.id";
    $result = $conn->query($sql);
    return $result;
}
$disciplina = filter_input(INPUT_POST, 'disciplina', FILTER_SANITIZE_STRING);
$professor_id = filter_input(INPUT_POST, 'professor_id', FILTER_SANITIZE_NUMBER_INT);
$alunos = $_POST['aluno']; // Array de IDs de alunos selecionados

$sqlTurma = "INSERT INTO turma (disciplina, professor_id, coordenador_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sqlTurma);
$stmt->bind_param("sii", $disciplina, $professor_id, $coordenador_id);
$stmt->execute();
$turma_id = $stmt->insert_id; // Pega o ID da turma recém-criada


header('Location: ../pages/criarTurmas.php');
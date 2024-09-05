<?php
include "conexao.php";
// Função para atribuir um aluno a uma turma
function atribuirTurma($conn, $aluno_id, $turma_id) {
    // Verificar se o aluno já está matriculado em uma turma
    $sqlCheck = "SELECT * FROM matricula WHERE aluno_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck); // Prepara a consulta para verificar a matrícula existente.
    $stmtCheck->bind_param("i", $aluno_id); // Liga o parâmetro da consulta.
    $stmtCheck->execute(); // Executa a consulta.
    $result = $stmtCheck->get_result(); // Obtém o resultado da execução.

    if ($result->num_rows > 0) {
        // Atualizar a turma do aluno existente
        $sqlUpdate = "UPDATE matricula SET turma_id = ? WHERE aluno_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate); // Prepara a consulta para atualizar a matrícula existente.
        $stmtUpdate->bind_param("ii", $turma_id, $aluno_id); // Liga os parâmetros da consulta.
        if ($stmtUpdate->execute()) {
            return "Turma do aluno atualizada com sucesso!"; // Retorna mensagem de sucesso se a atualização for bem-sucedida.
        } else {
            return "Erro ao atualizar a turma: " . $stmtUpdate->error; // Retorna mensagem de erro se a atualização falhar.
        }
    } else {
        // Inserir nova matrícula
        $sqlInsert = "INSERT INTO matricula (aluno_id, turma_id) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert); // Prepara a consulta para inserir uma nova matrícula.
        $stmtInsert->bind_param("ii", $aluno_id, $turma_id); // Liga os parâmetros da consulta.
        if ($stmtInsert->execute()) {
            return "Aluno atribuído à turma com sucesso!"; // Retorna mensagem de sucesso se a inserção for bem-sucedida.
        } else {
            return "Erro ao atribuir aluno à turma: " . $stmtInsert->error; // Retorna mensagem de erro se a inserção falhar.
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['escolher_turma'])) {
    $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT); // Filtra e valida o ID do aluno.
    $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT); // Filtra e valida o ID da turma.

    if (!$aluno_id || !$turma_id) {
        die("Selecione um aluno e uma turma válidos."); // Exibe mensagem de erro e encerra o script se os IDs não forem válidos.
    }

    $message = atribuirTurma($conn, $aluno_id, $turma_id); // Chama a função para atribuir o aluno à turma e obtém a mensagem de resultado.

    // Exibe uma mensagem de alerta e redireciona o usuário para 'escolher_turma.php'.
    echo "<script>alert('$message'); window.location.href = 'escolher_turma.php';</script>";
    exit;
}

// Função para obter turmas atribuídas
function getTurmasAtribuidas($conn) {
    $sql = "SELECT m.id, a.nome AS aluno_nome, t.disciplina AS turma_nome 
            FROM matricula m
            JOIN aluno a ON m.aluno_id = a.id
            JOIN turma t ON m.turma_id = t.id"; // Consulta SQL para obter turmas atribuídas, incluindo informações do aluno e da turma.
    $result = $conn->query($sql); // Executa a consulta e obtém o resultado.
    return $result; // Retorna o resultado da consulta.
}

$disciplina = filter_input(INPUT_POST, 'disciplina', FILTER_SANITIZE_STRING); // Filtra e sanitiza o nome da disciplina.
$professor_id = filter_input(INPUT_POST, 'professor_id', FILTER_SANITIZE_NUMBER_INT); // Filtra e sanitiza o ID do professor.
$alunos = $_POST['aluno']; // Obtém o array de IDs de alunos selecionados.

$sqlTurma = "INSERT INTO turma (disciplina, professor_id, coordenador_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sqlTurma); // Prepara a consulta para inserir uma nova turma.
$stmt->bind_param("sii", $disciplina, $professor_id, $coordenador_id); // Liga os parâmetros da consulta.
$stmt->execute(); // Executa a consulta para inserir a nova turma.
$turma_id = $stmt->insert_id; // Obtém o ID da turma recém-criada.

header('Location: ../pages/diretor/criarTurmas.php'); // Redireciona o usuário para a página de criação de turmas.
?>

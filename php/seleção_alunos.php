<?php
include "conexao.php"; // Inclui o arquivo 'processamento.php', que deve conter a conexão com o banco de dados.

if (isset($_POST['escolher_turma'])) { // Verifica se o formulário foi enviado com o campo 'escolher_turma'
    $aluno_id = $_POST['aluno_id']; // Obtém o ID do aluno a partir do formulário POST.
    $turma_id = $_POST['turma_id']; // Obtém o ID da turma a partir do formulário POST.

    // Prepara a consulta SQL para inserir ou atualizar a matrícula do aluno na turma.
    // Se o aluno já estiver matriculado na turma, a cláusula ON DUPLICATE KEY UPDATE garantirá que a turma_id seja atualizada.
    $sqlMatricula = "INSERT INTO matricula (aluno_id, turma_id) VALUES (?, ?) 
                     ON DUPLICATE KEY UPDATE turma_id = VALUES(turma_id)";
    $stmt = $conn->prepare($sqlMatricula); // Prepara a consulta para execução.
    $stmt->bind_param("ii", $aluno_id, $turma_id); // Liga os parâmetros da consulta SQL aos valores fornecidos.

    if ($stmt->execute()) { // Executa a consulta SQL
        echo "Aluno atribuído à turma com sucesso!<br>"; // Exibe uma mensagem de sucesso se a execução for bem-sucedida.
    } else {
        echo "Erro ao atribuir aluno à turma: " . $stmt->error . "<br>"; // Exibe uma mensagem de erro se houver um problema na execução.
    }

    $stmt->close(); // Fecha a declaração preparada.
}
?>

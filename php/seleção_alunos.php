<?php
include "processamento.php";
if (isset($_POST['escolher_turma'])) {
    $aluno_id = $_POST['aluno_id'];
    $turma_id = $_POST['turma_id'];

    // Insere ou atualiza a tabela matricula
    $sqlMatricula = "INSERT INTO matricula (aluno_id, turma_id) VALUES (?, ?) 
                     ON DUPLICATE KEY UPDATE turma_id = VALUES(turma_id)";
    $stmt = $conn->prepare($sqlMatricula);
    $stmt->bind_param("ii", $aluno_id, $turma_id);

    if ($stmt->execute()) {
        echo "Aluno atribuído à turma com sucesso!<br>";
    } else {
        echo "Erro ao atribuir aluno à turma: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
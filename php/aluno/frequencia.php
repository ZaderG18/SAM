<?php 
include '../global/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_SANITIZE_NUMBER_INT);
    $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_SANITIZE_NUMBER_INT);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $presenca = filter_input(INPUT_POST, 'presenca', FILTER_SANITIZE_STRING);

    try {
        if (!empty($_POST['id'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $conn->prepare("UPDATE frequencia SET presenca = :presenca WHERE id = :id");
            $stmt->execute(['presenca' => $presenca, 'id' => $id]);
            $mensagem = 'FREQUENCIA_ATUALIZADA';
        } else {
            $stmt = $conn->prepare("INSERT INTO frequencia (aluno_id, turma_id, data, presenca) VALUES (:aluno_id, :turma_id, :data, :presenca)");
            $stmt->execute(['aluno_id' => $aluno_id, 'turma_id' => $turma_id, 'data' => $data, 'presenca' => $presenca]);
            $mensagem = 'FREQUENCIA_ADICIONADA';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// If an ID for attendance was passed, fetch the data for editing
if (!empty($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare('SELECT * FROM frequencia WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $frequencia = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

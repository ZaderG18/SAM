<?php
function get_todos_alunos($conn) {
    $stmt = $conn->prepare("SELECT id, nome, email, RM, codigo FROM aluno");
    $stmt->execute();
    return $stmt->get_result();
}

function get_todos_professores($conn) {
    $stmt = $conn->prepare("SELECT id, RM, nome, email, codigo FROM professor");
    $stmt->execute();
    return $stmt->get_result();
}

function get_todos_alunos_e_professores($conn) {
    $alunos = get_todos_alunos($conn);
    $professores = get_todos_professores($conn);
    return ['aluno' => $alunos, 'professor' => $professores];
}

function get_aluno_especifico($conn, $RM) {
    $stmt = $conn->prepare("SELECT id, nome, email, RM, codigo FROM aluno WHERE RM = ?");
    $stmt->bind_param("s", $RM);
    $stmt->execute();
    return $stmt->get_result();
}
?>
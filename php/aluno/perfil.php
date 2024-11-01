<?php
function getAtividadesExtracurriculares($conn, $id) {
    $query = "SELECT descricao FROM atividade_extracurricular WHERE aluno_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $atividades = [];
    while ($row = $result->fetch_assoc()) {
        $atividades[] = $row['descricao'];
    }
    return $atividades;
}
function getAlunoData($conn, $id) {
    $query = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function getAcademicoData($conn, $id) {
    $query = "SELECT * FROM academico WHERE aluno_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function getContatoEmergencia($conn, $id) {
    $query = "SELECT * FROM contato_emergencia WHERE aluno_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}




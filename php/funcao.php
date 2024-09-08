<?php
// Função para obter todos os alunos do banco de dados.
function get_todos_alunos($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Aluno' AS cargo FROM aluno");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os professores do banco de dados.
function get_todos_professores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Professor' AS cargo FROM professor");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os coordenadores do banco de dados.
function get_todos_coordenadores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Coordenador' AS cargo FROM coordenador");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os diretores do banco de dados.
function get_todos_diretores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Diretor' AS cargo FROM diretor");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os usuários do banco de dados.
function get_todos_usuarios($conn) {
    $alunos = get_todos_alunos($conn);
    $professores = get_todos_professores($conn);
    $coordenadores = get_todos_coordenadores($conn);
    $diretores = get_todos_diretores($conn);

    // Combina os resultados em um único array.
    $todos = [];
    while ($row = $alunos->fetch_assoc()) {
        $todos[] = $row;
    }
    while ($row = $professores->fetch_assoc()) {
        $todos[] = $row;
    }
    while ($row = $coordenadores->fetch_assoc()) {
        $todos[] = $row;
    }
    while ($row = $diretores->fetch_assoc()) {
        $todos[] = $row;
    }

    return $todos;
}
function total_alunos($conn){
    $stmt = $conn ->prepare("SELECT COUNT(*) AS total FROM aluno");
    $stmt->execute();
    $resutado = $stmt -> get_result();
    $row = $resutado->fetch_assoc();
    return $row["total"];
}
function total_professores($conn){
    $stmt = $conn -> prepare("SELECT COUNT(*) AS total FROM professor");
    $stmt->execute();
    $resutado = $stmt -> get_result();
    $row = $resutado->fetch_assoc();
    return $row["total"];
}
?>

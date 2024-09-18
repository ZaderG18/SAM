<?php
// Função para obter todos os alunos do banco de dados.
function get_todos_alunos($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Aluno' AS cargo, data_criacao FROM aluno ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os professores do banco de dados.
function get_todos_professores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, email, 'Professor' AS cargo, data_criacao FROM professor ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os coordenadores do banco de dados.
function get_todos_coordenadores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Coordenador' AS cargo, data_criacao FROM coordenador ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os diretores do banco de dados.
function get_todos_diretores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Diretor' AS cargo, data_criacao FROM diretor ORDER BY data_criacao DESC");
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
    $maximo_registros = 6;

    function adicionar_registros(&$todos, $resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $todos[] = $row;
        }
    }

    adicionar_registros($todos, $alunos);
    adicionar_registros($todos, $professores);
    adicionar_registros($todos, $coordenadores);
    adicionar_registros($todos, $diretores);

    // Ordena por 'data_criacao' se estiver disponível
    usort($todos, function($a, $b) {
        if (!isset($a['data_criacao']) || !isset($b['data_criacao'])) {
            return 0;
        }
        return strtotime($b['data_criacao']) - strtotime($a['data_criacao']);
    });

    // Limita o número de registros a 6
    $todos = array_slice($todos, 0, $maximo_registros);

    return $todos;
}

// Funções para contar o total de registros
function total_alunos($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM aluno");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}

function total_professores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM professor");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}

function total_coordenadores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM coordenador");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}

function total_diretores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM diretor");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}
?>

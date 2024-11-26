<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Função para obter todos os alunos do banco de dados.
function get_todos_alunos($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Aluno' AS cargo, data_criacao FROM usuarios WHERE cargo = 'aluno' ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os professores do banco de dados.
function get_todos_professores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, cpf, email, 'Professor' AS cargo, data_criacao FROM usuarios WHERE cargo = 'professor' ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os coordenadores do banco de dados.
function get_todos_coordenadores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Coordenador' AS cargo, data_criacao FROM usuarios WHERE cargo = 'coordenador' ORDER BY data_criacao DESC");
    $stmt->execute();
    return $stmt->get_result();
}

// Função para obter todos os diretores do banco de dados.
function get_todos_diretores($conn) {
    $stmt = $conn->prepare("SELECT id, nome, RM, 'Diretor' AS cargo, data_criacao FROM usuarios WHERE cargo = 'diretor' ORDER BY data_criacao DESC");
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
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'aluno'");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}
function total_cursos($conn){
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM curso");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}
// Função para buscar alunos por critério
function fetchAlunosByStatus($status, $conn) {
    // Construção da consulta para buscar alunos com base no status da turma
    $query = "
        SELECT 
            usuarios.nome,
            usuarios.rm,
            turma.nome AS turma,
            usuarios.foto
        FROM usuarios
        INNER JOIN matricula ON usuarios.id = matricula.aluno_id
        INNER JOIN turma ON matricula.turma_id = turma.id
        WHERE usuarios.cargo = 'aluno'
    ";

    // Ajustar a consulta com base no status da turma
    if ($status === 'pendente') {
        $query .= " AND turma.status = 'pendente'";
    } elseif ($status === 'risco') {
        $query .= " AND turma.status = 'risco'";
    }

    // Preparar e executar a consulta
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Retornar os resultados como um array associativo
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getAccessData($conn) {
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM usuarios WHERE cargo = 'aluno') AS alunos,
            (SELECT COUNT(*) FROM usuarios WHERE cargo = 'coordenador') AS coordenadores,
            (SELECT COUNT(*) FROM usuarios WHERE cargo = 'diretor') AS diretores,
            (SELECT COUNT(*) FROM usuarios WHERE cargo = 'professor') AS professores
    ";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc(); // Retorna os dados como um array associativo
    }

    return [
        'alunos' => 0,
        'coordenadores' => 0,
        'diretores' => 0,
        'professores' => 0
    ]; // Retorna valores padrão caso a consulta falhe
}

function total_professores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'professor'");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}

function total_coordenadores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'coordenador'");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}

function total_diretores($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'diretor'");
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    return $row["total"];
}
?>

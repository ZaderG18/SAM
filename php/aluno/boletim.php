<?php
// Verifica se a sessão já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicie a sessão apenas se ainda não estiver ativa
}

// Configuração do banco de dados
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

$cursoId = $_SESSION['curso_id'] ?? null;
$turmaId = $_SESSION['turma_id'] ?? null;
// Função para obter o curso do aluno


// Função para obter a turma do aluno
function getCurso($conn, $cursoId) {
    try {
        $sql = "SELECT * FROM curso WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $cursoId);
        $stmt->execute();
        $result = $stmt->get_result();
        $curso = $result->fetch_assoc();
        $stmt->close();
        
        return $curso ?: null;
    } catch (Exception $e) {
        echo "Erro ao obter o curso: " . $e->getMessage();
        return null;
    }
}

function getTurma($conn, $turmaId) {
    try {
        $sql = "SELECT * FROM turma WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $turmaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $turma = $result->fetch_assoc();
        $stmt->close();
        
        return $turma ?: null;
    } catch (Exception $e) {
        echo "Erro ao obter a turma: " . $e->getMessage();
        return null;
    }
}



// Função para obter notas
// Função para obter todas as notas do aluno
function getTodasNotas($conn, $id) {
    $query = "
        SELECT n.*, d.nome_disciplina AS disciplina
        FROM notas n
        JOIN disciplina d ON n.disciplina_id = d.id
        WHERE n.aluno_id = ?
    ";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// Obtendo todas as notas do aluno
$notas = getTodasNotas($conn, $id);

// Obter dados do curso e da turma
$curso = getCurso($conn, $cursoId);
$turma = getTurma($conn, $turmaId);


// Função para calcular a situação
function calcularSituacao($nota1, $nota2) {
    if (is_null($nota1) || is_null($nota2)) {
        return 'Dados insuficientes';
    }
    $media = ($nota1 + $nota2) / 2;
    return $media >= 5 ? 'Aprovado' : 'Reprovado';
}

function getAluno($conn, $id) {
    try {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();
        
        return $usuario;
    } catch (Exception $e) {
        echo "Erro ao obter o usuário: " . $e->getMessage();
    }
}
// Atualizando o loop para gerar os modais corretamente
$modals = [];
$sql = "SELECT * FROM modulo";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $modalId = strtolower(str_replace(' ', '-', $row['nome_modulo'])); // Defina o modalId corretamente
        $modals[] = [
            'id' => $modalId,
            'titulo' => $row['nome_modulo'],
            'criterio' => isset($row['criterio']) ? explode(';', $row['criterio']) : []
        ];
    }
}


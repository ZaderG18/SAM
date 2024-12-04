<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

/**
 * Função para obter informações de um professor pelo ID.
 */
function getProfessor($conn, $id) {
    $sql = "SELECT * FROM professor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar se o professor foi encontrado
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();  // Retorna os dados se encontrado
    } else {
        return null;  // Retorna null se não encontrado
    }
}


/**
 * Função para obter informações do usuário pelo ID.
 */
function getUsuario($conn, $id) {
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

/**
 * Função para obter informações de contato de emergência pelo ID.
 */
function getContatoEmergencia($conn, $id) {
    try {
        $sql = "SELECT * FROM contato_emergencia WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $contatoEmergencia = $result->fetch_assoc();
        $stmt->close();
        
        return $contatoEmergencia;
    } catch (Exception $e) {
        echo "Erro ao obter o contato de emergência: " . $e->getMessage();
    }
}

/**
 * Função para obter atividades extracurriculares do professor.
 */
function getAtividadesExtraCurriculares($conn, $professorId) {
    try {
        $sql = "SELECT * FROM atividade_extracurricular WHERE professor_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $professorId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $atividades = [];
        while ($row = $result->fetch_assoc()) {
            $atividades[] = $row['atividade'];
        }
        
        $stmt->close();
        
        return $atividades;
    } catch (Exception $e) {
        echo "Erro ao obter as atividades extracurriculares: " . $e->getMessage();
    }
}
function getProjetosProfessor($conn, $professorId) {
    $sql = "SELECT projetos, projetos_pesquisa FROM professor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $professorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $professor = $result->fetch_assoc();
    
    // Verifica se existe algum dado e separa os projetos por vírgula
    $projetos = isset($professor['projetos']) ? explode(',', $professor['projetos']) : [];
    $projetosPesquisa = isset($professor['projetos_pesquisa']) ? explode(',', $professor['projetos_pesquisa']) : [];

    return array_merge($projetos, $projetosPesquisa);  // Retorna os projetos combinados
}
function getEventos($conn, $id) {
    $sql = "SELECT * FROM eventos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $evento = $result->fetch_assoc();
    $stmt->close();
    return $evento;
}
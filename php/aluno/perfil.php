<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getAtividadesExtracurriculares($conn, $id) {
    try {
        $sql = "SELECT * FROM atividade_extracurricular WHERE professor_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Erro ao preparar a consulta: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id);
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
function getAlunoData($conn, $id) {
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
function getAcademicoData($conn, $id) {
    $query = "SELECT * FROM academico WHERE aluno_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
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

function getCurso($conn, $id) {
    $query = "SELECT * FROM curso WHERE aluno_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


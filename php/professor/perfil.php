<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

function getProfessor($conn ,$id) {
$sql = "SELECT * FROM professor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();
return $professor;
}
function getUsuario($conn ,$id) {
$sql = "SELECT* FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
return $usuario;
}
function getContatoEmergencia($conn ,$id) {
    $sql = "SELECT * FROM contato_emergencia WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contatoEmergencia = $result->fetch_assoc();
    return $contatoEmergencia;
}
function getAtividadesExtraCurriculares($conn, $professorId) {
    $sql = "SELECT * FROM atividade_extracurricular WHERE professor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $professorId);
    $stmt->execute();
    $result = $stmt->get_result();
    $atividades = [];
    while ($row = $result->fetch_assoc()) {
        $atividades[] = $row['atividade'];
    }
    return $atividades;
}

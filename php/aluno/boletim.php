<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sam";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn ->connect_error){
    die("erro na conexão com o banco de dados");
}
function getNotas($alunoId) {
    global $conn; // Supondo que você tenha uma conexão com o banco de dados
    $query = "
        SELECT n.*, d.nome_disciplina AS disciplina
        FROM notas n
        JOIN disciplina d ON n.disciplina_id = d.id
        WHERE n.aluno_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $alunoId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
function getModulos() {
    global $conn;
    $query = "SELECT * FROM modulo"; // Supondo que você tenha uma tabela modulo
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$modulos = getModulos(); // Chame a função para obter módulos

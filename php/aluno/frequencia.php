<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verifica se foi passado o módulo via POST
if (isset($_POST['modulo'])) {
    $modulo = $_POST['modulo'];

    // ID do aluno (pegando da sessão)
    session_start();
    $user = $_SESSION['user'];
    $alunoId = $user['id'];

    // Consulta para buscar as frequências do aluno para o módulo selecionado
    $sql = "SELECT d.nome AS disciplina, f.frequencia AS frequencia 
            FROM frequencia f
            JOIN disciplina d ON f.disciplina_id = d.id
            WHERE f.aluno_id = ? AND f.modulo = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $alunoId, $modulo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Array para armazenar as frequências
    $frequencias = [];

    while ($row = $result->fetch_assoc()) {
        $frequencias[] = [
            'disciplina' => $row['disciplina'],
            'frequencia' => $row['frequencia']
        ];
    }

    // Retorna os dados em formato JSON
    echo json_encode($frequencias);
}
?>

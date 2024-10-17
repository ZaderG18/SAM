<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Suponha que o ID do professor esteja armazenado na sessão
$professor_id = $_SESSION['user']['id'];

// Consulta para obter os dados do professor
$sql = "SELECT nome, genero FROM professor WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se os dados foram encontrados
if ($result->num_rows > 0) {
    $professor = $result->fetch_assoc(); // Preenche a variável $professor com os dados
} else {
    echo "Nenhum professor encontrado.";
}

$stmt->close();

if (isset($professor)) {
    $genero = $professor['genero']; // Verifica se o gênero existe dentro do array $professor
    if ($genero === 'masculino') {
        $denominacao = "Professor";
    } elseif ($genero === 'feminino') {
        $denominacao = "Professora";
    } else {
        $denominacao = "Professor(a)";
    }

}


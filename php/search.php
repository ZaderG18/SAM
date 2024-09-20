<?php
$host = "localhost";
$username = "root";
$password = ""; // Assumindo que não tem senha no ambiente local
$dbname = "sam";

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Função para procurar professores
    function procurarProfessor($conn) {
        if (isset($_GET['q'])) {
            $query = $_GET['q'];

            // Preparar a consulta SQL para buscar resultados na tabela de professores
            $stmt = $conn->prepare("SELECT nome, cpf, disciplina, rm, foto FROM professor WHERE nome LIKE :query LIMIT 10");
            $stmt->execute([':query' => '%' . $query . '%']);
            
            // Buscar os resultados
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retornar os resultados como JSON
            echo json_encode($result);
        }
    }

    // Chama a função para executar a busca
    procurarProfessor($conn);

} catch (PDOException $e) {
    header('Content-Type: application/json');
    // Retornar erro em formato JSON
    echo json_encode(['erro' => $e->getMessage()]);
}
?>

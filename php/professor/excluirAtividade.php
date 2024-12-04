<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);
// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Verificar se o id da atividade foi passado na URL
if (isset($_GET['id'])) {
    $id_atividade = $_GET['id']; // Obter o ID da atividade

    // Preparar a consulta SQL para excluir a atividade
    $query = "DELETE FROM atividade WHERE id = ?";
    
    // Preparar a consulta
    if ($stmt = $conn->prepare($query)) {
        // Bind do parâmetro
        $stmt->bind_param("i", $id_atividade); // "i" é para integer (id da atividade)

        // Executar a consulta
        if ($stmt->execute()) {
            // Se a exclusão for bem-sucedida, redireciona de volta para a página de atividades
            header("Location: ../../pages/professor/aulas.php?status=sucesso");
            exit;
        } else {
            // Se falhar, exibe uma mensagem de erro
            echo "<script>alert('Erro ao excluir a atividade.');
            window.location.href='../../pages/professor/aulas.php';</script>";
        }

        // Fechar o statement
        $stmt->close();
    } else {
        echo "<script>alert('Erro ao preparar a consulta.')
        window.location.href='../../pages/professor/aulas.php';</script>";
    }
} else {
    echo "<script>alert('ID não especificado.');
    window.location.href='../../pages/professor/aulas.php';</script>";
}


?>

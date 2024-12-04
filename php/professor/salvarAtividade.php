<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os dados foram enviados corretamente
    if (isset($_POST['id'], $_POST['descricao'], $_POST['data_vencimento'])) {
        $atividade_id = $_POST['id'];
        $descricao = $_POST['descricao'];
        $data_vencimento = $_POST['data_vencimento'];

        // Atualiza a atividade no banco de dados
        $query = "UPDATE atividade SET descricao = ?, data_vencimento = ? WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Bind dos parâmetros
        $stmt->bind_param('ssi', $descricao, $data_vencimento, $atividade_id);

        // Executa a query
        if ($stmt->execute()) {
            echo "<script>alert('Atividade atualizada com sucesso!');
            window.location.href='../../pages/professor/aulas.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar a atividade.');
            window.location.href='../../pages/professor/aulas.php';</script>";
        }
    } else {
        echo "<script>alert('Erro: Dados não enviados corretamente.')
        window.location.href='../../pages/professor/aulas.php';</script>";
    }
}

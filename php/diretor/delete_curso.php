<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);


// Verifica se o ID do curso foi fornecido na URL
if (isset($_GET['id'])) {
    $curso_id = intval($_GET['id']); // Obtém e converte o ID do curso para um inteiro

    // Consulta SQL para verificar se o curso existe na tabela 'cursos'
    $sql = "SELECT * FROM curso WHERE id = $curso_id"; // Prepara a consulta
    $result = $conn->query($sql); // Executa a consulta

    // Verifica se algum curso foi encontrado
    if ($result->num_rows > 0) {
        // Se o curso existe, prepara a consulta para deletá-lo
        $sql_delete = "DELETE FROM curso WHERE id = $curso_id"; // SQL para deletar o curso
        // Executa a consulta de deleção
        if ($conn->query($sql_delete) === TRUE) {
            // Se a deleção foi bem-sucedida, retorna uma mensagem de sucesso em formato JSON
            echo json_encode(["status" => "success", "message" => "Curso deletado com sucesso."]);
        } else {
            // Se houve erro ao deletar, retorna uma mensagem de erro
            echo json_encode(["status" => "error", "message" => "Erro ao deletar o curso: " . $conn->error]);
        }
    } else {
        // Se o curso não foi encontrado, retorna uma mensagem de erro
        echo json_encode(["status" => "error", "message" => "Curso não encontrado."]);
    }
} else {
    // Se o ID do curso não foi fornecido, retorna uma mensagem de erro
    echo json_encode(["status" => "error", "message" => "ID do curso não fornecido."]);
}

// Fecha a conexão com o banco de dados
$conn->close(); // Fecha a conexão com o banco de dados
?>

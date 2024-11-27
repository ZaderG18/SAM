<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeCompleto = $_POST['nome_completo'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    $curso = $_POST['curso'];
    $mensagem = $_POST['mensagem'];
    
    // Upload de arquivo
    $arquivoNome = $_FILES['arquivo']['name'];
    $arquivoTemp = $_FILES['arquivo']['tmp_name'];
    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . basename($arquivoNome);

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($arquivoTemp, $uploadPath)) {
        $arquivoSalvo = $uploadPath;
    } else {
        $arquivoSalvo = null;
    }

    // Conectar ao banco
    $conn = new mysqli('localhost', 'root', '', 'sam');

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Inserir os dados
    $stmt = $conn->prepare("INSERT INTO solicitacoes (nome_completo, telefone, email, id_usuario, curso_id, mensagem, arquivo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $nomeCompleto, $telefone, $email, $id, $curso, $mensagem, $arquivoSalvo);

    if ($stmt->execute()) {
        echo "Solicitação enviada com sucesso!";
    } else {
        echo "Erro ao enviar solicitação: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

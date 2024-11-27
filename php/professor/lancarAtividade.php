<?php
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";
$conn = new mysqli($host, $username, $password, $dbName);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos obrigatórios foram enviados
    if (isset($_POST['titulo'], $_POST['descricao'], $_FILES['arquivo'])) {
        $nomeAtividade = $conn->real_escape_string($_POST['titulo']);
        $descricao = $conn->real_escape_string($_POST['descricao']);

        // Verifica e processa o upload do arquivo
        $uploadDir = '../../assets/atividades/'; // Pasta onde os arquivos serão armazenados
        $arquivoNome = basename($_FILES['arquivo']['name']);
        $uploadFile = $uploadDir . $arquivoNome;

        // Valida o arquivo (tamanho e extensão permitida)
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'docx', 'txt', 'zip'];

        if (in_array($fileType, $allowedTypes) && $_FILES['arquivo']['size'] <= 5000000) { // Limite de 5MB
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadFile)) {
                // Insere os dados no banco de dados
                $query = "INSERT INTO atividade (titulo, descricao, arquivo) VALUES ('$nomeAtividade', '$descricao', '$arquivoNome')";

                if ($conn->query($query)) {
                    echo "Atividade cadastrada com sucesso!";
                } else {
                    echo "Erro ao cadastrar atividade: " . $conn->error;
                }
            } else {
                echo "Erro ao fazer upload do arquivo.";
            }
        } else {
            echo "Arquivo inválido ou tamanho excedido. Use formatos permitidos: " . implode(', ', $allowedTypes);
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
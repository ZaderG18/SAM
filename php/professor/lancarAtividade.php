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

        // Caminho absoluto para a pasta de upload
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/SAM/assets/atividades/'; // Caminho absoluto
        $arquivoNome = basename($_FILES['arquivo']['name']);
        $uploadFile = $uploadDir . $arquivoNome;

        // Valida o arquivo (tamanho e extensão permitida)
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'docx', 'txt', 'zip'];

        // Tamanho máximo de 50MB
        if (in_array($fileType, $allowedTypes) && $_FILES['arquivo']['size'] <= 50000000) {
            if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
                // Tenta mover o arquivo
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadFile)) {
                    // Usa uma consulta preparada para inserir dados no banco de dados
                    $query = $conn->prepare("INSERT INTO atividade (titulo, descricao, arquivo) VALUES (?, ?, ?)");
                    $query->bind_param("sss", $nomeAtividade, $descricao, $arquivoNome);

                    if ($query->execute()) {
                        echo "<script>alert('Atividade cadastrada com sucesso!');</script>";
                    } else {
                        echo "<script>alert('Erro ao cadastrar atividade: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Erro ao mover o arquivo para o diretório de destino.');</script>";
                }
            } else {
                echo "<script>alert('Erro ao fazer upload do arquivo. Código de erro: " . $_FILES['arquivo']['error'] . "');</script>";
            }
        } else {
            echo "<script>alert('Arquivo inválido ou tamanho excedido. Use formatos permitidos: " . implode(', ', $allowedTypes) . " e tamanho máximo de 50MB.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
    }
} else {
    echo "<script>alert('Método de solicitação inválido.');</script>";
}
?>

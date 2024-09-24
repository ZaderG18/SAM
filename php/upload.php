<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    //$sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_BCRYPT) : null;

    // Processa o upload da foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = 'img/uploads/fotos/';

        // Verifica se o diretório existe, caso contrário, cria
        if (!is_dir($fotoPasta)) {
            mkdir($fotoPasta, 0777, true);
        }

        // Valida o tipo de arquivo (apenas imagens)
        $fotoTipo = mime_content_type($fotoTemp);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fotoTipo, $tiposPermitidos)) {
            // Gera um nome único para a foto
            $fotoNovoNome = uniqid() . '_' . $fotoNome;
            $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;

            // Move a foto para o diretório
            if (move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                // Cadastra o usuário no banco de dados
                $sql = "INSERT INTO aluno (nome, email, senha, foto) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $nome,  $email, $senha, $fotoNovoNome);

                // Executa a consulta
                if ($stmt->execute()) {
                    echo "Usuário cadastrado com sucesso!";
                } else {
                    echo "Erro ao cadastrar usuário: " . $stmt->error;
                }

                // Fecha a declaração e conexão
                $stmt->close();
                $conn->close();
            } else {
                echo "Erro no upload da foto.";
            }
        } else {
            echo "Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.";
        }
    } else {
        echo "Nenhuma foto enviada ou erro no upload.";
    }
}
?>

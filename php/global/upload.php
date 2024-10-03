<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_STRING);
    $curso = filter_var($_POST['curso'], FILTER_SANITIZE_STRING);
    $data_nascimento = filter_var($_POST['data_nascimento'], FILTER_SANITIZE_STRING);
    $genero = filter_var($_POST['genero'], FILTER_SANITIZE_STRING);


    // Prepare SQL to update student data
    $sql = "UPDATE aluno 
            SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nome, $telefone, $email, $endereco, $curso, $data_nascimento, $genero, $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Dados do aluno atualizados com sucesso!'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
    } else {
        error_log("Erro ao atualizar dados: " . $stmt->error);
        echo "<script>alert('Erro ao atualizar os dados do aluno.'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
    }

    // Handle file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = '../../assets/img/uploads/';
    
        // Create directory if it doesn't exist
        if (!is_dir($fotoPasta)) {
            if (!mkdir($fotoPasta, 0777, true)) {
                die("Erro ao criar o diretório de upload.");
            }
        }
    
        // Validate file type
        $fotoTipo = mime_content_type($fotoTemp);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    
        if (in_array($fotoTipo, $tiposPermitidos)) {
            // Generate a unique name for the photo
            $fotoNovoNome = uniqid('foto_', true) . '.' . pathinfo($fotoNome, PATHINFO_EXTENSION);
            $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;
    
            // Move the photo to the directory
            if (move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                // Update the photo in the database
                if (isset($id) && !empty($id)) {
                    $sqlFoto = "INSERT INTO aluno SET foto = ? WHERE id = ?";
                    $stmtFoto = $conn->prepare($sqlFoto);
                    $stmtFoto->bind_param("si", $fotoNovoNome, $id);
    
                    if ($stmtFoto->execute()) {
                        echo "<script>alert('Foto do aluno atualizada com sucesso!'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
                    } else {
                        error_log("Erro ao atualizar a foto: " . $stmtFoto->error);
                        echo "<script>alert('Erro ao atualizar a foto do aluno.'); window.location.href='../../pages/aluno/configuracoes.php';</script>";
                    }
    
                    $stmtFoto->close();
                }
            } else {
                echo "Erro no upload da foto.";
            }
        } else {
            echo "Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.";
        }
    } else {
        // Handle upload errors
        if (isset($_FILES['foto'])) {
            switch ($_FILES['foto']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "A imagem excede o tamanho máximo permitido.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "A imagem excede o tamanho máximo permitido pelo formulário.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "O upload da imagem foi feito parcialmente.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "Nenhuma imagem foi enviada.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Pasta temporária ausente.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Falha em escrever a imagem no disco.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "Upload de imagem interrompido por uma extensão.";
                    break;
                default:
                    echo "Erro desconhecido no upload da imagem.";
                    break;
            }
        }
    }
}
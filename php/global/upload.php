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
session_start();
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $endereco = isset($_POST['endereco']) ? $_POST['endereco'] : null;
    $curso = isset($_POST['curso']) ? $_POST['curso'] : null;
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;

    // Prepara o SQL para atualizar os dados do aluno
    $sql = "UPDATE aluno 
            SET nome = ?, telefone = ?, email = ?, endereco = ?, curso = ?, data_nascimento = ?, genero = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nome, $telefone, $email, $endereco, $curso, $data_nascimento, $genero, $id);

    // Executa a consulta
    if ($stmt->execute()) {
        echo "<script> alert('Dados do aluno atualizados com sucesso!');
        window.location.href='../../pages/aluno/configuracoes.php';</script>";
    } else {
        echo "<script> alert('Erro ao atualizar os dados do aluno: ');
        window.location.href='../../pages/aluno/configuracoes.php';</script>" . $stmt->error;
    }

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = '../../assets/img/uploads/';
    
        // Verifica se o diretório existe, caso contrário, cria
        if (!is_dir($fotoPasta)) {
            if (!mkdir($fotoPasta, 0777, true)) {
                die("Erro ao criar o diretório de upload.");
            }
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
                // Verifique se a variável $id está definida e contém um valor válido
                if (isset($id) && !empty($id)) {
                    // Atualiza o campo 'foto' no banco de dados
                    $sqlFoto = "UPDATE aluno SET foto = ? WHERE id = ?";
                    $stmtFoto = $conn->prepare($sqlFoto);
    
                    if (!$stmtFoto) {
                        die("Erro na preparação da consulta: " . $conn->error);
                    }
    
                    $stmtFoto->bind_param("si", $fotoNovoNome, $id);
    
                    if ($stmtFoto->execute()) {
                        echo "<script> alert('Foto do aluno atualizada com sucesso!'); 
                        window.location.href = '../../pages/aluno/configuracoes.php';</script>";
                    } else {
                        // Exibe um erro caso a consulta não funcione
                        echo "Erro ao atualizar a foto do aluno: " . $stmtFoto->error;
                    }
    
                    // Fecha a declaração
                    $stmtFoto->close();
                } else {
                    echo "ID do aluno não encontrado.";
                }
            } else {
                echo "Erro no upload da foto.";
            }
        } else {
            echo "Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.";
        }
    } else {
        // Exibe mensagem de erro caso algo aconteça durante o upload
        switch ($_FILES['foto']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                echo "A imagem excede o tamanho máximo permitido pelo servidor.";
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
            default:
                echo "Erro no upload da imagem: " . $_FILES['foto']['error'];
                break;
        }
    }
}
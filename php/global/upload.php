<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurações de conexão com o banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para processar o upload da foto
function uploadFoto($conn) {

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = '../../assets/img/uploads/';

        if (!is_dir($fotoPasta)) {
            mkdir($fotoPasta, 0777, true);
        }

        $fotocargo = mime_content_type($fotoTemp);
        $cargosPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fotocargo, $cargosPermitidos)) {
            $fotoNovoNome = uniqid() . '_' . $fotoNome;
            $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;

            if (move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                $sqlFoto = "UPDATE usuarios SET foto = ? WHERE id = ?";
                $id = $_SESSION['user']['id'];
                
                $stmtFoto = $conn->prepare($sqlFoto);
                $stmtFoto->bind_param("si", $fotoNovoNome, $id);

                if ($stmtFoto->execute()) {
                    echo "<script> alert('Foto atualizada com sucesso!');</script>";
                } else {
                    echo "<script> alert('Erro ao atualizar a foto: " . $stmtFoto->error . "');</script>";
                }
                $stmtFoto->close();
            } else {
                echo "<script> alert('Erro no upload da foto.');</script>";
            }
        } else {
            echo "<script> alert('Formato de arquivo não permitido.');</script>";
        }
    } else {
        echo "<script> alert('Nenhum arquivo enviado ou erro no upload.');</script>";
    }

    echo "<script> window.location.href = '../../pages/" . $_SESSION['user']['cargo'] . "/configuracoes.php'; </script>";
}

// Função para redirecionamento com mensagem
function redirecionarComMensagem($mensagem, $url) {
    echo "<script>alert('$mensagem'); window.location.href = '$url';</script>";
}

// Função para atualizar informações pessoais com base no tipo de usuário
function atualizarInformacoes($conn) {
    $tipo_usuario = $_SESSION['user']['cargo']; // Tipo de usuário (aluno, professor, etc.)
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $genero = $_POST['genero'];
    $estado_civil = $_POST['estado_civil'];
    $data_nascimento = $_POST['data_nascimento'];
    $nacionalidade = filter_var($_POST['nacionalidade'], FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_SPECIAL_CHARS);
    $RM = filter_var($_POST['RM'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Monta o SQL de atualização dinamicamente com base no tipo de usuário
    $sql = "UPDATE usuarios SET nome=?, telefone=?, email=?, genero=?, estado_civil=?, data_nascimento=?, nacionalidade=?, endereco=?, RM=?";
    $param_types = "sssssssss";
    $params = [$nome, $telefone, $email, $genero, $estado_civil, $data_nascimento, $nacionalidade, $endereco, $RM];

    if ($tipo_usuario === 'aluno') {
        $curso = $_POST['curso'];
        $sql .= ", curso=?";
        $param_types .= "s";
        $params[] = $curso;
    }

    $sql .= " WHERE id=?";
    $param_types .= "i";
    $params[] = $_SESSION['user']['id'];

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($param_types, ...$params);

    if ($stmt->execute()) {
        redirecionarComMensagem('Informações atualizadas com sucesso!', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
    } else {
        redirecionarComMensagem('Erro ao atualizar informações.', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
    }
    $stmt->close();
}

// Função para atualizar a senha
function atualizarSenha($conn) {

    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($nova_senha === $confirmar_senha) {
        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user']['id']);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $senha_db = $row['senha'];

            if (password_verify($senha_atual, $senha_db)) {
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $nova_senha_hash, $_SESSION['user']['id']);

                if ($stmt_update->execute()) {
                    redirecionarComMensagem('Senha atualizada com sucesso!', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
                } else {
                    redirecionarComMensagem('Erro ao atualizar a senha.', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
                }
                $stmt_update->close();
            } else {
                redirecionarComMensagem('Senha atual incorreta!', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
            }
        } else {
            redirecionarComMensagem('Usuário não encontrado.', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
        }
        $stmt->close();
    } else {
        redirecionarComMensagem('As novas senhas não coincidem!', '../../pages/' . $_SESSION['user']['cargo'] . '/configuracoes.php');
    }
}

// Verifica qual formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_foto'])) {
        uploadFoto($conn);
    }

    if (isset($_POST['submit_informacoes'])) {
        atualizarInformacoes($conn);
    }

    if (isset($_POST['submit_senha'])) {
        atualizarSenha($conn);
    }
}
?>

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
// Verifica se o id do usuário está definido na sessão
if (!isset($_SESSION['user']['id'])) {
    die("Erro: ID do usuário não encontrado na sessão.");
}

// Função para processar o upload da foto
function uploadFoto($conn) {
    // Verifica se foi enviado um arquivo
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = basename($foto['name']);
        $fotoTemp = $foto['tmp_name'];
        $fotoPasta = '../../assets/img/uploads/';

        if (!is_dir($fotoPasta)) {
            mkdir($fotoPasta, 0777, true);
        }

        $fotoTipo = mime_content_type($fotoTemp);
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fotoTipo, $tiposPermitidos)) {
            $fotoNovoNome = uniqid() . '_' . $fotoNome;
            $fotoCaminhoCompleto = $fotoPasta . $fotoNovoNome;

            if (move_uploaded_file($fotoTemp, $fotoCaminhoCompleto)) {
                $sqlFoto = "UPDATE usuarios SET foto = ? WHERE id = ?";
                $id = $_SESSION['user']['id'];

                $stmtFoto = $conn->prepare($sqlFoto);
                $stmtFoto->bind_param("si", $fotoNovoNome, $id);

                if ($stmtFoto->execute()) {
                    echo "<script>alert('Foto do professor atualizada com sucesso!');</script>";
                } else {
                    echo "<script>alert('Erro ao atualizar a foto do professor: " . $stmtFoto->error . "');</script>";
                }
                $stmtFoto->close();
            } else {
                echo "<script>alert('Erro no upload da foto.');</script>";
            }
        } else {
            echo "<script>alert('Formato de arquivo não permitido. Apenas JPEG, PNG e GIF são aceitos.');</script>";
        }
    } else {
        echo "<script>alert('Nenhum arquivo foi enviado ou ocorreu um erro no upload.');</script>";
    }

    echo "<script>window.location.href = '../../pages/professor/configuracoes.php';</script>";
}


// Função auxiliar para redirecionamento com mensagem
function redirecionarComMensagem($mensagem, $url) {
    echo "<script>alert('$mensagem'); window.location.href = '$url';</script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar ao banco de dados
    $notificacao_email = $_POST['notificacao_email'];
    $notificacao_telefone = $_POST['notificacao_telefone'];
    $senha_segura = isset($_POST['senha_segura']) ? 1 : 0; // Assumindo checkbox ou toggle
    $receber_notificacoes = isset($_POST['receber_notificacoes']) ? 1 : 0;
    $compartilhar_dados = isset($_POST['compartilhar_dados']) ? 1 : 0;

    // Atualizar na tabela preferencias_notificacao
    $query = "UPDATE preferencias_notificacao SET 
                notificacao_email = ?, 
                notificacao_telefone = ?, 
                senha_segura = ?, 
                receber_notificacoes = ?, 
                compartilhar_dados = ? 
              WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iiiiii", $notificacao_email, $notificacao_telefone, $senha_segura, $receber_notificacoes, $compartilhar_dados, $userId);
    $stmt->execute();
    $stmt->close();
    
    // Redirecionar ou exibir mensagem de sucesso
    header("Location: perfil.php?status=sucesso");
}

// Função para atualizar informações pessoais
function atualizarInformacoes($conn) {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $estado_civil = $_POST['estado_civil'];
    $data_nascimento = $_POST['data_nascimento'];
    $nacionalidade = filter_var($_POST['nacionalidade'], FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_SPECIAL_CHARS);
    $RM = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Atualizar no banco de dados
    $sql = "UPDATE usuarios SET nome=?, telefone=?, email=?, genero=?, estado_civil=?, data_nascimento=?, nacionalidade=?, endereco=?, RM=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $nome, $telefone, $email, $genero, $estado_civil, $data_nascimento, $nacionalidade, $endereco, $RM, $_SESSION['user']['id']);

    if ($stmt->execute()) {
        redirecionarComMensagem('Informações pessoais atualizadas com sucesso!', '../../pages/professor/configuracoes.php');
    } else {
        redirecionarComMensagem('Erro ao atualizar as informações pessoais.', '../../pages/professor/configuracoes.php');
    }
    $stmt->close();
}

// Função para atualizar a senha
function atualizarSenha($conn) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verificar se as senhas coincidem
    if ($nova_senha === $confirmar_senha) {
        // Consultar a senha atual no banco
        $sql = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user']['id']);
        $stmt->execute();

        // Obter o resultado da consulta
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $senha_db = $row['senha'];

            // Verificar se a senha atual está correta
            if (password_verify($senha_atual, $senha_db)) {
                // Atualizar para a nova senha (criptografada)
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql_update = "UPDATE professor SET senha = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("si", $nova_senha_hash, $_SESSION['user']['id']);

                if ($stmt_update->execute()) {
                    redirecionarComMensagem('Senha atualizada com sucesso!', '../../pages/professor/configuracoes.php');
                } else {
                    redirecionarComMensagem('Erro ao atualizar a senha.', '../../pages/professor/configuracoes.php');
                }
                $stmt_update->close();
            } else {
                redirecionarComMensagem('Senha atual incorreta!', '../../pages/professor/configuracoes.php');
            }
        } else {
            redirecionarComMensagem('Usuário não encontrado.', '../../pages/professor/configuracoes.php');
        }
        $stmt->close();
    } else {
        redirecionarComMensagem('As novas senhas não coincidem!', '../../pages/professor/configuracoes.php');
    }
}

// Verifica qual formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Upload de foto
    if (isset($_POST['submit_foto'])) {
        uploadFoto($conn);
    }

    // Atualizar informações pessoais
    if (isset($_POST['submit_informacoes'])) {
        atualizarInformacoes($conn);
    }

    // Atualizar senha
    if (isset($_POST['submit_senha'])) {
        atualizarSenha($conn);
    }
}
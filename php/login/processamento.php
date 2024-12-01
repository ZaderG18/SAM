<?php
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

//include_once '../global/conexao.php';

try {
    $conn = new mysqli($host, $username, $password, $dbName);
    if ($conn->connect_error) {
        throw new Exception("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}

// Sanitiza e valida os dados do formulário
$usuarioEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$usuarioSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioRM = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_NUMBER_INT);
$usuarioNome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioCargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);

function redirecionarComMensagem($mensagem) {
    echo "<script>
            alert('$mensagem');
            window.location.href = '../../pages/login/cadastro.html';
          </script>";
    exit();
}

// Verifica campos obrigatórios
if (!$usuarioEmail || !$usuarioSenha || !$usuarioNome || !$usuarioRM || !$usuarioCargo) {
    redirecionarComMensagem("Todos os campos são obrigatórios!");
}

// Valida o cargo
if (!in_array($usuarioCargo, [1, 2, 3, 4])) {
    redirecionarComMensagem("Cargo inválido.");
}

// Valida a senha
function validarSenha($senha) {
    return preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/', $senha);
}

if (!validarSenha($usuarioSenha)) {
    redirecionarComMensagem("A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, um número e um caractere especial.");
}

// Gera o hash da senha
$hashedPassword = password_hash($usuarioSenha, PASSWORD_DEFAULT);

// Prepara a consulta para inserção na tabela 'usuarios'
$sqlInsert = "INSERT INTO usuarios (email, senha, RM, nome, cargo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlInsert);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("ssisi", $usuarioEmail, $hashedPassword, $usuarioRM, $usuarioNome, $usuarioCargo);

try {
    if ($stmt->execute()) {
        redirecionarComMensagem("Os dados foram inseridos com sucesso!");
    } else {
        redirecionarComMensagem("Não foi possível inserir os dados!");
    }
} catch (mysqli_sql_exception $e) {
    redirecionarComMensagem("Erro ao inserir os dados. Tente novamente mais tarde.");
}

$stmt->close();

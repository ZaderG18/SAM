<?php
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";
$conn = new mysqli($host, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
// include_once '../global/conexao.php';

// Sanitiza e valida os dados do formulário.
$usuarioEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$usuarioSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioRM = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_NUMBER_INT);
$usuarioNome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioCargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);

// Função para verificar campos obrigatórios
function verificarCamposObrigatorios($usuarioEmail, $usuarioSenha, $usuarioRM, $usuarioNome, $usuarioCargo) {
    if (!$usuarioEmail || !$usuarioSenha || !$usuarioNome || !$usuarioRM || !$usuarioCargo) {
        echo "<script>
                alert('Todos os campos são obrigatórios!');
                window.location.href = '../../pages/login/cadastro.html';
              </script>";
        exit();
    }
}

verificarCamposObrigatorios($usuarioEmail, $usuarioSenha, $usuarioRM, $usuarioNome, $usuarioCargo);

// Validação do cargo
if (!in_array($usuarioCargo, [1, 2, 3, 4])) {
    echo "<script>
            alert('Cargo inválido.');
            window.location.href = '../../pages/login/cadastro.html';
          </script>";
    exit();
}

// Função para verificar critérios de segurança de senha
function validarSenha($senha) {
    return preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/', $senha);
}

if (!validarSenha($usuarioSenha)) {
    echo "<script>
            alert('A senha deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, um número e um caractere especial.');
            window.location.href = '../../pages/login/cadastro.html';
          </script>";
    exit();
}

// Mapeia o cargo para o nome da tabela correspondente
$tableMap = [
    1 => 'aluno',
    2 => 'professor',
    3 => 'coordenador',
    4 => 'diretor'
];
$tableName = $tableMap[$usuarioCargo];

// Gera o hash da senha
$hashedPassword = password_hash($usuarioSenha, PASSWORD_DEFAULT);

// Prepara a consulta de inserção
$sqlInsert = "INSERT INTO usuarios (email, senha, RM, nome, cargo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlInsert);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("ssisi", $usuarioEmail, $hashedPassword, $usuarioRM, $usuarioNome, $usuarioCargo);

try {
    if ($stmt->execute()) {
        echo "<script>
                alert('Os dados foram inseridos com sucesso!');
                window.location.href = '../../pages/login/cadastro.html';
              </script>";
    } else {
        echo "<script>
                alert('Não foi possível inserir os dados!');
                window.location.href = '../../pages/login/cadastro.html';
              </script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>
            alert('Erro ao inserir os dados. Tente novamente mais tarde.');
            window.location.href = '../../pages/login/cadastro.html';
          </script>";
}

// Fecha a declaração
$stmt->close();
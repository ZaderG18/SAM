<?php

include "../global/conexao.php"; // Assegure-se de que a conexão usa MySQLi

// Sanitiza e valida os dados do formulário.
$usuarioEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$usuarioSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioRM = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_NUMBER_INT);
$usuarioNome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioCargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);

// Verifica se todos os campos obrigatórios foram preenchidos.
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
    die("Cargo inválido.");
}

// Critérios para uma senha segura
function ValidarSenha($senha){
    return preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/', $senha);
}

// Mapeia o cargo para o nome da tabela correspondente.
$tableMap = [
    1 => 'aluno',
    2 => 'professor',
    3 => 'coordenador',
    4 => 'diretor'
];

// Define o nome da tabela com base no cargo.
$tableName = $tableMap[$usuarioCargo];

// Gera o hash da senha.
$hashedPassword = password_hash($usuarioSenha, PASSWORD_DEFAULT);

// Prepara e executa a consulta de inserção dos dados na tabela apropriada.
$sqlInsert = "INSERT INTO $tableName (email, senha, RM, nome, cargo) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlInsert);
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
    echo "Erro: " . htmlspecialchars($e->getMessage());
}

$stmt->close(); // Fecha a declaração
$conn->close(); // Fecha a conexão
?>

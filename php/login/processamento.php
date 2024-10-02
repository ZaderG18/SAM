<?php

include "../global/conexao.php"; // Assegure-se de que a conexão usa PDO

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

// Verifica se o email já existe no banco de dados.
if (emailExiste($conn, $usuarioEmail)) {
    die("Email já existe");
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
$sqlInsert = "INSERT INTO $tableName (email, senha, RM, nome, cargo) VALUES (:email, :senha, :RM, :nome, :cargo)";
$stmt = $conn->prepare($sqlInsert);

$stmt->bindParam(':email', $usuarioEmail);
$stmt->bindParam(':senha', $hashedPassword);
$stmt->bindParam(':RM', $usuarioRM);
$stmt->bindParam(':nome', $usuarioNome);
$stmt->bindParam(':cargo', $usuarioCargo);

try {
    if ($stmt->execute()) {
        echo "<script>
                alert('Os dados foram inseridos com sucesso!');
                window.location.href = '../../pages/login/cadastro.html';
              </script>";
    } else {
        echo "Não foi possível inserir os dados na tabela.";
    }
} catch (PDOException $e) {
    echo "Erro: " . htmlspecialchars($e->getMessage());
}

// Função para verificar se o email já existe nas tabelas.
function emailExiste($conn, $email) {
    $sql = "SELECT id FROM aluno WHERE email = :email
            UNION
            SELECT id FROM professor WHERE email = :email
            UNION
            SELECT id FROM coordenador WHERE email = :email
            UNION
            SELECT id FROM diretor WHERE email = :email";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    
    $stmt->execute();
    return $stmt->rowCount() > 0;
}
?>

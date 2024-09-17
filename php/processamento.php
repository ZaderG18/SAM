<?php

include "conexao.php";

// Sanitiza e valida os dados do formulário.
$usuarioEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$usuarioSenha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioRM = filter_input(INPUT_POST, 'RM', FILTER_SANITIZE_NUMBER_INT);
$usuarioNome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$usuarioCargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT);

// Verifica se todos os campos obrigatórios foram preenchidos.
function verificarCamposObrigatorios($usuarioEmail, $usuarioSenha, $usuarioRM, $usuarioNome, $usuarioCargo) {
    // Verifica se algum dos campos obrigatórios está vazio.
    if (!$usuarioEmail || !$usuarioSenha || !$usuarioNome|| !$usuarioRM || !$usuarioCargo) {
        // Exibe uma mensagem de alerta e redireciona o usuário.
        echo "<script>
                alert('Todos os campos são obrigatórios!');
                window.location.href = 'pages/login/cadastro.html';
              </script>";
        exit(); // Encerra o script para garantir que o código subsequente não seja executado.
    }
}

$usuarioEmail = $_POST['email'] ?? '';
$usuarioSenha = $_POST['senha'] ?? '';
$usuarioNome = $_POST['nome'] ?? '';
$usuarioRM = $_POST['RM'] ?? '';
$usuarioCargo = $_POST['cargo'] ?? '';

verificarCamposObrigatorios($usuarioEmail, $usuarioSenha, $usuarioRM, $usuarioNome, $usuarioCargo);

// Validação do cargo
if (!in_array($usuarioCargo, [1, 2, 3, 4])) {
    die("Cargo inválido.");
}

// Verifica se o email já existe no banco de dados.
if (emailExiste($conn, $usuarioEmail)) {
    die ("Email já existe");
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
$stmt->bind_param("ssssi", $usuarioEmail, $hashedPassword, $usuarioRM, $usuarioNome, $usuarioCargo);

if ($stmt->execute()) {
    ?>
    <script>
     alert("Os dados foram inseridos com sucesso!<br>");
     window.location.href = "pages/login/cadastro.html";
     </script>
     <?php
} else {
    echo "Não foi possível inserir os dados na tabela: " . $stmt->error;
}

// Redireciona o usuário para a página de cadastro após as operações.
header('Location: ../pages/login/cadastro.html');
exit;

// Função para verificar se o email já existe nas tabelas 'aluno', 'professor', 'coordenador' ou 'diretor'.
function emailExiste($conn, $email) {
    $sql = "SELECT id FROM aluno WHERE email = ?
            UNION
            SELECT id FROM professor WHERE email = ?
            UNION
            SELECT id FROM coordenador WHERE email = ?
            UNION
            SELECT id FROM diretor WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssss", $email, $email, $email, $email);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    } else {
        die("Erro na query: " . $conn->error);
    }
}

// Fecha a conexão com o banco de dados.
$conn -> close();

?>
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

// Função para atualizar informações pessoais
function atualizarInformacoes($conn) {
    // Verificar se o tipo do usuário está definido na sessão
    if (!isset($_SESSION['user']['tipo'])) {
        die("Erro: tipo de usuário não definido.");
    }

    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $genero = $_POST['genero'];
    $estado_civil = $_POST['estado_civil'];
    $data_nascimento = $_POST['data_nascimento'];
    $nacionalidade = filter_var($_POST['nacionalidade'], FILTER_SANITIZE_SPECIAL_CHARS);
    $endereco = filter_var($_POST['endereco'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Definindo o tipo de usuário (aluno ou professor)
    $tipoUsuario = $_SESSION['user']['tipo']; // 'aluno' ou 'professor'

    // Montar a query de acordo com o tipo de usuário
    if ($tipoUsuario === 'aluno') {
        $sql = "UPDATE aluno SET nome=?, telefone=?, email=?, genero=?, estado_civil=?, data_nascimento=?, nacionalidade=?, endereco=? WHERE id=?";
    } elseif ($tipoUsuario === 'professor') {
        $sql = "UPDATE professor SET nome=?, telefone=?, email=?, genero=?, estado_civil=?, data_nascimento=?, nacionalidade=?, endereco=? WHERE id=?";
    } else {
        die("Tipo de usuário inválido.");
    }

    // Preparando a query
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Se houver erro na preparação da query, exiba a mensagem de erro
        die("Erro ao preparar a query: " . $conn->error);
    }

    // Bind dos parâmetros
    $stmt->bind_param("ssssssssi", $nome, $telefone, $email, $genero, $estado_civil, $data_nascimento, $nacionalidade, $endereco, $_SESSION['user_id']);

    // Executando a query
    if ($stmt->execute()) {
        // Redireciona com mensagem de sucesso
        redirecionarComMensagem('Informações pessoais atualizadas com sucesso!', '../../pages/aluno/configuracoes.php');
    } else {
        // Redireciona com mensagem de erro
        redirecionarComMensagem('Erro ao atualizar as informações pessoais.', '../../pages/aluno/configuracoes.php');
    }
    $stmt->close();
}

// Função auxiliar para redirecionamento com mensagem
function redirecionarComMensagem($mensagem, $url) {
    echo "<script>alert('$mensagem'); window.location.href = '$url';</script>";
}

// Verifica qual formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizar informações pessoais
    if (isset($_POST['submit_informacoes'])) {
        atualizarInformacoes($conn);
    }
}
?>

<?php
include_once "../php/conexao.php";
// Inicia a sessão
session_start();

// Verifica se o ID do usuário está definido na sessão
if (!isset($_SESSION['user_id'])) {
    die("Usuário não autenticado.");
}

// Declarando variáveis para conectar ao banco de dados
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao servidor MySQL
$conn = new mysqli($host, $username, $password);

// Verifica se houve erro na conexão com o servidor MySQL
if ($conn->connect_error) {
    die("Erro ao conectar ao servidor de banco de dados: " . $conn->connect_error);
}

// Criando o banco de dados 'SAM' se ele não existir
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    die("Erro ao criar banco de dados: " . $conn->error);
}

// Reestabelece a conexão ao banco de dados específico 'SAM'
$conn = new mysqli($host, $username, $password, $dbName);

// Verifica se houve erro na conexão com o banco de dados específico
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Obtém o ID do usuário atual da sessão
$usuario_atual_id = $_SESSION['user_id'];

// Prepara a consulta SQL para buscar contatos
$sql = "SELECT id, username FROM usuarios WHERE id != ?";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $conn->error);
}

$stmt->bind_param("i", $usuario_atual_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela principal</title>
    <link rel="stylesheet" href="../scss/mensagens.scss">
    <!--==== Box-icons ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <header>
        <div class="flex-icons">
            <div class="atalho-office">
                <img src="../imagens/pacoteoffice.webp" alt="Pacote Office">
            </div>
            <img src="../imagens/logo.jpg" alt="Logo">
        </div>
        <div class="box-serch">
            <i class='bx bx-search-alt-2'></i>
            <input type="text" placeholder="Pesquisar">
        </div>
        <div class="box-right">
            <i class='bx bx-dots-horizontal-rounded'></i>
            <i class='bx bxs-face'></i>
            <button><a href="../php/logout.php">Desconectar</a></button>
        </div>
    </header>
    <div class="flex-container">
        <aside>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-hourglass'></i>
                <span><a href="home_aluno.php">Frequência</a></span>
            </div>
            <div class="box-menu-01">
                <i class='bx bx-notepad'></i>
                <span>Boletim</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-graduation'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-message'></i>
                <span><a href="mensagens.html">Mensagens</a></span>
            </div>
            <div class="box-menu-01">
                <i class='bx bx-cog'></i>
                <span>Aplicativos</span>
            </div>
        </aside>
        <div class="box-chat">
            <div class="top-chat">
                <h4>Chat</h4>
                <div class="icons-chat">
                    <i class='bx bx-dots-horizontal-rounded'></i>
                    <i class='bx bx-edit-alt'></i>
                    <i class='bx bxs-user-pin'></i>
                </div>
            </div>
            <div class="box-contatos">
                <div class="box-recentes">
                    <i class='bx bxs-down-arrow'></i>
                    <h5>Recentes</h5>
                </div>
                <!-- Preencher os contatos dinamicamente com PHP -->
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="contatos">
                            <div class="box-perfil"></div>
                            <div class="content-usuario">
                                <h3>' . htmlspecialchars($row['username']) . '</h3>
                                <span>Lorem ipsum dolor sit amet</span>
                            </div>
                            <i class="bx bx-dots-horizontal-rounded"></i>
                          </div>';
                }
                ?>
            </div>
        </div>
        <div class="chat-aluno">
            <div class="header-aluno">
                <div class="box-aluno">
                    <div class="foto-perfil"></div>
                    <h1>Nome do aluno completo</h1> <!-- Aqui vai ficar o nome do usuario que se cadastrou no SAM -->
                </div>
                <div class="atalho-chat">
                    <h5>Chat</h5>
                    <h5>Arquivos</h5>
                    <i class='bx bxs-comment-add'></i>
                </div>
                <div class="tipo-chat">
                    <i class='bx bx-phone'></i>
                    <i class='bx bx-male-female'></i>
                    <i class='bx bx-dots-horizontal-rounded'></i>
                </div>
            </div>
            <form id="chat-form" method="POST" action="../php/chat.php">
                <input type="hidden" name="receptor_id" value="ID_DO_RECEPTOR"> <!-- Substituir pelo ID do receptor real -->
                <textarea name="mensagem" placeholder="Digite sua mensagem" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once '../php/funcao.php';
$user = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
$professores = get_todos_professores($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" type="imagex/png" href="../imagens/logo.jpg">
    <link rel="stylesheet" href="../scss/home.scss">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <header>
        <div class="flex-icons">
            <!--<i class='bx bxl-microsoft'></i>-->
            <div class="atalho-office">
                <img src="../SAM/imagens/pacoteoffice.webp" alt="">
            </div>
            <img src="../SAM/imagens/logosam.jpg" alt="">
        </div>
        <div class="box-serch">
            <i class='bx bx-search-alt-2'></i>
            <input type="text" placeholder="Pesquisar">
        </div>
        <div class="box-right">
            <i class='bx bx-dots-horizontal-rounded'></i>
            <i class='bx bxs-face'></i>
            <button> <a href="../php/logout.php">Desconectar</a></button>
        </div>
    </header>
    <div class="flex-container">
        <aside>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span><a href="criarTurmas.php">Criar turma</a></span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-hourglass'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bx-notepad'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-graduation'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-message'></i>
                <span><a href="mensagens.php">Mensagens</a></span>
            </div>
            <div class="box-menu-01">
                <i class='bx bx-cog'></i>
                <span>Aplicativos</span>
            </div>
        </aside>
        <main>
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['nome']); ?>!</h1>
        <div class="box">
            <table>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($user['nome']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            </table>
        </div>
        <div class="box2">
            <h2>Esses são seus professores</h2>
            <table>
                <tr>
                    <th>RM</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
                <?php while ($professor = $professores->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($professor['RM']); ?></td>
                        <td><?php echo htmlspecialchars($professor['nome']); ?></td>
                        <td><?php echo htmlspecialchars($professor['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        </main>
    </div>
</body>
</html>
<?php $conn->close(); ?>

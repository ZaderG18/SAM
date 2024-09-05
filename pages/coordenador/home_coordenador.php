<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once '../../php/funcao.php';
$user = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
$data = get_todos_alunos_e_professores($conn);
$alunos = $data ['aluno'];
$professores = $data ['professor'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" type="imagex/png" href="../../assets/imagens/logo.jpg">
    <link rel="stylesheet" href="../../assets/scss/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <header>
        <div class="flex-icons">
            <i class='bx bx-menu-alt-left'></i>
            <img src="/imagens/logosam.jpg" alt="">
        </div>
        <div class="box-search">
            <i class='bx bx-search-alt-2'></i>
            <input type="text" placeholder="Pesquisar">
        </div>
        <div class="box-right">
            <i class='bx bx-dots-horizontal-rounded'></i>
            <i class='bx bxs-face'></i>
        </div>
    </header>
    <div class="flex-container">
        <aside>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bxs-bell'></i>
                <span>Atividade</span>
            </div>
            <div class="box-menu-01">
                <i class='bx bx-plus-medical'></i>
                <span>Aplicativos</span>
            </div>
        </aside>
        <h1>Bem-vindo, <?php echo htmlspecialchars($user['nome']); ?>!</h1>
        <div class="box">
            <table>
                <tr>
                    <th>RM</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Código</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['nome']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['codigo']); ?></td>
                </tr>
            </table>
        </div>
        <div class="box2">
            <h2>Esses são os alunos da sua rede</h2>
            <table>
                <tr>
                    <th>RM</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
                <?php while ($aluno = $alunos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aluno['RM']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars($aluno['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <div class="box3">
            <h2>Esses são os professores da sua rede</h2>
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
    </div>
</body>
</html>
<?php $conn->close(); ?>

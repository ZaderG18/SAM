<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once 'funcao.php';
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
    <link rel="shortcut icon" type="imagex/png" href="../SAM/imagens/logosam.jpg">
    <link rel="stylesheet" href="../SAM/css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

:root {
    --background: linear-gradient(180deg, rgb(7, 3, 70) 0%, rgb(8, 39, 77) 35%, rgb(12, 55, 105) 100%);
    --navbar-width: 256px;
    --navbar-width-min: 80px;
    --cor-primaria: red;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

header {
    width: 100%;
    height: auto;
    background-color: #ebebeb;
    padding: 5px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

header .flex-icons {
    display: flex;
    align-items: center;
}

header .flex-icons i {
    font-size: 30px;
    cursor: pointer;
    margin-right: 20px;
    color: #6c6c6c;
}

header .flex-icons img {
    width: 25px;
}

header .box-search i {
    color: #616161;
    font-size: 20px;
    padding: 5px 10px;
}

header .box-search {
    width: 30%;
    background-color: white;
    display: flex;
    align-items: center;
    margin: 0 auto;
    border-radius: 5px;
}

header .box-search input {
    border: none;
    padding: 5px 5px;
    outline: none;
    width: 100%;
}

header .box-right {
    display: flex;
    align-items: center;
}

header .box-right .bx-dots-horizontal-rounded {
    color: #616161;
    font-size: 25px;
}

header .box-right i {
    font-size: 22px;
    color: #616161;
    margin: 0 10px;
    padding: 5px;
    transition: 0.2s;
    cursor: pointer;
}

header .box-right i:hover {
    background-color: white;
    border-radius: 100px;
}

.flex-container {
    display: flex;
    width: 100%;
    height: auto;
    background-color: purple;
}

.flex-container aside {
    width: 80px;
    height: 100vh;
    background-color: #ebebeb;
    display: flex;
    flex-direction: column;
    padding: 20px 0;
}

.flex-container aside .box-menu-01 {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #616161;
    margin: 10px 0;
    padding: 10px 0;
    cursor: pointer;
}

.flex-container aside .box-menu-01:hover {
    background-color: white;
}

.flex-container aside .box-menu-01 i {
    font-size: 20px;
}

.flex-container aside .box-menu-01 span {
    font-size: 10px;
}

h1 {
    color: aliceblue;
    text-align: center;
    align-items: center;
}

.box {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 400px;
    height: auto;
    flex-direction: column;
    left: 55%;
    transform: translate(-50%, -50%);
    position: absolute;
    top: 30%;
    color: aliceblue;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}.box2 {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 400px;
    height: auto;
    flex-direction: column;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
    top: 60%;
    color: aliceblue;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}.box3 {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 400px;
    height: auto;
    flex-direction: column;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
    top: 90%;
    color: aliceblue;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

td, th {
    box-shadow: 20px 20px 50px rgba(0, 0, 0, 0.25);
    border-top: 1px solid rgba(255, 255, 255, 0.25);
    border-right: 1px solid rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(8px);
    border-radius: 15px;
    margin: 0 auto;
    color: aliceblue;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    padding: 0 100px;
}
    </style>
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

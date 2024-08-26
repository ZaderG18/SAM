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
$professores = get_todos_professores($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" type="imagex/png" href="../imagens/logo.jpg">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

header{
    width: 100%;
    height: auto;
    background-color: #ebebeb;
    padding: 0 20px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 999;
    position: sticky;
    top: 0;
}

header .flex-icons{
    display: flex;
    align-items: center;
}

header .flex-icons .atalho-office{
    cursor: pointer;
    margin-right: 10px;
}

header .flex-icons .atalho-office:hover{
    background-color:white;
}


header .flex-icons .atalho-office img{
    width: 38px;
    margin: 5px 20px 0 20px;
}

header .flex-icons i{
    font-size: 30px;
    cursor: pointer;
    margin-right: 20px;
    color: #6c6c6c;
    padding: 10px 25px 10px 25px;
}

header .flex-icons i:hover{
    background-color: white;
    color: #777ee3;
}

header .flex-icons img{
    width: 25px;
    margin-left: 5px;
}

header .box-serch i{
    color: #616161;
    font-size: 20px;
    padding: 5px 10px 5px 10px;

}

header .box-serch{
    width:30%;
    height: 37px;
    background-color: white;
    display: flex;
    align-items: center;
    margin: 0 auto;
    border-radius: 5px;
}


header .box-serch input{
    border: none;
    padding: 5px 5px;
    outline: none;
    width: 100%;
}

header .box-right{
    display: flex;
    align-items: center;
}

 header.box-right button{
    padding: 5px 10px;
    cursor: pointer;
}
header .box-right button a{
    text-decoration: none;
    color: black;
}

header .box-right .bx-dots-horizontal-rounded{
    color: #616161;
    font-size: 25px;
}


header .box-right .bx-dots-horizontal-rounded:hover{
    background-color: white;
}

header .box-right i{
    font-size: 22px;
    color: #616161;
    margin: 0 10px;
    padding: 5px;
    transition: 0.2s;
    cursor: pointer;
}

header .box-right i:hover{
    background-color: white;
    border-radius: 100px;
}

header .box-right .right-menu{
    height: auto;
}

.flex-container{
    display: flex;
    width: 100%;
    height: auto;
}

.flex-container aside{
    width: 90px;
    height: 100vh;
    background-color: #ebebeb;
    display: flex;
    flex-direction: column;
    padding: 50px 0 20px 0;
}

.flex-container aside .box-menu-01{
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
color: #616161;
margin: 10px 0;
padding: 10px 0;
cursor: pointer;
}

.flex-container aside .box-menu-01:hover{
    background-color: white;
    color: #777ee3;
}

.flex-container aside .box-menu-01 i{
    font-size: 20px;
}

.flex-container aside .box-menu-01 span{
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
    top: 50%;
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
    top: 80%;
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
main{
    background-color: purple;
    height: auto;
    width: 100%;
}
    </style>
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
                <span>Atividade</span>
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
                <span><a href="../SAM/mensagens.html">Mensagens</a></span>
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
                <tr>
                    <th>RM</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Código</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($user['RM']); ?></td>
                    <td><?php echo htmlspecialchars($user['nome']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['codigo']); ?></td>
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

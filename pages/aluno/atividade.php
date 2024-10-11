<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
require_once '../../php/login/validar.php';
$user = $_SESSION['user'];
$id = $user['id'];

// Prepare SQL statement to retrieve photo
$sql = "SELECT foto FROM aluno WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fotoNome);
$stmt->fetch();
$stmt->close();
$conn->close();

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/atividade/atividade.css">
    <link rel="stylesheet" href="../../assets/css/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/global/estilogeral.css">
 
    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/Group 4.png" type="image/png">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Box-icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    
    <!-- Remixicons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
    <!--========== HEADER ==========-->
<header class="header">
    <div class="header__container">
        <div class="header__search">
            <input type="search" placeholder="Search" class="header__input">
            <i class='bx bx-search header__icon'></i>
        </div>
        <div class="header__dropdown">
            <i class='bx bx-bell header__notification'></i>
            <div class="header__dropdown-content">
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/Ana_Icon.png" alt="Notificação 1">
                        <div>
                            <h4>Notificação 1</h4>
                            <p>Descrição da notificação 1</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/img_enrico.png" alt="Notificação 2">
                        <div>
                            <h4>Notificação 2</h4>
                            <p>Descrição da notificação 2</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <img src="../../assets/img/home/fotos/img_neide.png" alt="Notificação 3">
                        <div>
                            <h4>Notificação 3</h4>
                            <p>Descrição da notificação 3</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="header__dropdown">
            <img src="../../assets/img/home/fotos/Usuário_Header.png" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="../../html/perfil/index.html" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="../../html/configuracoes/index.html" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="../../html/faq/index.html" class="header__dropdown-item">
                    <i class='bx bx-help-circle'></i> Ajuda
                </a>
            </div>
        </div>
        <div class="header__toggle">
            <i class='bx bx-menu' id="header-toggle"></i>
        </div>
    </div>
</header>

<!--========== NAV ==========-->
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                <img src="../../assets/img/Group 4.png" alt="Logo SAM" class="nav__logo-img">
                <span class="nav__logo-name">SAM</span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Home</h3>
                    <a href="../../html/home/home.html" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="../../html/historico/index.html" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="../../html/documentos/index.html" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="../../html/calendario/index.html" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="../../html/enquetes/index.html" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="../../html/chat/index.html" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../html/login/login.html" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>

<!--=================================================================== MAIN CONTENT ============================================================-->

        <main>
            <div class="activity-page">
                <a href="../../html/aulas/index.html" class="back-button"><i class="fas fa-arrow-left"></i> Voltar</a>
                <h1>Atividade 11/01 - Redação Inglês</h1>
                <p class="due-date">Vence 17 de janeiro de 2024 às 23:59 • Fecha 17 de janeiro de 2024 às 23:59</p>
                <div class="activity-description">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Integer id libero id neque pulvinar sodales. Vivamus vehicula, mi id tincidunt vulputate, 
                        magna odio vehicula ligula, vitae placerat risus lorem nec justo. Lorem ipsum dolor sit amet, 
                        consectetur adipiscing elit. Integer id libero id neque pulvinar sodales. 
                        Vivamus vehicula, mi id tincidunt vulputate, magna odio vehicula ligula, 
                        vitae placerat risus lorem nec justo. 
                    </p>
                    <!-- Continuação do texto descritivo -->
                </div>
                <div class="upload-section">
                    <h2>Meu Trabalho</h2>
                    <label for="file-upload" class="file-upload-label">
                        <i class="fas fa-paperclip"></i> Enviar arquivo
                    </label>
                    <input id="file-upload" type="file" />
                    <button id="submit-button" class="submit-button" disabled>Enviar</button>
                </div>
            </div>

        </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/atividade/atividade.js"></script>
</body>
</html>

<?php
session_start(); // Ensure session is started

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Erro ao conectar ao banco: " . $conn->connect_error);
}

// Include required files for upload and validation
require_once '../../php/global/upload.php';
require_once '../../php/login/validar.php';

// Ensure the user is authenticated
if (!isset($_SESSION['user'])) {
    die("Usuário não autenticado.");
}

// Get user data from session
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
    <title>Configurações</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/configuracoes/configuracoes.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.scss">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.scss">
 
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
            <img src="<?php echo $fotoCaminho ?>" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="perfil.php" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="configuracoes.php" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="faq.php" class="header__dropdown-item">
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
                    <a href="home_aluno.php" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="historico.php" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="documentos.php" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="cronograma.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="secretaria.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../php/login/logout.php" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>
<!--=================================================================== MAIN CONTENT ============================================================-->

<main>
    <div class="cards-container">
        <!-- Lado esquerdo - Info Card -->
        <div class="info-card">
            <div class="profile-picture">
                <form action="../../php/global/upload.php" method="post">
                <h3>Upload Foto(150px X 150px)</h3>
                <img src="profile-placeholder.png" id="profile-pic"/>
                <label for="upload" class="upload-button">Escolher Arquivo</label>
                <input type="file" id="upload" accept="image/*" class="input">
                <button class="btn-padrao">Salvar</button>
                </form>
            </div>
            <div class="notifications">
                <h3>Notificações</h3>
                <label>Email</label>
                <select>
                    <option>Selecione</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
                <label>Telefone</label>
                <select>
                    <option>Selecione</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
                <button class="btn-padrao">Salvar</button>
            </div>
            <div class="security">
                <h3>Segurança e Privacidade</h3>
                <label class="toggle">
                    <div class="toggle-row">
                        <label>Mantenha suas senhas seguras</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-1"></i>
                    </div>
                    <div class="toggle-row">
                        <label>Aceito receber notificações</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-2"></i>
                    </div>
                    <div class="toggle-row">
                        <label>Não aceito o compartilhamento de dados</label>
                        <i class='bx bxs-toggle-left toggle-icon' id="toggle-3"></i>
                    </div>
                </label>
            </div>
        </div>
    
        <!-- Lado direito - Personal Info e Password Update -->
        <div class="main-content">
            <form action="../../php/global/upload.php" method="post" enctype="multipart/form-data">
                <div class="personal-info">
                    <h3>Informações Pessoais</h3>
                    <label>Nome Completo*</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($user['nome']); ?>" required>
                    <label>Telefone*</label>
                    <input type="tel" name="telefone" value="<?= htmlspecialchars($user['telefone']); ?>" required>
                    <label>Email*</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                    <label>Gênero*</label>
                    <select name="genero" required>
                        <option>Selecione seu gênero</option>
                        <option value="Homem">Homem Cis</option>
                        <option value="Mulher_cis">Mulher cis</option>
                        <option value="mulher_trans">Mulher Trans</option>
                        <option value="homem_trans">Homem Trans</option>
                        <option value="nao_binario">Não-Binário</option>
                        <option value="prefiro_n_dizer">Prefiro Não Dizer</option>
                    </select>
                    <label>Estado Civil*</label>
                    <select name="estado_civil" required>
                        <option>Selecione</option>
                        <option value="solteiro">Solteiro</option>
                        <option value="casado">Casado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="viuvo">Viúvo</option>
                    </select>
                    <label>Data de Nascimento*</label>
                    <input type="date" name="data_nascimento" value="<?= htmlspecialchars($user['data_nascimento']); ?>" required>
                    <label>Nacionalidade*</label>
                    <input type="text" name="nacionalidade" value="<?= htmlspecialchars($user['nacionalidade']); ?>" required>
                    <label>Endereço*</label>
                    <input type="text" name="endereco" value="<?= htmlspecialchars($user['endereco']); ?>" required>
                    <label>RM</label>
                    <input type="text" name="RM" value="<?= htmlspecialchars($user['RM']); ?>">
                    <label>Curso*</label>
                    <select name="curso" required>
                        <option>Selecione o curso</option>
                        <option value="desenvolvimento_de_sistemas">Desenvolvimento de Sistemas</option>
                        <option value="enfermagem">Enfermagem</option>
                        <option value="nutricao">Nutrição</option>
                        <option value="gastronomia">Gastronomia</option>
                    </select>
                    <h3>Contato de Emergência</h3>
                    <label>Nome do Contato*</label>
                    <input type="text" >
                    <label>Parentesco*</label>
                    <input type="text">
                    <label>Telefone de Contato*</label>
                    <input type="text" >
                    <label>Email de Contato*</label>
                    <input type="text">
                    <button class="btn-padrao">Editar</button>
                    <button class="btn-padrao">Salvar</button>
                </div>
    
                <div class="password-update">
                    <h3>Atualizar Senha</h3>
                    <label>Senha Atual</label>
                    <input type="password" >
                    <label>Nova Senha*</label>
                    <input type="password" >
                    <label>Confirmar Nova Senha*</label>
                    <input type="password" >
                    <button class="btn-padrao">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/aluno/configuracoes/configuracoes.js"></script>
</body>
</html>

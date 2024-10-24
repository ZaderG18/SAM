<?php
session_start(); // Certifique-se de que a sessão está iniciada

$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$id = $user['id']; // ID do usuário

// Prepara SQL statement para recuperar a foto
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

// Verifica se há uma foto para o usuário
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Imagem padrão se nenhuma foto for carregada
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/aulas/aulas.css">
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
          

            <div class="containerfx">
                <!-- Descrição da matéria -->
                <div class="section description">
                    <h2>Descrição da Matéria</h2>
                    <p>Esta matéria aborda tópicos fundamentais de matemática, incluindo álgebra, geometria e trigonometria. 
                    Pré-requisitos incluem uma compreensão básica de aritmética. O objetivo é desenvolver habilidades analíticas e 
                    a capacidade de resolver problemas complexos.</p>
                </div>

                <!-- Indicador de progresso -->
                <div class="section progress-section">
                    <h3>Progresso da Matéria</h3>
                    <div class="progress-bar">
                        <div style="width: 50%;">50% concluído</div>
                    </div>
                </div>

                <!-- Atividades -->
                <div class="section activities">
                    <h4>Atividades</h4>
                    <div class="item activity-item">
                        <span>Exercício 1: Resolver equações lineares</span>
                        <a href="atividade.php">Fazer</a>
                    </div>
                    <div class="item activity-item">
                        <span>Exercício 2: Análise de figuras geométricas</span>
                        <a href="atividade.php">Fazer</a>
                    </div>
                </div>

                <!-- Atividades Não Entregues e Pendentes -->
                <div class="section pending-activities">
                    <h4>Atividades Não Entregues e Pendentes</h4>
                    <div class="item">
                        <span>Exercício 3: Problemas de proporções</span>
                        <a href="atividade.php">Fazer</a>
                    </div>
                    <div class="item">
                        <span>Exercício 4: Teorema de Pitágoras</span>
                        <a href="atividade.php">Fazer</a>
                    </div>
                </div>

                <!-- Feedback -->
                <div class="section feedback">
                    <h4>Feedback do Professor</h4>
                    <div class="item feedback-item">
                        <span>Exercício 1: Resolver equações lineares</span>
                        <a href="feedback.php">Ver Feedback</a>
                    </div>
                    <div class="item feedback-item">
                        <span>Exercício 2: Análise de figuras geométricas</span>
                        <a href="feedback.php">Ver Feedback</a>
                    </div>
                </div>

                <!-- Fórum de Discussão -->
                <div class="section forum">
                    <h4>Fórum de Discussão</h4>
                    <textarea rows="4" placeholder="Digite sua dúvida ou comentário..."></textarea>
                    <input type="file" id="fileInput" style="display: none;" />
                    <div class="button-container">
                    <label for="fileInput" class="file-label">Enviar Arquivo</label>
                    <div id="fileName" style="margin-top: 10px;"></div>
                        <button class="btn">Postar</button>
                    </div>
                </div>

                <!-- Materiais Complementares -->
                <div class="section additional-materials">
                    <h4>Materiais Complementares</h4>
                    <div class="item material-item">
                        <span>Livro: Fundamentos de Matemática</span>
                        <a href="cronograma.php">Acessar</a>
                    </div>
                    <div class="item material-item">
                        <span>Artigo: A História da Matemática</span>
                        <a href="#">Ler Artigo</a>
                    </div>
                </div>

                <!-- Suporte de Tutores -->
                <div class="section tutor-support">
                    <h4>Suporte de Tutores</h4>
                    <p>Para suporte adicional, entre em contato com os tutores:</p>
                    <ul>
                        <li>Tutor 1: tutor1@example.com</li>
                        <li>Tutor 2: tutor2@example.com</li>
                        <li>Tutor 3: tutor3@example.com</li>
                    </ul>
                </div>
            </div>

    </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/aulas/aulas.js"></script>
</body>
</html>

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
    <title>Pesquisa de Avaliação Escolar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/enquetes/enquetes.css">
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
     
    <div class="containerpx">
        <h1 class="headerpx">Enquetes</h1>
        <h2>Enquetes Ativas</h2>

        <ul class="poll-list">
            <!-- Enquete sobre Aulas -->
            <li class="poll-item">
                <h3>Como você avalia a qualidade das aulas online?</h3>
                <form class="poll-form" data-poll="aulas"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_aulas" value="muito_bom"> Muito bom</li>
                        <li><input type="radio" name="poll_aulas" value="bom"> Bom</li>
                        <li><input type="radio" name="poll_aulas" value="regular"> Regular</li>
                        <li><input type="radio" name="poll_aulas" value="ruim"> Ruim</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>

            <!-- Enquete sobre Matérias -->
            <li class="poll-item">
                <h3>Qual matéria você considera mais desafiadora?</h3>
                <form class="poll-form" data-poll="materias"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_materias" value="matematica"> Matemática</li>
                        <li><input type="radio" name="poll_materias" value="fisica"> Física</li>
                        <li><input type="radio" name="poll_materias" value="quimica"> Química</li>
                        <li><input type="radio" name="poll_materias" value="programacao"> Programação</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>

            <!-- Enquete sobre Professores -->
            <li class="poll-item">
                <h3>Qual professor você acha mais acessível?</h3>
                <form class="poll-form" data-poll="professores"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_professores" value="professor_a"> Professor A</li>
                        <li><input type="radio" name="poll_professores" value="professor_b"> Professor B</li>
                        <li><input type="radio" name="poll_professores" value="professor_c"> Professor C</li>
                        <li><input type="radio" name="poll_professores" value="professor_d"> Professor D</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>

            <!-- Enquete sobre Secretaria -->
            <li class="poll-item">
                <h3>Você está satisfeito com o atendimento da secretaria acadêmica?</h3>
                <form class="poll-form" data-poll="secretaria"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_secretaria" value="sim"> Sim</li>
                        <li><input type="radio" name="poll_secretaria" value="nao"> Não</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>

            <!-- Enquete sobre Curso -->
            <li class="poll-item">
                <h3>Como você avalia o seu curso em geral?</h3>
                <form class="poll-form" data-poll="curso"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_curso" value="excelente"> Excelente</li>
                        <li><input type="radio" name="poll_curso" value="bom"> Bom</li>
                        <li><input type="radio" name="poll_curso" value="regular"> Regular</li>
                        <li><input type="radio" name="poll_curso" value="ruim"> Ruim</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>

            <!-- Enquete sobre Escola -->
            <li class="poll-item">
                <h3>Qual a sua opinião sobre a infraestrutura da escola?</h3>
                <form class="poll-form" data-poll="escola"></form>
                    <ul class="poll-options">
                        <li><input type="radio" name="poll_escola" value="excelente"> Excelente</li>
                        <li><input type="radio" name="poll_escola" value="boa"> Boa</li>
                        <li><input type="radio" name="poll_escola" value="regular"> Regular</li>
                        <li><input type="radio" name="poll_escola" value="ruim"> Ruim</li>
                    </ul>
                    <div class="textarea-container">
                        <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                    </div>
                    <button class="btn" type="submit">Votar</button>
                </form>
            </li>
        </ul>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/enquetes/enquetes.js"></script>
</body>
</html>
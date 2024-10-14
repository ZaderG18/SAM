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
    <title>Secretaria</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/secretaria/secretaria.css">
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
        <h2>Secretaria Acadêmica</h2>

        <div class="section">
            <h3>Sobre a Escola e a Equipe da Secretaria</h3>
            <p>A Secretaria Acadêmica está comprometida em oferecer o melhor suporte aos alunos, pais e responsáveis. Nossa equipe é formada por profissionais dedicados e capacitados, prontos para ajudar em todas as demandas relacionadas à vida acadêmica. Desde a rematrícula até a solicitação de documentos, estamos aqui para garantir uma experiência tranquila e eficiente.</p>
        </div>

        <!-- Horário de Atendimento -->
        <div class="section">
            <h3>Horário de Atendimento</h3>
            <p>Segunda-feira a sexta-feira das 9h às 13h e das 15h às 20h</p>
        </div>

        <!-- Prazo para Entrega de Documentos -->
        <div class="section">
            <h3>Prazo para Entrega de Documentos</h3>
            <p>Declarações: 48 horas</p>
            <p>Transferências: 48 horas</p>
            <p>Históricos: 15 dias</p>
        </div>

        <!-- Comunicados Gerais -->
        <div class="section">
            <h3>Comunicados de Rematrícula</h3>
            <p>
            Prezados Pais, Responsáveis e Alunos,
            <br><br>
            Informamos que o período de Rematrícula para 2024 acontecerá de (data de início) a (data de término). As rematrículas podem ser feitas online por aqui ou presencialmente na secretaria da escola.
            <br><br>
            Não deixe para a última hora! Garanta sua vaga e atualize seus dados dentro do prazo.
            <br><br>
            Para mais informações, entre em contato pelo e-mail [e-mail da escola] ou telefone [número de contato].
            <br><br>
            Atenciosamente,
            <br>
            [Nome da Escola]
            </p>
        </div>

        <!-- Equipe da Secretaria -->
        <div class="section">
            <h3>Equipe da Secretaria</h3>
            <p>Conheça nossa equipe:</p>
            <ul>
            <li><strong>Maria Silva</strong> - Coordenadora da Secretaria | Email: maria@escola.com</li>
            <li><strong>João Pereira</strong> - Atendimento ao Aluno | Email: joao@escola.com</li>
            <li><strong>Ana Costa</strong> - Suporte Administrativo | Email: ana@escola.com</li>
            </ul>
        </div>

        <!-- Documentos Necessários -->
        <div class="section">
            <h3>Documentos Necessários</h3>
            <p>Para diferentes tipos de solicitações, os seguintes documentos são necessários:</p>
            <ul>
            <li>Histórico Escolar: Cópia do RG e CPF.</li>
            <li>Declaração de Matrícula: Cópia do RG e comprovante de matrícula.</li>
            <li>Transferência: Cópia do histórico escolar e declaração de transferência.</li>
            </ul>
        </div>

        <!-- Próximos Eventos -->
        <div class="section">
            <h3>Próximos Eventos</h3>
            <ul>
            <li>Reunião de Pais: 15/10/2024 às 18h.</li>
            <li>Palestra sobre Orientação Vocacional: 20/10/2024 às 19h.</li>
            <li>Festival Cultural da Escola: 30/10/2024.</li>
            </ul>
        </div>

        <!-- FAQ -->
        <div class="section">
            <h3>Perguntas Frequentes (FAQ)</h3>
            <ul>
            <li><strong>Qual o prazo para solicitar um histórico escolar?</strong> <br> O prazo é de 15 dias.</li>
            <li><strong>Como posso solicitar uma declaração de matrícula?</strong> <br> Você pode solicitar online ou presencialmente.</li>
            <li><strong>Quais documentos são necessários para a rematrícula?</strong> <br> É necessário apresentar RG, CPF e comprovante de residência.</li>
            </ul>
        </div>

        <!-- Link para Formulário de Ajuda -->
        <div class="section">
            <h3>Formulário de Suporte</h3>
            <a href="suporte.php" class="btn">Acessar Formulário de Ajuda</a>
        </div>
        </div>
   
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/secretaria/secretaria.js"></script>
</body>
</html>
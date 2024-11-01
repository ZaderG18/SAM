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
include '../../php/global/notificacao.php';

$user = $_SESSION['user'];
$id = $user['id'];

// Prepare SQL statement to retrieve photo
$sql = "SELECT foto FROM usuarios WHERE id = ?";
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
    <title>Perfil</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/perfil/perfil.css">
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
                    <?php $notificacoes = obterNotificacoes($conn, $id, true);
                if (!empty($notificacoes)) { 
                    echo "<p> Nenhuma notificação no momento.</p>";
                } else{
                    foreach ($notificacoes as $notificacao){?>
                <a href="<?php echo $notificacao['link'] ? $notificacao['link'] : '#'; ?>" class="header__dropdown-item">
                    <div class="header__notification-item">
                        <?php if ($notificacao['imagem']){?>
                        <img src="<?php echo $notificacao['imagem']; ?>" alt="Notificação 1">
                        <?php } ?>
                        <div>
                            <h4><?php echo htmlspecialchars($notificacao['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($notificacao['mensagem']);?></p>
                            <small><?php date("d/m/Y H:i", strtotime($notificacao['data_criacao']))?></small>
                        </div>
                    </div>
                </a>
                <?php } }?>
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
        <!-- Cabeçalho -->
        <div class="headerpx">
            <img src="<?php echo $fotoCaminho ?>" alt="Foto do Aluno">
            <div class="info">
                <h2><?php echo htmlspecialchars($user['nome']) ?></h2>
                <p>RM: 123456</p>
                <p>Email: Juliana@exemplo.com</p>
                <p>Curso: Desenvolvimento de Sistemas</p>
                <p>Status Acadêmico: Ativo</p>
            </div>
        </div>

        <!-- Informações Pessoais -->
        <div class="section">
            <h3 class="section-title">Informações Pessoais</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome Completo:</label>
                    <p><?php echo htmlspecialchars($user['nome']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Data de Nascimento:</label>
                    <p><?php echo htmlspecialchars($user['data_nascimento']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Telefone:</label>
                    <p><?php echo htmlspecialchars($user['telefone']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Endereço:</label>
                    <p><?php echo htmlspecialchars($user['endereco']) ?></p>
                </div>
                <!-- <div class="detail-item">
                    <label>CPF:</label>
                    <p></p>
                </div>
                <div class="detail-item">
                    <label>RG:</label>
                    <p>12.345.678-9</p>
                </div> -->
                <!-- <div class="detail-item">
                    <label>Estado Civil:</label>
                    <p>Solteiro</p>
                </div> -->
                <div class="detail-item">
                    <label>Nacionalidade:</label>
                    <p>Brasileiro</p>
                </div>
                <div class="detail-item">
                    <label>Data de Matrícula:</label>
                    <p><?php echo htmlspecialchars($user['data_matricula']) ?></p>
                </div>
            </div>
        </div>

        <!-- Informações Acadêmicas -->
        <div class="section">
            <h3 class="section-title">Informações Acadêmicas</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Curso:</label>
                    <p><?php echo htmlspecialchars($user['curso']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Período:</label>
                    <p><?php echo htmlspecialchars($user['periodo']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Semestre Atual:</label>
                    <p><?php echo htmlspecialchars($user['modulo_atual']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Sala:</label>
                    <p><?php echo htmlspecialchars($user['turma']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Orientador Acadêmico:</label>
                    <p>Prof. <?php echo htmlspecialchars($user['nome_professor']) ?></p>
                </div>
                <div class="detail-item">
                    <label>Bolsas e Auxílios:</label>
                    <p>Bolsa de Iniciação Científica</p>
                </div>
                <div class="detail-item">
                    <label>Horas Complementares:</label>
                    <p>100 horas</p>
                </div>
                <div class="detail-item">
                    <label>Estágio Atual:</label>
                    <p>Estágio na Empresa XYZ - Setor de TI</p>
                </div>
            </div>
        </div>

        <!-- Desempenho Acadêmico -->
        <div class="section">
            <h3 class="section-title">Desempenho Acadêmico</h3>
            <ul>
                <li>Participação em 90% das aulas no semestre atual.</li>
                <li>Média Geral: 8.7</li>
                <li>Projetos realizados no curso com destaque.</li>
                <li>Melhor aluno em Matemática Aplicada no 5º semestre.</li>
            </ul>
        </div>

        <!-- Projetos e Pesquisas -->
        <div class="section">
            <h3 class="section-title">Projetos e Pesquisas</h3>
            <ul>
                <li>Projeto de robótica autônoma (em andamento).</li>
                <li>Pesquisa sobre algoritmos de inteligência artificial (concluída em 2023).</li>
                <li>Projeto de Sistema de Energia Solar (em desenvolvimento).</li>
            </ul>
        </div>

        <!-- Contato de Emergência -->
        <div class="section">
            <h3 class="section-title">Contato de Emergência</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome do Contato:</label>
                    <p>Maria Silva</p>
                </div>
                <div class="detail-item">
                    <label>Parentesco:</label>
                    <p>Mãe</p>
                </div>
                <div class="detail-item">
                    <label>Telefone de Contato:</label>
                    <p>(11) 98888-8888</p>
                </div>
                <div class="detail-item">
                    <label>Email de Contato:</label>
                    <p>maria.silva@email.com</p>
                </div>
            </div>
        </div>

        <!-- Atividades Extracurriculares -->
        <div class="section">
            <h3 class="section-title">Atividades Extracurriculares</h3>
            <ul>
                <li>Participação no grupo de robótica da universidade.</li>
                <li>Monitor de Algoritmos no 5º semestre.</li>
                <li>Voluntário no projeto de inclusão digital da comunidade local.</li>
                <li>Membro da Associação Atlética Acadêmica.</li>
            </ul>
        </div>

        <!-- Eventos -->
        <div class="section">
            <h3 class="section-title">Eventos Acadêmicos</h3>
            <ul>
                <li>Semana da Engenharia - 12/11/2024</li>
                <li>Hackathon Acadêmico - 25/11/2024</li>
                <li>Feira de Ciências e Tecnologia - 10/12/2024</li>
            </ul>
        </div>
    </div>
   
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/perfil/perfil.js"></script>
</body>
</html>

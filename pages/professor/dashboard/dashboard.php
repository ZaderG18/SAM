<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';

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
    $fotoCaminho = "../../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orientador</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/global/estilogeral.css">
 
    <!-- Favicon -->
    <link rel="icon" href="../../../assets/img/Group 4.png" type="image/png">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            <img src="../<?php echo $fotoCaminho ?>" alt="" class="header__img">
            <div class="header__dropdown-content">
                <a href="../perfil.php" class="header__dropdown-item">
                    <i class='bx bx-user'></i> Perfil
                </a>
                <a href="../configuracoes.php" class="header__dropdown-item">
                    <i class='bx bx-cog'></i> Configurações
                </a>
                <a href="../faq.php" class="header__dropdown-item">
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
                <img src="../../../assets/img/Group 4.png" alt="Logo SAM" class="nav__logo-img">
                <span class="nav__logo-name">SAM</span>
            </a>
            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Home</h3>
                    <a href="../home_professor.php" class="nav__link">
                        <i class='bx bx-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                    <a href="../historico.php" class="nav__link active">
                        <i class='bx bx-history nav__icon'></i>
                        <span class="nav__name">Histórico</span>
                    </a>
                    <a href="../documentos.php" class="nav__link">
                        <i class='bx bx-file nav__icon'></i>
                        <span class="nav__name">Documentos</span>
                    </a>
                    <a href="../calendario.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="../enquetes.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="../chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="dashboard.php" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
        <a href="../../../php/login/logout.php" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Sair</span>
        </a>
    </nav>
</div>


<!--=================================================================== MAIN CONTENT ============================================================-->

<main>
    <div class="main-dashboard">
        <!-- Card de Visão Geral de Disciplinas -->
        <a href="disciplinas.html" class="card">
            <h3>Disciplinas Coordenadas</h3>
            <div class="count">8</div>
            <p>Disciplinas atualmente sob sua coordenação. Clique para detalhes.</p>
        </a>

        <!-- Card de Alunos Supervisionados -->
        <a href="alunos.html" class="card">
            <h3>Alunos Supervisionados</h3>
            <div class="count">120</div>
            <p>Total de alunos sob supervisão direta em várias disciplinas. Clique para detalhes.</p>
        </a>

        <!-- Card de Supervisão de Professores -->
        <a href="professores.html" class="card">
            <h3>Professores Supervisionados</h3>
            <div class="count">15</div>
            <p>Número de professores sob sua coordenação. Clique para detalhes.</p>
        </a>

        <!-- Card de Relatórios Pendentes -->
        <a href="relatorios.html" class="card">
            <h3>Relatórios Pendentes</h3>
            <div class="count">3</div>
            <p>Relatórios acadêmicos que precisam ser enviados. Clique para detalhes.</p>
        </a>

        <!-- Card de Reuniões Agendadas -->
        <div class="card">
            <h3>Reuniões Agendadas</h3>
            <ul class="events-list">
                <li><span>12/10:</span> Reunião com o corpo docente</li>
                <li><span>15/10:</span> Discussão sobre planejamento anual</li>
                <li><span>20/10:</span> Reunião com os diretores</li>
            </ul>
        </div>

        <!-- Card de Comunicados Recentes -->
        <div class="card">
            <h3>Comunicados Recentes</h3>
            <ul class="events-list">
                <li><span>05/10:</span> Prazo de entrega de notas</li>
                <li><span>03/10:</span> Atualização no currículo</li>
                <li><span>01/10:</span> Mudanças no sistema SAM</li>
            </ul>
        </div>

        <!-- Card de Progresso Acadêmico com Gráfico -->
        <div class="card">
            <h3>Progresso Acadêmico Geral</h3>
            <p>Média de progresso dos alunos nas disciplinas coordenadas.</p>
            <canvas id="progressChart"></canvas>
        </div>

        <!-- Card de Desempenho das Turmas -->
        <div class="card">
            <h3>Desempenho das Turmas</h3>
            <canvas id="performanceChart"></canvas>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/professor/dashboard/dashboard.js"></script>
</body>
</html>

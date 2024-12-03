<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';

// ID da atividade (você deve obter esse valor a partir da URL ou outro meio)
$atividade_id = $_GET['id'] ?? 0; // Obter ID da URL (ex: editar_atividade.php?id=1)

// Verificar se o ID da atividade foi passado
if ($atividade_id == 0) {
    die("Atividade não encontrada.");
}

// Buscar os dados da atividade no banco de dados
$query = "SELECT * FROM atividades WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $atividade_id); // Bind do parâmetro como inteiro
$stmt->execute();
$result = $stmt->get_result();

// Verificar se a atividade existe
$atividade = $result->fetch_assoc();
if (!$atividade) {
    die("Atividade não encontrada no banco de dados.");
}

// Dados da atividade
$conteudo_atividade = $atividade['conteudo']; // Assumindo que a tabela tem uma coluna 'conteudo'
$data_vencimento = $atividade['data_vencimento']; // Assumindo que a tabela tem uma coluna 'data_vencimento'

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edição Atividade</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/atividade/atividade.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.css">
 
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
            <input type="search" placeholder="Search" class="header__input" id="searchInput" oninput="showSuggestions()" autocomplete="off">
            <div id="suggestions"></div>
            <button onclick="redirectToPage()"><i class='bx bx-search header__icon'></i></button>
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
                    <a href="home_professor.php" class="nav__link">
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
                    <a href="calendario.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="enquetes.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="dashboard/dashboard.php" class="nav__link">
                        <i class='bx bx-bar-chart-alt-2 nav__icon'></i>
                        <span class="nav__name">Dashboard</span>
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
            <div class="activity-page">
                <a href="aulas.php" class="back-button"><i class="fas fa-arrow-left"></i> Voltar</a>
            
                <h1>Editar Atividade - <?php echo htmlspecialchars( $atividade['nome'])?></h1>
                <form action="../../php/professor/salvarAtividade.php" method="post">
                <div class="activity-description">
                    <label for="edit-activity" class="activity-label">Editar Conteúdo da Atividade:</label>
                    <textarea id="edit-activity" rows="6"><?php echo htmlspecialchars( $atividade['conteudo']);?></textarea>
                </div>
            
                <div class="due-date-section">
                    <label for="edit-due-date">Editar Data de Vencimento:</label>
                    <input type="datetime-local" id="edit-due-date" value="<?php echo date('Y-m-d\TH:i', strtotime($data_vencimento))?>">
                </div>
            
                <button id="submit-button" class="submit-button">Salvar Alterações</button>
            </div>
            </form>
        </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
   <script src="../../assets/js/professor/atividade/atividade.js"></script>
</body>
</html>

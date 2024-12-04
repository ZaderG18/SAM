<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
function obterDadosPorTipo($conn, $tipo) {
    $validTypes = ['horario', 'prazo_documentos', 'comunicado_rematricula', 'equipe', 'documentos_necessarios', 'eventos', 'faq', 'formulario_suporte'];

    if (!in_array($tipo, $validTypes)) {
        echo "Tipo inválido: $tipo";
        return false;
    }

    $stmt = $conn->prepare("SELECT * FROM secretaria WHERE tipo = ?");
    if ($stmt === false) {
        echo "Erro ao preparar a consulta: " . $conn->error;
        return false;
    }

    $stmt->bind_param("s", $tipo);
    if (!$stmt->execute()) {
        echo "Erro ao executar a consulta: " . $stmt->error;
        return false;
    }

    return $stmt->get_result();
}

// Obtém os dados para cada seção
$horario = obterDadosPorTipo($conn, 'horario')->fetch_assoc();
$prazoDocumentos = obterDadosPorTipo($conn, 'prazo_documentos')->fetch_assoc();
$comunicadoRematricula = obterDadosPorTipo($conn, 'comunicado_rematricula')->fetch_assoc();
$documentos = obterDadosPorTipo($conn, 'documentos_necessarios')->fetch_assoc();
$equipe = obterDadosPorTipo($conn, 'equipe');
$eventos = obterDadosPorTipo($conn, 'eventos');
$faq = obterDadosPorTipo($conn, 'faq');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/secretaria/secretaria.css">
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
    <div class="containerpx">
        <h2>Secretaria Acadêmica - Professores</h2>
    
        <!-- Sobre a Escola e a Equipe da Secretaria -->
        <div class="section">
            <h3>Sobre a Secretaria e Suporte ao Professor</h3>
            <p>A Secretaria Acadêmica oferece suporte especializado aos professores para facilitar a gestão acadêmica e administrativa. Nossa equipe está disponível para atender demandas relacionadas a relatórios de desempenho, solicitação de documentos, e apoio ao planejamento de aulas. Estamos comprometidos em garantir que o corpo docente tenha os recursos necessários para uma experiência educacional eficiente e organizada.</p>
        </div>
    
        <!-- Horário de Atendimento -->
        <div class="section">
            <h3>Horário de Atendimento Exclusivo</h3>
            <p><?= isset($horario['conteudo']) ? $horario['conteudo'] : 'Não informado' ?></p>
        </div>
    
        <!-- Prazo para Entrega de Documentos -->
        <div class="section">
            <h3>Prazo para Solicitação de Documentos</h3>
            <p><?= isset($prazoDocumentos['conteudo']) ? $prazoDocumentos['conteudo'] : 'Não informado'  ?></p>
        </div>
    
        <!-- Comunicados Gerais -->
        <div class="section">
            <h3>Comunicados Importantes</h3>
            <p><?= isset($comunicadoRematricula['conteudo']) ? $comunicadoRematricula['conteudo'] : 'Não informado' ?></p>
        </div>
    
        <!-- Equipe da Secretaria -->
        <div class="section">
            <h3>Equipe de Suporte ao Professor</h3>
            <p>Equipe responsável por atender os professores:</p>
            <ul>
            <?php while ($membro = $equipe->fetch_assoc()): ?>
                    <li><?= $membro['conteudo'] ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    
        <!-- Documentos Necessários -->
        <div class="section">
            <h3>Documentos Necessários para Solicitações</h3>
            <p>Para solicitar documentos específicos, tenha os seguintes itens prontos:</p>
            <ul>
            <?php while ($evento = $eventos->fetch_assoc()): ?>
                    <li><?= $documentos['conteudo'] ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    
        <!-- Próximos Eventos -->
        <div class="section">
            <h3>Próximos Eventos para Professores</h3>
            <ul>
            <?php while ($evento = $eventos->fetch_assoc()): ?>
                    <li><?= $evento['conteudo'] ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    
        <!-- FAQ -->
        <div class="section">
            <h3>Perguntas Frequentes (FAQ)</h3>
            <ul>
            <?php while ($faqItem = $faq->fetch_assoc()): ?>
                    <li><?= $faqItem['conteudo'] ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    
        <!-- Link para Formulário de Suporte -->
        <div class="section">
            <h3>Formulário de Suporte</h3>
            <a href="suporte.php" class="btn">Acessar Formulário de Suporte ao Professor</a>
        </div>
    </div>
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/secretaria/secretaria.js"></script>
</body>
</html>

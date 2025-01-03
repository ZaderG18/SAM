<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
// Buscar documentos do banco de dados
$sql = "SELECT tipo_declaracao FROM declaracao";
$result = $conn->query($sql);
$documentos = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de Documentos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/documentos/documentos.css">
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
    <div class="form-container">
        <!-- Coluna Esquerda -->
        <div class="left-column">
            <div class="box">
                <h2>Solicitação de Documentos</h2>
                <form action="../../php/professor/documentos.php" method="post">
                <label for="documento">Selecione o Documento:</label>
                <select id="documento" name="documento" class="caixa" required>
                    <option value="">Selecione o tipo de documento</option>
                    <?php foreach ($documentos as $documento) :?>
                    <option value="<?= htmlspecialchars($documento['tipo_declaracao'])?>"><?= htmlspecialchars($documento['tipo_declaracao'])?></option>
                   <?php endforeach; ?>
                </select>
    
                <label for="motivo">Motivo da Solicitação:</label>
                <input type="text" id="motivo" name="motivo" class="caixa" required>
    
                <label for="protocolo">Consulta de Protocolo:</label>
                <input type="text" id="protocolo" name="protocolo" class="caixa" required>
                <p>Prazo para retirada dos documentos: até 3 dias úteis.</p>
    
                <div style="display: flex; justify-content: space-between;">
                    <button type="button" name="acao" onclick="buscarProtocolo()">Buscar</button>
                    <button type="submit" name="acao">Enviar</button>
                </div>
                </form>
            </div>
    
            <div class="box">
                <h2>Documentos Disponíveis</h2>
                <form action="../../php/global/gerarPDF.php" method="post" target="_blank">
                <label for="tipo-documento">Selecione o Tipo de Documento:</label>
                <select id="tipo-documento" name="tipo-documento" class="caixa" required>
                    <option value="">Selecione o tipo de documento</option>
                    <?php foreach ($documentos as $documento) :?>
                    <option value="<?= htmlspecialchars($documento['tipo_declaracao'])?>"><?= htmlspecialchars($documento['tipo_declaracao'])?></option>
                   <?php endforeach?>
                </select>
                <button type="submit">Gerar Documento</button>
                </form>
            </div>
        </div>
    
        <!-- Coluna Direita -->
        <div class="right-column">
            <div class="box">
                <h2>Informações Importantes</h2>
                <p>Prazo para solicitação de documentos: 01/01/2024 a 31/12/2024.</p>
                <p>Prazo para retirada dos documentos: até 3 dias úteis após a solicitação.</p>
                <p>Para mais informações, consulte o guia disponível abaixo:</p>
                <button onclick="window.location.href='#'" type="button">Guia de Solicitação de Documentos</button>
            </div>
        </div>
    </div>
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/documentos/documentos.js"></script>
</body>
</html>

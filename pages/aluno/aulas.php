<?php
include '../../php/global/cabecario.php';
include '../../php/global/notificacao.php';
include '../../php/aluno/aulas.php';
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
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
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
                    <p><?php echo htmlspecialchars($descricao_materia); ?></p>
                </div>

                <!-- Indicador de progresso -->
                <div class="section progress-section">
                    <h3>Progresso da Matéria</h3>
                    <div class="progress-bar">
                        <div style="width: <?php echo htmlspecialchars($progresso);?>;"><?php echo htmlspecialchars($progresso); ?> concluído</div>
                    </div>
                </div>

                <!-- Atividades -->
                <div class="section activities">
                    <h4>Atividades</h4>
                    <?php foreach ($atividades as $atividade) : ?>
                    <div class="item activity-item">
                        <span><?php echo htmlspecialchars($atividade['titulo']); ?></span>
                        <a href="atividade.php?id=<?php echo htmlspecialchars($atividade['id'])?>">Fazer</a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Atividades Não Entregues e Pendentes -->
                <div class="section pending-activities">
                    <h4>Atividades Não Entregues e Pendentes</h4>
                    <?php foreach($pendentes as $pendente) : ?>
                    <div class="item">
                        <span><?php echo htmlspecialchars($pendente['titulo']); ?></span>
                        <a href="atividade.php?id=<?php echo htmlspecialchars($pendente['id']); ?>">Fazer</a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Feedback -->
                <div class="section feedback">
                    <h4>Feedback do Professor</h4>
                    <?php foreach ($feedbacks as $feedback): ?>
                    <div class="item feedback-item">
                        <span><?php echo htmlspecialchars($feedback['titulo']); ?></span>
                        <a href="feedback.php?atividade_id=<?php echo htmlspecialchars($feedback['atividade_id']); ?>">Ver Feedback</a>
                    </div>
                    <?php endforeach; ?>
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
                    <?php foreach ($materiais as $material) : ?>
                    <div class="item material-item">
                        <span><?php echo htmlspecialchars($material['titulo']); ?></span>
                        <a href="<?php echo htmlspecialchars($material['link']); ?>">Acessar</a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Suporte de Tutores -->
                <div class="section tutor-support">
                    <h4>Suporte de Tutores</h4>
                    <p>Para suporte adicional, entre em contato com os tutores:</p>
                    <ul>
                        <?php foreach ($tutores as $tutor) : ?>
                        <li><?php echo htmlspecialchars($tutor['nome']); ?>: <?php echo htmlspecialchars($tutor['email']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

    </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/aluno/aulas/aulas.js"></script>
    <script src="../../assets/js/global/search.js"></script>

</body>
</html>

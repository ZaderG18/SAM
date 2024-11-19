<?php
include '../../php/global/cabecario.php';
require '../../php/login/validar.php';
include '../../php/global/notificacao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Ajuda - Secretaria</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/suporte/suporte.css">
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
    <div class="containerbx">
        <div class="containerpx">
            <div class="secretaria">
                <h2>Solicite Ajuda da Secretaria Acadêmica</h2>
                <p>Se você precisa de assistência ou tem dúvidas sobre os serviços oferecidos pela Secretaria Acadêmica, 
                    este formulário é o lugar certo! Preencha as informações abaixo para que nossa equipe possa entender
                    melhor sua solicitação e oferecer a ajuda necessária. Estamos aqui para garantir que você tenha a melhor
                    experiência possível em sua jornada acadêmica.
                </p>
            </div>

        
        </div> 
            
        
        <div class="form-container">
            <h2>Formulário de ajuda</h2>
            <form action="../../php/aluno/envioEmail.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome-completo">Nome Completo:</label>
                    <input type="text" id="nome-completo" name="nome-completo" class = "caixa" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" class = "caixa" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class = "caixa" required>
                </div>
                <div class="form-group">
                    <label for="rm">RM:</label>
                    <input type="text" id="rm" name="rm" class = "caixa" required>
                </div>
                <div class="form-group">
                    <label for="curso">Curso:</label>
                    <select id="curso" name="curso" class = "caixa" required>
                        <option value="">Selecione o curso</option>
                        <option value="Desenvolvimento_de_sistemas">Desenvolvimento de sistemas</option>
                        <option value="Nutricao">Nutrição</option>
                        <option value="Gastronomia">Gastronomia</option>
                        <option value="Enfermagem">Enfermagem</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mensagem">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" rows="4" class="textarea" required></textarea>
                </div>
                <div class="file-group">
                    <label for="arquivo">Envio de Arquivos:</label>
                    <input type="file" id="arquivo" name="arquivo" class="btn-upload">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Enviar</button>
                </div>
            </form>
        </div>

    </div> 
    
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/suporte/suporte.js"></script>
</body>
</html>

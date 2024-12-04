<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
include '../../php/aluno/perfil.php';

// Dados principais
$user = getAlunoData($conn, $id);
$academico = getAcademicoData($conn, $id);
$contatoEmergencia = getContatoEmergencia($conn, $id);
$extracurricularActivities = getAtividadesExtraCurriculares($conn, $id);
if ($extracurricularActivities && is_array($extracurricularActivities)) {
    foreach ($extracurricularActivities as $atividade) {
        echo $atividade;
    }
}$curso = getCurso($conn, $id);
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
    <div class="containerpx">
        <!-- Cabeçalho -->
        <div class="headerpx">
            <img src="<?php echo $fotoCaminho ?>" alt="Foto do Aluno">
            <div class="info">
                <h2><?php echo htmlspecialchars($user['nome']) ?></h2>
                <p>RM: <?php echo htmlspecialchars($user['RM'])?></p>
                <p>Email: <?php echo htmlspecialchars($user['email'])?></p>
                <p>Curso: <?php echo htmlspecialchars(isset($curso['nome_curso'])? $curso['nome_curso'] : 'Não informado'); ?></p>
                <p>Status Acadêmico: <?php echo htmlspecialchars($user['status'])?></p>
            </div>
        </div>

        <!-- Informações Pessoais -->
        <div class="section">
            <h3 class="section-title">Informações Pessoais</h3>
            <div class="details">
                <div class="detail-item"><label>Nome Completo:</label><p><?= $user['nome']; ?></p></div>
                <div class="detail-item"><label>Data de Nascimento:</label><p><?= $user['data_nascimento']; ?></p></div>
                <div class="detail-item"><label>Telefone:</label><p><?= $user['telefone']; ?></p></div>
                <div class="detail-item"><label>Endereço:</label><p><?= $user['endereco']; ?></p></div>
                <div class="detail-item"><label>CPF:</label><p><?= $user['cpf']; ?></p></div>
                <!-- <div class="detail-item"><label>RG:</label><p><?= $user['rg']; ?></p></div> -->
                <div class="detail-item"><label>Estado Civil:</label><p><?= $user['estado_civil']; ?></p></div>
                <div class="detail-item"><label>Nacionalidade:</label><p><?= $user['nacionalidade']; ?></p></div>
                <div class="detail-item"><label>Data de Matrícula:</label><p><?= isset($curso['data_inicio']) ? date('d/m/Y', strtotime($curso['data_inicio'])) : 'Não informado'; ?></p></div>
            </div>
        </div>

        <!-- Informações Acadêmicas -->
        <div class="section">
            <h3 class="section-title">Informações Acadêmicas</h3>
            <div class="details">
                <div class="detail-item"><label>Curso:</label><p><?= isset($curso['nome_curso']) ? $curso['nome_curso'] : 'Não informado'; ?></p></div>
                <div class="detail-item"><label>Período:</label><p><?= isset($curso['periodo']) ? $curso['periodo'] : 'Não informado'; ?></p></div>
                <div class="detail-item"><label>Semestre Atual:</label><p><?= isset($curso['semestre_atual']) ? $curso['semestre_atual'] : 'Não informado'; ?></p></div>
                <div class="detail-item"><label>Sala:</label><p><?= isset($curso['sala']) ? $curso['sala'] : 'Não informada'; ?></p></div>
                <div class="detail-item"><label>Orientador Acadêmico:</label><p><?= isset($curso['orientador']) ? $curso['orientador'] : 'Não informado'; ?></p></div>
            </div>
        </div>

        <!-- Atividades Extracurriculares -->
        <div class="section">
            <h3 class="section-title">Atividades Extracurriculares</h3>
            <ul>
                <?php foreach ($extracurricularActivities as $activity): ?>
                    <li><?= $activity; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Contato de Emergência -->
        <div class="section">
            <h3 class="section-title">Contato de Emergência</h3>
            <div class="details">
                <div class="detail-item"><label>Nome do Contato:</label><p><?= isset($contatoEmergencia['nome_emergencia']) ? $contatoEmergencia['nome_emergencia'] : 'Não informado'; ?></p></div>
                <div class="detail-item"><label>Parentesco:</label><p><?= isset($contatoEmergencia['parentesco_emergencia']) ? $contatoEmergencia['parentesco_emergencia'] : 'Não informado'; ?></p></div>
                <div class="detail-item"><label>Telefone:</label><p><?= isset($contatoEmergencia['telefone_emergencia']) ? $contatoEmergencia['telefone_emergencia'] : 'Não informado'; ?></p></div>
            </div>
        </div>
        </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/perfil/perfil.js"></script>
</body>
</html>

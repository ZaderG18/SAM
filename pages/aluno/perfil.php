<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
include '../../php/aluno/perfil.php';

// Dados principais
$user = getAlunoData($conn, $id);
$academico = getAcademicoData($conn, $id);
$contatoEmergencia = getContatoEmergencia($conn, $id);
$atividades = getAtividadesExtracurriculares($conn, $id);
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
                <p>RM: <?php echo htmlspecialchars($user['RM'])?></p>
                <p>Email: <?php echo htmlspecialchars($user['email'])?></p>
                <p>Curso: <?php echo htmlspecialchars($user['curso_id'])?></p>
                <p>Status Acadêmico: <?php echo htmlspecialchars($user['status'])?></p>
            </div>
        </div>

        <!-- Informações Pessoais -->
         <?php if(!empty($user)) : ?>
        <div class="section">
            <h3 class="section-title">Informações Pessoais</h3>
            <div class="details">
                <?php $infoPessoais = [
                    'Nome Completo' => $user['nome'],
                    'Data de Nascimento' => $user['data_nascimento'],
                    'Telefone' => $user['telefone'],
                    'Endereço' => $user['endereco'],
                    'CPF' => $user['cpf'],
                    'Nacionalidade' => $user['nacionalidade'],
                    'Data de Matrícula' => $user['data_matricula']
                ];
                foreach ($infoPessoais as $label => $value) : ?>
                <div class="detail-item">
                    <label><?= $label; ?>:</label>
                    <p><?php htmlspecialchars($value) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- Informações Acadêmicas -->
         <?php if (!empty($academico)) : ?>
        <div class="section">
            <h3 class="section-title">Informações Acadêmicas</h3>
            <div class="details">
                <?php $infoAcademicas = [
                    'Curso' => $academico['curso'],
                    'Período' => $academico['periodo'],
                    'Semestre Atual' => $academico['modulo_atual'],
                    'Sala' => $academico['turma'],
                    'Orientador Acadêmico' => 'Prof. ' . $academico['nome_professor'],
                    'Bolsas e Auxílios' => $academico['bolsas_auxilios'],
                    'Horas Complementares' => $academico['horas_complementares'],
                    'Estágio Atual' => $academico['estagio_atual']
                ]; 
                foreach ($infoAcademicas as $label => $value) : ?>
                <div class="detail-item">
                    <label><?= $label ?>:</label>
                    <p><?= htmlspecialchars($value) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php $listas = [
            'Desempenho Acadêmico' => $desempenhoAcademico,
            'Projetos e Pesquisas' => $projetosPesquisas,
            'Eventos Acadêmicos' => $eventosAcademicos,
            'Atividades Extracurriculares' => $atividadesExtracurriculares
        ];
        foreach ($listas as $titulo => $itens) :
        if (!empty($itens)) : ?>
        <!-- Desempenho Acadêmico -->
        <div class="section">
            <h3 class="section-title"><?= $titulo ?></h3>
            <ul>
                <?php foreach ($itens as $item) : ?>
                <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; endforeach;?>

        <!-- Contato de Emergência -->
        <div class="section">
            <h3 class="section-title">Contato de Emergência</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome do Contato:</label>
                    <p><?php echo htmlspecialchars($contatoEmergencia['nome_emergencia']); ?></p>
                </div>
                <div class="detail-item">
                    <label>Parentesco:</label>
                    <p><?php echo htmlspecialchars($contatoEmergencia['parente_emergencia']); ?></p>
                </div>
                <div class="detail-item">
                    <label>Telefone de Contato:</label>
                    <p><?php echo htmlspecialchars($contatoEmergencia['telefone_emergencia']); ?></p>
                </div>
                <div class="detail-item">
                    <label>Email de Contato:</label>
                    <p><?php echo htmlspecialchars($contatoEmergencia['email_emergencia']); ?></p>
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

<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
include '../../php/professor/perfil.php';
$usuario = getUsuario($conn, $id);
$professor = getProfessor($conn, $id);
$contatoEmergencia = getContatoEmergencia($conn, $id);
$extracurricularActivities = getAtividadesExtraCurriculares($conn, $id);
if ($extracurricularActivities && is_array($extracurricularActivities)) {
    foreach ($extracurricularActivities as $atividade) {
        echo $atividade;
    }
}
$projetos = getProjetosProfessor($conn, $id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/perfil/perfil.css">
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
        <!-- Cabeçalho -->
        <div class="headerpx">
            <img src="<?php echo $fotoCaminho ?>" alt="Foto da Professora">
            <div class="info">
                <h2>Prof. <?php echo htmlspecialchars($user['nome']);?></h2>
                <p>ID: <?= $user['id']; ?></p>
                <p>Email: <?= $user['email'];?></p>
                <p>Departamento: <?= htmlspecialchars(isset($professor['departamento']) ? $professor['departamento'] : 'Não informado');?></p>
                <p>Status: <?= $user['status']?></p>
            </div>
        </div>

        <!-- Informações Pessoais -->
        <div class="section">
            <h3 class="section-title">Informações Pessoais</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome Completo:</label>
                    <p>Prof. <?php echo htmlspecialchars($user['nome']);?></p>
                </div>
                <div class="detail-item">
                    <label>Data de Nascimento:</label>
                    <p><?= $usuario['data_nascimento']?></p>
                </div>
                <div class="detail-item">
                    <label>Telefone:</label>
                    <p><?= isset($usuario['telefone']) ? $usuario['telefone'] : 'Não informado'; ?></p>
                    </div>
                <div class="detail-item">
                    <label>Endereço:</label>
                    <p><?= $usuario['endereco']; ?></p>
                </div>
                <div class="detail-item">
                    <label>Estado Civil:</label>
                    <p><?= $usuario['estado_civil']?></p>
                </div>
                <div class="detail-item">
                    <label>Nacionalidade:</label>
                    <p><?= $usuario['nacionalidade']?></p>
                </div>
                <div class="detail-item">
                    <label>Data de Admissão:</label>
                    <p><?php echo date("d/m/Y",strtotime(isset($professor['data_admissao']) ? $professor['data_admissao'] : '0'))?></p>
                </div>
            </div>
        </div>

        <!-- Informações Acadêmicas -->
        <div class="section">
            <h3 class="section-title">Informações Acadêmicas</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Departamento:</label>
                    <p><?= isset($professor['departamento']) ? htmlspecialchars($professor['departamento']) : 'Não informado' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Cargo:</label>
                    <p><?= isset($usuario['cargo']) ? $usuario['cargo'] : 'Não informado' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Disciplinas Ministradas:</label>
                    <p><?= isset($professor['disciplinas_id']) ? $professor['disciplinas_id'] : 'Não informado' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Sala:</label>
                    <p>Sala <?= isset($professor['sala']) ? htmlspecialchars($professor['sala']) : 'Não informada' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Orientações:</label>
                    <p><?= isset($professor['orientacoes']) ? $professor['orientacoes'] : 'Não informado' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Projetos de Pesquisa:</label>
                    <p><?= isset($professor['projetos_pesquisa']) ? $professor['projetos_pesquisa'] : 'Não informado' ?></p>
                    </div>
                <div class="detail-item">
                    <label>Publicações:</label>
                    <p><?= isset($professor['publicacoes']) ? $professor['publicacoes'] : 'Não informada' ?></p>
                    </div>
            </div>
        </div>

        <!-- Desempenho Acadêmico -->
        <div class="section">
            <h3 class="section-title">Desempenho Acadêmico</h3>
            <?php if (isset($desempenho) && is_array($desempenho)): ?>
            <ul>
                <?php foreach ($desempenho as $item) :?>
                <li><?= $item?></li>
                <!-- <li>Avaliação média pelos alunos: 9.2</li>
                <li>Coordenação de 3 projetos de extensão.</li>
                <li>Prêmio de Melhor Professora do Departamento em 2022.</li> -->
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
    <p>Sem dados de desempenho.</p>
<?php endif; ?>
        </div>

        <!-- Projetos e Pesquisas -->
        <div class="section">
            <h3 class="section-title">Projetos e Pesquisas</h3>
            <ul>
            <?php if (!empty($projetos)): ?>
            <?php foreach ($projetos as $projeto): ?>
                <li><?php echo htmlspecialchars(trim($projeto)); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhum projeto encontrado.</li>
        <?php endif; ?>
            </ul>
        </div>

        <!-- Contato de Emergência -->
        <div class="section">
            <h3 class="section-title">Contato de Emergência</h3>
            <div class="details">
                <div class="detail-item">
                    <label>Nome do Contato:</label>
                    <p><?= isset($contatoEmergencia['nome_emergencia']) ? $contatoEmergencia['nome_emergencia'] : 'Não informado'?></p>
                </div>
                <div class="detail-item">
                    <label>Parentesco:</label>
                    <p><?= isset($contatoEmergencia['parente_emergencia']) ? $contatoEmergencia['parente_emergencia'] : 'Não informado'?></p>
                </div>
                <div class="detail-item">
                    <label>Telefone de Contato:</label>
                    <p><?= isset($contatoEmergencia['telefone_emergencia']) ? $contatoEmergencia['telefone_emergencia'] : 'Não informado'; ?></p>
                    </div>
                <div class="detail-item">
                    <label>Email de Contato:</label>
                    <p><?= isset($contatoEmergencia['email_emergencia']) ? $contatoEmergencia['email_emergencia'] : 'Não informado'?></p>
                </div>
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

        <!-- Eventos -->
        <div class="section">
            <h3 class="section-title">Eventos Acadêmicos</h3>
            <ul>
            <?php if (!empty($eventos)): ?>
            <?php foreach ($eventos as $evento): ?>
                <li><?php echo htmlspecialchars($evento['nome_evento']); ?> - <?php echo date('d/m/Y', strtotime($evento['data_evento'])); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhum evento encontrado.</li>
        <?php endif; ?>
            </ul>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/perfil/perfil.js"></script>
</body>
</html>

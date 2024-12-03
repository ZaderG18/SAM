<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
include_once '../../php/professor/home.php';
include '../../php/global/notificacao.php';
include '../../php/global/cabecario.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo ao SAM</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/home/home.css">
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
        <div class="container">
            <!-- Banner de saudação -->
            <div class="banner">
                <div>
                    <h1>Bem-vindo, <?php echo htmlspecialchars($user['nome'])?>!</h1>
                    <p>Você tem <?php echo $totalAtualizacoes; ?> novas mensagens e <?php echo $totalTarefas; ?> tarefas para revisar.</p>
                </div>
                <img src="../../assets/img/home/fotos/imgprof.png" alt="Avatar">
            </div>

            <!-- Cards principais -->
            <div class="cards">
                <div class="card">
                    <a href="frequencia.php">
                        <img src="../../assets/img/home/fotos/circulo_verde.png" alt="Chamada">
                    </a>
                    <h3>Chamada</h3>
                    <p>Gerencie a chamada dos alunos.</p>
                </div>
                <div class="card">
                    <a href="boletim.php">
                        <img src="../../assets/img/home/fotos/circulo_azul.png" alt="Lançamento de Notas">
                    </a>
                    <h3>Lançamento de Notas</h3>
                    <p>Registre as notas dos alunos.</p>
                </div>
                <div class="card">
                    <a href="materias.php">
                        <img src="../../assets/img/home/fotos/circulo_amarelo.png" alt="Disciplinas">
                    </a>
                    <h3>Disciplinas</h3>
                    <p>Gerencie suas disciplinas.</p>
                </div>
                <div class="card">
                    <a href="secretaria.php">
                        <img src="../../assets/img/home/fotos/circulo_rosa.png" alt="Secretaria">
                    </a>
                    <h3>Secretaria</h3>
                    <p>Acesse informações da secretaria.</p>
                </div>
            </div>

            <!-- Calendário -->
            <div class="sections">
                <div class="calendar">
                    <h3>Calendário</h3>
                    <div class="calendar-header">
                        <button id="prevMonth">Anterior</button>
                        <h3 id="monthYear"></h3>
                        <button id="nextMonth">Próximo</button>
                    </div>
                    <div class="calendar-weekdays">
                        <div>Dom</div>
                        <div>Seg</div>
                        <div>Ter</div>
                        <div>Qua</div>
                        <div>Qui</div>
                        <div>Sex</div>
                        <div>Sáb</div>
                    </div>
                    <div class="calendar-days" id="calendarDays"></div>
                </div>

                <!-- Perfil da professora -->
                <div class="profile">
                    <h3>Dados do <?php $denominacao; ?></h3>
                    <img src="<?php echo htmlspecialchars($fotoCaminho) ?>" alt="Perfil da Professora">
                    <h2><?php echo htmlspecialchars($user['nome']);?></h2>
                    <p>Professora de Matemática</p>
                    <p>Matrícula:<?php echo htmlspecialchars($user['RM']);?></p>
                    <p>Email: <?php echo htmlspecialchars($user['email']);?></p>
                    <p>Telefone: <?php echo htmlspecialchars($user['telefone']);?></p>
                </div>

                <!-- Tarefas Pendentes -->
                <div class="section">
                    <h3>Tarefas Pendentes</h3>
                    <ul>
                        <?php while ($tarefa = $resultTarefas->fetch_assoc()) : ?>
                        <li><?php echo htmlspecialchars($tarefa['tarefa']); ?> <span>(entrega em <?php echo htmlspecialchars($tarefa['prazo']); ?>)</span></li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <!-- Horário de Aula -->
                <div class="section">
                    <h3>Horário de Aula</h3>
                    <?php $diaAnterior = null; while ($horario = $resultHorario->fetch_assoc()) : 
                        if ($diaAnterior !== $horario['dia_semana']) {
                            if ($diaAnterior !== null) echo "<hr>";
                            echo "<h4>" . htmlspecialchars($horario['dia_semana']) . "</h4>"; 
                            $diaAnterior = $horario['dia_semana'];
                        }?>
                    <p><?php echo htmlspecialchars($horario['disciplina']); ?>: <?php echo htmlspecialchars($horario['hora_inicio']); ?> - <?php echo htmlspecialchars($horario['hora_fim']); ?></p>
                    <?php endwhile; ?>
                </div>

                <!-- Chamadas Pendentes -->
                <div class="section">
                    <h3>Chamadas Pendentes</h3>
                    <ul>
                        <?php while ($chamada = $resultChamadas->fetch_assoc()) : ?>
                        <li>Chamada da turma de <?php echo htmlspecialchars($chamada['disciplina']); ?> <span>(pendente)</span></li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <!-- Feed de atualizações recentes -->
                <div class="feed">
                    <h3>Atualizações Recentes</h3>
                    <ul>
                        <?php while ($atualizacao = $resultAtualizacoes->fetch_assoc()) : ?>
                        <li><?php echo htmlspecialchars($atualizacao['descricao'])?> <span>(<?php echo htmlspecialchars($atualizacao['data'])?>)</span></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/home/home.js"></script>
</body>
</html>

<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Obter contagem de disciplinas coordenadas
$disciplinasCount = $conn->query("SELECT COUNT(*) AS total FROM disciplina")->fetch_assoc()['total'];

// Obter contagem de alunos supervisionados
$alunosCount = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'aluno'")->fetch_assoc()['total'];

// Obter contagem de professores supervisionados
$professoresCount = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE cargo = 'professor'")->fetch_assoc()['total'];

// Obter contagem de relatórios pendentes
$relatoriosCount = $conn->query("SELECT COUNT(*) AS total FROM relatorio WHERE status = 'pendente'")->fetch_assoc()['total'];

// Obter reuniões agendadas
$reunioes = $conn->query("SELECT DATE_FORMAT(data, '%d/%m') AS data_formatada, descricao FROM reuniao ORDER BY data ASC LIMIT 3");

// Obter comunicados recentes
$comunicados = $conn->query("SELECT DATE_FORMAT(data, '%d/%m') AS data_formatada, descricao FROM comunicado ORDER BY data DESC LIMIT 3");

// Dados para progresso acadêmico
$progressQuery = "SELECT nome_disciplina, AVG(progresso) AS progresso FROM progresso_academico GROUP BY nome_disciplina";
$progressResult = $conn->query($progressQuery);
$progressData = $progressResult->fetch_all(MYSQLI_ASSOC);

// Dados para desempenho das turmas
$performanceQuery = "SELECT nome_turma, AVG(nota) AS media_notas FROM desempenho_turmas GROUP BY nome_turma";
$performanceResult = $conn->query($performanceQuery);
$performanceData = $performanceResult->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE php>
<php lang="pt-br">
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
        <a href="disciplina.php" class="card">
            <h3>Disciplinas Coordenadas</h3>
            <div class="count"><?= $disciplinasCount; ?></div>
            <p>Disciplinas atualmente sob sua coordenação. Clique para detalhes.</p>
        </a>

        <!-- Card de Alunos Supervisionados -->
        <a href="alunos.php" class="card">
            <h3>Alunos Supervisionados</h3>
            <div class="count"><?= $alunosCount; ?></div>
            <p>Total de alunos sob supervisão direta em várias disciplinas. Clique para detalhes.</p>
        </a>

        <!-- Card de Supervisão de Professores -->
        <a href="professores.php" class="card">
            <h3>Professores Supervisionados</h3>
            <div class="count"><?= $professoresCount;?></div>
            <p>Número de professores sob sua coordenação. Clique para detalhes.</p>
        </a>

        <!-- Card de Relatórios Pendentes -->
        <a href="relatorios.php" class="card">
            <h3>Relatórios Pendentes</h3>
            <div class="count"><?= $relatoriosCount;?></div>
            <p>Relatórios acadêmicos que precisam ser enviados. Clique para detalhes.</p>
        </a>

        <!-- Card de Reuniões Agendadas -->
        <div class="card">
            <h3>Reuniões Agendadas</h3>
            <ul class="events-list">
                <?php while ($row = $reunioes->fetch_row()) : ?>
                <li><span><?= $row['data_formatada']; ?>:</span> <?= $row['descricao']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Card de Comunicados Recentes -->
        <div class="card">
            <h3>Comunicados Recentes</h3>
            <ul class="events-list">
            <?php while ($row = $comunicados->fetch_row()) : ?>
                <li><span><?= $row['data_formatada']; ?>:</span> <?= $row['descricao']; ?></li>
                <?php endwhile; ?>
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
    <script src="../../../assets/js/global/search.js"></script>
    <script>
    // Dados dinâmicos do PHP
    var progressData = <?= json_encode($progressData); ?>;
    var performanceData = <?= json_encode($performanceData); ?>;

    // Preparar dados para o gráfico de progresso acadêmico
    var progressLabels = progressData.map(item => item.nome_disciplina);
    var progressValues = progressData.map(item => parseInt(item.progresso));

    var ctx = document.getElementById('progressChart').getContext('2d');
    var progressChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: progressLabels,
            datasets: [{
                label: 'Progresso (%)',
                data: progressValues,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Preparar dados para o gráfico de desempenho das turmas
    var performanceLabels = performanceData.map(item => item.nome_turma);
    var performanceValues = performanceData.map(item => parseInt(item.media_notas));

    var ctx = document.getElementById('performanceChart').getContext('2d');
    var performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: performanceLabels,
            datasets: [{
                label: 'Média de Notas (%)',
                data: performanceValues,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    if (progressData.length === 0) {
    document.getElementById('progressChart').parentNode.innerHTML = '<p>Sem dados para o gráfico de progresso.</p>';
}

if (performanceData.length === 0) {
    document.getElementById('performanceChart').parentNode.innerHTML = '<p>Sem dados para o gráfico de desempenho.</p>';
}

    </script>
</body>
</php>

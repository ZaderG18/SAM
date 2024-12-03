<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
include '../../php/professor/historico.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico Acadêmico </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/historico/historico.css">
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
  
    <div class="containerxx">
        <!-- Cabeçalho com título e busca -->
        <div class="header-section">
            <h1 class="headerpx">Histórico Acadêmico - Turmas e Alunos</h1>
        </div>

        <!-- Filtros de Turma, Bimestre, Turno, etc. -->
        <div class="filters">
            <div>
                <label for="turma">Selecionar Turma:</label>
                <select id="turma">
                    <option value="todas">Todas</option>
                    <?php while ($turma = $turmas->fetch_assoc()) { ?>
                        <option value="<?= $turma['id'] ?>"><?= $turma['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="bimestre">Selecionar Bimestre:</label>
                <select id="bimestre">
                    <option value="todos">Todos</option>
                    <?php foreach ($bimestres as $bimestre) { ?>
                        <option value="<?= $bimestre ?>"><?= $bimestre ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="turno">Selecionar Turno:</label>
                <select id="turno">
                    <option value="todos">Todos</option>
                    <?php foreach ($turnos as $turno) { ?>
                        <option value="<?= $turno ?>"><?= $turno ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label for="periodo">Selecionar Período:</label>
                <select id="periodo">
                    <option value="todos">Todos</option>
                    <?php foreach ($periodos as $periodo) { ?>
                        <option value="<?= $periodo ?>"><?= $periodo ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <!-- Visão Geral da Turma -->
        <div class="dashboard-overview">
            <h2>Visão Geral da Turma</h2>
            <div class="cards-overview">
                <div class="card">
                    <h3>Média da Turma</h3>
                    <p><?= $turmaDados->fetch_assoc()['media_turma'] ?></p>
                </div>
                <div class="card">
                    <h3>Disciplinas Críticas</h3>
                    <p><?= $turmaCritica->fetch_assoc()['disciplinas_criticas']?> Disciplinas com alta taxa de reprovação</p>
                </div>
                <div class="card">
                    <h3>Progresso da Turma</h3>
                    <div class="progress-bar">
                        <div class="progress" style="width: 65%;">65% Concluído</div>
                    </div>
                </div>
                <div class="card">
                    <h3>Alunos com Desempenho Crítico</h3>
                    <p><?= $alunosCriticos->fetch_assoc()['alunos_criticos'] ?> alunos com nota média abaixo de 5.0</p>
                </div>
            </div>
        </div>

        <!-- Análise Individualizada -->
        <div class="student-analysis">
            <h2>Análise Individualizada do Aluno</h2>
            <div class="filters">
                <label for="student-select">Selecionar Aluno:</label>
                <select id="student-select">
                    <?php $alunos->data_seek(0);
                    while ($aluno = $alunos->fetch_assoc()) { ?>
                    <option value="<?= $aluno['id'] ?>"><?=  $aluno['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Resumo Acadêmico do Aluno -->
            <div class="summary">
                <?php $resumo = $alunoResumo->fetch_assoc(); ?>
                <p><strong>Nome:</strong> <?= $resumo['nome']; ?></p>
                <p><strong>RM:</strong> <?= $resumo['rm']; ?></p>
                <p><strong>Média Geral:</strong> <?= $resumo['media_geral']; ?></p>
                <p><strong>Disciplinas Pendentes:</strong> <?= $resumo['disciplinas_pendentes']; ?></p>
                <p><strong>Prazo Estimado de Conclusão:</strong> <?= $resumo['prazo_estimado']; ?></p>

                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo $progresso; ?>%;"><?php echo round($progresso); ?>% Concluído</div>
                </div>
            </div>

            <!-- Desempenho por Disciplina -->
            <h3>Desempenho por Disciplina</h3>
            <div class="table-container">
                <table class="performance-table">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Nota</th>
                            <th>Faltas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($disciplina = $desempenhoDisciplinas->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $disciplina['nome']; ?></td>
                            <td><?= $disciplina['nota']; ?></td>
                            <td><?= $disciplina['faltas']; ?></td>
                            <td class="<?= strtolower($disciplina['status']) ?>"><?=  $disciplina['status']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Alertas e Recomendações -->
        <div class="alerts-section">
            <h2>Alertas e Recomendações</h2>
            <ul class="alerts-list">
               <!-- Exibir alertas de faltas -->
        <?php while ($alerta = $result_alertas->fetch_assoc()): ?>
            <li><strong>Alerta:</strong> Aluno com alta taxa de faltas em <?php echo $alerta['nome_disciplina']; ?> (<?php echo $alerta['aluno_nome']; ?>)</li>
        <?php endwhile; ?>

        <!-- Exibir recomendações de recuperação -->
        <?php while ($recomendacao = $result_recomendacoes->fetch_assoc()): ?>
            <li><strong>Recomendação:</strong> Considerar recuperação para <?php echo $recomendacao['aluno_nome']; ?> em <?php echo $recomendacao['nome_disciplina']; ?></li>
        <?php endwhile; ?>
            </ul>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/historico/historico.js"></script>
</body>
</html>

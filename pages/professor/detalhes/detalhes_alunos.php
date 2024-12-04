<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Obtém o ID do aluno da URL
$idAluno = $_GET['id'] ?? null;

if ($idAluno) {
    // Busca os dados do aluno
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE cargo = 'aluno' AND id = ?");
    $stmt->bind_param("i", $idAluno);
    $stmt->execute();
    $result = $stmt->get_result();
    $aluno = $result->fetch_assoc();

    // Busca o desempenho acadêmico
    $stmt = $conn->prepare("SELECT nota_media, disciplinas_risco, observacoes FROM notas WHERE aluno_id = ?");
    $stmt->bind_param("i", $idAluno);
    $stmt->execute();
    $notas = $stmt->get_result()->fetch_assoc();

    // Busca a frequência
    $stmt = $conn->prepare("SELECT frequencia_total, faltas FROM frequencia WHERE aluno_id = ?");
    $stmt->bind_param("i", $idAluno);
    $stmt->execute();
    $frequencia = $stmt->get_result()->fetch_assoc();

    // busca turmas
    $stmt = $conn->prepare("SELECT * FROM turma WHERE aluno_id = ?");
    $stmt->bind_param("i", $idAluno);
    $stmt->execute();
    $turmas = $stmt->get_result()->fetch_assoc();

    // Busca relatórios
    $stmt = $conn->prepare("SELECT descricao FROM relatorio WHERE aluno_id = ?");
    $stmt->bind_param("i", $idAluno);
    $stmt->execute();
    $relatorios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<script>alert('ID do aluno não fornecido.')</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - Alunos</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/detalhes/detalhes_alunos.css">
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
            <img src="../<?php echo $fotoCaminho ?>" alt="" class="header__img">
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
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="../dashboard/dashboard.php" class="nav__link">
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
  
    <!-- Container Principal -->
    <div class="container">
        <div class="student-header">
            <div class="student-info">
                <h2><?= htmlspecialchars($aluno['nome'] ?? 'Sem Nome')?></h2>
                <p>Matrícula: <?= htmlspecialchars($aluno['rm'] ?? 'Sem Matrícula');?></p>
                <p>Turma: <?= htmlspecialchars(isset($turmas['nome']) ? $turmas['nome'] : 'Sem Turma');?></p>
            </div>   
        </div>

        <!-- Seção de Detalhes -->
        <div class="detail-section">
            <div class="card">
                <h3>Desempenho Acadêmico</h3>
                <i class="fas fa-chart-line icon"></i>
                <p>Média: <?= $notas['nota_media'] ?? 'Sem Média';?></p>
                <p>Disciplinas em Risco: <?php 
    // Verifica se 'disciplinas_risco' é um array ou string e converte para array, caso necessário
    if (!empty($notas['disciplinas_risco'])) {
        // Se for uma string, transforma em array
        $disciplinasRisco = is_array($notas['disciplinas_risco']) ? $notas['disciplinas_risco'] : explode(',', $notas['disciplinas_risco']);
        echo implode(', ', $disciplinasRisco); 
    } else {
        echo 'Nenhuma Disciplina em Risco';
    }
?></p>            </div>

            <div class="card">
                <h3>Frequência</h3>
                <i class="fas fa-calendar-check icon"></i>
                <p>Frequência Geral: <?= $frequencia['frequencia_total'] ?? 'Sem Frequência';?>%</p>
                <p>Faltas: <?= $frequencia['faltas'] ?? 'Sem Faltas';?></p>
            </div>

            <div class="card">
                <h3>Observações</h3>
                <i class="fas fa-sticky-note icon"></i>
                <p><?php echo $notas['observacoes'] ?? 'Sem Observações';?></p>
            </div>

            <div class="card">
                <h3>Relatórios</h3>
                <i class="fas fa-file-alt icon"></i>
                <ul>
                <?php foreach ($relatorios as $relatorio) : ?>
                        <li><a href="<?php echo $relatorio['url']; ?>"><?php echo $relatorio['titulo']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Seção de Gráfico Simulada 
        <div class="graph-container">
            <canvas id="performanceChart" class="graph"></canvas>
        </div>-->

        <!-- Ações -->
        <div class="actions">
            <button onclick="alert('Gerar novo relatório');"><i class="fas fa-file-medical"></i> Gerar Relatório</button>
        </div>
    </div>


</main>

    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../../assets/js/global/search.js"></script>
    <script src="../../../assets/js/professor/detalhes/detalhes_aluno.js"></script>
</body>
</html>

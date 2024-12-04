<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta SQL para pegar os dados do professor
    $sql = "SELECT u.id, u.nome, u.foto, AVG(a.nota) AS media_avaliacoes, 
            GROUP_CONCAT(m.nome SEPARATOR ', ') AS materias, f.frequencia_total, f.faltas
            FROM usuarios u
            LEFT JOIN avaliacao a ON a.professor_id = u.id
            LEFT JOIN materias m ON m.professor_id = u.id
            LEFT JOIN frequencia f ON f.professor_id = u.id
            WHERE u.id = ?
            GROUP BY u.id";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o professor foi encontrado
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Professor não encontrado.";
        exit();
    }
     // Consulta para pegar as observações
     $sqlObservacoes = "SELECT observacao FROM observacoes WHERE usuario_id = ?";
     $stmtObservacoes = $conn->prepare($sqlObservacoes);
     $stmtObservacoes->bind_param("s", $userId);
     $stmtObservacoes->execute();
     $resultObservacoes = $stmtObservacoes->get_result();
 
     // Consulta para pegar os relatórios
     $sqlRelatorios = "SELECT titulo, mes_ano FROM relatorios WHERE usuario_id = ?";
     $stmtRelatorios = $conn->prepare($sqlRelatorios);
     $stmtRelatorios->bind_param("s", $userId);
     $stmtRelatorios->execute();
     $resultRelatorios = $stmtRelatorios->get_result();
} else {
    echo "ID de usuário não fornecido.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - Professores</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/detalhes/detalhes_professores.css">
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
  
    <!-- Container Principal -->
    <div class="container">
        <div class="student-header">
            <div class="student-info">
            <h2>Prof: <?= htmlspecialchars(isset($row['nome']) ? $row['nome'] : 'Sem Nome') ?></h2>
            <p>ID: <?= htmlspecialchars(isset($row['id']) ? $row['id'] : 'Sem ID') ?></p>
            <p>Departamento: <?= htmlspecialchars(isset($row['departamento']) ? $row['departamento'] : 'Sem Departamento') ?></p>
            </div>   
        </div>

        <!-- Seção de Detalhes -->
        <div class="detail-section">
            <div class="card">
                <h3>Desempenho Profissional</h3>
                <i class="fas fa-chart-line icon"></i>
                <p>Média de Avaliações: <?= number_format(isset($row['media_avaliacoes']) ? $row['media_avaliacoes'] : 0, 1) ?></p>
                <p>Disciplinas Ministradas: <?= htmlspecialchars(isset($row['materias']) ? $row['materias'] : 'Sem Disciplinas') ?></p>
            </div>

            <div class="card">
                <h3>Frequência</h3>
                <i class="fas fa-calendar-check icon"></i>
                <p>Frequência Geral: <?= htmlspecialchars($row['frequencia_total']) ?>%</p>
                <p>Faltas: <?= htmlspecialchars($row['faltas']) ?></p>
            </div>

            <div class="card">
                <h3>Observações</h3>
                <i class="fas fa-sticky-note icon"></i>
                <?php
                if ($resultObservacoes->num_rows > 0) {
                    while ($observacao = $resultObservacoes->fetch_assoc()) {
                        echo "<p>" . htmlspecialchars($observacao['observacao']) . "</p>";
                    }
                } else {
                    echo "<p>Não há observações disponíveis.</p>";
                }
                ?>
            </div>            </div>

            <div class="card">
                <h3>Relatórios</h3>
                <i class="fas fa-file-alt icon"></i>
                <ul>
                <?php
                    if ($resultRelatorios->num_rows > 0) {
                        while ($relatorio = $resultRelatorios->fetch_assoc()) {
                            echo "<li><a href='#'>" . htmlspecialchars($relatorio['titulo']) . " - " . htmlspecialchars($relatorio['mes_ano']) . "</a></li>";
                        }
                    } else {
                        echo "<li>Não há relatórios disponíveis.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Seção de Gráfico Simulada 
        <div class="graph-container">
            <canvas id="performanceChart" class="graph"></canvas>
        </div> -->

        <!-- Ações -->
        <div class="actions">
            <button onclick="alert('Gerar novo relatório');"><i class="fas fa-file-medical"></i> Gerar Relatório</button>
        </div>
    </div>



</main>

    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../../assets/js/global/search.js"></script>
    <script src="../../../assets/js/professor/detalhes/detalhes_professor.js"></script>
</body>
</html>

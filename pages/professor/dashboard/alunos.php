<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Definir a turma padrão como 'todas as turmas'
$classFilter = 'all';
if (isset($_GET['classFilter']) && in_array($_GET['classFilter'], ['turma1', 'turma2', 'turma3'])) {
    $classFilter = $_GET['classFilter'];
}

// Consultar todas as turmas para o filtro
$sqlTurmas = "SELECT DISTINCT nome FROM turma";
$turmasResult = $conn->query($sqlTurmas);

// Consultar alunos com base na turma e buscar desempenho na tabela desempenho_aluno
$sqlAlunos = "SELECT u.id, u.nome, u.foto, t.nome AS turma, d.desempenho
              FROM usuarios u
              JOIN turma t ON u.id = t.aluno_id
              LEFT JOIN desempenho_alunos d ON u.id = d.aluno_id
              WHERE u.cargo = 'aluno'";

// Adicionar filtro de turma se necessário
if ($classFilter !== 'all') {
    $sqlAlunos .= " AND t.nome = '$classFilter'";
}

$alunosResult = $conn->query($sqlAlunos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alunos</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/dashboard/alunos.css">
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
    <div class="main-content">
        <div class="search-bar">
            <form action="" method="get">
            <input type="text" id="searchInput" placeholder="Buscar aluno...">
            <select id="classFilter">
                <option value="all" <?php if ($classFilter === 'all') echo 'selecionado'?>>Todas as turmas</option>
               <?php if ($turmasResult->num_rows > 0) {
                        while ($turma = $turmasResult->fetch_assoc()) {
                            $turmaNome = $turma['nome'];
                            echo "<option value='$turmaNome' " . ($classFilter === $turmaNome ? 'selected' : '') . ">$turmaNome</option>";
                        }
                    }?>
            </select>
            <button type="submit">Buscar</button>
            </form>
        </div>

        <div class="student-list" id="studentList">
    <?php if ($alunosResult->num_rows > 0) {
        while ($row = $alunosResult->fetch_assoc()) {
            $id = $row['id']; 
            $nome = $row['nome'];
            $turma = $row['turma'];
            $desempenho = $row['desempenho'] ?? 'Não disponível';
            $foto = $row['foto'];
    ?>
    <div class="student-card" data-turma="<?php echo $turma; ?>">
        <img src="../../../assets/img/uploads/<?php echo $foto; ?>" alt="<?php echo $nome; ?>">
        <h3><?php echo $nome; ?></h3>
        <p>Turma: <?php echo $turma; ?> | Desempenho: <?php echo $desempenho; ?>%</p>
        <a href="../detalhes/detalhes_alunos.php?id=<?php echo $id; ?>">Ver Detalhes</a>
    </div>
    <?php
        }
    } else {
        echo "<p>Nenhum aluno encontrado.</p>";
    } ?>
</div>

            <!-- <div class="student-card" data-turma="turma2">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Ana Souza">
                <h3>Ana Souza</h3>
                <p>Turma: 2 | Desempenho: 90%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma3">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Clara Lima">
                <h3>Clara Lima</h3>
                <p>Turma: 3 | Desempenho: 88%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma1">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Beatriz Alves">
                <h3>Beatriz Alves</h3>
                <p>Turma: 1 | Desempenho: 92%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma2">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Fernanda Costa">
                <h3>Fernanda Costa</h3>
                <p>Turma: 2 | Desempenho: 87%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma3">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Gabriela Rocha">
                <h3>Gabriela Rocha</h3>
                <p>Turma: 3 | Desempenho: 89%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma1">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Isabela Martins">
                <h3>Isabela Martins</h3>
                <p>Turma: 1 | Desempenho: 91%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma2">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Juliana Pereira">
                <h3>Juliana Pereira</h3>
                <p>Turma: 2 | Desempenho: 86%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma3">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Larissa Fernandes">
                <h3>Larissa Fernandes</h3>
                <p>Turma: 3 | Desempenho: 93%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div>
            <div class="student-card" data-turma="turma1">
                <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Mariana Oliveira">
                <h3>Mariana Oliveira</h3>
                <p>Turma: 1 | Desempenho: 94%</p>
                <a href="../detalhes/detalhes_alunos.php">Ver Detalhes</a>
            </div> -->
        </div>

        <div class="pagination">
            <button disabled>&laquo; Anterior</button>
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>Próximo &raquo;</button>
        </div>
    </div>
</main>



    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/global/search.js"></script>
    <script src="../../../assets/js/professor/dashboard/dashboard.js"></script>
    <script src="../../../assets/js/professor/dashboard/alunos.js"></script>
</body>
</html>

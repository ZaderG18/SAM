<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Variáveis para armazenar os filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$classFilter = isset($_GET['classFilter']) ? $_GET['classFilter'] : 'all';

// Consulta para obter os professores, matérias e turmas com base nos filtros
$sql = "SELECT u.id, u.nome, u.foto, t.nome, GROUP_CONCAT(m.nome SEPARATOR ', ') AS materias
        FROM usuarios u
        LEFT JOIN turma t ON t.professor_id = u.id
        LEFT JOIN materias m ON m.professor_id = u.id
        WHERE 1=1";


// Se houver uma busca, adicionar filtro de nome
if ($search) {
    $sql .= " AND nome LIKE ?";
}

// Se houver um filtro de turma, adicionar filtro de turma
if ($classFilter !== 'all') {
    $sql .= " AND turma = ?";
}

// Preparar e executar a consulta
$stmt = $conn->prepare($sql);

// Bind dos parâmetros de busca
if ($search && $classFilter !== 'all') {
    $search = "%" . $search . "%";
    $stmt->bind_param("ss", $search, $classFilter);
} elseif ($search) {
    $search = "%" . $search . "%";
    $stmt->bind_param("s", $search);
} elseif ($classFilter !== 'all') {
    $stmt->bind_param("s", $classFilter);
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Professores</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/dashboard/professores.css">
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
            <input type="text" id="searchInput" placeholder="Buscar professores...">
            <select id="classFilter">
                <option value="all">Todas as turmas</option>
                <option value="turma1">Turma 1</option>
                <option value="turma2">Turma 2</option>
                <option value="turma3">Turma 3</option>
            </select>
        </div>
        <div class="teacher-list" id="teacherList">
        <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="teacher-card" data-turma="<?= htmlspecialchars($row['nome']) ?>">
                        <img src="../../../assets/img/uploads/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>">
                        <h3><?= htmlspecialchars($row['nome']) ?></h3>
                        <p>Turma: <?= htmlspecialchars($row['nome']) ?> | Matérias: <?= htmlspecialchars($row['materias']) ?></p>
                        <a href="../detalhes/detalhes_professor.php?id=<?= $row['id'] ?>">Ver Detalhes</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum professor encontrado.</p>
            <?php endif; ?>
            </div>
            <!-- <div class="teacher-card" data-turma="turma2">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Ana Souza">
            <h3>Ana Souza</h3>
            <p>Turma: 2 | Matérias: JavaScript, React</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma3">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Clara Lima">
            <h3>Clara Lima</h3>
            <p>Turma: 3 | Matérias: Python, Django</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma1">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Beatriz Alves">
            <h3>Beatriz Alves</h3>
            <p>Turma: 1 | Matérias: Java, Spring</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma2">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Fernanda Costa">
            <h3>Fernanda Costa</h3>
            <p>Turma: 2 | Matérias: C#, .NET</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma3">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Gabriela Rocha">
            <h3>Gabriela Rocha</h3>
            <p>Turma: 3 | Matérias: PHP, Laravel</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma1">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Isabela Martins">
            <h3>Isabela Martins</h3>
            <p>Turma: 1 | Matérias: Ruby, Rails</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma2">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Juliana Pereira">
            <h3>Juliana Pereira</h3>
            <p>Turma: 2 | Matérias: Swift, iOS</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma3">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Larissa Fernandes">
            <h3>Larissa Fernandes</h3>
            <p>Turma: 3 | Matérias: Kotlin, Android</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
            <div class="teacher-card" data-turma="turma1">
            <img src="../../../assets/img/home/fotos/Ana_Icon.png" alt="Mariana Oliveira">
            <h3>Mariana Oliveira</h3>
            <p>Turma: 1 | Matérias: SQL, NoSQL</p>
            <a href="../detalhes/detalhes_professor.php">Ver Detalhes</a>
            </div>
        </div> -->

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
    <script src="../../../assets/js/professor/dashboard/professores.js"></script>
</body>
</html>

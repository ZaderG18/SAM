<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';

$user = $_SESSION['user'];
$id = $user['id'];

// Prepare SQL statement to retrieve photo
$sql = "SELECT foto FROM professor WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fotoNome);
$stmt->fetch();
$stmt->close();

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes - Materias</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/detalhes/detalhes_materias.css">
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
            <input type="search" placeholder="Search" class="header__input">
            <i class='bx bx-search header__icon'></i>
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
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a>
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
            <h1>Detalhes da Matéria</h1>

            <div class="info-section">
                <div class="info-header">
                    <div>
                        <p>Nome: <strong>Programação Avançada</strong></p>
                    </div>
                    <div>
                        <p>Código: <strong>CS201</strong></p>
                    </div>
                    <div>
                        <p>Semestre: <strong>2º Semestre - 2024</strong>
                    </div>
                    <div>
                        <p>Professor: <strong>Maria Silva</strong></p>
                    </div>
                </div>
            </div>

            <div class="evaluations">
                <h2 class="section-title">Avaliações</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data de Entrega</th>
                            <th>Peso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Prova 1</td>
                            <td>2024-05-10</td>
                            <td>30%</td>
                            <td><button class="btn secondary" onclick="openModal('editEvaluationModal')">Editar</button></td>
                        </tr>
                        <tr>
                            <td>Projeto Final</td>
                            <td>2024-06-15</td>
                            <td>50%</td>
                            <td><button class="btn secondary" onclick="openModal('editEvaluationModal')">Editar</button></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn" onclick="openModal('addEvaluationModal')">Adicionar Avaliação</button>
            </div>

            <div class="resources">
                <h2 class="section-title">Material Complementar</h2>
                <p>Recursos disponíveis: <em>Slides, Vídeos, Apostilas</em></p>
                <button class="btn" onclick="openModal('addResourceModal')">Adicionar Novo Material</button>
            </div>

            <div class="classes">
                <h2 class="section-title">Turmas Associadas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Turma</th>
                            <th>Número de Alunos</th>
                            <th>Horário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Turma A</td>
                            <td>25</td>
                            <td>Segunda - 14:00</td>
                            <td><button class="btn secondary" onclick="openModal('detailsClassModal', 'Turma A', 25, 'Segunda - 14:00')">Ver Detalhes</button></td>
                        </tr>
                        <tr>
                            <td>Turma B</td>
                            <td>30</td>
                            <td>Quarta - 10:00</td>
                            <td><button class="btn secondary" onclick="openModal('detailsClassModal', 'Turma B', 30, 'Quarta - 10:00')">Ver Detalhes</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal para Adicionar Avaliação -->
        <div id="addEvaluationModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addEvaluationModal')">&times;</span>
                <h2>Adicionar Avaliação</h2>
                <input type="text" id="evaluationTitle" placeholder="Título da Avaliação" required>
                <input type="date" id="evaluationDate" placeholder="Data de Entrega" required>
                <input type="number" id="evaluationWeight" placeholder="Peso (%)" required>
                <button class="btn" onclick="addEvaluation()">Salvar Avaliação</button>
            </div>
        </div>

        <!-- Modal para Editar Avaliação -->
        <div id="editEvaluationModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editEvaluationModal')">&times;</span>
                <h2>Editar Avaliação</h2>
                <input type="text" id="editEvaluationTitle" placeholder="Título da Avaliação" required>
                <input type="date" id="editEvaluationDate" placeholder="Data de Entrega" required>
                <input type="number" id="editEvaluationWeight" placeholder="Peso (%)" required>
                <button class="btn" onclick="saveEditedEvaluation()">Salvar Alterações</button>
            </div>
        </div>

        <!-- Modal para Adicionar Novo Material -->
        <div id="addResourceModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addResourceModal')">&times;</span>
                <h2>Adicionar Novo Material</h2>
                <input type="text" id="resourceTitle" placeholder="Título do Material" required>
                <input type="text" id="resourceLink" placeholder="Link do Material" required>
                <button class="btn" onclick="addResource()">Salvar Material</button>
            </div>
        </div>

        <!-- Modal para Ver Detalhes da Turma -->
        <div id="detailsClassModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('detailsClassModal')">&times;</span>
                <h2>Detalhes da Turma</h2>
                <p><strong>Nome da Turma:</strong> <span id="className"></span></p>
                <p><strong>Número de Alunos:</strong> <span id="studentCount"></span></p>
                <p><strong>Horário:</strong> <span id="classSchedule"></span></p>
                <p><strong>Professor:</strong> <span id="classTeacher">Maria Silva</span></p>
                
            </div>
        </div>


</main>



    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../../assets/js/professor/detalhes/detalhes_materias.js"></script>
</body>
</html>

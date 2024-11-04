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
$sql = "SELECT foto FROM usuarios WHERE id = ?";
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
    <title>Dashboard - Relatórios</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../../assets/scss/professor/dashboard/relatorios.css">
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
   
    <!-- Conteúdo Principal -->
    <div class="main-content">
        <!-- Botão para Criar Novo Relatório -->
        <div class="create-report">
            <button onclick="openModal()">Criar Novo Relatório</button>
        </div>

        <!-- Tabela de Relatórios -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>Nome do Relatório</th>
                    <th>Descrição</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="reportTableBody">
                <!-- Linhas de relatórios serão inseridas aqui via JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para Criar Novo Relatório -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Criar Novo Relatório</h2>
            <div class="form-group">
                <input type="text" id="reportName" placeholder="Nome do Relatório" required>
            </div>
            <div class="form-group">
                <textarea id="reportDescription" rows="4" placeholder="Descrição do Relatório" required></textarea>
            </div>
            <div class="form-group">
                <label for="startDate">Data de Início</label>
                <input type="date" id="startDate" required>
            </div>
            <div class="form-group">
                <label for="endDate">Data de Término</label>
                <input type="date" id="endDate" required>
            </div>
            <div class="form-group">
                <label for="reportType">Tipo de Relatório</label>
                <select id="reportType" required>
                    <option value="">Selecione o Tipo de Relatório</option>
                    <option value="Desempenho">Desempenho</option>
                    <option value="Frequência">Frequência</option>
                    <option value="Notas">Notas</option>
                </select>
            </div>
            <div class="form-actions">
                <button onclick="addReport()">Salvar Relatório</button>
            </div>
        </div>
    </div>

    <!-- Modal de Edição do Relatório -->
    <div id="editReportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Editar Relatório</h2>
            <div class="form-group">
                <input type="text" id="editReportName" placeholder="Nome do Relatório" required>
            </div>
            <div class="form-group">
                <textarea id="editReportDescription" rows="4" placeholder="Descrição do Relatório" required></textarea>
            </div>
            <div class="form-group">
                <label for="editStartDate">Data de Início</label>
                <input type="date" id="editStartDate" required>
            </div>
            <div class="form-group">
                <label for="editEndDate">Data de Término</label>
                <input type="date" id="editEndDate" required>
            </div>
            <div class="form-group">
                <label for="editReportType">Tipo de Relatório</label>
                <select id="editReportType" required>
                    <option value="">Selecione o Tipo de Relatório</option>
                    <option value="Desempenho">Desempenho</option>
                    <option value="Frequência">Frequência</option>
                    <option value="Notas">Notas</option>
                </select>
            </div>
            <div class="form-actions">
                <button onclick="saveEditedReport()">Salvar Alterações</button>
            </div>
        </div>
    </div>

    <!-- Modal para Enviar Relatório -->
    <div id="sendReportModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeSendModal()">&times;</span>
            <h2>Enviar Relatório</h2>
            <div class="form-group">
                <input type="email" id="recipientEmail" placeholder="Email do Destinatário" required>
            </div>
            <div class="form-group">
                <textarea id="emailMessage" rows="4" placeholder="Mensagem" required></textarea>
            </div>
            <div class="form-actions">
                <button onclick="sendEmail()">Enviar</button>
            </div>
        </div>
    </div>
</main>



    <!-- Scripts -->
    <script src="../../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../../assets/js/global/search.js"></script>
    <script src="../../../assets/js/professor/dashboard/dashboard.js"></script>
    <script src="../../../assets/js/professor/dashboard/relatorios.js"></script>
</body>
</html>

<?php 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sam";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco". $conn->connect_error);
}
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';

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
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aulas/aulas.css">
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
        <div class="containerfx">
            <!-- Lista de Alunos Inscritos -->
            <div class="section students-list">
                <h2>Alunos Inscritos</h2>
                <ul>
                    <li>
                        <img src="../../assets/img/home/fotos/Ana_Icon.png" alt="Aluno 1" class="student-img">
                        <div class="student-info">
                            <span>Aluno 1</span>
                            <span>aluno1@example.com</span>
                        </div>
                    </li>
                    <li>
                        <img src="../../assets/img/home/fotos/Ana_Icon.png" alt="Aluno 2" class="student-img">
                        <div class="student-info">
                            <span>Aluno 2</span>
                            <span>aluno2@example.com</span>
                        </div>
                    </li>
                    <li>
                        <img src="../../assets/img/home/fotos/Ana_Icon.png" alt="Aluno 3" class="student-img">
                        <div class="student-info">
                            <span>Aluno 3</span>
                            <span>aluno3@example.com</span>
                        </div>
                    </li>
                    <!-- Adicione mais alunos conforme necessário -->
                </ul>
            </div>

            <!-- Alunos que Fizeram e Não Fizeram Atividades -->
            <div class="section activities-status">
                <h3>Status das Atividades</h3>
                <div class="sub-section">
                    <h4>Alunos que Fizeram</h4>
                    <ul>
                        <li>Aluno 1 <a href="feedback.php" class="feedback-link">Enviar Feedback</a></li>
                        <li>Aluno 2 <a href="feedback.php" class="feedback-link">Enviar Feedback</a></li>
                        <!-- Adicione mais alunos conforme necessário -->
                    </ul>
                </div>
                <div class="sub-section">
                    <h4>Alunos que Não Fizeram</h4>
                    <ul>
                        <li>Aluno 3</li>
                        <li>Aluno 4</li>
                        <!-- Adicione mais alunos conforme necessário -->
                    </ul>
                </div>
            </div>

            <!-- Tarefas Atribuídas e Pendentes -->
            <div class="section assigned-tasks">
                <h4>Tarefas Atribuídas e Pendentes</h4>
                <ul>
                    <li>
                        <span>Atividade 1</span>
                        <div class="task-buttons">
                            <a href="atividade.php" class="edit-link">Editar</a>
                            <a href="#" class="delete-link">Excluir</a>
                        </div>
                    </li>
                    <li>
                        <span>Atividade 2</span>
                        <div class="task-buttons">
                            <a href="atividade.php" class="edit-link">Editar</a>
                            <a href="#" class="delete-link">Excluir</a>
                        </div>
                    </li>
                    <!-- Adicione mais atividades conforme necessário -->
                </ul>
            </div>

            <!-- Enviar Materiais Complementares -->
            <div class="section additional-materials">
                <h4>Enviar Materiais Complementares</h4>
                <textarea rows="2" placeholder="Nome do arquivo..."></textarea>
                <input type="file" id="material-file" style="display: none;">
                <button class="btn" id="send-material-btn">Enviar Material</button>
                <label for="material-file" class="btnarq">Escolher Arquivo</label>
                <span id="file-name" ></span>
            </div>

            <!-- Comunicação Individual -->
            <div class="section individual-communication">
                <h4>Comunicação Individual</h4>
                <div class="forum">
                    <select>
                        <option value="aluno1">Aluno 1</option>
                        <option value="aluno2">Aluno 2</option>
                        <option value="aluno3">Aluno 3</option>
                        <!-- Adicione mais alunos conforme necessário -->
                    </select>
                    <div class="forum-messages">
                        <div class="message">
                            <p><strong>Aluno 1:</strong> Mensagem do aluno 1</p>
                        </div>
                        <div class="message">
                            <p><strong>Aluno 2:</strong> Mensagem do aluno 2</p>
                        </div>
                        <!-- Adicione mais mensagens conforme necessário -->
                    </div>
                    <textarea rows="4" placeholder="Digite sua resposta..."></textarea>
                    <button class="btn" id="send-reply-btn">Enviar Resposta</button>
                </div>
            </div>

            <!-- Lançar Atividades -->
            <div class="section launch-activities">
                <h4>Lançar Atividades</h4>
                <textarea rows="2" placeholder="Nome da atividade..."></textarea>
                <textarea rows="4" placeholder="Descrição da atividade..."></textarea>
                <input type="file" id="activity-file" style="display: none;">
                <button class="btn" id="launch-activity-btn">Lançar Atividade</button>
                <label for="activity-file" class="btnarq">Escolher Arquivo</label>
                <span id="activity-file-name"></span>
            </div>
        </div>

        <div id="delete-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>Tem certeza que deseja excluir a atividade?</h4>
                <button class="btn" id="confirm-delete-btn">Excluir</button>
                <button class="btn" id="cancel-delete-btn">Cancelar</button>
            </div>
        </div>
       
    </main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/professor/aulas/aulas.js"></script>
</body>
</html>

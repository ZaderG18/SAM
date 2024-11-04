<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
require_once '../../php/login/validar.php';
require_once '../../php/aluno/documentos.php';
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
    <title>Solicitação de Documentos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/documentos/documentos.css">
    <link rel="stylesheet" href="../../assets/scss/global/sidebar.scss">
    <link rel="stylesheet" href="../../assets/scss/global/estilogeral.scss">
 
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
                    <a href="home_aluno.php" class="nav__link">
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
                    <a href="cronograma.php" class="nav__link">
                        <i class='bx bx-calendar nav__icon'></i>
                        <span class="nav__name">Cronograma</span>
                    </a>
                    <a href="secretaria.php" class="nav__link">
                        <i class='bx bx-poll nav__icon'></i>
                        <span class="nav__name">Pesquisas Secretaria</span>
                    </a>
                    <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
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
    <div class="form-container">
        <!-- Coluna Esquerda -->
        <div class="left-column">
            <div class="box">
                <h2>Declarações para retirada</h2>
                <form action="../../php/aluno/documentos.php" method="post">
                    <input type="hidden" name="action" value="declaracao">
                <label for="declaração">Selecione a Declaração:</label>
                <select id="declaração" name="declaração" class="caixa" required>
                    <option value="">Selecione o tipo de declaração</option>
                    <option value="transporte">Declaração Transporte</option>
                    <option value="matricula">Declaração de Matrícula</option>
                    <option value="conclusao">Declaração de Conclusão de Curso</option>
                    <option value="frequencia">Declaração de Frequência Escolar</option>
                </select>

                <label for="motivo">Para qual finalidade será a declaração?</label>
                <input type="text" id="motivo" name="motivo" class="caixa" required>
                <label for="protocolo">Consulta de Protocolo:</label>
                <input type="text" id="protocolo" name="protocolo" class="caixa">
                <p>Prazo para retirada das declarações acontece em até 2 dias úteis</p>
                <button type="button" onclick="buscarProtocolo()">Buscar</button>
                <button type="submit" name="action" value="declaracao">Enviar</button>
                
            </div>
            </form>
            <?php if (!empty($mensagem)) : ?>
                <p><?= $mensagem?></p>
                <?php endif; ?>
            <div class="box">
                <h2>Documentos Escolares</h2>
                <label for="tipo-declaracao">Selecione o Tipo de Declaração:</label>
                <select id="tipo-declaracao" name="tipo-declaracao" class="caixa" required>
                    <option value="">Selecione o tipo de declaração</option>
                    <option value="transporte">Declaração de Transporte</option>
                    <option value="matricula">Declaração de Matrícula</option>
                    <option value="conclusao">Declaração de Conclusão de Curso</option>
                    <option value="frequencia">Declaração de Frequência Escolar</option>
                </select>
                <button type="button" onclick="gerarDeclaracao()">Gerar Declaração</button>
            </div>
        </div>

        <!-- Coluna Direita -->
        <div class="right-column">
            <div class="box">
                <h2>Rematrícula</h2>
                <p>Prazo para rematricula: 09/10/2024 a 16/12/24 - Atualmente Fora do Prazo.</p>
                <form action="../../php/aluno/documentos.php" method="post" id="rematriculaForm">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="caixa" required>

                    <label for="matricula">Matrícula:</label>
                    <input type="text" id="matricula" name="RM" class="caixa" required>

                    <button type="submit" name="action" value="rematricula">Enviar Rematrícula</button>
                </form>
            </div>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/aluno/documentos/documentos.js"></script>
</body>
</html>

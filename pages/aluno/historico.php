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
require '../../php/aluno/historico.php';
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
    <title>Histórico Acadêmico </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/historico/historico.css">
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

    <div class="containerxx">
        <h1 class="headerpx">Histórico Acadêmico</h1>
        <h2>Resumo Acadêmico</h2>

        <div class="summary">
            <p><strong>Nome do Aluno:</strong> <?php echo htmlspecialchars($user['nome']) ?></p>
            <p><strong>RM:</strong> <?php echo htmlspecialchars($user['RM'])?></p>
            <p><strong>Média Geral:</strong> <?php echo htmlspecialchars($media_geral)?></p>
            <p><strong>Disciplinas Pendentes:</strong> <?php echo htmlspecialchars($disciplinas_pendentes)?></p>
            <p><strong>Prazo Estimado de Conclusão:</strong> <?php echo htmlspecialchars($prazo_conclusao)?></p>

        <?php echo '<div class="progress-bar">';
            echo '<div class="progress" style="width: ' . round($progresso) . '%;">' . round($progresso) . '% Concluído</div>';
            echo '</div>'; ?>

        </div>

        <h2>Filtros de Semestre</h2>
        <div class="filters">
            <div>
                <label for="semestre">Selecionar Semestre:</label>
                <select id="semestre">
                    <option value="todos">Todos</option>
                    <?php foreach ($semestres as $semestre): ?>
                    <option value="<?php echo htmlspecialchars($semestre);?>"><?php echo htmlspecialchars($semestre);?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="status">Status da Disciplina:</label>
                <select id="status">
                    <option value="todas">Todas</option>
                    <?php foreach ($statusOptions as $status): ?>
                    <option value="<?php echo htmlspecialchars($status)?>"><?php echo ucfirst(htmlspecialchars($status));?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <input type="text" id="busca" placeholder="Buscar disciplina...">
            </div>
        </div>
        <div id="resultado"></div>

        <h2>Disciplinas Concluídas</h2>
        <table>
            <thead>
                <tr>
                    <th>Disciplina</th>
                    <th>Semestre</th>
                    <th>Faltas</th>
                    <th>Nota</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($disciplinas as $disciplina): ?>
                <tr>
                    <td><?php echo htmlspecialchars($disciplina['disciplina_id'])?></td>
                    <td><?php echo htmlspecialchars($disciplina['semestre'])?></td>
                    <td><?php echo htmlspecialchars($disciplina['faltas'])?></td>
                    <td><?php echo htmlspecialchars($disciplina['nota'])?></td>
                    <td class="<?php echo strtolower($disciplina['status'])?>"><?php echo htmlspecialchars($disciplina['status'])?></td>
                </tr>
                <!-- <tr>
                    <td>Banco de dados</td>
                    <td>2021.1</td>
                    <td>4</td>
                    <td>7.5</td>
                    <td class="approved">Aprovado</td>
                </tr>
                <tr>
                    <td>Desenvolvimento Web</td>
                    <td>2021.2</td>
                    <td>4</td>
                    <td>6.0</td>
                    <td class="approved">Aprovado</td>
                </tr>
                <tr>
                    <td>Programação Mobile</td>
                    <td>2021.2</td>
                    <td>4</td>
                    <td>5.0</td>
                    <td class="failed">Reprovado</td>
                </tr> -->
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Linha do Tempo Acadêmica</h2>
        <div class="timeline">
            <?php foreach($historico as $ano => $semestres): ?>
            <h3><?php echo $ano; ?></h3>
            <div class="timeline-content">
                <?php foreach($semestres as $semestre): ?>
                <p><strong>Semestre <?php echo htmlspecialchars($semestre['semestre']); ?>:</strong> 
            <?php echo htmlspecialchars($semestre['status']); ?> </p>
            <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/historico/historico.js"></script>
</body>
</html>
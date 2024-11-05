<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "SAM";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

require '../../php/login/validar.php';
require '../../php/aluno/frequencia.php';
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
$stmt->close(); // Fechamos o statement aqui, pois ele já foi utilizado.

// Check if there is a photo for the user
if (!empty($fotoNome)) {
    $fotoCaminho = "../../assets/img/uploads/" . $fotoNome;
} else {
    $fotoCaminho = "../../assets/img/logo.jpg"; // Default image if no photo is uploaded
}

// Consulta para buscar as frequências do aluno
$sql = "SELECT * FROM frequencia WHERE aluno_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$frequencias = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $frequencias[] = $row;
    }
} else {
    echo "Erro na consulta: " . $conn->error;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequência</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/frequencia/frequencia.css">
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
            <?php $notificacoes = obterNotificacoes($conn, $id);
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

<main class="main">
    <!---------------------------------------------------------------------Modulo 1-------------------------------------------------------->
    <div id="tabelamodulo1" class="module-selection">
        <div>
            <label for="module-select">Selecione o Módulo:</label>
            <select id="module-select" onchange="changeModule(this.value)">
                <option value="modulo1">Módulo 1</option>
                <option value="modulo2">Módulo 2</option>
                <option value="modulo3">Módulo 3</option>
            </select>
           <!--<button id="downloadbtn" class="button">Baixar Boletim</button>--> 
        </div>
        
        <?php 
        //Definição dos modulos em arrays
        $modulos = [1=> 'modulo1', 2=> 'modulo2', 3=> 'modulo3'];
        //loop através dos modulos para criar as tabelas de forma dinamicamente
        foreach($modulos as $modulo){
        ?>
        <div id="<?php echo $modulo; ?>" class="module-table" style="<?php echo ($moduloId == 1) ? '' : 'display: none;'; ?>">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                        <th>Faltas Permitidas</th>
                        <th>Freq. Atual</th>
                        <th>Freq. Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT * FROM disciplina WHERE modulo_id = $moduloId";
                    $result = $conn->query($sql); 
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='#' onclick=\"showModal('modal-{$row['nome']}')\">" . $row["nome"] . "</a></td>";
                            echo "<td>" . $row["aulas_dadas"] . "</td>";
                            echo "<td>" . $row["faltas"] . "</td>";
                            echo "<td>" . $row["faltas_permitidas"] . "</td>";
                            echo "<td>" . $row["freq_atual"] . "</td>";
                            echo "<td>" . $row["freq_total"] . "</td>";
                            echo "</tr>";
                            }
                        } else{
                            echo "<tr><td colspan='6'>Nenhuma disciplina encontrada</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
    <!---------------------------------------------------------------------Modal-------------------------------------------------------->
    <?
// gerando uma modal para cada disciplina
$sql = "SELECT * FROM disciplina";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

?>        
<div id="modal-<?php echo strtolower(str_replace(' ', '-', $row['nome'])); ?>" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-<?php echo strtolower(str_replace(' ', '-', $row['nome'])); ?>')">&times;</span>
            <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
            <table class="modal-selection">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Conteúdo</th>
                        <th>Professor</th>
                        <th>Aulas Dadas</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $disciplinaId = $row['id'];
                    $aulasSql = "SELECT * FROM aula WHERE disciplina_id = '$disciplinaId'";
                    $aulasResult = $conn->query($aulasSql);

                    if ($aulasResult->num_rows > 0) {
                        while ($aulaRow = $aulasResult->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aulaRow['data']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['conteudo']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['professor']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['aulas_dadas']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['faltas']); ?></td>
                    </tr>
                    <?php } }else{
                        echo "<tr><td colspan='5'>Nenhuma aula encontrada para esta disciplina.</td></tr>";
                    }?>
                </tbody>
 
            </table>
        </div>
    </div>
    
</main>
    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/frequencia/frequencia.js"></script>
</body>
</html>

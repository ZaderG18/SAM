<?php
include '../../php/global/cabecario.php';
require '../../php/login/validar.php';
require '../../php/aluno/frequencia.php';
include '../../php/global/notificacao.php';
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
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
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
    <!---------------------------------------------------------------------Modulo-------------------------------------------------------->
    <div id="tabelamodulo1" class="module-selection">
    <form action="" method="post" id="module-form">  
    <div>
            <label for="module-select">Selecione o Módulo:</label>
            <select id="module-select" onchange="changeModule(this.value)">
                <option value="modulo1">Módulo 1</option>
                <option value="modulo2">Módulo 2</option>
                <option value="modulo3">Módulo 3</option>
            </select>
           <!--<button id="downloadbtn" class="button">Baixar Boletim</button>--> 
        </div>
        </form>  

        <?php if (empty($frequencias)) { ?>
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
                if (!empty($frequencias)) {
                    foreach ($frequencias as $frequencia) {
                        echo "<tr>";
                        echo "<td><a href='#' onclick=\"showModal('modal-{$frequencia['disciplina_id']}')\">" . htmlspecialchars($frequencia['disciplina']) . "</a></td>";
                        echo "<td>" . htmlspecialchars($frequencia['aulas_dadas']) . "</td>";
                        echo "<td>" . htmlspecialchars($frequencia['faltas']) . "</td>";
                        echo "<td>" . htmlspecialchars($frequencia['frequencia']) . "</td>";
                        echo "<td>" . htmlspecialchars($frequencia['frequencia_total']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhuma frequência encontrada para este módulo.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>

    <!---------------------------------------------------------------------Modal-------------------------------------------------------->
    <?php
    foreach ($frequencias as $frequencia) {
        $disciplinaId = $frequencia['disciplina_id'];
        $aulasSql = "SELECT * FROM aula WHERE disciplina_id = '$disciplinaId'";
        $aulasResult = $conn->query($aulasSql);
    ?>     
    <div id="modal-<?php echo $disciplinaId; ?>" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('modal-<?php echo $disciplinaId; ?>')">&times;</span>
            <h2><?php echo htmlspecialchars($frequencia['disciplina']); ?></h2>
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
                    if ($aulasResult && $aulasResult->num_rows > 0) {
                        while ($aulaRow = $aulasResult->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($aulaRow['data']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['conteudo']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['professor']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['aulas_dadas']); ?></td>
                        <td><?php echo htmlspecialchars($aulaRow['faltas']); ?></td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhuma aula encontrada para esta disciplina.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
        }
    ?>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/aluno/frequencia/frequencia.js"></script>
</body>
</html>

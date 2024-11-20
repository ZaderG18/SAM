<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
$sql = "SELECT * FROM enquete";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Avaliação Escolar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/enquetes/enquetes.css">
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
    <div class="containerpx">
        <h1 class="headerpx">Enquetes</h1>
        <h2>Enquetes Ativas</h2>

        <ul class="poll-list">
            <!-- Enquete sobre Aulas -->
            <?php
            // Consulta para buscar as enquetes
            $sql = "SELECT id, pergunta FROM enquetes";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($enquete = $result->fetch_assoc()) {
                    ?>
                    <li class="poll-item">
                        <h3><?php echo htmlspecialchars($enquete['pergunta']); ?></h3>
                        <form class="poll-form" data-poll="<?php echo $enquete['id']; ?>" action="../../php/global/enquetes.php" method="post">
                            <ul class="poll-options">
                                <?php
                                // Passando o ID da enquete para a função getOptions
                                $opcoes = getOptions($enquete['id'], $conn);
                                foreach ($opcoes as $opcao) {
                                    echo '<li><input type="radio" name="poll_' . $enquete['id'] . '" value="' . htmlspecialchars($opcao) . '"> ' . ucfirst(htmlspecialchars($opcao)) . '</li>';
                                }
                                ?>
                            </ul>
                            <div class="textarea-container">
                                <textarea name="comment" placeholder="Deixe um comentário ou sugestão..."></textarea>
                            </div>
                            <button class="btn" type="submit">Votar</button>
                        </form>
                    </li>
                    <?php
                }
            } else {
                echo "<p>Não há enquetes ativas no momento.</p>";
            }
            ?>
        </ul>
    </div>
</main>

<?php
// Função para buscar opções com base no ID da enquete
function getOptions($enqueteId, $conn)
{
    switch ($enqueteId) {
        case 1: // Exemplo de enquete fixa
            return ['muito_bom', 'bom', 'regular', 'ruim'];
        case 2: // Exemplo dinâmico: buscar matérias do banco de dados
            $sql = "SELECT nome_disciplina FROM disciplina";
            $result = $conn->query($sql);
            $opcoes = [];
            while ($row = $result->fetch_assoc()) {
                $opcoes[] = $row['nome_disciplina'];
            }
            return $opcoes;
        case 3: // Exemplo dinâmico: buscar alunos
            $sql = "SELECT nome FROM usuarios WHERE cargo = 'aluno'";
            $result = $conn->query($sql);
            $opcoes = [];
            while ($row = $result->fetch_assoc()) {
                $opcoes[] = $row['nome'];
            }
            return $opcoes;
        default: // Caso padrão
            return ['opção_1', 'opção_2', 'opção_3'];
    }
}
?>


    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/enquetes/enquetes.js"></script>
</body>
</html>

<?php 
include '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';
include '../../../php/global/notificacao.php';
// Recupera o ID da matéria a partir da URL
$materia_id = isset($_GET['id']) ? $_GET['id'] : null;

// Verifica se o ID foi passado
if ($materia_id) {
    // Conecte-se ao banco de dados e recupere as informações sobre a matéria
    $sql = "SELECT nome, id, professor_nome FROM materias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $materia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $materia = $result->fetch_assoc();
} else {
    // Caso não tenha um ID válido, redireciona ou exibe um erro
    echo "<script>alert('Erro: ID da matéria não encontrado.')
    window.location.href = '../dashboard/disciplina.php';</script>";
    exit;
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
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
                    <h2 class="nav__subtitle">Orientador</h2>
                    <a href="../dashboard/dashboard.php" class="nav__link">
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
        <div class="container">
            <h1>Detalhes da Matéria</h1>

            <div class="info-section">
                <div class="info-header">
                    <div>
                    <p>Nome: <strong><?= htmlspecialchars($materia['nome']) ?></strong></p>
                    </div>
                    <div>
                    <p>Código: <strong><?= htmlspecialchars($materia['id']) ?></strong></p>
                    </div>
                    <div>
                    <p>Semestre: <strong><?= htmlspecialchars(isset($materia['semestre']) ? $materia['semestre'] : 'Semestre não definido') ?></strong></p>
                    </div>
                    <div>
                    <p>Professor: <strong><?= htmlspecialchars(isset($materia['professor_nome']) ? $materia['professor_nome'] : 'Professor não definido') ?></strong></p>
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
                    <?php
                    // Consultar as avaliações da matéria
                    $sqlAvaliacoes = "SELECT * FROM avaliacao WHERE materia_id = ?";
                    $stmt = $conn->prepare($sqlAvaliacoes);
                    $stmt->bind_param("i", $materia_id);
                    $stmt->execute();
                    $resultAvaliacoes = $stmt->get_result();

                    // Exibir as avaliações
                    while ($avaliacao = $resultAvaliacoes->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($avaliacao['titulo']) . "</td>";
                        echo "<td>" . htmlspecialchars($avaliacao['data_entrega']) . "</td>";
                        echo "<td>" . htmlspecialchars($avaliacao['peso']) . "%</td>";
                        echo "<td><button class='btn secondary' onclick=\"openModal('editEvaluationModal')\">Editar</button></td>";
                        echo "</tr>";
                    }
                    ?>
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
                    <?php
                    // Consultar turmas associadas à matéria
                    $sqlTurmas = "SELECT * FROM turma WHERE materia_id = ?";
                    $stmt = $conn->prepare($sqlTurmas);
                    $stmt->bind_param("i", $materia_id);
                    $stmt->execute();
                    $resultTurmas = $stmt->get_result();

                    // Exibir as turmas
                    while ($turma = $resultTurmas->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($turma['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($turma['num_alunos']) . "</td>";
                        echo "<td>" . htmlspecialchars($turma['horario']) . "</td>";
                        echo "<td><button class='btn secondary' onclick=\"openModal('detailsClassModal', '" . htmlspecialchars($turma['nome']) . "', " . $turma['num_alunos'] . ", '" . htmlspecialchars($turma['horario']) . "')\">Ver Detalhes</button></td>";
                        echo "</tr>";
                    }
                    ?>
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
   <script src="../../../assets/js/global/search.js"></script>
    <script src="../../../assets/js/professor/detalhes/detalhes_materias.js"></script>
</body>
</html>

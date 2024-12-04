<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aulas</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/aulas/aulas.css">
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
                   <!-- <a href="chat.php" class="nav__link">
                        <i class='bx bx-chat nav__icon'></i>
                        <span class="nav__name">Chat</span>
                    </a> -->
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
                <?php
                $query = "SELECT nome, email, foto FROM usuarios WHERE cargo = 'aluno'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                <li>
                    <img src="../../assets/img/uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>" class="student-img">
                    <div class="student-info">
                        <span><?php echo htmlspecialchars($row['nome']); ?></span>
                        <span><?php echo htmlspecialchars($row['email']); ?></span>
                    </div>
                </li>
                <?php
                    }
                } else {
                    echo '<li>Nenhum aluno inscrito.</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Alunos que Fizeram e Não Fizeram Atividades -->
        <div class="section activities-status">
    <h3>Status das Atividades</h3>
    
    <!-- Alunos que fizeram -->
    <div class="sub-section">
        <h4>Alunos que Fizeram</h4>
        <ul>
        <?php
        $queryFeitos = "SELECT u.nome FROM usuarios u 
                        INNER JOIN atividade a ON u.id = a.aluno_id
                        WHERE u.cargo = 'aluno' AND a.status = 'concluida'";
        $resultFeitos = $conn->query($queryFeitos);
        
        if ($resultFeitos->num_rows > 0) {
            while ($row = $resultFeitos->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['nome']) . "</li>";
            }
        } else {
            echo '<li>Nenhum aluno concluiu as atividades.</li>';
        }
        ?>
        </ul>
    </div>
    
    <!-- Alunos que não fizeram -->
    <div class="sub-section">
        <h4>Alunos que Não Fizeram</h4>
        <ul>
        <?php
        $queryNaoFeitos = "SELECT u.nome FROM usuarios u 
                           INNER JOIN atividade a ON u.id = a.aluno_id
                           WHERE u.cargo = 'aluno' AND a.status = 'pendente'";
        $resultNaoFeitos = $conn->query($queryNaoFeitos);
        
        if ($resultNaoFeitos->num_rows > 0) {
            while ($row = $resultNaoFeitos->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['nome']) . "</li>";
            }
        } else {
            echo '<li>Todos os alunos concluíram as atividades.</li>';
        }
        ?>
        </ul>
    </div>

</div>


        <!-- Tarefas Atribuídas e Pendentes -->
        <div class="section assigned-tasks">
            <h4>Tarefas Atribuídas e Pendentes</h4>
            <ul>
                <?php
                $query = "SELECT id, titulo FROM atividade";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                <li>
                    <span><?php echo htmlspecialchars($row['titulo']); ?></span>
                    <div class="task-buttons">
                        <a href="atividade.php?id=<?php echo $row['id']; ?>" class="edit-link">Editar</a>
                        <a href="../../php/professor/excluirAtividade.php?id=<?php echo $row['id']; ?>" class="delete-link">Excluir</a>
                    </div>
                </li>
                <?php
                    }
                } else {
                    echo '<li>Nenhuma atividade cadastrada.</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Comunicação Individual -->
        <div class="section individual-communication">
            <h4>Comunicação Individual</h4>
            <div class="forum">
            <form action="../../php/global/enviarNotificacoes.php" method="post">
            <select name="user_id">
                <?php
                $query = "SELECT id, nome FROM usuarios WHERE cargo = 'aluno'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nome']); ?></option>
                <?php
                    }
                }
                ?>
            </select>
            
            <div class="forum-messages">
                <!-- Mensagens podem ser carregadas aqui dinamicamente -->
            </div>
            
            <input class="forum-messages" type="text" name="titulo" id="titulo" placeholder="Título da mensagem" required>

            <textarea name="mensagem" rows="4" placeholder="Digite sua resposta..."></textarea>
            <button type="submit" class="btn">Enviar Resposta</button>
        </form>
    </div>
</div>

        <!-- Lançar Atividades -->
        <div class="section launch-activities">
    <h4>Lançar Atividades</h4>
    <form method="post" action="../../php/professor/lancarAtividade.php" enctype="multipart/form-data">
    <select name="turma_id" required>
            <option value="" disabled selected>Escolha a turma</option>
            <option value="1">Turma 1</option>
            <option value="2">Turma 2</option>
        </select>
        <textarea name="titulo" rows="2" placeholder="Nome da atividade..." required></textarea>
        <textarea name="descricao" rows="4" placeholder="Descrição da atividade..." required></textarea>
        <input type="file" name="arquivo" id="activity-file" style="display: none;" required>
        <button class="btn" type="submit">Lançar Atividade</button>
        <label for="activity-file" class="btnarq">Escolher Arquivo</label>
    </form>
</div>

        </div>
    </div>
</main>


    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/aulas/aulas.js"></script>
</body>
</html>

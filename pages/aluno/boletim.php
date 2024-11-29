<?php
include '../../php/global/cabecario.php';
require '../../php/login/validar.php';
require '../../php/aluno/boletim.php';
include '../../php/global/notificacao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletim</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/aluno/boletim/boletim.css">
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
          
    <div class="student-info">
        <h2>Dados do Aluno</h2>
        <p>Nome: <?php echo htmlspecialchars($user['nome']) ?></p>
        <p>Turma: <?php echo htmlspecialchars($turma['modulo']) . 'º Módulo'; ?></p>
        <p>Curso: <?php echo htmlspecialchars($curso['nome']); ?></p>
        <p>Turma: <?php  echo htmlspecialchars($turma['nome'])?></p>
        <p>Inicio Curso: <?php echo htmlspecialchars($curso['inicio_curso'])?></p>
        <p>Final Curso: <?php echo htmlspecialchars($curso['final_curso'])?></p>
        <p>Situação: <?php  echo htmlspecialchars($user['status'])?></p>
    </div>
    <!---------------------------------------------------------------------Modulo 1-------------------------------------------------------->
    <div id="tabelamodulo1" class="module-selection">
    <div>
        <label for="module-select">Selecione o Módulo:</label>
        <select id="module-select">
        <?php foreach ($modulos as $modulo): ?>
            <option value="<?php echo $modulo['id']; ?>" <?php echo ($modulo['id'] == $selectedModule) ? 'selected' : ''; ?>>
                Módulo <?php echo $modulo['id']; ?>
            </option>
        <?php endforeach; ?>
        </select>
        <button id="downloadbtn" class="button">Baixar Boletim</button>
    </div>

    <div id="modulo<?php echo $selectedModule; ?>" class="module-table">
        <table class="module-selection">
            <thead>
                <tr>
                    <th>Disciplinas</th>
                    <th>Faltas</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota média</th>
                    <!-- <th>Nota 4</th> -->
                    <th>Critérios</th>
                    <th>Observações</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($notas as $nota) {
                    // Calcular a média das notas
                    $media = ($nota['nota1'] + $nota['nota2']) /2;

                    // Definindo a situação com base na média
                    $situacao = ($media >= 5) ? 'Aprovado' : 'Reprovado';
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($nota['disciplina']); ?></td>
                    <td><?php echo htmlspecialchars($nota['faltas']); ?></td>
                    <td><?php echo htmlspecialchars($nota['nota1']); ?></td>
                    <td><?php echo htmlspecialchars($nota['nota2']); ?></td>
                    <td><?php echo htmlspecialchars($nota['notamedia']); ?></td>
                    <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo $situacao; ?></a></td>
                    <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo htmlspecialchars($nota['observacoes']); ?></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!---------------------------------------------------------------------Modulo 2-------------------------------------------------------->
        <div id="modulo2" class="module-table" style="display:none;">
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Faltas</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota média</th>
                        <th>Critérios</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($notas as $nota) {
                        // Calcular a média das notas
                        $media = ($nota['nota1'] + $nota['nota2']) / 2;

                        // Definindo a situação com base na média
                        $situacao = ($media >= 5) ? 'Aprovado' : 'Reprovado';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nota['disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($nota['faltas']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota1']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota2']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota_media']); ?></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo $situacao; ?></a></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo htmlspecialchars($nota['observacoes']); ?></a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
<!---------------------------------------------------------------------Modulo 3-------------------------------------------------------->
        <div id="modulo3" class="module-table" style="display:none;" >
            <table class="module-selection">
                <thead>
                    <tr>
                        <th>Disciplinas</th>
                        <th>Faltas</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Nota média</th>
                        <th>Critérios</th>
                        <th>Observações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($notas as $nota) {
                        // Calcular a média das notas
                        $media = ($nota['nota1'] + $nota['nota2']) / 2;

                        // Definindo a situação com base na média
                        $situacao = ($media >= 5) ? 'Aprovado' : 'Reprovado';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nota['disciplina']); ?></td>
                        <td><?php echo htmlspecialchars($nota['faltas']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota1']); ?></td>
                        <td><?php echo htmlspecialchars($nota['nota2']); ?></td>
                        <td><?php echo htmlspecialchars($nota['notamedia']); ?></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo $situacao; ?></a></td>
                        <td><a href="#" onclick="showModal('modal-<?php echo strtolower(str_replace(' ', '_', $nota['disciplina'])); ?>')"><?php echo htmlspecialchars($nota['observacoes']); ?></a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>

    <!---------------------------------------------------------------------Modal-------------------------------------------------------->
    <div id="modal-<?php echo $id; ?>" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('modal-<?php echo $id; ?>')">&times;</span>
                <h2><?php echo $row['nome_modulo']; ?></h2>
                
                <?php if (!empty($criterios)) { ?>
                    <ul>
                        <?php foreach ($criterios as $criterio) { ?>
                            <li><?php echo $criterio; ?></li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p><?php echo $row['conteudo']; ?></p>
                <?php } ?>
            </div>
        </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/aluno/boletim/boletim.js"></script>
</body>
</html>

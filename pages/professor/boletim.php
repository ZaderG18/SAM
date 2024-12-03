<?php 
include '../../php/global/cabecario.php';
require_once '../../php/login/validar.php';
include '../../php/global/notificacao.php';

// Consultar os módulos
$modulos_query = "SELECT * FROM modulo";
$modulos_result = $conn->query($modulos_query);

// Consultar as turmas
$turmas_query = "SELECT * FROM turma";
$turmas_result = $conn->query($turmas_query);

// Consultar as matérias
$materias_query = "SELECT * FROM materias";
$materias_result = $conn->query($materias_query);

// Consultar os alunos
$alunos_query = "SELECT * FROM usuarios where cargo = 'aluno'";
$alunos_result = $conn->query($alunos_query);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletim</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/scss/professor/boletim/boletim.css">
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

    <div class="container">
        <h1>Lançamento de Notas</h1>

        <!-- Filtros -->
        <div class="filters">
            <select id="modulo">
                <option value="">Selecione o Módulo</option>
                <?php while($modulo = $modulos_result->fetch_assoc()) : ?>
                <option value="<?= $modulo['id'] ?>"><?php echo $modulo['nome_modulo']; ?></option>
                <?php endwhile; ?>
            </select>

            <select id="turma">
                <option value="">Selecione a Turma</option>
                <?php while($turma = $turmas_result->fetch_assoc()) :?>
                <option value="<?= $turma['id'] ?>"><?= $turma['nome'] ?></option>
                <?php endwhile; ?>
            </select>

            <select id="materia">
                <option value="">Selecione a Matéria</option>
                <?php while($materia = $materias_result->fetch_assoc()) : ?>
                <option value="<?= $materia['id'] ?>"><?= $materia['descricao']; ?></option>
                <?php endwhile; ?>
            </select>

            <select id="turno">
                <option value="">Selecione o Turno</option>
                <?php while($turma = $turmas_result->fetch_assoc()) :?>
                    <option value="<?= $turma['id'] ?>"><?= $turma['turno'] ?></option>
                <?php endwhile; ?>
            </select>

            <select id="semestre">
                <option value="">Selecione o Semestre</option>
                <option value="1sem">1º Semestre</option>
                <option value="2sem">2º Semestre</option>
            </select>

            <input type="date" id="filtro-dia">
        </div>

        <!-- Tabela de Notas -->
        <div class="table-wrapper">
            <form action="../../php/professor/notas.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nome do Aluno</th>
                        <th>Nota 1</th>
                        <th>Nota 2</th>
                        <th>Média Final</th>
                        <th>Recuperação</th>
                        <th>Média com Recuperação</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($aluno = $alunos_result->fetch_assoc()) :?>
                    <tr>
                        <td><?= $aluno['id']?></td>
                        <td><?= $aluno['nome']?></td>
                        <td><input type="number" name="nota1[<?= $aluno['id']?>]" id="nota1-<?= $aluno['id']?>" min="0" max="10"></td>
                        <td><input type="number" name="nota2[<?= $aluno['id']?>]" id="nota2-<?= $aluno['id']?>" min="0" max="10"></td>
                        <td><input type="number" name="media[<?= $aluno['id']?>]" id="media-<?= $aluno['id']?>"></td>
                        <td><input type="number" name="recuperacao[<?= $aluno['id']?>]" id="recuperacao-<?= $aluno['id']?>" min="0" max="10"></td>
                        <td><input type="number"  name="media_rec[<?= $aluno['id']?>]" id="media-rec-<?= $aluno['id']?>"></td>
                        <td><textarea name="observacoes[<?= $aluno['id']?>]" id="observacoes-<?= $aluno['id']?>" placeholder="Observações"></textarea></td>
                        <td class="actions">
                            <button class="edit" onclick="calcularMedia(<?= $aluno['id']?>)">Calcular Média</button>
                            <button class="edit" onclick="editarNota(<?= $aluno['id']?>)">Editar Nota</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Botões de Ações -->
        <div class="save-button">
            <button type="submit">Salvar Notas</button>
        </div>
        <div class="send-button">
            <button onclick="enviarParaCoordenacao()">Enviar para Coordenação/Diretoria</button>
        </div>
        </form>
    </div>
</main>

    <!-- Scripts -->
    <script src="../../assets/js/sidebar/sidebar.js"></script>
   <script src="../../assets/js/global/search.js"></script>
    <script src="../../assets/js/professor/boletim/boletim.js"></script>
</body>
</html>

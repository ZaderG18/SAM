<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: validar.php');
    exit();
}
require_once '../../php/global/funcao.php';
require '../../php/global/cabecario.php';
require '../../php/global/notificacao.php';
$notificacoes = obterNotificacoes($conn, $id);
$countNaoLidas = count(array_filter($notificacoes, fn($n) => $n['lida'] == 0));

// Obtenha todos os usuários e os totais.
$usuarios = get_todos_usuarios($conn);
$totalAlunos = total_alunos($conn);
$totalProfessor = total_professores($conn);
$totalCoordenador = total_coordenadores($conn);
$totalDiretores = total_diretores($conn); // Se precisar, adicione isso.

$maximo_registros = 6;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <!-- <link rel="stylesheet" href="../../assets/scss/home/style.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/home/style.css">

     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <title>Bem vindo ao sam</title>
</head>
<body>
    
     <!--========== HEADER ==========-->
     <header class="header">
        <div class="header__container">
            <a href="#" class="header__logo">SAM</a>
    
            <div class="header__search">
                <i class='bx bx-search header__icon'></i>
                <input type="search" placeholder="Search" class="header__input">
            </div>
    
            <!-- Notificações -->
                    <div class="dropdown notification-dropdown">
              <div class="dropdown-toggle" id="notification-toggle">
                  <span class="notification-count"><?= $countNaoLidas ?></span>
                  <i class='bx bxs-bell'></i>
              </div>
              <div class="dropdown-content content-noti" id="notification-content">
                  <hr>
                  <h4>Alertas</h4>
                  <hr>
                  <ul>
                      <li>Aviso: Prazo de matrícula termina em 2 dias!</li>
                  </ul>
                  <hr>
                  <h4>Notificações</h4>
                  <hr>
                  <?php if (empty($notificacoes)): ?>
                    <p>Não há notificações!</p>
                    <?php else: ?>
                        <?php foreach ($notificacoes as $notificacao): ?>
                  <div class="box-flex-notification">
                     <div class="boximg-noti">
                      <img src="<?= htmlspecialchars($notificacao['imagem'])?>" alt="Profile">
                      <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                     </div>
                      <div class="dados-notification">
                          <h6><?= htmlspecialchars($notificacao['titulo'])?></h6>
                          <p><?= htmlspecialchars($notificacao['mensagem'])?></p>
                          <small><?= date('d/m/Y H:i', strtotime($notificacao['data_criacao']))?></small>
                      </div>
                  </div>
                  <?php endforeach?>
                  <?php endif?>
              </div>
          </div>
    
            <!-- Perfil -->
            <div class="dropdown profile-dropdown" style="margin: 0 15px;">
                <img src="<?php echo $fotoCaminho ?>" alt="Profile" class="header__img" id="profile-toggle">
                <div class="dropdown-content" id="profile-content">
                    <h5>Etec | Centro Paula souza</h5>
                    <div class="flex-conta">
                        <img src="<?php echo $fotoCaminho ?>" alt="Profile">
                        <div class="box-info-conta">
                            <h4><?php echo htmlspecialchars($user['nome'])?></h4>
                            <p><?php echo htmlspecialchars($user['email'])?></p>
                            <span><a href="">Exibir Conta <i class='bx bx-check-square'></i></a></span>
                        </div>
                    </div><!--flex-conta-->
    
                   <!-- Sub-dropdown de Configurações -->
                <div class="profile-option" id="settings-toggle">
                    <p id="current-status"><i class='bx bxs-check-circle'></i> Disponível</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown" id="settings-content">
                    <p data-status="Disponível"><i class='bx bxs-check-circle'></i> Disponível</p>
                    <p data-status="Ocupado"><i class='bx bxs-circle'></i> Ocupado</p>
                    <p data-status="Não incomodar"><i class='bx bxs-minus-circle'></i> Não incomodar</p>
                    <p data-status="Volto logo"><i class='bx bxs-time-five'></i> Volto logo</p>
                    <p data-status="Ausente"><i class='bx bxs-time-five'></i> Aparecer como ausente</p>
                    <p data-status="Offline"><i class='bx bx-x-circle'></i> Aparecer offline</p>
                </div>
                
                <!-- Sub-dropdown de Localização -->
                <div class="profile-option" id="location-toggle">
                    <p id="current-location"><i class='bx bxs-location-plus'></i> Definir local de trabalho</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown sub-drop-localiza" id="location-content">
                    <h6>Para hoje</h6>
                    <p data-location="Office"><i class='bx bx-buildings'></i> Office</p>
                    <p data-location="Remoto"><i class='bx bxs-home'></i> Remoto</p>
                </div>

    
                    <button class="logout-btn" style="float: right; margin: 15px 5px 0 5px;"><i class='bx bx-log-out-circle'></i>Logout</button>
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
                        <i class='bx bxs-disc nav__icon' ></i>
                        <span class="nav__logo-name">SAM</span>
                    </a>
    
                    <div class="nav__list">
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Principais</h3>
    
                            <a href="#" class="nav__link active">
                                <i class='bx bx-home nav__icon' ></i>
                                <span class="nav__name">Home</span>
                            </a>
                            
                            <a href="calendario.php" class="nav__link ">
                                <i class='bx bx-calendar-event  nav__icon'></i>
                                <span class="nav__name">calendário</span>
                            </a>
                        
                            <a href="dashboard.php" class="nav__link">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                        </div>

                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
    
                        
                            <a href="usuarios/gerenuser.php" class="nav__link">
                                <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                            </a>

                            <a href="cursos/cursos.php" class="nav__link">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                <span class="nav__name">Gerenciar Cursos</span>
                            </a>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Comunicações</h3>
    
                            <a href="comunicado.php" class="nav__link">
                                <i class='bx bx-broadcast nav__icon'></i>
                                <span class="nav__name">Comunicados</span>
                            </a>

                            <a href="documentos/solicdocument.php" class="nav__link">
                                <i class='bx bx-archive-in nav__icon' ></i>
                                <span class="nav__name">Envio de Documentos</span>
                            </a>
                        </div>

                        <div class="nav__items">
                            <h3 class="nav__subtitle">Interação</h3>

                            <a href="chat.php" class="nav__link">
                                <i class='bx bx-conversation nav__icon'></i>
                                <span class="nav__name">Chat</span>
                            </a>
                        </div>

                        <div class="nav__items">
                            <h3 class="nav__subtitle">Configurações</h3>

                            <a href="configuracoes.php" class="nav__link">
                                <i class='bx bx-cog nav__icon'></i>
                                <span class="nav__name">Configurações</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="../../php/login/logout.php" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>

        <main>
            <div class="container">
                <div class="box-welcome">
                    <div class="title-welcome">
                        <span>Olá <?php echo htmlspecialchars($user['nome'])?></span>
                        <h1>Seja bem vinda </h1>
                    </div>
                    <div class="img-welcome"></div>
                </div>
    
                <div class="box-visao-geral">
                    <div class="box-visao">
                        <h2>Visão geral</h2>
                        <!-- <input type="date" name="" id=""> -->
                    </div>
    
                    <div class="flex-visao-geral">
                        <div class="content-visao" id="content-visao01">
                            <div class="box-menu"><a href="usuarios/aluno.php"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img1" src="../../assets/img/home/logo/Layer_1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalAlunos)?></h4>
                            </div>
                            <p>Total de estudantes </p>
                        </div>
    
                        <div class="content-visao" id="content-visao02">
                            <div class="box-menu"><a href="usuarios/docente.php"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements">
                                <img id="img2" src="../../assets/img/home/logo/sala-de-aula (3) 1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalProfessor)?></h4>
                            </div>
                            <p>Total de docentes</p>
                        </div>
    
                        <div class="content-visao" id="content-visao03">
                            <div class="box-menu"><a href="usuarios/coordenador.php"><img src="../../assets/img/home/logo/icon-menu.png" alt="" width="30px" style="float: right;"></a></div>
                            <div class="visao-elements img3">
                                <img id="img3" src="../../assets/img/home/logo/Layer_1-1.png" alt="">
                                <h4><?php echo htmlspecialchars($totalCoordenador)?></h4>
                            </div>
                            <p>Total de Coordenadores</p>
                        </div>
                    </div>
                </div> <!--box-visão-geral-->
                <section class="box-registro">
                    <div class="box-flex-registro">

                        <div class="grafico">
                            <h2>Perfis <br>incompletos</h2>
                            <img src="../../assets/img/home/logo/grafic.png" alt="">
                            <span>63.8%</span>
                        </div>

                        <div class="registro">
                            <h2>últimos  registros </h2>

                            <table>
                                <div class="line"></div>
                                <tr>
                                    <th>Nome</th>
                                    <th>Matricula</th>
                                    <th>Genero</th>
                                </tr>
                                <?php $contador =0;
                                foreach ($usuarios as $usuario) {
                                    if($contador >= $maximo_registros){ break; } ?>
                                <tr style=" margin-top: 100px;">
                                    <td><?php echo htmlspecialchars($usuario['nome'])?></td>
                                    <td><?php echo htmlspecialchars($usuario['RM'])?></td>
                                    <td><?php echo htmlspecialchars($usuario['cargo'])?></td>
                                </tr>
                                <?php $contador++; } ?>
                            </table>
                        </div>
                    </div><!--box-flex-registro-->
                </section>
            </div><!--container-->
            <!--<div class="bottom-nav">
                <button class="nav-item"><img src="../../assets/img/home/icons/icon1.png" alt="" > <span>gestão</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon2.png" alt="" srcset=""><span>Docentes</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon3.png" alt="" srcset=""><span>cursos</span></button>
                <button class="nav-item"><img src="../../assets/img/home/icons/icon4.png" alt="" srcset=""><span>Usuários</span></button>
                <button id="add-btn" class="nav-item plus"><img src="../../assets/img/home/icons/icon-menu.png" alt="" srcset=""><span>Mais</span></button>
              </div>
              
              <div id="expand-menu" class="expand-menu">
                <button class="close-btn">&times;</button>
                <div class="menu-options">
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon5.png" alt="" ><span>Comunicados</span></button>
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon6.png" alt="" ><span>Documentos</span></button>
                  <button class="menu-item"><img src="../../assets/img/home/icons/icon7.png" alt="" ><span>Financeiro</span></button>
                </div>
              </div>-->
        </main>

    <!-- <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script> -->

    <script src="../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../assets/js/diretor/global/dropdown.js"></script>
</body>
</html>
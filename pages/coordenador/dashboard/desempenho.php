<?php
require '../../../php/global/cabecario2.php';
require '../../../php/login/validar.php';
require '../../../php/global/notificacao.php';
$notificacoes = obterNotificacoes($conn, $id);
$countNaoLidas = count(array_filter($notificacoes, fn($n) => $n['lida'] == 0));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/dashboard/style.css">
     <!--========== BOX ICONS ==========-->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

     <link rel="stylesheet" href="../../assets/css/dashboard/dashboard.css">
     <link rel="icon" href="../../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <title>Dashboard SAM</title>
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
                        <h4>David Richard Ramos Rosa</h4>
                        <p>david.rosa4@etec.sp.gov.br</p>
                        <span><a href="">Exibir Conta <i class='bx bx-check-square'></i></a></span>
                    </div>
                </div><!--flex-conta-->

                <!-- Sub-dropdown de Configurações -->
                <div class="profile-option" id="settings-toggle">
                    <p><i class='bx bxs-check-circle'></i> Disponivel</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown" id="settings-content">
                    <p><a href=""><i class='bx bxs-check-circle'></i>Disponivel</a></p>
                    <p><a href=""><i class='bx bxs-circle'></i>Ocupado</a></p>
                    <p><a href=""><i class='bx bxs-minus-circle'></i>Não incomodar</a></p>
                    <p><a href=""><i class='bx bxs-time-five'></i>Volto logo</a></p>
                    <p><a href=""><i class='bx bxs-time-five'></i>Aparecer como ausente</a></p>
                    <p><a href=""><i class='bx bx-x-circle'></i>Aparecer offline</a></p>
                </div>

                <!-- Sub-dropdown de Localização -->
                <div class="profile-option" id="location-toggle">
                    <p><i class='bx bxs-location-plus' ></i>Definir local de trabalho</p>
                    <i class='bx bx-chevron-right'></i>
                </div>
                <div class="sub-dropdown sub-drop-localiza" id="location-content">
                    <h6>Para hoje</h6>
                    <p><i class='bx bx-buildings'></i>Office</p>
                    <p><i class='bx bxs-home'></i>Remoto</p>
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
    
                            <a href="../../html/home/home.html" class="nav__link">
                                <i class='bx bx-home nav__icon' ></i>
                                <span class="nav__name">Home</span>
                            </a>

                            <a href="../calendario/calendario.html" class="nav__link ">
                                <i class='bx bx-calendar-event  nav__icon'></i>
                                <span class="nav__name">calendário</span>
                            </a>

                            <a href="#" class="nav__link active">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                            
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
    
                        
                            <a href="../../html/usuarios/gerenuser.html" class="nav__link">
                                <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                            </a>

                            <a href="../../html/cursos/index.html" class="nav__link">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                <span class="nav__name">Gerenciar Cursos</span>
                            </a>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Comunicações</h3>
    
                            <a href="#" class="nav__link">
                                <i class='bx bx-broadcast nav__icon'></i>
                                <span class="nav__name">Comunicados</span>
                            </a>

                            <a href="#" class="nav__link">
                                <i class='bx bx-archive-in nav__icon' ></i>
                                <span class="nav__name">Envio de Documentos</span>
                            </a>
                        </div>

                        <div class="nav__items">
                            <h3 class="nav__subtitle">Interação</h3>

                            <a href="../../html/chat/index.html" class="nav__link">
                                <i class='bx bx-conversation nav__icon'></i>
                                <span class="nav__name">Chat</span>
                            </a>
                        </div>

                        <div class="nav__items">
                            <h3 class="nav__subtitle">Configurações</h3>

                            <a href="../../html/configuracoes/index.html" class="nav__link">
                                <i class='bx bx-cog nav__icon'></i>
                                <span class="nav__name">Configurações</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="../../html/login/login.html" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>

        <div class="global-container">
           
            <main>
                <div class="box-title-dashboard">
                    <div class="flexh1">
                        <h1>Painel de Desempenho Acadêmico</h1>
                        <i class='bx bx-trending-up nav__icon' style="color: #365d85;"></i>
                    </div>            
                </div>
            
                <div class="container-content" id="main-content">
                    <section class="dashboard">
                        <div class="flex-box-dashboard">
                            <!-- Box para Alunos com Baixo Desempenho -->
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../../assets/img/dashboard/risk.svg" alt="" srcset="">
                                </div>
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>Alunos com Baixo Desempenho</span>
                                        <h3>8</h3> <!-- Número de alunos com baixo desempenho -->
                                    </div>
                                </div>
                            </div>
                
                            <!-- Box para Intervenções de Melhoria Realizadas -->
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../../assets/img/dashboard/intervention.svg" alt="" srcset="">
                                </div>
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>Intervenções de Melhoria Realizadas</span>
                                        <h3>5</h3> <!-- Número de intervenções realizadas -->
                                    </div>
                                </div>
                            </div>
                
                            <!-- Box para Alunos com Risco de Evasão -->
                            <div class="box-dashboard">
                                <div class="box-icon">
                                    <img src="../../../assets/img/dashboard/evade.svg" alt="" srcset="">
                                </div>
                                <div class="box-flex-dados">
                                    <div class="dados">
                                        <span>Alunos com Risco de Evasão</span>
                                        <h3>3</h3> <!-- Número de alunos com risco de evasão -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                
                    <!-- Gráfico de Desempenho Acadêmico -->
                    <section class="section-registro">
                        <h3>Últimos Registros de Desempenho Acadêmico</h3>
                        <div class="box-grifico">
                            <canvas id="graficoDesempenho"></canvas>
                        </div>
                    </section>
                
                    <!-- Gráfico de Progresso das Intervenções (Comentado) -->
                    <!-- <section class="section-registro">
                        <h3>Progresso das Intervenções</h3>
                        <div class="box-grifico">
                            <canvas id="graficoIntervencao"></canvas>
                        </div>
                    </section> -->
                </div><!--container-content-->
            </main>
                
            <aside>
                <!-- Lista de Alunos em Risco -->
                <section class="section-aluno">
                    <h6>Lista de Alunos em Risco de Baixo Desempenho</h6>
                    <div class="box-global-alunos">
                        <div class="aluno">
                            <img src="../../../assets/img/persona/minhafoto.PNG" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>David Richard</h5>
                                    <span>3º Análise de Sistemas</span>
                                </div>
                                <p>RM: <span>000-00-000</span></p>
                            </div>
                        </div>
            
                        <div class="aluno">
                            <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>Christina W.</h5>
                                    <span>2º Análise de Sistemas</span>
                                </div>
                                <p>RM: <span>000-00-001</span></p>
                            </div>
                        </div>
            
                        <div class="aluno">
                            <img src="../../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>Jurica Koletic</h5>
                                    <span>4º Redes de Computadores</span>
                                </div>
                                <p>RM: <span>000-00-002</span></p>
                            </div>
                        </div>
                        <button class="button-notificar">Notificar</button>
                    </div>
                </section>
            
                <!-- Alunos com Risco de Evasão -->
                <section class="section-aluno">
                    <h6>Alunos com Risco de Evasão</h6>
                    <div class="box-global-alunos">
                        <div class="aluno">
                            <img src="../../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>Alfredo Silva</h5>
                                    <span>1º Ciência da Computação</span>
                                </div>
                                <p>RM: <span>000-00-003</span></p>
                            </div>
                        </div>
            
                        <div class="aluno">
                            <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>Fernanda Souza</h5>
                                    <span>2º Engenharia de Software</span>
                                </div>
                                <p>RM: <span>000-00-004</span></p>
                            </div>
                        </div>
            
                        <div class="aluno">
                            <img src="../../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="">
                            <div class="box-info-aluno">
                                <div class="box-nome">
                                    <h5>Carlos Pereira</h5>
                                    <span>3º Sistemas de Informação</span>
                                </div>
                                <p>RM: <span>000-00-005</span></p>
                            </div>
                        </div>
                        <button class="button-notificar">Notificar</button>
                    </div>
                </section>
            </aside>
        </div><!--global-container-->

        <script src="../../../assets/js/diretor/global/navgation.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="../../../assets/js/diretor/dashboard/dashboard.js"></script>
        <script src="../../../assets/js/diretor/global/dropdown.js"></script>
        <script src="../../../assets/js/diretor/dashboard/desempenho.js"></script>
        <!-- <script src="../../assets/js/dashboard/acompanhamento.js"></script> -->
</body>
</html>
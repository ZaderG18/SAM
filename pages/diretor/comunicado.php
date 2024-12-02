<?php
require '../../php/global/cabecario2.php';
require '../../php/login/validar.php';
require '../../php/global/notificacao.php';
$notificacoes = obterNotificacoes($conn, $id);
$countNaoLidas = count(array_filter($notificacoes, fn($n) => $n['lida'] == 0));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../assets/scss/diretor/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/global/menumobile.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/comunicado/comunicado.css">

    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

    <!--==== Box-icons ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Comunicados</title>
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
    
                            <a href="home_diretor.php" class="nav__link">
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

                            <div class="nav__dropdown">
                              <a href="#" class="nav__link active">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                  <span class="nav__name">Gerenciar Cursos</span>
                                  <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                              </a>
  
                              <div class="nav__dropdown-collapse">
                                  <div class="nav__dropdown-content">
                                      <a href="cursos/cursos.php" class="nav__dropdown-item">Home</a>
                                      <a href="cursos/editarcursos.php" class="nav__dropdown-item">Editar</a>
                                      <a href="#" class="nav__dropdown-item">Remover</a>
                                  </div>
                              </div>
                          </div>
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
        <section class="formulario-flex">
            <div class="box-left">
                <img src="../../assets/img/diretor/comunicado/4782264-min.jpg" alt="">
            </div>
            <form action="cursos/editarcursos.php" method="get" class="form-container">
                <!-- Primeiro grupo de inputs -->
                <fieldset class="step active">
                    <div class="box-legend">
                        <legend class="legend1">Título do Comunicado</legend>
                        <div class="line-legend line1"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <input type="text" id="titulo" name="titulo" placeholder="Digite o título do comunicado" required>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
        
                <!-- Segundo grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend2">Corpo do Comunicado</legend>
                        <div class="line-legend line2"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <textarea id="corpo" name="corpo" placeholder="Escreva aqui o comunicado para informar novidades, atualizações importantes, avisos de eventos ou qualquer outra informação relevante para os usuários da instituição." required></textarea>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="prev">Voltar</button>
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
        
                <!-- Terceiro grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend3">Imagem (opcional)</legend>
                        <div class="line-legend line3"></div>
                    </div>
                    
                    <div class="box-inputs box-img">
                        <div class="input">
                            <!-- Escondendo o input de arquivo real -->
                            <input type="file" id="imagem" accept="image/*" onchange="previewImage(event)" style="display: none;">
                            
                            <!-- Label estilizado que funciona como botão -->
                            <label for="imagem" class="upload-button">
                                <i class='bx bxl-dropbox bx-tada'></i>Selecione uma imagem
                            </label>
                        </div>
                        <div class="input">
                            <div id="imagePreviewContainer">
                                <img id="imagePreview" src="" alt="Pré-visualização da Imagem" style="display: none;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-buttons">
                        <button type="button" class="cancel-image" onclick="cancelImage()" style="display: none;">Cancelar Imagem</button>
                        <button type="button" class="prev">Voltar</button>
                        <button type="button" class="next">Próximo</button>
                        <!-- Botão de cancelar imagem -->
                    </div>
                </fieldset>
                
        
                <!-- Quarto grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend4">Tipo de Comunicado</legend>
                        <div class="line-legend line4"></div>
                    </div>
                   
                    <div class="box-inputs">
                        <div class="input">
                            <label for="alerta">Marcar como Alerta Importante:</label>
                            <div id="infoExtraAlerta" class="extra-info" style="display: none;">
                                <p>Você está prestes a marcar este comunicado como "Alerta Importante". Isso significa que a mensagem terá prioridade e será destacada para os destinatários, garantindo que todos vejam a informação com urgência. Você realmente deseja prosseguir com essa marcação?</p>
                                <div class="box-flex-comunicado">
                                    <label for="confirmAlerta" class="confirm-label">Confirmar</label>
                                    <input type="checkbox" id="confirmAlerta" name="confirmAlerta">
                                </div>
                            </div>
                        </div>
                        
                        <div class="input">
                            <label for="chat">Postar no Chat:</label>
                            <div id="infoExtraChat" class="extra-info" style="display: none;">
                                <p>Você está prestes a notificar os usuários no chat, mas essa notificação será enviada apenas aos destinatários selecionados. Isso significa que, dependendo da sua escolha (professores, alunos, funcionários ou todos), a mensagem será enviada a esses grupos específicos. Você deseja prosseguir com essa notificação?</p>
                                <div class="box-flex-comunicado">
                                    <label for="confirmChat" class="confirm-label">Confirmar</label>
                                    <input type="checkbox" id="confirmChat" name="confirmChat">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-buttons">
                        <button type="button" class="prev">Voltar</button>
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
        
                <!-- Quinto grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend5">Destinatário</legend>
                        <div class="line-legend line5"></div>
                    </div>
                   
                    <div class="box-inputs">
                        <div class="input">
                            <select name="destinatario" required>
                                <option value="todos">Todos</option>
                                <option value="professores">Professores</option>
                                <option value="alunos">Alunos</option>
                                <option value="coordenadores">Coordenadores</option>
                              </select>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="prev">Voltar</button>
                        <button type="submit" class="salvar">Salvar</button>
                    </div>
                </fieldset>
            </form>
        </section>
    </main>

    <script src="../../assets/js/diretor/cursos/criar.js"></script>
    <script src="../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../assets/js/diretor/global/dropdown.js"></script>
    <script src="../../assets/js/diretor/comunicado/comunicado.js"></script>
</body>
</html>
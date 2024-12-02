<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->
    <!-- <link rel="stylesheet" href="../../assets/scss/diretor/home/style.css"> -->
    <link rel="stylesheet" href="../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../assets/scss/diretor/configuracoes/configuracoes.css">

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

                            <a href="configuracoes.php" class="nav__link active">
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
                <div class="box-config">
                    <h1>Configurações</h1>
                    <i class='bx bxs-cog'></i>
                </div>
        
                <nav class="navbar">
                    <div class="menu-toggle"><i class='bx bx-menu-alt-right'></i></div> <!-- Ícone hambúrguer -->
                    <ul>
                        <li><a href="#" class="nav_link active" data-section="perfil">Perfil</a></li>
                        <li><a href="#" class="nav_link" data-section="sistema">Sistema Acadêmico</a></li>
                        <li><a href="#" class="nav_link" data-section="notificacoes">Notificações</a></li>
                        <li><a href="#" class="nav_link" data-section="permissoes">Permissões</a></li>
                        <li><a href="#" class="nav_link" data-section="relatorios">Relatórios</a></li>
                        <li><a href="#" class="nav_link" data-section="integracoes">Integrações</a></li>
                    </ul>
                </nav>
        
                <!-- Seção: Perfil -->
                <section id="perfil" class="content-section active">
                    <h2>Seu Perfil</h2>
                    <span>escolha como você será exibido no SAM</span>
                    <form>
                        
                        <div class="global-flex-perfil">

                            <div class="global-picture">
                                <div class="box-input nome">
                                    <label for="nome">Nome:</label>
                                    <input  type="text" id="nome" placeholder="Seu nome completo">
                                </div><!--box-input-->
    
                                <div class="box-input">
                                    <div class="profile-picture">
                                        <h5>Foto de perfil</h5>
                                        <img id="profileImg" alt="Profile Picture" />
                                        <label for="imageUpload" class="upload-label"><i class='bx bxs-up-arrow-circle'></i></label>
                                        <input type="file" id="imageUpload" accept="image/*" style="display: none;" />
                                    </div>
                                </div><!--box-input-->
                            </div><!--global-picture-->

                            <button class="button-picture"><i class='bx bxs-save'></i>Salvar essas alterações</button>

                            <div class="global-inputs" style="width: 100%; display: flex; flex-wrap: wrap;">
                                <div class="box-input">
                                    <label for="email">E-mail:</label>
                                    <input type="email" id="email" placeholder="seuemail@exemplo.com">
                                </div><!--box-input-->
    
                                <div class="box-input">
                                    <label for="cargo">Cargo:</label>
                                    <input type="text" id="cargo" placeholder="Cargo na instituição">
                                </div><!--box-input-->
    
                                <div class="box-input">
                                    <label for="senha">Alterar Senha:</label>
                                    <input type="password" id="senha" placeholder="Nova senha">
                                </div><!--box-input-->
                            </div><!--global-inputs-->
                        </div>
        
                        <button type="submit"><i class='bx bxs-save'></i>Salvar Alterações</button>
                    </form>
                </section>
        
                <!-- Seção: Sistema Acadêmico -->
                <section id="sistema" class="content-section">
                    <h2>Sistema Acadêmico</h2>
                    <form>

                        <div class="global-flex-perfil">

                            <div class="box-input">
                                <label for="ano-letivo">Ano Letivo Ativo:</label>
                                <select id="ano-letivo">
                                    <option>2024</option>
                                    <option>2025</option>
                                    <option>2026</option>
                                </select>
                            </div>
    
                            <div class="box-input">
                                <label for="nota-minima">Nota Mínima para Aprovação:</label>
                                <input type="number" id="nota-minima" placeholder="Ex: 6.0" min="0" max="10">
                            </div>
                            
                            <div class="box-input">
                                <label for="frequencia-minima">Frequência Mínima (%):</label>
                            <input type="number" id="frequencia-minima" placeholder="Ex: 75" min="0" max="100">
                            </div>
    
                            <div class="box-input">
                                <label for="modulos">Módulos Ativos:</label>
                            <div class="box-global-check">
                                <div class="box-check"><input type="checkbox" id="financeiro"> Gestão Financeira</div>
                                <div class="box-check"><input type="checkbox" id="calendario"> Calendário Acadêmico</div>
                            </div>
                            </div>
                        </div>
                        <button type="submit">Salvar Configurações</button>
                    </form>
                </section>
        
                <!-- Seção: Notificações -->
                <section id="notificacoes" class="content-section">
                    <h2>Notificações</h2>
                    <form>
                        <div class="global-flex-perfil">
                            <div class="box-input">
                                <label>Canais de Comunicação:</label>
                                <div class="box-global-check">
                                    <div class="box-check"><input type="checkbox" id="email-notif" checked> E-mail</div>
                                    <div class="box-check"><input type="checkbox" id="sms"> SMS</div>
                                    <div class="box-check"> <input type="checkbox" id="internas" checked> Notificações Internas</div>
                                </div>
                            </div>
    
                            <div class="box-input">
                                <label for="frequencia-notif">Frequência de Notificações:</label>
                                <select id="frequencia-notif">
                                    <option>Diária</option>
                                    <option>Semanal</option>
                                    <option>Mensal</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit">Salvar Preferências</button>
                    </form>
                </section>
        
                <!-- Seção: Permissões -->
                <section id="permissoes" class="content-section">
                    <h2>Permissões</h2>
                    <form>
                        <div class="global-flex-perfil">
                            <div class="box-input">
                                <label for="papel">Atribuir Papéis:</label>
                                <select id="papel">
                                    <option>Administrador</option>
                                    <option>Coordenador</option>
                                    <option>Professor</option>
                                </select>
                            </div>
    
                            <div class="box-input">
                                <label for="modulo-acesso">Módulo com Acesso Restrito:</label>
                                <select id="modulo-acesso">
                                    <option>Financeiro</option>
                                    <option>Relatórios</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit">Salvar Permissões</button>
                    </form>
                </section>
        
                <!-- Seção: Relatórios -->
                <section id="relatorios" class="content-section">
                    <h2>Relatórios</h2>
                    <form>
                        <div class="global-flex-perfil">
                            <div class="box-input">
                                <label for="kpis">Selecionar Indicadores (KPIs):</label>
                                <div class="box-global-check">
                                    <div class="box-check"><input type="checkbox" id="matricula" checked> Matrículas</div>
                                    <div class="box-check">  <input type="checkbox" id="evasao"> Evasão Escolar</div>
                                    <div class="box-check"><input type="checkbox" id="desempenho"> Desempenho Médio</div>
                                </div>
                            </div>
    
                            <div class="box-input">
                                <label for="frequencia-relatorios">Frequência dos Relatórios:</label>
                                <select id="frequencia-relatorios">
                                    <option>Semanal</option>
                                    <option>Mensal</option>
                                    <option>Trimestral</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit">Salvar Preferências</button>
                    </form>
                </section>
        
                <!-- Seção: Integrações -->
                <section id="integracoes" class="content-section">
                    <h2>Integrações e Backup</h2>
                    <form>
                        <div class="global-flex-perfil">
                            <div class="box-input">
                                <label for="google">Conectar ao Google Calendar:</label>
                                <button type="button">Conectar</button>
                            </div>
    
                            <div class="box-input">
                                <label for="backup">Agendar Backup Automático:</label>
                                <select id="backup">
                                    <option>Diário</option>
                                    <option>Semanal</option>
                                    <option>Mensal</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit">Salvar Configurações</button>
                    </form>
                </section>
            </div><!--container-->
        </main>
        
        
    <!-- <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script> -->

    <script src="../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../assets/js/diretor/global/dropdown.js"></script>
    <script src="../../assets/js/diretor/config/config.js"></script>
</body>
</html>
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
    <!-- <link rel="stylesheet" href="../../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/global/menumobile.css"> -->
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/usuario/criaruser.css">

    <link rel="icon" href="../../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

    <!--==== Box-icons ====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gerenciamento de Cursos</title>
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
    
                            <a href="../home_diretor.php" class="nav__link">
                                <i class='bx bx-home nav__icon' ></i>
                                <span class="nav__name">Home</span>
                            </a>
                            
                            <a href="../calendario.php" class="nav__link ">
                                <i class='bx bx-calendar-event  nav__icon'></i>
                                <span class="nav__name">calendário</span>
                            </a>
                        
                            <a href="../dashboard/dashboard.php" class="nav__link">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
  
                            <a href="gerenuser.php" class="nav__link">
                                <i class='bx bx-user nav__icon'></i>
                                <span class="nav__name">Gerenciar Usuários</span>
                            </a>

                            <div class="nav__dropdown">
                              <a href="../cursos/cursos.php" class="nav__link active">
                                <i class='bx bx-edit-alt nav__icon'></i>
                                  <span class="nav__name">Gerenciar Cursos</span>
                                  <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                              </a>
  
                              <div class="nav__dropdown-collapse">
                                  <div class="nav__dropdown-content">
                                      <a href="../cursos/cursos.php" class="nav__dropdown-item">Home</a>
                                      <a href="../cursos/editarcursos.php" class="nav__dropdown-item">Editar</a>
                                      <a href="#" class="nav__dropdown-item">Remover</a>
                                  </div>
                              </div>
                          </div>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Comunicações</h3>
    
                            <a href="../comunicado.php" class="nav__link">
                                <i class='bx bx-broadcast nav__icon'></i>
                                <span class="nav__name">Comunicados</span>
                            </a>
  
                            <a href="../documentos/solicdocument.php" class="nav__link">
                                <i class='bx bx-archive-in nav__icon' ></i>
                                <span class="nav__name">Envio de Documentos</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Interação</h3>
  
                            <a href="../chat.php" class="nav__link">
                                <i class='bx bx-conversation nav__icon'></i>
                                <span class="nav__name">Chat</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Configurações</h3>
  
                            <a href="../configuracoes.php" class="nav__link">
                                <i class='bx bx-cog nav__icon'></i>
                                <span class="nav__name">Configurações</span>
                            </a>
                        </div>
                    </div>
                </div>
  
                <a href="../../../php/login/logout.php" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>

        <main>
            <section class="formulario-flex">
                <div class="box-left" style="background-color: #c57dba;">
                    <img src="../../../assets/img/diretor/docente/flat-design-children-back-school_52683-44264.jpg" alt="">
                </div>
                <form action="adicionarusuario.html" method="post" class="form-container">
                    
                    <!-- Primeiro grupo de inputs -->
                    <fieldset class="step active">
                        <div class="box-legend">
                            <legend class="legend1">Informações Básicas</legend>
                            <div class="line-legend line1"></div>
                        </div>
                        <div class="box-inputs">
                            <div class="input">
                                <label for="nome-completo">Nome Completo:</label>
                                <input type="text" id="nome-completo" name="nome-completo" placeholder="Digite o nome completo" required>
                            </div>
                            <div class="input input-right">
                                <label for="matricula">Matrícula:</label>
                                <input type="text" id="matricula" name="matricula" placeholder="Digite a matrícula" required>
                            </div>
                            <div class="input">
                                <label for="email">Email Institucional:</label>
                                <input type="email" id="email" name="email" placeholder="Digite o email institucional" required>
                            </div>
                            <div class="input input-right">
                                <label for="telefone">Telefone:</label>
                                <input type="tel" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                            </div>
                        </div>
                        <div class="box-buttons">
                            <button type="button" class="next">Próximo</button>
                        </div>
                    </fieldset>
                    
                    <!-- Segundo grupo de inputs -->
                    <fieldset class="step">
                        <div class="box-legend">
                            <legend class="legend2">Informações de Acesso</legend>
                            <div class="line-legend line2"></div>
                        </div>
                        <div class="box-inputs">
                            <div class="input">
                                <label for="tipo-acesso">Tipo de Acesso:</label>
                                <select id="tipo-acesso" name="tipo-acesso" required>
                                    <option value="aluno">Aluno</option>
                                    <option value="professor">Professor</option>
                                    <option value="coordenador">Coordenador</option>
                                </select>
                            </div>
                            <div class="input input-right">
                                <label for="nivel-acesso">Nível de Acesso:</label>
                                <select id="nivel-acesso" name="nivel-acesso" required>
                                    <option value="1">Nível 1 - Básico</option>
                                    <option value="2">Nível 2 - Intermediário</option>
                                    <option value="3">Nível 3 - Avançado</option>
                                    <option value="4">Nível 4 - Administrativo</option>
                                </select>
                            </div>
                            <div class="input">
                                <label for="senha">Senha:</label>
                                <input type="password" id="senha" name="senha" placeholder="Digite uma senha" required>
                            </div>
                            <div class="input input-right">
                                <label for="confirmar-senha">Confirmar Senha:</label>
                                <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Confirme a senha" required>
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
                            <legend class="legend3">Dados Institucionais</legend>
                            <div class="line-legend line3"></div>
                        </div>
                        <div class="box-inputs">
                            <div class="input">
                                <label for="departamento">Departamento:</label>
                                <input type="text" id="departamento" name="departamento" placeholder="Digite o departamento (se aplicável)">
                            </div>
                            <div class="input input-right">
                                <label for="data-admissao">Data de Admissão:</label>
                                <input type="date" id="data-admissao" name="data-admissao" required>
                            </div>
                            <div class="input" style="width: 100%;">
                                <label for="observacoes">Observações:</label>
                                <textarea id="observacoes" name="observacoes" rows="3" placeholder="Ex: experiência, especialização ou outras observações"></textarea>
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
        
        

    <script src="../../../assets/js/diretor/usuarios/criaruser.js"></script>
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
</body>
</html>
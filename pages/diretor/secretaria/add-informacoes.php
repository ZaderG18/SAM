<?php
require '../../../php/global/cabecario2.php';
require '../../../php/login/validar.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../../assets/scss/global/sidebar.css">
    <link rel="stylesheet" href="../../../assets/scss/global/menumobile.css"> -->
    <link rel="stylesheet" href="../../../assets/scss/diretor/global/navgation.css">
    <link rel="stylesheet" href="../../../assets/scss/diretor/cursos/cursos.css">

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
                <span class="notification-count">3</span>
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
                <div class="box-flex-notification">
                   <div class="boximg-noti">
                    <img src="../../../assets/img/persona/minhafoto.PNG" alt="Profile">
                    <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                   </div>
                    <div class="dados-notification">
                        <h6>fulanodetal0110@gmail.com</h6>
                        <p>Chat - Aluno - 3°DS</p>
                    </div>
                </div>
                <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../../assets/img/persona/christina-wocintechchat-com-0Zx1bDv5BNY-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Coordenação</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../../assets/img/persona/christina-wocintechchat-com-SJvDxw0azqw-unsplash (1).jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Coordenação</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../../assets/img/persona/linkedin-sales-solutions-pAtA8xe_iVM-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Professor - nutrição</p>
                     </div>
                 </div>
                 <div class="box-flex-notification">
                    <div class="boximg-noti">
                     <img src="../../../assets/img/persona/jurica-koletic-7YVZYZeITc8-unsplash.jpg" alt="Profile">
                     <div class="circle-noti"> <i class='bx bx-conversation nav__icon'></i></div>
                    </div>
                     <div class="dados-notification">
                         <h6>fulanodetal0110@gmail.com</h6>
                         <p>Chat - Professor - Física</p>
                     </div>
                 </div>
            </div>
        </div>

        <!-- Perfil -->
        <div class="dropdown profile-dropdown" style="margin: 0 15px;">
            <img src="../../../assets/img/persona/coqui-chang-COP.jpg" alt="Profile" class="header__img" id="profile-toggle">
            <div class="dropdown-content" id="profile-content">
                <h5>Etec | Centro Paula souza</h5>
                <div class="flex-conta">
                    <img src="../../../assets/img/persona/coqui-chang-COP.jpg" alt="Profile">
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
    
                            <a href="../home_diretor.php" class="nav__link">
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
                                      <a href="index.html" class="nav__dropdown-item">Home</a>
                                      <a href="cursos/editarcursos.php" class="nav__dropdown-item">Editar</a>
                                      <a href="#" class="nav__dropdown-item">Remover</a>
                                  </div>
                              </div>
                          </div>
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
                <img src="../../../assets/img/secretaria/students.PNG" alt="">
            </div>
            <form action="" method="post" class="form-container">
                <!-- Primeiro grupo de inputs -->
                <fieldset class="step active">
                    <div class="box-legend">
                        <legend class="legend1">Informações da Escola</legend>
                        <div class="line-legend line1"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label for="nome-escola">Nome da Escola:</label>
                            <input type="text" id="nome-escola" name="nome-escola" placeholder="Digite o nome da escola" required>
                        </div>
                        <div class="input input-right">
                            <label for="codigo-escola">Código da Escola:</label>
                            <input type="text" id="codigo-escola" name="codigo-escola" placeholder="Ex: 12345" required>
                        </div>
                        <div class="input">
                            <label for="cnpj-escola">CNPJ:</label>
                            <input type="text" id="cnpj-escola" name="cnpj-escola" placeholder="Digite o CNPJ" required>
                        </div>
                        <div class="input input-right">
                            <label for="tipo-instituicao">Tipo de Instituição:</label>
                            <select id="tipo-instituicao" name="tipo-instituicao" required>
                                <option value="">Selecione</option>
                                <option value="publica">Pública</option>
                                <option value="privada">Privada</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
            
                <!-- Segundo grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend2">Endereço e Contato</legend>
                        <div class="line-legend line2"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label for="endereco">Endereço:</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Digite o endereço completo" required>
                        </div>
                        <div class="input input-right">
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade" required>
                        </div>
                        <div class="input">
                            <label for="estado">Estado:</label>
                            <select id="estado" name="estado" required>
                                <option value="">Selecione</option>
                                <option value="sp">São Paulo</option>
                                <option value="rj">Rio de Janeiro</option>
                                <option value="mg">Minas Gerais</option>
                                <!-- Outros estados -->
                            </select>
                        </div>
                        <div class="input input-right">
                            <label for="telefone">Telefone:</label>
                            <input type="tel" id="telefone" name="telefone" placeholder="(xx) xxxx-xxxx" required>
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
                        <legend class="legend3">Horários e Funcionamento</legend>
                        <div class="line-legend line3"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label for="horario-abertura">Horário de Abertura:</label>
                            <input type="time" id="horario-abertura" name="horario-abertura" required>
                        </div>
                        <div class="input input-right">
                            <label for="horario-fechamento">Horário de Fechamento:</label>
                            <input type="time" id="horario-fechamento" name="horario-fechamento" required>
                        </div>
                        <div class="input">
                            <label for="dias-funcionamento">Dias de Funcionamento:</label>
                            <select id="dias-funcionamento" name="dias-funcionamento" required>
                                <option value="segunda-sexta">Segunda a Sexta</option>
                                <option value="segunda-sabado">Segunda a Sábado</option>
                            </select>
                        </div>
                        <div class="input input-right">
                            <label for="feriados">Feriados Atípicos:</label>
                            <textarea id="feriados" name="feriados" rows="3" placeholder="Liste os feriados com datas"></textarea>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="prev">Voltar</button>
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
            
                <!-- Quarto grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend4">Redes Sociais e Observações</legend>
                        <div class="line-legend line4"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label for="site">Site Oficial:</label>
                            <input type="url" id="site" name="site" placeholder="https://www.seusite.com">
                        </div>
                        <div class="input input-right">
                            <label for="facebook">Facebook:</label>
                            <input type="url" id="facebook" name="facebook" placeholder="https://www.facebook.com/suaescola">
                        </div>
                        <div class="input">
                            <label for="instagram">Instagram:</label>
                            <input type="url" id="instagram" name="instagram" placeholder="https://www.instagram.com/suaescola">
                        </div>
                        <div class="input input-right">
                            <label for="observacoes">Observações:</label>
                            <textarea id="observacoes" name="observacoes" rows="3" placeholder="Informações adicionais"></textarea>
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

    <script>
        // Seleciona todas as caixas de imagem
const boxes = document.querySelectorAll('.box-img');

// Função para remover a classe 'selected' de todas as caixas de imagem
function removeSelected() {
    boxes.forEach(box => box.classList.remove('selected'));
}

// Adiciona o evento de clique para cada caixa de imagem
boxes.forEach(box => {
    box.addEventListener('click', () => {
        removeSelected();  // Remove a seleção de qualquer outra caixa
        box.classList.add('selected');  // Adiciona a borda à caixa clicada
    });
});

    </script>

    <script src="../../../assets/js/diretor/cursos/criar.js"></script>
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
</body>
</html>
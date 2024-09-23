<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/global/sidebar.css">
    <link rel="stylesheet" href="../../assets/css/global/menumobile.css">
    <link rel="stylesheet" href="../../assets/css/cursos/cursos.css">

    <link rel="icon" href="../../assets/img/icone_logo 1.png" type="image/png"> <!-- Ícone da aba do navegador -->

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gerenciamento de Cursos</title>
</head>
<body>
    <header class="header"> 
        <div class="logo-sam"><img src="../../assets/img/home/logo/Mask group.png" alt=""></div>
        <div class="box-search"><i class='bx bx-search'></i><input type="text" placeholder="Pesquisar"></div>
        <nav class="nav container" id="menu-mobile">
            <div class="nav__data">
               <!-- <a href="#" class="nav__logo">
                  <i class="ri-planet-line"></i> Company
               </a> -->
               
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line nav__burger"></i>
                  <i class="ri-close-line nav__close"></i>
               </div>
            </div>

            <!--=============== NAV MENU ===============-->
            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li><a href="../home/home.html" class="nav__link"><img src="../../assets/img/home/icons/home.svg" alt="" srcset="">Home</a></li>

                  <li><a href="../docente/index.html" class="nav__link"><img src="../../assets/img/home/icons/docentes.svg" alt="" srcset="">Docentes</a></li>

                  <li><a href="../dashboard/index.html" class="nav__link"><img src="../../assets/img/home/icons/dashboard.svg" alt="" srcset="">Dashboard</a></li>
                  <!--=============== DROPDOWN 1 
                  <li class="dropdown__item">
                     <div class="nav__link"><img src="../../assets/img/home/icons/dashboard.svg" alt="" srcset="">
                        Dashboard<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="../dashboard/index.html" class="dropdown__link">
                              <i class="ri-pie-chart-line"></i> Painel
                           </a>                          
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-arrow-up-down-line"></i> Transactions
                           </a>
                        </li>

                        <!--=============== DROPDOWN SUBMENU ===============
                        <li class="dropdown__subitem">
                           <div class="dropdown__link">
                              <i class="ri-bar-chart-line"></i> Reports <i class="ri-add-line dropdown__add"></i>
                           </div>

                           <ul class="dropdown__submenu">
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-file-list-line"></i> Documents
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-cash-line"></i> Payments
                                 </a>
                              </li>
      
                              <li>
                                 <a href="#" class="dropdown__sublink">
                                    <i class="ri-refund-2-line"></i> Refunds
                                 </a>
                              </li>
                           </ul>
                        </li>-->
                     </ul>
                  </li>
                  

                  <!--=============== DROPDOWN 2 ===============-->
                  <li class="dropdown__item">
                     <div class="nav__link">
                        Users <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                     </div>

                     <ul class="dropdown__menu">
                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-user-line"></i> Profiles
                           </a>                          
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-lock-line"></i> Accounts
                           </a>
                        </li>

                        <li>
                           <a href="#" class="dropdown__link">
                              <i class="ri-message-3-line"></i> Messages
                           </a>
                        </li>
                     </ul>
                  </li>

                  <li><a href="#" class="nav__link">Contact</a></li>
               </ul>
            </div>
         </nav>
    </header>
    <div class="global-container">
        <aside>
            <div class="sidebar">
                        <!--aside bar-->
                        <nav id="sidebar">
                            <div id="sidebar_content">
                                <div id="user">
                                    <img src="../../assets/img/home/coqui-chang-COP.jpg" id="user_avatar" alt="Avatar">
                        
                                    <p id="user_infos">
                                        <span class="item-description">
                                            Fulano de Tal
                                        </span>
                                        <span class="item-description">
                                            Lorem Ipsum
                                        </span>
                                    </p>
                                </div>
                        
                                <ul id="side_items">
                                    <li class="side-item">
                                        <a href="../home/home.html">
                                            <img src="../../assets/img/home/icons/home.svg" alt="" >
                                            <span class="item-description">
                                                Home
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="../docente/index.html">
                                            <img src="../../assets/img/home/icons/docentes.svg" alt="">
                                            <span class="item-description">
                                                Docentes
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item active">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/cursos.svg" alt="" width="30px">
                                            <span class="item-description">
                                                Gerenciar Cursos
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/user.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar usuarios
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/comunicado.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar comunicados
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/documento.svg" alt="">
                                            <span class="item-description">
                                                Gerenciar documentos
                                            </span>
                                        </a>
                                    </li>

                                    <li class="side-item">
                                        <a href="../dashboard/index.html">
                                            <img src="../../assets/img/home/icons/dashboard.svg" alt="">
                                            <span class="item-description">
                                                Dashboard
                                            </span>
                                        </a>
                                    </li>
                        
                                    <li class="side-item">
                                        <a href="#">
                                            <img src="../../assets/img/home/icons/configuracao.svg" alt="">
                                            <span class="item-description">
                                                Configurações
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                        
                                <button id="open_btn">
                                    <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                    
                            <div id="logout">
                                <button id="logout_btn" onclick="window.location.href='../login/login.html'">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span class="item-description">
                                        Logout
                                    </span>
                                </button>
                            </div>
                        </nav>
            </div>
        </aside>
        <main>
            <div class="container">
                <div class="box-title">
                    <div class="flex-title">
                        <h1>Gerenciamento de Cursos</h1>
                        <div class="box-img"><img src="../../assets/img/cursos/cusos.svg" alt="" srcset=""></div>
                    </div>
                    <div class="line"></div>
                </div><!--box-title-->
                    <form action="#" method="POST">
                

                         <fieldset style="border: none;">
                            <div class="box-inputs">

                                <div class="input">
                                    <label for="nome-curso">Nome do Curso:</label>
                                    <input type="text" id="nome-curso" name="nome-curso" placeholder="Digite o nome do curso" required>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="codigo">Código:</label>
                                    <input type="text" id="codigo" name="codigo" placeholder="Digite o código do curso" required>
                                </div><!--input-->

                                <div class="input ">
                                    <label for="descricao">Descrição:</label>
                                    <textarea id="descricao" name="descricao" rows="4"  placeholder="Descreva o curso" required></textarea>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="departamento">Departamento:</label>
                                    <input type="text" id="departamento" name="departamento" placeholder="Digite o departamento" required>
                                </div><!--input-->

                                <div class="input">
                                    <label for="carga-horaria">Carga Horária (em horas):</label>
                                    <input type="number" id="carga-horaria" name="carga-horaria" placeholder="Ex: 40" min="1" required>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="pre-requisitos">Pré-requisitos:</label>
                                    <input type="text" id="pre-requisitos" placeholder="Digite os pré-requisitos" name="pre-requisitos">
                                </div><!--input-->

                                <div class="input">
                                    <label for="tipo-curso">Tipo de Curso:</label>
                                    <select id="tipo-curso" name="tipo-curso" required>
                                        <option value="presencial">Presencial</option>
                                        <option value="online">Online</option>
                                        <option value="semipresencial">Semipresencial</option>
                                    </select>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="nivel-curso">Nível do Curso:</label>
                                    <select id="nivel-curso" name="nivel-curso" required>
                                        <option value="basico">Básico</option>
                                        <option value="intermediario">Intermediário</option>
                                        <option value="avancado">Avançado</option>
                                    </select>
                                </div><!--input-->

                                <div class="input">
                                    <label for="periodo">Período/Semestre:</label>
                                    <input type="text" id="periodo" name="periodo" placeholder="Ex: 1º Semestre de 2024" required>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="professor">Professor/Instrutor:</label>
                                    <input type="text" id="professor" placeholder="Digite o nome do professor" name="professor" required>
                                </div><!--input-->

                                <div class="input">
                                    <label for="status-curso">Status do Curso:</label>
                                    <select id="status-curso" name="status-curso" required>
                                        <option value="ativo">Ativo</option>
                                        <option value="inativo">Inativo</option>
                                    </select>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="data-inicio">Data de Início:</label>
                                    <input type="date" id="data-inicio" name="data-inicio" required>
                                </div><!--input-->

                                <div class="input">
                                    <label for="data-termino">Data de Término:</label>
                                    <input type="date" id="data-termino" name="data-termino" required>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="vagas">Vagas Disponíveis:</label>
                                    <input type="number" id="vagas" name="vagas" min="1" placeholder="Ex: 30" required>
                                </div><!--input-->

                                <div class="input">
                                    <label for="modalidade">Modalidade:</label>
                                    <input type="text" id="modalidade" name="modalidade" placeholder="Ex: EAD, Presencial" required>
                                </div><!--input-->

                                <div class="input input-right">
                                    <label for="material-recurso">Material e Recurso:</label>
                                    <textarea id="material-recurso" name="material-recurso" rows="3" placeholder="Liste os materiais e recursos necessários"></textarea>
                                </div><!--input-->

                                <div class="input-obser">
                                    <label for="observacoes">Observações:</label>
                                    <textarea id="observacoes" name="observacoes" rows="3" placeholder="Ex: Este curso requer participação ativa em atividades práticas"></textarea>
                                </div><!--input-->

                        </div><!--box-inputs-->
                        <div class="box-buttons">
                            <button type="submit" class="salvar">Salvar alterações</button>
                            <button type="submit" class="cancelar">Cancelar</button>
                        </div><!--box-buttons-->
                        </fieldset> 
                    </form>
            </div><!--container-->
        </main>
    </div>

    <script src="../../assets/js/sidebar/sidebar.js"></script>
    <script src="../../assets/js/home/bottomnav.js"></script>
    <script src="../../assets/js/home/menumobile.js"></script>
</body>
</html>
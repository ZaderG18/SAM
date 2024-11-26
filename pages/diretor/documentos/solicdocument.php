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

    <style>
         .filtered-users {
        list-style-type: none;
        padding: 0;
        width: 100%;
    }

    .filtered-users div{
        padding: 10px;
        background-color: #f4f4f4;
        margin-bottom: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #1f0c8a;
    }

    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    @media (max-width:704px){
        .fildset-container{
            margin: 0 10px;
        }
    }
    </style>
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
                                      <a href="../cursos/cursos.php" class="nav__dropdown-item">Home</a>
                                      <a href="../cursos/editarcursos.php" class="nav__dropdown-item">Editar</a>
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
                <img src="../../../assets/img/diretor/documentos/6203999.jpg" alt="">
            </div>
            <div action="" method="post" class="form-container">
                <!-- Primeiro grupo de inputs -->
                <fieldset class="step active">
                    <div class="box-legend">
                        <legend class="legend1">Solicitar Documentos</legend>
                        <div class="line-legend line1"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label>Destinatários:</label>
                            <select id="destinatario" name="destinatario">
                                <option value="todos">Todos</option>
                                <option value="alunos">Alunos</option>
                                <option value="professores">Professores</option>
                                <option value="coordenadores">Coordenadores</option>
                              </select>
                        </div>
                        <div class="input input-right">
                            <label for="codigo-escola">Documentos Comuns:</label>
                            <select id="documentoComum" name="documentoComum">
                                <option value="" disabled selected>Selecione um documento</option>
                                <option value="boletim">Boletim de Notas</option>
                                <option value="certificado">Certificado de Conclusão</option>
                                <option value="declaracao">Declaração de Matrícula</option>
                                <option value="historico">Histórico Escolar</option>
                                <option value="atestado_frequencia">Atestado de Frequência</option>
                                <option value="identidade_estudantil">Identidade Estudantil</option>
                                <option value="comprovante_residencia">Comprovante de Residência</option>
                                <option value="declaracao_transferencia">Declaração de Transferência</option>
                                <option value="alistamento_militar">Certificado de Alistamento Militar</option>
                                <option value="relatorio_notas">Relatório de Notas</option>
                                <option value="ficha_inscricao">Ficha de Inscrição</option>
                                <option value="atestado_medico">Atestado Médico</option>
                                <option value="documentacao_bolsa">Documentação para Bolsa de Estudos</option>
                                <option value="certificado_participacao">Certificado de Participação em Eventos</option>
                                <option value="formulario_reuniao">Formulário de Solicitação de Reunião</option>
                                <option value="declaracao_responsabilidade">Declaração de Responsabilidade</option>
                            </select>
                        </div>
                        <div class="input">
                            <label>Outros documentos:</label>
                            <input type="text" id="documentoEspecifico" name="documentoEspecifico" placeholder="Especifique o documento">
                        </div>
                        <div class="input input-right">
                            <label>Observações:</label>
                            <input type="text" id="observacoes" placeholder="Instruções ou observações adicionais">
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="next" id="filterUsers">Especificar Usuários</button>
                        <button type="submit" class="salvar">Solicitar</button>
                    </div>
                </fieldset>

                <!-- Quarto grupo de inputs -->
            <fieldset class="step">
                <div class="box-legend">
                    <legend class="legend1" style="color: #1f0c8a;">Dados de Identificação</legend>
                    <div class="line-legend line1" style="background-color: #1f0c8a;"></div>
                </div>
                <div class="box-inputs">
                <div class="input">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome Completo">
                </div>
                <div class="input">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="CPF">
                </div>
                <div class="input">
                    <label for="serie">Série/Sala:</label>
                    <input type="text" id="serie" name="serie" placeholder="Série/Sala (ex: 3B)">
                </div>
                <div class="input">
                    <label for="matricula">ID/Nº Matrícula:</label>
                    <input type="text" id="matricula" name="matricula" placeholder="ID/Nº Matrícula">
                </div>
                </div>
                <div class="box-buttons">
                    <button type="button" class="prev">Voltar</button>
                    <button type="submit" class="next">Filtrar</button>
                </div>
            </fieldset>

                <!-- Segundo grupo de inputs -->
            <fieldset class="step fildset-container">
                <div class="box-legend">
                    <legend class="legend2">Lista de Usuários Filtrados</legend>
                    <div class="line-legend line2"></div>
                </div>
                <div class="box-inputs">
                    <ul id="lista-usuarios" class="filtered-users">
                        <!-- Lista dinâmica será preenchida aqui -->
                    </ul>
                </div>
                <div class="box-buttons">
                    <button type="button" class="prev">Voltar</button>
                    <button type="submit" class="salvar">Confirmar</button>
                </div>
            </fieldset>

            </div>
            
        </section>
    </main>

    <script>
// Dados de exemplo para usuários
const usuarios = [
  { nome: "João Silva", cpf: "12345678901", serie: "3B", matricula: "001", tipo: "alunos" },
  { nome: "Maria Souza", cpf: "23456789012", serie: "2A", matricula: "002", tipo: "professores" },
  { nome: "Pedro Lima", cpf: "34567890123", serie: "1C", matricula: "003", tipo: "coordenadores" },
  { nome: "Ana Clara", cpf: "45678901234", serie: "3B", matricula: "004", tipo: "alunos" },
];

// Elementos
const destinatarioSelect = document.getElementById("destinatario");
const inputs = document.querySelectorAll(".box-inputs input");
const listaUsuarios = document.getElementById("lista-usuarios");

// Função para renderizar usuários na lista
function renderizarUsuarios(lista) {
  listaUsuarios.innerHTML = ""; // Limpa a lista
  if (lista.length === 0) {
    listaUsuarios.innerHTML = "<p>Nenhum usuário encontrado</p>";
    return;
  }
  lista.forEach((usuario) => {
    const userDiv = document.createElement("div");
    userDiv.textContent = `Nome: ${usuario.nome}, CPF: ${usuario.cpf}, Série: ${usuario.serie}, Matrícula: ${usuario.matricula}, Tipo: ${usuario.tipo}`;
    listaUsuarios.appendChild(userDiv);
  });
}

// Função para filtrar usuários dinamicamente
function filtrarUsuarios() {
  // Valor do select
  const destinatario = destinatarioSelect.value;

  // Valores dos inputs
  const nome = document.getElementById("nome").value.toLowerCase();
  const cpf = document.getElementById("cpf").value;
  const serie = document.getElementById("serie").value.toLowerCase();
  const matricula = document.getElementById("matricula").value;

  // Filtra a lista de usuários
  const usuariosFiltrados = usuarios.filter((usuario) => {
    return (
      (destinatario === "todos" || usuario.tipo === destinatario) &&
      (nome === "" || usuario.nome.toLowerCase().includes(nome)) &&
      (cpf === "" || usuario.cpf.includes(cpf)) &&
      (serie === "" || usuario.serie.toLowerCase().includes(serie)) &&
      (matricula === "" || usuario.matricula.includes(matricula))
    );
  });

  renderizarUsuarios(usuariosFiltrados);
}

// Eventos
destinatarioSelect.addEventListener("change", filtrarUsuarios);
inputs.forEach((input) => input.addEventListener("input", filtrarUsuarios));

// Inicializa com todos os usuários
renderizarUsuarios(usuarios);

    </script>

    <script src="../../../assets/js/diretor/cursos/criar.js"></script>
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
</body>
</html>
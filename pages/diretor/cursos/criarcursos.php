<?php
require '../../../php/global/cabecario2.php';
require_once '../../../php/login/validar.php';

// ** Consulta para listar professores ** //
$professores = [];
$sqlProfessores = "SELECT id, nome FROM usuarios WHERE cargo = 'professor' "; // Ajuste a tabela conforme necessário
$resultProfessores = $conn->query($sqlProfessores);

if ($resultProfessores) {
    while ($row = $resultProfessores->fetch_assoc()) {
        $professores[] = $row; // Adiciona ao array
    }
} else {
    echo "Erro na consulta de professores: " . $conn->error;
}

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
                        
                            <a href="../dashboard.php" class="nav__link">
                                <i class='bx bx-trending-up nav__icon'></i>
                                <span class="nav__name">Dashboard</span>
                            </a>
                        </div>
  
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Gerenciamento</h3>
  
                            <a href="../usuarios/gerenuser.php" class="nav__link">
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
                                      <a href="cursos.php" class="nav__dropdown-item">Home</a>
                                      <a href="editarcursos.php" class="nav__dropdown-item">Editar</a>
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
            <div class="box-left">
                <img src="../../../assets/img/diretor/cursos/criar/11285789.jpg" alt="">
            </div>
            <form action="../../../php/diretor/cadastrar_curso.php" method="post" class="form-container" enctype="multipart/form-data">
                <!-- Primeiro grupo de inputs -->
                <fieldset class="step active">
                    <div class="box-legend">
                        <legend class="legend1">Informações Básicas</legend>
                        <div class="line-legend line1"></div>
                    </div>
                            <label for="imagem" class="circle">
                                <input type="file" id="imagem" name="imagem" accept="image/*" required onchange="previewImage(event)" style="z-index: 1;">
                                <img id="imagemDisplay" class="image-circle" src="adicionar-icone-adicionar-foto-de-video-de-postagem-imagens-vetoriais_292645-294.avif" alt="Imagem Selecionada">
                            </label>


                    <div class="box-inputs">
                        <div class="input">
                            <label for="nome_curso">Nome do Curso:</label>
                            <input type="text" id="nome_curso" name="nome_curso" placeholder="Digite o nome do curso" required>
                        </div>
                        <div class="input input-right">
                            <label for="codigo">Código:</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Digite o código do curso" required>
                        </div>
                        <div class="input">
                            <label for="dias-curso">Dias de Aula:</label>
                            <select id="dias-curso" name="dias-curso" required>
                                <option value="">Selecione os dias</option>
                                <option value="segunda-feira">Segunda-feira</option>
                                <option value="terça-feira">Terça-feira</option>
                                <option value="quarta-feira">Quarta-feira</option>
                                <option value="quinta-feira">Quinta-feira</option>
                                <option value="sexta-feira">Sexta-feira</option>
                                <option value="sabado">Sábado</option>
                                <option value="domingo">Domingo</option>
                                <option value="segunda-quarta-sexta">Segunda, Quarta e Sexta</option>
                                <option value="terça-quinta">Terça e Quinta</option>
                                <option value="segunda-sexta">Segunda e Sexta</option>
                                <option value="segunda-terça-quarta-quinta-sexta">Segunda a Sexta (todos os dias úteis)</option>
                                <option value="sabado-domingo">Sábado e Domingo</option>
                            </select>
                        </div>
                        <div class="input">
                            <label for="departamento">Departamento:</label>
                            <input type="text" id="departamento" name="departamento" placeholder="Digite o departamento" required>
                        </div>
                        <div class="input input-right">
                            <label for="carga_horaria">Carga Horária:</label>
                            <input type="number" id="carga_horaria" name="carga_horaria" placeholder="Ex: 40h" min="1" required>
                        </div>
                   
                    </div>
            
                    </div>
                    
                    <div class="box-buttons">
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
        
                <!-- Segundo grupo de inputs -->
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend2">Detalhes do Curso</legend>
                        <div class="line-legend line2"></div>
                    </div>
                    <div class="box-inputs">
                        <div class="input">
                            <label for="tipo_curso">Tipo de Curso:</label>
                            <select id="tipo-curso" name="tipo_curso" required>
                                <option value="presencial">Presencial</option>
                                <option value="online">Online</option>
                                <option value="semipresencial">Semipresencial</option>
                            </select>
                        </div>
                        <div class="input input-right">
                            <label for="nivel_curso">Nível do Curso:</label>
                            <select id="nivel-curso" name="nivel_curso" required>
                                <option value="basico">Básico</option>
                                <option value="intermediario">Intermediário</option>
                                <option value="avancado">Avançado</option>
                            </select>
                        </div>
                        <div class="input">
                            <label for="periodo">Período/Semestre:</label>
                            <input type="text" id="periodo" name="periodo" placeholder="Ex: 1º Semestre de 2024" required>
                        </div>
                        <div class="input input-right">
                            <label for="professor">Professor/Instrutor:</label>
                            <select id="professor" name="professor" required>
                                <option value="">Selecione um professor</option>
                                <?php foreach ($professores as $professor): ?>
                                    <option value="<?= $professor['id']; ?>"><?= htmlspecialchars($professor['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>


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
                        <legend class="legend3">Descrição e Metodologia</legend>
                        <div class="line-legend line3"></div>
                    </div>
                    
                    <div class="box-inputs">
                        <div class="input">
                            <label for="descricao">Descrição:</label>
                            <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o curso" required></textarea>
                        </div>
                        <div class="input input-right">
                            <label for="metodologia">Metodologia:</label>
                            <textarea id="metodologia" name="metodologia" rows="3" placeholder="Explique a metodologia do curso"></textarea>
                        </div>
                        <div class="input">
                            <label for="objetivos_curso">Objetivos do Curso:</label>
                            <textarea id="objetivos-curso" name="objetivos_curso" rows="3" placeholder="Descreva os objetivos do curso"></textarea>
                        </div>
                        <div class="input input-right">
                            <label for="pre_requisitos">Pré-requisitos:</label>
                            <input type="text" id="pre-requisitos" name="pre_requisitos" placeholder="Digite os pré-requisitos">
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
                        <legend class="legend4">Avaliação e Recursos</legend>
                        <div class="line-legend line4"></div>
                    </div>
                   
                    <div class="box-inputs">
                        <div class="input">
                            <label for="criterios_avaliacao">Critérios:</label>
                            <textarea id="criterios-avaliacao" name="criterios_avaliacao" rows="3" placeholder="Descreva os critérios de avaliação"></textarea>
                        </div>
                        <div class="input input-right">
                            <label for="material_recurso">Material e Recurso:</label>
                            <textarea id="material-recurso" name="material_recurso" rows="3" placeholder="materiais e recursos necessários"></textarea>
                        </div>
                        <div class="input">
                            <label for="modalidade">Modalidade:</label>
                            <input type="text" id="modalidade" name="modalidade" placeholder="Ex: EAD, Presencial" required>
                        </div>
                        <div class="input input-right">
                            <label for="vagas">Vagas Disponíveis:</label>
                            <input type="number" id="vagas" name="vagas" min="1" placeholder="Ex: 30" required>
                        </div>
                    </div>
                    <div class="box-buttons">
                        <button type="button" class="prev">Voltar</button>
                        <button type="button" class="next">Próximo</button>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <div class="box-legend">
                        <legend class="legend-img">Personalização</legend>
                        <div class="line-legend line-img"></div>
                    </div>
                   
                    <div class="box-img-curso">
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img1.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img2.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img3.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img4.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img5.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img6.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img7.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img8.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img9.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img10.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img11.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img12.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img13.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img14.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img15.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img16.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img17.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img18.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img19.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img20.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img21.PNG" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img22.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img23.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img24.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img25.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img26.jpg" alt="">
                        </div>
                        <div class="box-img">
                            <img src="../../../assets/img/diretor/cursos/img-criar-curso/img27.PNG" alt="">
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
                        <legend class="legend5">Datas e Status</legend>
                        <div class="line-legend line5"></div>
                    </div>
                   
                    <div class="box-inputs">
                        <div class="input">
                            <label for="data_inicio">Data de Início:</label>
                            <input type="date" id="data-inicio" name="data_inicio" required>
                        </div>
                        <div class="input input-right">
                            <label for="data_termino">Data de Término:</label>
                            <input type="date" id="data-termino" name="data_termino" required>
                        </div>
                        <div class="input">
                            <label for="status_curso">Status do Curso:</label>
                            <select id="status-curso" name="status_curso" required>
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <div class="input input-right">
                            <label for="observacoes">Observações:</label>
                            <textarea id="observacoes" name="observacoes" rows="3" placeholder="Ex: requer participação ativa em atividades práticas"></textarea>
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
    <script src="../../../assets/js/diretor/cursos/criar.js"></script>
    <script src="../../../assets/js/diretor/global/navgation.js"></script>
    <script src="../../../assets/js/diretor/global/dropdown.js"></script>
    <script>
function previewImage(event) {
    const imageDisplay = document.getElementById('imagemDisplay');
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
    imageDisplay.src = e.target.result; // Atualiza a imagem no círculo
    }
if (file) {
        reader.readAsDataURL(file); // Lê a imagem como URL
    }
}
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
</body>
</html>
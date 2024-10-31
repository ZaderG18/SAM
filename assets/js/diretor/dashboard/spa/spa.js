// Objetos com os conteúdos de cada seção

  const contentData = {
    coordenador: {
      main: `
      <section class="dashboard active">
                    <div class="flex-box-dashboard">
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/docente02.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Alunos matriculados</span>
                                    <h3>350</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
    
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/student.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Matrículas pendentes ou canceladas</span>
                                    <h3>78</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
    
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/curso.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Risco de evasão</span>
                                    <h3>10</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
                    </div>
                </section>
                <section class="section-registro">
                      <h3>Últimos registros</h3>
                    <div class="table-container">
                        <table>
                          <thead>
                            <tr>
                              <th>Nome</th>
                              <th>Matrícula</th>
                              <th>Gênero</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td data-label="Nome">Ana Souza</td>
                              <td data-label="Matrícula">20231001</td>
                              <td data-label="Gênero">Feminino</td>
                            </tr>
                            <tr>
                              <td data-label="Nome">Carlos Santos</td>
                              <td data-label="Matrícula">20231002</td>
                              <td data-label="Gênero">Masculino</td>
                            </tr>
                            <tr>
                              <td data-label="Nome">Mariana Oliveira</td>
                              <td data-label="Matrícula">20231003</td>
                              <td data-label="Gênero">Feminino</td>
                            </tr>
                            <tr>
                                <td data-label="Nome">Ana Souza</td>
                                <td data-label="Matrícula">20231001</td>
                                <td data-label="Gênero">Feminino</td>
                              </tr>
                              <tr>
                                <td data-label="Nome">Carlos Santos</td>
                                <td data-label="Matrícula">20231002</td>
                                <td data-label="Gênero">Masculino</td>
                              </tr>
                              <tr>
                                <td data-label="Nome">Mariana Oliveira</td>
                                <td data-label="Matrícula">20231003</td>
                                <td data-label="Gênero">Feminino</td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                </section>
      `,
      aside: `
        <h3>Últimos Acessos</h3>
        <div class="aluno">David Richard - 3º Desenvolvimento de Sistemas</div>
        <div class="aluno">Ana Souza - 2º Redes de Computadores</div>
      `
    },
    aluno: {
      main: `
      <section class="dashboard">
                    <div class="flex-box-dashboard">
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/docente02.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Alunos matriculados</span>
                                    <h3>350</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
    
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/student.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Matrículas pendentes ou canceladas</span>
                                    <h3>78</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
    
                        <div class="box-dashboard">
                            <div class="box-icon">
                                <img src="../../assets/img/dashboard/curso.svg" alt="" srcset="">
                            </div><!--box-icon-->
                            <div class="box-flex-dados">
                                <div class="dados">
                                    <span>Risco de evasão</span>
                                    <h3>10</h3>
                                </div><!--dados-->
                                <!-- <div class="grafico"></div> -->
                            </div><!--box-flex-dados-->
                            <!-- <span >últimas 24 horas</span> -->
                        </div>
                    </div>
                </section>
                <section class="section-registro">
                        <h3>Últimos registros</h3>
                    <div class="table-container">
                        <table>
                          <thead>
                            <tr>
                              <th>Nome</th>
                              <th>Matrícula</th>
                              <th>Gênero</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td data-label="Nome">Ana Souza</td>
                              <td data-label="Matrícula">20231001</td>
                              <td data-label="Gênero">Feminino</td>
                            </tr>
                            <tr>
                              <td data-label="Nome">Carlos Santos</td>
                              <td data-label="Matrícula">20231002</td>
                              <td data-label="Gênero">Masculino</td>
                            </tr>
                            <tr>
                              <td data-label="Nome">Mariana Oliveira</td>
                              <td data-label="Matrícula">20231003</td>
                              <td data-label="Gênero">Feminino</td>
                            </tr>
                            <tr>
                                <td data-label="Nome">Ana Souza</td>
                                <td data-label="Matrícula">20231001</td>
                                <td data-label="Gênero">Feminino</td>
                              </tr>
                              <tr>
                                <td data-label="Nome">Carlos Santos</td>
                                <td data-label="Matrícula">20231002</td>
                                <td data-label="Gênero">Masculino</td>
                              </tr>
                              <tr>
                                <td data-label="Nome">Mariana Oliveira</td>
                                <td data-label="Matrícula">20231003</td>
                                <td data-label="Gênero">Feminino</td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                </section>
      `,
      aside: `
        <h3>Últimos Acessos</h3>
        <div class="aluno">David Richard - 3º Desenvolvimento de Sistemas</div>
        <div class="aluno">Ana Souza - 2º Redes de Computadores</div>
      `
    },
    professor: {
      main: `
      <section class="dashboard">
      <div class="flex-box-dashboard docente">
          <div class="box-dashboard">
              <div class="box-icon">
                  <img src="../../assets/img/dashboard/docente02.svg" alt="" srcset="">
              </div><!--box-icon-->
              <div class="box-flex-dados">
                  <div class="dados">
                      <span>Professores ativos</span>
                      <h3>15</h3>
                  </div><!--dados-->
                  <!-- <div class="grafico"></div> -->
              </div><!--box-flex-dados-->
              <!-- <span >últimas 24 horas</span> -->
          </div>

          <div class="box-dashboard">
              <div class="box-icon">
                  <img src="../../assets/img/dashboard/student.svg" alt="" srcset="">
              </div><!--box-icon-->
              <div class="box-flex-dados">
                  <div class="dados">
                      <span> aguardando alocação em cursos</span>
                      <h3>6</h3>
                  </div><!--dados-->
                  <!-- <div class="grafico"></div> -->
              </div><!--box-flex-dados-->
              <!-- <span >últimas 24 horas</span> -->
          </div>
      </div>
  </section>
  <section class="section-registro">
          <h3>Últimos registros</h3>
      <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Teste</th>
                <th>Teste</th>
                <th>Teste</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Nome">Ana Souza</td>
                <td data-label="Matrícula">20231001</td>
                <td data-label="Gênero">Feminino</td>
              </tr>
              <tr>
                <td data-label="Nome">Carlos Santos</td>
                <td data-label="Matrícula">20231002</td>
                <td data-label="Gênero">Masculino</td>
              </tr>
              <tr>
                <td data-label="Nome">Mariana Oliveira</td>
                <td data-label="Matrícula">20231003</td>
                <td data-label="Gênero">Feminino</td>
              </tr>
              <tr>
                  <td data-label="Nome">Ana Souza</td>
                  <td data-label="Matrícula">20231001</td>
                  <td data-label="Gênero">Feminino</td>
                </tr>
                <tr>
                  <td data-label="Nome">Carlos Santos</td>
                  <td data-label="Matrícula">20231002</td>
                  <td data-label="Gênero">Masculino</td>
                </tr>
                <tr>
                  <td data-label="Nome">Mariana Oliveira</td>
                  <td data-label="Matrícula">20231003</td>
                  <td data-label="Gênero">Feminino</td>
                </tr>
            </tbody>
          </table>
        </div>
  </section>
      `,
      aside: `
        <h3>Alunos com Risco de Evasão</h3>
        <div class="aluno">Carlos Santos - 3º Desenvolvimento de Sistemas</div>
      `
    },
    curso: {
      main: `
      <section class="dashboard">
      <div class="flex-box-dashboard">
          <div class="box-dashboard">
              <div class="box-icon">
                  <img src="../../assets/img/dashboard/docente02.svg" alt="" srcset="">
              </div><!--box-icon-->
              <div class="box-flex-dados">
                  <div class="dados">
                      <span>Alunos matriculados</span>
                      <h3>350</h3>
                  </div><!--dados-->
                  <!-- <div class="grafico"></div> -->
              </div><!--box-flex-dados-->
              <!-- <span >últimas 24 horas</span> -->
          </div>

          <div class="box-dashboard">
              <div class="box-icon">
                  <img src="../../assets/img/dashboard/student.svg" alt="" srcset="">
              </div><!--box-icon-->
              <div class="box-flex-dados">
                  <div class="dados">
                      <span>Matrículas pendentes ou canceladas</span>
                      <h3>78</h3>
                  </div><!--dados-->
                  <!-- <div class="grafico"></div> -->
              </div><!--box-flex-dados-->
              <!-- <span >últimas 24 horas</span> -->
          </div>

          <div class="box-dashboard">
              <div class="box-icon">
                  <img src="../../assets/img/dashboard/curso.svg" alt="" srcset="">
              </div><!--box-icon-->
              <div class="box-flex-dados">
                  <div class="dados">
                      <span>Risco de evasão</span>
                      <h3>10</h3>
                  </div><!--dados-->
                  <!-- <div class="grafico"></div> -->
              </div><!--box-flex-dados-->
              <!-- <span >últimas 24 horas</span> -->
          </div>
      </div>
  </section>
  <section class="section-registro">
           <h3>Últimos registros</h3>
      <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Matrícula</th>
                <th>Gênero</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="Nome">Ana Souza</td>
                <td data-label="Matrícula">20231001</td>
                <td data-label="Gênero">Feminino</td>
              </tr>
              <tr>
                <td data-label="Nome">Carlos Santos</td>
                <td data-label="Matrícula">20231002</td>
                <td data-label="Gênero">Masculino</td>
              </tr>
              <tr>
                <td data-label="Nome">Mariana Oliveira</td>
                <td data-label="Matrícula">20231003</td>
                <td data-label="Gênero">Feminino</td>
              </tr>
              <tr>
                  <td data-label="Nome">Ana Souza</td>
                  <td data-label="Matrícula">20231001</td>
                  <td data-label="Gênero">Feminino</td>
                </tr>
                <tr>
                  <td data-label="Nome">Carlos Santos</td>
                  <td data-label="Matrícula">20231002</td>
                  <td data-label="Gênero">Masculino</td>
                </tr>
                <tr>
                  <td data-label="Nome">Mariana Oliveira</td>
                  <td data-label="Matrícula">20231003</td>
                  <td data-label="Gênero">Feminino</td>
                </tr>
            </tbody>
          </table>
        </div>
  </section>
      `,
      aside: `
        <h3>Informações de Cursos</h3>
        <p>Total de cursos ativos: 10</p>
      `
    }
  };

  // Função para carregar conteúdo dinamicamente
  function loadContent(section) {
    const mainContent = document.getElementById('main-content');
    const asideContent = document.getElementById('aside-content');

    mainContent.innerHTML = contentData[section].main;
    asideContent.innerHTML = contentData[section].aside;
  }

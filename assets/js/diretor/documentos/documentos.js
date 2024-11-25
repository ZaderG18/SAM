 // Função para mostrar/esconder o filtro de usuários específicos
 function toggleSpecificUsers() {
  const specificUserFilter = document.getElementById("specificUserFilter");
  const isChecked = document.getElementById("usuariosEspecificos").checked;
  specificUserFilter.style.display = isChecked ? "block" : "none";
  
  if (!isChecked) {
      document.getElementById("userList").innerHTML = ""; // Limpa a lista ao desmarcar
  }
}

// Lista de exemplo com usuários (normalmente viriam do banco de dados)
const todosUsuarios = [
  { id: 1, nome: "João Silva", cpf: "123.456.789-10", serie: "3B", curso: "Informática", tipo: "aluno" },
  { id: 2, nome: "Maria Souza", cpf: "987.654.321-00", serie: "2A", curso: "Administração", tipo: "coordenador" },
  { id: 3, nome: "Pedro Santos", cpf: "111.222.333-44", serie: "1A", curso: "Matemática", tipo: "coordenador" },
  { id: 4, nome: "Ana Costa", cpf: "444.555.666-77", serie: "3B", curso: "Educação Física", tipo: "professor" },
  { id: 5, nome: "Lucas Oliveira", cpf: "222.333.444-55", serie: "2B", curso: "Biologia", tipo: "aluno" },
  { id: 1, nome: "João Silva", cpf: "123.456.789-10", serie: "3B", curso: "Informática", tipo: "aluno" },
  { id: 2, nome: "Maria Souza", cpf: "987.654.321-00", serie: "2A", curso: "Administração", tipo: "coordenador" },
  { id: 3, nome: "Pedro Santos", cpf: "111.222.333-44", serie: "1A", curso: "Matemática", tipo: "coordenador" },
  { id: 4, nome: "Ana Costa", cpf: "444.555.666-77", serie: "3B", curso: "Educação Física", tipo: "professor" },
  { id: 5, nome: "Lucas Oliveira", cpf: "222.333.444-55", serie: "2B", curso: "Biologia", tipo: "aluno" },
  { id: 1, nome: "João Silva", cpf: "123.456.789-10", serie: "3B", curso: "Informática", tipo: "aluno" },
  { id: 2, nome: "Maria Souza", cpf: "987.654.321-00", serie: "2A", curso: "Administração", tipo: "coordenador" },
  { id: 3, nome: "Pedro Santos", cpf: "111.222.333-44", serie: "1A", curso: "Matemática", tipo: "coordenador" },
  { id: 4, nome: "Ana Costa", cpf: "444.555.666-77", serie: "3B", curso: "Educação Física", tipo: "professor" },
  { id: 5, nome: "Lucas Oliveira", cpf: "222.333.444-55", serie: "2B", curso: "Biologia", tipo: "aluno" },
  // ... outros usuários
];

// Função para atualizar a lista de usuários em tempo real
function atualizarListaUsuarios() {
  const userList = document.getElementById("userList");
  userList.innerHTML = ""; // Limpa a lista antes de exibir novos resultados

  // Filtros selecionados
  const filtroNome = document.getElementById("nome").value.toLowerCase();
  const filtroCPF = document.getElementById("cpf").value;
  const filtroSerie = document.getElementById("serie").value.toLowerCase();
  const filtroCurso = document.getElementById("curso").value.toLowerCase();
  const isAlunosSelected = document.getElementById("alunos").checked;
  const isProfessoresSelected = document.getElementById("professores").checked;
  const isCoordenadoresSelected = document.getElementById("coordenadores").checked;
  const isUsuariosEspecificosSelected = document.getElementById("usuariosEspecificos").checked;

  // Filtra os usuários de acordo com os critérios selecionados
  const usuariosFiltrados = todosUsuarios.filter(usuario => {
      // Verifica se o usuário corresponde ao tipo selecionado
      const isTipoCorreto = 
          (isAlunosSelected && usuario.tipo === "aluno") ||
          (isProfessoresSelected && usuario.tipo === "professor") ||
          (isCoordenadoresSelected && usuario.tipo === "coordenador") ||
          (isUsuariosEspecificosSelected && usuario.tipo !== "coordenador");

      // Verifica os filtros específicos
      const isNomeCorreto = usuario.nome.toLowerCase().includes(filtroNome);
      const isCPFCorreto = !filtroCPF || usuario.cpf.includes(filtroCPF);
      const isSerieCorreta = !filtroSerie || usuario.serie.toLowerCase().includes(filtroSerie);
      const isCursoCorreto = !filtroCurso || usuario.curso.toLowerCase().includes(filtroCurso);

      // Retorna true se todos os filtros forem atendidos
      return isTipoCorreto && isNomeCorreto && isCPFCorreto && isSerieCorreta && isCursoCorreto;
  });

  // Exibe os usuários que se encaixam nos filtros aplicados
  usuariosFiltrados.forEach(usuario => {
      const userItem = document.createElement("div");
      userItem.classList.add("user-item");
      userItem.innerHTML = `
          <span>${usuario.nome} - ${usuario.serie} - ${usuario.curso}</span>
          <div class="user-modal">
              <p><strong>Nome:</strong> ${usuario.nome}</p>
              <p><strong>CPF:</strong> ${usuario.cpf}</p>
              <p><strong>Série/Sala:</strong> ${usuario.serie}</p>
              <p><strong>Curso:</strong> ${usuario.curso}</p>
          </div>
      `;
      userList.appendChild(userItem);
  });
}

// Função para enviar a solicitação
function enviarSolicitacao() {
  alert("Solicitação enviada com sucesso!");
}

// Função para limpar o formulário e resetar a interface
function limparFormulario() {
  document.querySelector("form").reset();
  document.getElementById("specificUserFilter").style.display = "none";
  document.getElementById("userList").innerHTML = "";
}

// Adiciona o evento de atualização para cada input de filtro
document.getElementById("nome").addEventListener("input", atualizarListaUsuarios);
document.getElementById("cpf").addEventListener("input", atualizarListaUsuarios);
document.getElementById("serie").addEventListener("input", atualizarListaUsuarios);
document.getElementById("curso").addEventListener("input", atualizarListaUsuarios);
document.getElementById("alunos").addEventListener("change", atualizarListaUsuarios);
document.getElementById("professores").addEventListener("change", atualizarListaUsuarios);
document.getElementById("coordenadores").addEventListener("change", atualizarListaUsuarios);
document.getElementById("usuariosEspecificos").addEventListener("change", atualizarListaUsuarios);


const selectedDocumento = document.getElementById('selectedDocumento');
const documentoOptions = document.getElementById('documentoOptions');

// Mostrar opções ao clicar
selectedDocumento.addEventListener('click', () => {
    documentoOptions.style.display = documentoOptions.style.display === 'block' ? 'none' : 'block';
});

// Fechar opções ao clicar em um documento e atualizar o texto do campo selecionado
documentoOptions.querySelectorAll('div').forEach(option => {
    option.addEventListener('click', () => {
        selectedDocumento.textContent = option.textContent; // Atualiza o texto selecionado
        documentoOptions.style.display = 'none'; // Oculta opções após a seleção
    });
});

// Ocultar opções ao clicar fora do dropdown
document.addEventListener('click', (event) => {
    if (!selectedDocumento.contains(event.target) && !documentoOptions.contains(event.target)) {
        documentoOptions.style.display = 'none'; // Oculta as opções
    }
});
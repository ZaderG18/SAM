const atividades = {};
const lembretes = {};

// Função de criação do calendario

function criarCalendario(){
    let calendario = document.getElementById('calendario');
    const mesAtual = new Date();
    const mes = mesAtual.getMonth();
    const ano = mesAtual.getFullYear();

    //Primeiro dia do mês
    const primeiroDia = new Date(ano, mes, 1);
    const diasNoMes = new Date(ano, mes + 1, 0).getDate();
    const semana = primeiroDia.getDay();

    //dias em branco para alinhamento do primeiro dia
    calendario.innerHTML = '';
    for (let i = 0; i < semana; i++) {
        const diaEmBranco = document.createElement('div');
        calendario.appendChild(diaEmBranco);
    }

    //adiciona dia no mês
    for (let dia = 1; dia <= diasNoMes; dia++){
        const diaDoMes = document.createElement('div');
        diaDoMes.className = 'dia';
        diaDoMes.innerText = dia;
        const data = `${ano}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
        diaDoMes.setAttribute('data-data', data);


        //Adiciona o lembrete ou atividade caso exista
        if(tipo === 'professor'){
            if(atividades[data]){
                const atividade = document.createElement('div');
                atividade.className = 'atividade';
                atividade.innerText = atividades[data];
                diaDoMes.appendChild(atividade);
                }
        
        diaDoMes.addEventListener('click', () =>{
            editarAtividade(data);
        });
    }else {
        if(lembretes[data]){
            const lembrete = document.createElement('div');
            lembrete.className = 'lembrete';
            lembrete.innerText = lembretes[data];
            diaDoMes.appendChild(lembrete);
            }
            diaDoMes.addEventListener('click', () =>{
                editarLembrete(data);
                });
    }
    calendario.appendChild(diaDoMes);
    }

}
function editarAtividade(data){
    document.getElementById('dataAtividade').value = data;
    document.getElementById('atividade').value = atividades[data] || '';
    document.getElementById('formularioProfessor').classList.remove('hidden');
}

// Função para salvar atividade do Professor
function salvarAtividade(){
    const data = document.getElementById('dataAtividade').value;
    const atividade = document.getElementById('atividade').value;
        
    atividades[data] = atividade;
    criarCalendario(document.getElementById('calendarioProfessor'), 'professor'); // atualiza o calendario
    document.getElementById('formularioProfessor').classList.add('hidden');
}

// Função para editar lembrete do aluno
function editarLembrete(data){
    document.getElementById('dataLembrete').value = data;
    document.getElementById('lembrete').value = lembretes[data] || '';
    document.getElementById('formularioAluno').classList.remove('hidden');
}

// Função para salvar lembrete do aluno
function salvarLembrete(){
    const data = document.getElementById('dataLembrete').value;
    const lembrete = document.getElementById('lembrete').value;

    lembretes[data] = lembrete; // salva o lembrete
    criarCalendario(document.getElementById('calendarioAluno'), 'aluno'); // atualiza o calendario do aluno
    document.getElementById('formularioAluno').classList.add('hidden'); // Esconde o formulario
}

// Função para cancelar a edição
function cancelar(formulario){
    document.getElementById(formulario).classList.add('hidden');
}

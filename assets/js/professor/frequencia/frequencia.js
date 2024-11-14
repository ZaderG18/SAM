document.addEventListener("DOMContentLoaded", function () {
    carregarOpcoes();
    document.getElementById('turma').addEventListener('change', carregarAlunos);
    document.getElementById('materia').addEventListener('change', carregarAlunos);
});

function carregarOpcoes() {
    fetch('../../../../php/professor/chamada.php?acao=carregarFiltros')
        .then(response => response.json())
        .then(data => {
            const turmaSelect = document.getElementById('turma');
            const materiaSelect = document.getElementById('materia');

            turmaSelect.innerHTML = '<option value="">Selecione a Turma</option>';
            data.turmas.forEach(turma => {
                turmaSelect.innerHTML += `<option value="${turma.id}">${turma.nome}</option>`;
            });

            materiaSelect.innerHTML = '<option value="">Selecione a Matéria</option>';
            data.materias.forEach(materia => {
                materiaSelect.innerHTML += `<option value="${materia.id}">${materia.nome_disciplina}</option>`;
            });
        })
        .catch(error => console.error('Erro ao carregar filtros:', error));
}

function carregarAlunos() {
    const turmaId = document.getElementById('turma').value;
    const materiaId = document.getElementById('materia').value;

    if (turmaId && materiaId) {
        fetch(`../../../../php/professor/chamada.php?acao=carregarAlunos&turma=${turmaId}&materia=${materiaId}`)
            .then(response => response.json())
            .then(alunos => {
                const tbody = document.querySelector("tbody");
                tbody.innerHTML = ''; // Limpar a tabela antes de adicionar novos alunos

                alunos.forEach((aluno, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${aluno.nome}</td>
                            <td class="status">
                                <button onclick="marcarPresenca(this, ${aluno.id})">Presente</button>
                                <button onclick="marcarAusencia(this, ${aluno.id})">Ausente</button>
                            </td>
                            <td><textarea placeholder="Adicionar observação"></textarea></td>
                            <td class="actions">
                                <button class="edit" onclick="editarStatus(this)">Editar</button>
                            </td>
                        </tr>`;
                });
            })
            .catch(error => console.error('Erro ao carregar alunos:', error));
    }
}

function marcarPresenca(button, alunoId) {
    atualizarStatus(button, alunoId, 1);
}

function marcarAusencia(button, alunoId) {
    atualizarStatus(button, alunoId, 0);
}

function editarStatus(button) {
    const statusCell = button.parentNode.previousElementSibling.previousElementSibling;
    statusCell.innerHTML = `
        <button onclick="marcarPresenca(this)">Presente</button>
        <button onclick="marcarAusencia(this)">Ausente</button>
    `;
}

// Função para salvar o status de presença no banco de dados
function atualizarStatus(button, alunoId, presente) {
    const observacao = button.closest("tr").querySelector("textarea").value;
    
    fetch('../../../../php/professor/chamada.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            acao: 'marcarPresenca',
            alunoId: alunoId,
            presente: presente,
            observacao: observacao
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            button.parentNode.innerHTML = presente ? 
                "<span style='color:green;'>Presente</span>" : 
                "<span style='color:red;'>Ausente</span>";
        } else {
            alert('Erro ao salvar presença!');
        }
    })
    .catch(error => console.error('Erro ao atualizar presença:', error));
}

function salvarChamada() {
    alert('Chamada salva com sucesso!');
}

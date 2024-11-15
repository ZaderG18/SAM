document.addEventListener("DOMContentLoaded", function () {
    carregarFiltros();
    document.getElementById('turma').addEventListener('change', carregarAlunos);
    document.getElementById('materia').addEventListener('change', carregarAlunos);
});

function carregarFiltros() {
    fetch('../../../../php/professor/chamada.php?acao=carregarFiltros')
        .then(response => response.json())
        .then(data => {
            const turmaSelect = document.getElementById('turma');
            const materiaSelect = document.getElementById('materia');

            // Preencher turmas
            turmaSelect.innerHTML = '<option value="">Selecione a Turma</option>';
            data.turmas.forEach(turma => {
                turmaSelect.innerHTML += `<option value="${turma.id}">${turma.nome}</option>`;
            });

            // Preencher matérias
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
                const tbody = document.getElementById('tabela-alunos');
                tbody.innerHTML = '';

                alunos.forEach((aluno, index) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${aluno.nome}</td>
                            <td>
                                <button onclick="marcarPresenca(this, ${aluno.id}, 1)">Presente</button>
                                <button onclick="marcarPresenca(this, ${aluno.id}, 0)">Ausente</button>
                            </td>
                            <td><textarea placeholder="Adicionar observação"></textarea></td>
                        </tr>`;
                });
            })
            .catch(error => console.error('Erro ao carregar alunos:', error));
    }
}

function marcarPresenca(button, alunoId, presente) {
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
    .catch(error => console.error('Erro ao marcar presença:', error));
}

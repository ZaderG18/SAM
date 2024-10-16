function openModal(modalId, className = '', studentCount = '', classSchedule = '') {
    if (modalId === 'detailsClassModal') {
        document.getElementById('className').textContent = className;
        document.getElementById('studentCount').textContent = studentCount;
        document.getElementById('classSchedule').textContent = classSchedule;
    }
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function addEvaluation() {
    const title = document.getElementById('evaluationTitle').value;
    const date = document.getElementById('evaluationDate').value;
    const weight = document.getElementById('evaluationWeight').value;
    // Lógica para salvar avaliação no banco de dados
    closeModal('addEvaluationModal');
    alert(`Avaliação "${title}" adicionada com sucesso!`);
}

function saveEditedEvaluation() {
    // Lógica para salvar as alterações da avaliação
    closeModal('editEvaluationModal');
    alert("Avaliação editada com sucesso!");
}

function addResource() {
    const title = document.getElementById('resourceTitle').value;
    const link = document.getElementById('resourceLink').value;
    // Lógica para salvar material no banco de dados
    closeModal('addResourceModal');
    alert(`Material "${title}" adicionado com sucesso!`);
}

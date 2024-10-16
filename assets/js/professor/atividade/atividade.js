document.getElementById('submit-button').addEventListener('click', function() {
    // Obter os valores dos campos de edição
    var atividadeEditada = document.getElementById('edit-activity').value;
    var novaData = document.getElementById('edit-due-date').value;

    // Simulação de envio
    console.log('Atividade Editada:', atividadeEditada);
    console.log('Nova Data de Vencimento:', novaData);

    // Lógica para salvar as alterações (aqui você integraria com o backend)
    alert('Alterações salvas com sucesso!');
});

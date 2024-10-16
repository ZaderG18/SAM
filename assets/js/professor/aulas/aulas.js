document.getElementById('launch-activity-btn').addEventListener('click', function() {
    alert('Atividade lançada com sucesso!');
    // Adicione aqui a lógica para lançar a atividade
});

document.getElementById('send-reply-btn').addEventListener('click', function() {
    alert('Resposta enviada com sucesso!');
    // Adicione aqui a lógica para enviar a resposta
});

document.getElementById('send-material-btn').addEventListener('click', function() {
    alert('Material enviado com sucesso!');
    // Adicione aqui a lógica para enviar o material
});

document.querySelectorAll('.delete-link').forEach(function(button) {
    button.addEventListener('click', function() {
        document.getElementById('delete-modal').style.display = 'block';
    });
});

document.querySelectorAll('.close').forEach(function(span) {
    span.addEventListener('click', function() {
        span.parentElement.parentElement.style.display = 'none';
    });
});

window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

document.getElementById('material-file').addEventListener('change', function() {
    document.getElementById('file-name').textContent = this.files[0].name;
    document.getElementById('file-name').style.color = 'black';
});

document.getElementById('activity-file').addEventListener('change', function() {
    document.getElementById('activity-file-name').textContent = this.files[0].name;
    document.getElementById('activity-file-name').style.color = 'black';
});

document.getElementById('confirm-delete-btn').addEventListener('click', function() {
    alert('Atividade excluída com sucesso!');
    document.getElementById('delete-modal').style.display = 'none';
    // Adicione aqui a lógica para excluir a atividade
});

document.getElementById('cancel-delete-btn').addEventListener('click', function() {
    document.getElementById('delete-modal').style.display = 'none';
});


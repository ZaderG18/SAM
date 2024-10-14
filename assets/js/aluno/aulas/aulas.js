document.querySelector('.file-label').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', function() {
    var fileName = this.files[0].name;
    document.getElementById('fileName').textContent = 'Arquivo selecionado: ' + fileName;
});

document.querySelector('.btn').addEventListener('click', function() {
    var text = document.querySelector('.forum textarea').value;
    var fileName = document.getElementById('fileName').textContent;
    if (text || fileName) {
        alert('Postado com sucesso!');
    } else {
        alert('Por favor, insira um comentário ou selecione um arquivo.');
    }
});


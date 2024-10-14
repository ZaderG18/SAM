const fileInput = document.getElementById('file-upload');
const uploadButton = document.querySelector('.file-upload-label'); // Corrigido para a classe correta
const submitButton = document.getElementById('submit-button');

// Atualiza o botão de upload com o nome do arquivo e habilita o botão de enviar
fileInput.addEventListener('change', function() {
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        uploadButton.textContent = ` ${fileName}`;
        submitButton.disabled = false; // Habilita o botão de enviar
        submitButton.style.cursor = 'pointer'; // Altera o cursor do botão de enviar
    } else {
        submitButton.disabled = true; // Desabilita o botão de enviar se não houver arquivo
        uploadButton.textContent = ' Enviar arquivo'; // Reseta o texto caso o arquivo seja removido
    }
});

// Ouvinte de evento para o clique no botão de enviar
submitButton.addEventListener('click', function() {
    if (fileInput.files.length > 0) {
        // Simula o envio do arquivo
        alert('Arquivo enviado com sucesso!');
    } else {
        alert('Por favor, selecione um arquivo antes de enviar.');
    }
});

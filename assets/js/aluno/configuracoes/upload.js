document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    const formData = new FormData();
    const fotoInput = document.getElementById('foto');

    // Adiciona o arquivo à FormData
    if (fotoInput.files.length > 0) {
        formData.append('foto', fotoInput.files[0]);

        fetch('../../php/global/upload.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('message').innerHTML = data; // Exibe a resposta do servidor
        })
        .catch(error => {
            console.error('Erro:', error);
            document.getElementById('message').innerHTML = 'Erro ao enviar a imagem.';
        });
    } else {
        document.getElementById('message').innerHTML = 'Por favor, selecione uma imagem.';
    }
});

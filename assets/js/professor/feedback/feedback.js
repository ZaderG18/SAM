
// Função para simular o download do arquivo
document.getElementById('download-file').addEventListener('click', function() {
    const fileName = 'Redação_Juliana_Santos.pdf';  // Nome do arquivo
    const link = document.createElement('a');
    link.href = `path/to/your/file/${fileName}`; // Caminho do arquivo
    link.download = fileName;  // Nome do arquivo para download
    link.click();
});

// Função para capturar o feedback e exibir um alerta de confirmação
document.getElementById('send-feedback').addEventListener('click', function() {
    const feedbackText = document.getElementById('feedback-text').value;
    
    if (feedbackText.trim() === "") {
        alert("Por favor, escreva um feedback antes de enviar.");
    } else {
        // Aqui você pode adicionar a lógica para enviar o feedback ao servidor
        alert("Feedback enviado com sucesso: " + feedbackText);
    }
});


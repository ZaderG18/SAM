document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Impede o envio tradicional do formulário
    
    const formData = new FormData(this);
    
    fetch('message_send.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Código para exibir a mensagem no chat
            console.log("Mensagem enviada com sucesso");
        } else {
            console.error("Erro ao enviar a mensagem");
        }
    })
    .catch(error => console.error('Erro:', error));
});

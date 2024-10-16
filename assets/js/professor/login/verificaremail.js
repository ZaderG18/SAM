document.getElementById('enviar').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Simulação de envio de um novo email
    alert('Um novo email de recuperação foi enviado! Verifique sua caixa de entrada.');
});

document.getElementById('voltar').addEventListener('click', function() {
    // Redireciona para a tela de login, o comportamento padrão onclick já faz isso, mas mantendo no JS
    window.location.href = 'login.html';
});

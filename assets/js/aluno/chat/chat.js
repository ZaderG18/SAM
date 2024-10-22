// start: Sidebar
const chatSidebarToggle = document.querySelector('.chat-sidebar-profile-toggle');
const chatSidebarProfile = document.querySelector('.chat-sidebar-profile');

chatSidebarToggle.addEventListener('click', function(e) {
    e.preventDefault();
    chatSidebarProfile.classList.toggle('active');
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.chat-sidebar-profile')) {
        chatSidebarProfile.classList.remove('active');
    }
});
// end: Sidebar

// start: Conversation
document.querySelectorAll('.conversation-item-dropdown-toggle').forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const dropdown = this.parentElement;
        const isActive = dropdown.classList.contains('active');

        // Remove 'active' class from all dropdowns
        document.querySelectorAll('.conversation-item-dropdown').forEach(function(i) {
            i.classList.remove('active');
        });

        // Toggle current dropdown
        if (!isActive) {
            dropdown.classList.add('active');
        }
    });
});

document.addEventListener('click', function(e) {
    if (!e.target.closest('.conversation-item-dropdown')) {
        document.querySelectorAll('.conversation-item-dropdown').forEach(function(i) {
            i.classList.remove('active');
        });
    }
});

document.querySelectorAll('.conversation-form-input').forEach(function(item) {
    item.addEventListener('input', function() {
        this.rows = Math.max(this.value.split('\n').length, 1); // Ensure at least one row
    });
});

document.querySelectorAll('[data-conversation]').forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const conversationId = this.dataset.conversation;

        document.querySelectorAll('.conversation').forEach(function(i) {
            i.classList.remove('active');
        });

        document.querySelector(conversationId).classList.add('active');
    });
});

document.querySelectorAll('.conversation-back').forEach(function(item) {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        this.closest('.conversation').classList.remove('active');
        document.querySelector('.conversation-default').classList.add('active');
    });
});

// Enviar mensagem
document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value;
    const senderId = 1; // Exemplo de ID do remetente
    const receiverId = 2; // Exemplo de ID do destinatário

    // Enviar mensagem com fetch
    fetch('../../php/global/chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ sender_id: senderId, receiver_id: receiverId, message: message })
    })
    .then(response => response.json())
    .then(response => {
        if (response.status === 'success') {
            messageInput.value = ''; // Limpar o campo de texto
            carregarMensagens();
        } else {
            alert('Falha ao enviar a mensagem');
        }
    })
    .catch(error => console.error('Erro ao enviar a mensagem:', error));
});

// Carregar mensagens
function carregarMensagens() {
    const senderId = 1;
    const receiverId = 2;

    fetch('../../php/global/chat.php?sender_id=' + senderId + '&receiver_id=' + receiverId)
        .then(response => response.json())
        .then(mensagens => {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.innerHTML = ''; // Limpar mensagens anteriores
            mensagens.forEach(function(msg) {
                const messageDiv = document.createElement('div');
                messageDiv.className = 'message';
                messageDiv.textContent = msg.message; // Usar textContent para segurança
                messagesContainer.appendChild(messageDiv);
            });
        })
        .catch(error => console.error('Erro ao carregar mensagens:', error));
}

// Verificar novas mensagens a cada 5 segundos
setInterval(carregarMensagens, 5000);

// Carregar mensagens ao iniciar
carregarMensagens();

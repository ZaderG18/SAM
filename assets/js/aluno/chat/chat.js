function openChat(user) {
    document.querySelector('.sidebarchat').style.display = 'none';
    document.querySelector('.chat-area').style.display = 'flex';
    document.getElementById('chat-person-name').textContent = user;
}

function closeChat() {
    document.querySelector('.sidebarchat').style.display = 'block';
    document.querySelector('.chat-area').style.display = 'none';
}

// Esconde a área de chat inicialmente em telas pequenas
if (window.innerWidth <= 768) {
    document.querySelector('.chat-area').style.display = 'none';
}

// Função para adicionar nova pessoa à lista de conversas
function addPerson() {
    const personName = prompt("Digite o nome da pessoa:");
    if (personName) {
        const chatList = document.querySelector('.chat-list');
        const newChatItem = document.createElement('div');
        newChatItem.className = 'chat-item';
        newChatItem.onclick = () => openChat(personName);
        newChatItem.innerHTML = `
            <img src="../../assets/img/home/fotos/default.png" alt="User" class="chat-img">
            <div class="chat-info">
                <h3>${personName}</h3>
                <p>Última mensagem...</p>
            </div>
        `;
        chatList.appendChild(newChatItem);
    }
}

// Função para enviar mensagem
function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const messageText = messageInput.value.trim();
    if (messageText) {
        const messagesContainer = document.querySelector('.messages');
        const newMessage = document.createElement('div');
        newMessage.className = 'message sent';
        const currentTime = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        newMessage.innerHTML = `
            <div class="message-content">
                <p>${messageText}</p>
                <span class="message-time">${currentTime}</span>
                <div class="message-actions">
                    <button onclick="replyMessage(this)"><i class="fas fa-reply"></i>Responder</button>
                    <button onclick="deleteMessage(this)"><i class="fas fa-trash"></i>Apagar</button>
                </div>
            </div>
        `;
        messagesContainer.appendChild(newMessage);
        messageInput.value = '';
    }
}

// Função para responder mensagem
function replyMessage(button) {
    const messageContent = button.closest('.message-content').querySelector('p').textContent;
    const messageInput = document.getElementById('message-input');
    messageInput.value = `Respondendo: ${messageContent}`;
}

// Função para apagar mensagem
function deleteMessage(button) {
    const message = button.closest('.message');
    message.remove();
}


 // Função para lidar com input de arquivo
        function handleFileInput(event) {
            const file = event.target.files[0];
            if (file) {
                const messageInput = document.getElementById('message-input');
                messageInput.value = `Arquivo: ${file.name}`;
            }
        }


        
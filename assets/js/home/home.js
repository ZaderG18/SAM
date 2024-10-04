// Selecionando os elementos
const hideButton = document.getElementById('hide-button');
const showButton = document.getElementById('show-button');
const welcomeBanner = document.getElementById('welcome-banner');

// Inicialmente, o botão de mostrar deve estar escondido
showButton.style.display = 'none';

// Função para esconder o banner
hideButton.addEventListener('click', function() {
    welcomeBanner.classList.add('hide');  // Adiciona a classe para esconder o banner
    hideButton.style.display = 'none';     // Esconde o botão "Esconder"
    showButton.style.display = 'flex';     // Mostra o botão "Mostrar"
});

// Função para mostrar o banner
showButton.addEventListener('click', function() {
    welcomeBanner.classList.remove('hide'); // Remove a classe para mostrar o banner
    hideButton.style.display = 'flex';       // Mostra o botão "Esconder"
    showButton.style.display = 'none';       // Esconde o botão "Mostrar"
});


//Calendário

document.addEventListener('DOMContentLoaded', function () {
    const monthYear = document.getElementById('monthYear');
    const daysContainer = document.getElementById('calendarDays');
    const prevButton = document.getElementById('prevMonth');
    const nextButton = document.getElementById('nextMonth');

    const months = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];

    let currentDate = new Date();
    const atividades = {
        // Exemplo de dados, você pode preenchê-los dinamicamente
        '2024-10-10': 'Reunião de equipe',
        '2024-10-15': 'Entrega de projeto',
        '2024-10-20': 'Prova de matemática'
    };

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();

        monthYear.textContent = `${months[month]} ${year}`;
        daysContainer.innerHTML = '';

        // Datas do mês anterior
        const prevMonthLastDay = new Date(year, month, 0).getDate();
        for (let i = firstDay; i > 0; i--) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = prevMonthLastDay - i + 1;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);
        }

        // Datas do mês atual
        for (let i = 1; i <= lastDay; i++) {
            const diaFormatado = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;

            // Verifica se há atividades para a data
            if (atividades[diaFormatado]) {
                dayDiv.classList.add('evento'); // Adiciona uma classe para eventos
                dayDiv.title = atividades[diaFormatado]; // Tooltip com a descrição
            }

            // Destaca o dia de hoje
            if (i === new Date().getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
                dayDiv.classList.add('today');
            }

            daysContainer.appendChild(dayDiv);
        }

        // Datas do próximo mês
        const nextMonthStartDay = 7 - new Date(year, month + 1, 0).getDay() - 1;
        for (let i = 1; i <= nextMonthStartDay; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = i;
            dayDiv.classList.add('fade');
            daysContainer.appendChild(dayDiv);
        }
    }

    prevButton.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener('click', function () {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
});


//Chatbox mensagem 

// Abrir e fechar o chat
const chatToggle = document.getElementById('chatToggle');
const chatWindow = document.getElementById('chatWindow');
const toggleIcon = document.getElementById('toggleIcon');

chatToggle.addEventListener('click', function() {
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        chatWindow.style.display = 'flex'; // Mostrar o chat
        toggleIcon.classList.remove('bx-chevron-up'); // Trocar ícone
        toggleIcon.classList.add('bx-chevron-down');
    } else {
        chatWindow.style.display = 'none'; // Esconder o chat
        toggleIcon.classList.remove('bx-chevron-down'); // Trocar ícone
        toggleIcon.classList.add('bx-chevron-up');
    }
});

//online e offline

// Simulando o status do usuário
let isOnline = true; // Define se o usuário está online ou offline
const statusDot = document.getElementById('statusDot');
const statusText = document.getElementById('statusText');

// Função para alterar o status do usuário
function toggleUserStatus() {
    if (isOnline) {
        statusDot.style.backgroundColor = '#f44336'; // Cor vermelha para "offline"
        statusText.textContent = 'Offline';
    } else {
        statusDot.style.backgroundColor = '#4caf50'; // Cor verde para "online"
        statusText.textContent = 'Online';
    }
    isOnline = !isOnline; // Alterna o estado de online para offline
}

// Simulando a mudança de status a cada 5 segundos
setInterval(toggleUserStatus, 5000);

//Mensagem

// Referências para os elementos de input e mensagens
const messageInput = document.getElementById('messageInput');
const chatMessages = document.getElementById('chatMessages');
const sendButton = document.getElementById('sendButton');

// Função para adicionar uma nova mensagem ao chat
function sendMessage() {
    const messageText = messageInput.value.trim(); // Pega o texto e remove espaços extras

    if (messageText !== "") {
        // Cria um novo elemento de mensagem
        const newMessage = document.createElement('div');
        newMessage.classList.add('chat-message');
        newMessage.textContent = messageText;

        // Adiciona a nova mensagem à área de chat
        chatMessages.appendChild(newMessage);

        // Limpa o campo de input
        messageInput.value = '';

        // Mantém o chat sempre scrollando para o fim
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Evento de clique no botão de enviar
sendButton.addEventListener('click', sendMessage);

// Enviar a mensagem ao pressionar Enter
messageInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

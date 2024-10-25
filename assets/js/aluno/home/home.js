const calendarDays = document.getElementById('calendarDays');
const monthYear = document.getElementById('monthYear');
const prevMonth = document.getElementById('prevMonth');
const nextMonth = document.getElementById('nextMonth');
const modal = document.getElementById('modal');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementById('closeModal');
const eventModal = document.getElementById('eventModal');
const closeEventModal = document.getElementById('closeEventModal');
const addEventButton = document.getElementById('addEvent');
const saveEventButton = document.getElementById('saveEvent');
const eventTitleInput = document.getElementById('eventTitle');
const eventDescriptionInput = document.getElementById('eventDescription');

let currentDate = new Date();
const events = {}; // Armazenar eventos por dia

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();

    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const lastDateOfMonth = new Date(year, month + 1, 0).getDate();
    const lastDayOfLastMonth = new Date(year, month, 0).getDate();

    const months = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];

    monthYear.textContent = `${months[month]} ${year}`;

    let days = '';

    for (let x = firstDayOfMonth; x > 0; x--) {
        days += `<div class="calendar-day prev-month">${lastDayOfLastMonth - x + 1}</div>`;
    }

    for (let i = 1; i <= lastDateOfMonth; i++) {
        const hasEvent = events[i]; // Verifica se há evento para o dia

        if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            days += `<div class="calendar-day today ${hasEvent ? 'event-day' : ''}" onclick="showEvent(${i})">${i}</div>`;
        } else {
            days += `<div class="calendar-day ${hasEvent ? 'event-day' : ''}" onclick="showEvent(${i})">${i}</div>`;
        }
    }

    calendarDays.innerHTML = days;
}


function showEvent(day) {
    const event = events[day];
    if (event) {
        modalContent.innerHTML = `
            <h4>${event.title}</h4>
            <p>${event.description}</p>
        `;
        modal.style.display = 'block';
    } else {
        modalContent.innerHTML = `<p>Nenhum evento para este dia.</p>`;
        modal.style.display = 'block';
    }
}

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

addEventButton.addEventListener('click', () => {
    eventModal.style.display = 'block';
});

closeEventModal.addEventListener('click', () => {
    eventModal.style.display = 'none';
});

saveEventButton.addEventListener('click', () => {
    const day = currentDate.getDate(); // Usar o dia atual
    const title = eventTitleInput.value.trim();
    const description = eventDescriptionInput.value.trim();

    if (!events[day]) {
        events[day] = { title, description };
    } else {
        events[day].title += `, ${title}`; // Adiciona título para eventos no mesmo dia
    }

    eventTitleInput.value = '';
    eventDescriptionInput.value = '';
    eventModal.style.display = 'none';
    renderCalendar(); // Re-renderizar o calendário
});

prevMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();

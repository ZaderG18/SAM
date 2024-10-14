const calendarDays = document.getElementById('calendarDays');
const monthYear = document.getElementById('monthYear');
const prevMonth = document.getElementById('prevMonth');
const nextMonth = document.getElementById('nextMonth');

let currentDate = new Date();

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
        if (i === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            days += `<div class="calendar-day today">${i}</div>`;
        } else {
            days += `<div class="calendar-day">${i}</div>`;
        }
    }

    calendarDays.innerHTML = days;
}

prevMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();

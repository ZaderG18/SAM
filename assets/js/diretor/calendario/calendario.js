const calendar = document.querySelector(".calendar"),
  date = document.querySelector(".date"),
  daysContainer = document.querySelector(".days"),
  prev = document.querySelector(".prev"),
  next = document.querySelector(".next"),
  todayBtn = document.querySelector(".today-btn"),
  gotoBtn = document.querySelector(".goto-btn"),
  dateInput = document.querySelector(".date-input"),
  eventDay = document.querySelector(".event-day"),
  eventDate = document.querySelector(".event-date"),
  eventsContainer = document.querySelector(".events"),
  addEventBtn = document.querySelector(".add-event"),
  addEventWrapper = document.querySelector(".add-event-wrapper "),
  addEventCloseBtn = document.querySelector(".close "),
  addEventTitle = document.querySelector(".event-name "),
  addEventFrom = document.querySelector(".event-time-from "),
  addEventTo = document.querySelector(".event-time-to "),
  addEventSubmit = document.querySelector(".add-event-btn ");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
  "Janeiro",
  "Fevereiro",
  "Março",
  "Abril",
  "Maio",
  "Junho",
  "Julho",
  "Agosto",
  "Setembro",
  "Outubro",
  "Novembro",
  "Dezembro",
];

const eventsArr = [];
getEvents();
console.log(eventsArr);

function initCalendar() {
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const prevLastDay = new Date(year, month, 0);
  const prevDays = prevLastDay.getDate();
  const lastDate = lastDay.getDate();
  const day = firstDay.getDay();
  const nextDays = 7 - lastDay.getDay() - 1;

  date.innerHTML = months[month] + " " + year;

  let days = "";

  for (let x = day; x > 0; x--) {
    days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
  }

  for (let i = 1; i <= lastDate; i++) {
    let event = false;
    eventsArr.forEach((eventObj) => {
      if (
        eventObj.day === i &&
        eventObj.month === month + 1 &&
        eventObj.year === year
      ) {
        event = true;
      }
    });

    if (
      i === new Date().getDate() &&
      year === new Date().getFullYear() &&
      month === new Date().getMonth()
    ) {
      activeDay = i;
      getActiveDay(i);
      updateEvents(i);
      if (event) {
        days += `<div class="day today active event">${i}</div>`;
      } else {
        days += `<div class="day today active">${i}</div>`;
      }
    } else {
      if (event) {
        days += `<div class="day event">${i}</div>`;
      } else {
        days += `<div class="day ">${i}</div>`;
      }
    }
  }

  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="day next-date">${j}</div>`;
  }
  daysContainer.innerHTML = days;
  addListner();
}

function prevMonth() {
  month--;
  if (month < 0) {
    month = 11;
    year--;
  }
  initCalendar();
}

function nextMonth() {
  month++;
  if (month > 11) {
    month = 0;
    year++;
  }
  initCalendar();
}


// Adiciona eventos de clique nos botões de navegação
prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth);

initCalendar();  // Inicializa o calendário na primeira carga

// Função para adicionar classe "active" ao dia selecionado
function addListner() {
  const days = document.querySelectorAll(".day");
  days.forEach((day) => {
    day.addEventListener("click", (e) => {
      const selectedDay = Number(e.target.innerHTML);

      getActiveDay(selectedDay);
      updateEvents(selectedDay);
      activeDay = selectedDay;

      // Remove a classe "active" de todos os dias
      days.forEach((day) => {
        day.classList.remove("active");
      });

      // Verifica se o dia pertence ao mês anterior ou próximo
      if (e.target.classList.contains("prev-date")) {
        prevMonth();
        setTimeout(() => {
          setActiveDay(selectedDay);
        }, 100);
      } else if (e.target.classList.contains("next-date")) {
        nextMonth();
        setTimeout(() => {
          setActiveDay(selectedDay);
        }, 100);
      } else {
        e.target.classList.add("active");
      }
    });
  });
}

// Função auxiliar para adicionar "active" ao dia selecionado após mudar de mês
function setActiveDay(day) {
  const days = document.querySelectorAll(".day");
  days.forEach((dayElement) => {
    if (
      !dayElement.classList.contains("prev-date") &&
      !dayElement.classList.contains("next-date") &&
      Number(dayElement.innerHTML) === day
    ) {
      dayElement.classList.add("active");
    }
  });
}

// Botão "Hoje" para voltar ao mês e ano atuais
todayBtn.addEventListener("click", () => {
  const today = new Date();
  month = today.getMonth();
  year = today.getFullYear();
  initCalendar();
});

// Validação do input de data no formato dd/mm/aaaa
dateInput.addEventListener("input", (e) => {
  dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
  
  if (dateInput.value.length === 2) {
    dateInput.value += "/";
  } else if (dateInput.value.length > 7) {
    dateInput.value = dateInput.value.slice(0, 7);
  }

  if (e.inputType === "deleteContentBackward" && dateInput.value.length === 3) {
    dateInput.value = dateInput.value.slice(0, 2);
  }
});

// Botão "Ir" para navegar para uma data específica
gotoBtn.addEventListener("click", gotoDate);

function gotoDate() {
  const dateArr = dateInput.value.split("/");

  if (dateArr.length === 2) {
    const [mes, ano] = dateArr.map(Number);
    if (mes > 0 && mes < 13 && ano.toString().length === 4) {
      month = mes - 1;
      year = ano;
      initCalendar();
      return;
    }
  }
  alert("Data inválida. Por favor, use o formato dd/mm/aaaa.");
}

// Função para obter o dia ativo e exibir no evento
function getActiveDay(date) {
  const day = new Date(year, month, date);
  const dayName = day.toLocaleDateString("pt-BR", { weekday: "long" });
  eventDay.innerHTML = dayName.charAt(0).toUpperCase() + dayName.slice(1);
  eventDate.innerHTML = `${date} ${months[month]} ${year}`;
}

// Função para atualizar os eventos no dia selecionado
function updateEvents(date) {
  let events = "";
  eventsArr.forEach((event) => {
    if (date === event.day && month + 1 === event.month && year === event.year) {
      event.events.forEach((evt) => {
        events += `<div class="event">
            <div class="title">
              <i class="fas fa-circle"></i>
              <h3 class="event-title">${evt.title}</h3>
            </div>
            <div class="event-time">
              <span class="event-time">${evt.time}</span>
            </div>
        </div>`;
      });
    }
  });

  if (events === "") {
    events = `<div class="no-event">
            <h3>Sem eventos</h3>
        </div>`;
  }

  eventsContainer.innerHTML = events;
  saveEvents(); // Função que salva os eventos (deve estar definida em outro local).
}

// Ações para abrir e fechar a janela de adicionar evento
addEventBtn.addEventListener("click", () => {
  addEventWrapper.classList.toggle("active");
});

addEventCloseBtn.addEventListener("click", () => {
  addEventWrapper.classList.remove("active");
});

// Fechar ao clicar fora da janela de evento
document.addEventListener("click", (e) => {
  if (e.target !== addEventBtn && !addEventWrapper.contains(e.target)) {
    addEventWrapper.classList.remove("active");
  }
});

// Limite de 60 caracteres no título do evento
addEventTitle.addEventListener("input", (e) => {
  addEventTitle.value = addEventTitle.value.slice(0, 60);
});

// Permitir apenas entrada de hora válida (24h) no campo "De"
addEventFrom.addEventListener("input", (e) => {
  addEventFrom.value = addEventFrom.value.replace(/[^0-9:]/g, "");
  if (addEventFrom.value.length === 2) {
    addEventFrom.value += ":";
  }
  if (addEventFrom.value.length > 5) {
    addEventFrom.value = addEventFrom.value.slice(0, 5);
  }
});

// Permitir apenas entrada de hora válida (24h) no campo "Até"
addEventTo.addEventListener("input", (e) => {
  addEventTo.value = addEventTo.value.replace(/[^0-9:]/g, "");
  if (addEventTo.value.length === 2) {
    addEventTo.value += ":";
  }
  if (addEventTo.value.length > 5) {
    addEventTo.value = addEventTo.value.slice(0, 5);
  }
});

// Função para converter hora para exibição
function convertTime(time) {
  const [hour, minute] = time.split(":").map(Number);
  return `${hour.toString().padStart(2, "0")}:${minute.toString().padStart(2, "0")}`;
}

// Função para adicionar um evento
addEventSubmit.addEventListener("click", () => {
  const eventTitle = addEventTitle.value;
  const eventTimeFrom = addEventFrom.value;
  const eventTimeTo = addEventTo.value;

  if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
    alert("Por favor, preencha todos os campos.");
    return;
  }

  // Validação do formato da hora (24h)
  const timeFromArr = eventTimeFrom.split(":");
  const timeToArr = eventTimeTo.split(":");
  if (
    timeFromArr.length !== 2 ||
    timeToArr.length !== 2 ||
    timeFromArr[0] > 23 ||
    timeFromArr[1] > 59 ||
    timeToArr[0] > 23 ||
    timeToArr[1] > 59
  ) {
    alert("Formato de hora inválido. Use o formato HH:MM.");
    return;
  }

  const timeFrom = convertTime(eventTimeFrom);
  const timeTo = convertTime(eventTimeTo);

  // Verificar se o evento já existe
  let eventExist = false;
  eventsArr.forEach((event) => {
    if (
      event.day === activeDay &&
      event.month === month + 1 &&
      event.year === year
    ) {
      event.events.forEach((evt) => {
        if (evt.title === eventTitle) {
          eventExist = true;
        }
      });
    }
  });

  if (eventExist) {
    alert("Este evento já foi adicionado.");
    return;
  }

  const newEvent = {
    title: eventTitle,
    time: `${timeFrom} - ${timeTo}`,
  };

  let eventAdded = false;
  eventsArr.forEach((item) => {
    if (
      item.day === activeDay &&
      item.month === month + 1 &&
      item.year === year
    ) {
      item.events.push(newEvent);
      eventAdded = true;
    }
  });

  if (!eventAdded) {
    eventsArr.push({
      day: activeDay,
      month: month + 1,
      year: year,
      events: [newEvent],
    });
  }

  addEventWrapper.classList.remove("active");
  addEventTitle.value = "";
  addEventFrom.value = "";
  addEventTo.value = "";
  updateEvents(activeDay);

  // Adicionar classe "event" ao dia ativo se ainda não tiver
  const activeDayEl = document.querySelector(".day.active");
  if (activeDayEl && !activeDayEl.classList.contains("event")) {
    activeDayEl.classList.add("event");
  }
});

// Função para deletar evento ao clicar nele
eventsContainer.addEventListener("click", (e) => {
  if (e.target.closest(".event")) {  // Verifica se o elemento clicado é um evento
    if (confirm("Tem certeza de que deseja excluir este evento?")) {
      const eventTitle = e.target.querySelector(".event-title").innerHTML;

      eventsArr.forEach((event) => {
        if (
          event.day === activeDay &&
          event.month === month + 1 &&
          event.year === year
        ) {
          // Encontrar e remover o evento pelo título
          event.events.forEach((item, index) => {
            if (item.title === eventTitle) {
              event.events.splice(index, 1);
            }
          });

          // Se não houver mais eventos para o dia, remover o dia do `eventsArr`
          if (event.events.length === 0) {
            eventsArr.splice(eventsArr.indexOf(event), 1);

            // Remover a classe "event" do dia ativo
            const activeDayEl = document.querySelector(".day.active");
            if (activeDayEl && activeDayEl.classList.contains("event")) {
              activeDayEl.classList.remove("event");
            }
          }
        }
      });

      updateEvents(activeDay);  // Atualiza a lista de eventos do dia
      saveEvents();  // Salva os eventos atualizados no localStorage
    }
  }
});

// Função para salvar eventos no localStorage
function saveEvents() {
  localStorage.setItem("events", JSON.stringify(eventsArr));
}

// Função para recuperar eventos do localStorage
function getEvents() {
  const savedEvents = localStorage.getItem("events");
  if (savedEvents) {
    eventsArr.push(...JSON.parse(savedEvents));
  }
}

// Função para converter hora para o formato de 12 horas com AM/PM
function convertTime(time) {
  let [timeHour, timeMin] = time.split(":").map(Number);
  const timeFormat = timeHour >= 12 ? "PM" : "AM";
  timeHour = timeHour % 12 || 12;  // Converte para 12h (ex.: 0 -> 12)
  return `${timeHour}:${timeMin.toString().padStart(2, "0")} ${timeFormat}`;
}

document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("userModal");
    const modalName = document.getElementById("modalName");
    const closeButton = document.querySelector(".close-button");

    // Verifica se os elementos foram encontrados
    if (!modal || !modalName || !closeButton) {
        console.error("Elementos da modal não encontrados. Verifique o HTML.");
        return;
    }

    function openModal(name, userData) {
        modalName.textContent = name;

        // Atualiza os dados do usuário
        document.getElementById("fullName").textContent = userData.fullName;
        document.getElementById("birthDate").textContent = userData.birthDate;
        document.getElementById("registrationNumber").textContent = userData.registrationNumber;
        document.getElementById("emergencyContacts").textContent = userData.emergencyContacts;
        document.getElementById("responsibles").textContent = userData.responsibles;
        document.getElementById("currentYear").textContent = userData.currentYear;
        document.getElementById("class").textContent = userData.class;
        document.getElementById("reportCard").textContent = userData.reportCard;
        document.getElementById("academicHistory").textContent = userData.academicHistory;
        document.getElementById("absences").textContent = userData.absences;
        document.getElementById("financialStatus").textContent = userData.financialStatus;
        document.getElementById("activityLogs").textContent = userData.activityLogs;
        document.getElementById("performanceReports").textContent = userData.performanceReports;
        document.getElementById("notesComments").textContent = userData.notesComments;
        document.getElementById("importantDates").textContent = userData.importantDates;

        // Mostra a seção de Informações Pessoais por padrão
        showTopic('personal-info');

        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    closeButton.addEventListener("click", closeModal);

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Adiciona evento de clique em cada botão de navegação
    document.querySelectorAll(".nav-button").forEach(button => {
        button.addEventListener("click", function() {
            const topicId = button.getAttribute("data-topic");
            showTopic(topicId);
        });
    });

    function showTopic(topicId) {
        // Esconde todas as seções
        document.querySelectorAll('.topic').forEach(topic => {
            topic.style.display = 'none';
        });
        // Mostra a seção selecionada
        document.getElementById(topicId).style.display = 'block';
    }

    // Exemplo de dados do usuário
    const exampleUserData = {
        fullName: "João Silva",
        birthDate: "01/01/2000",
        registrationNumber: "123456",
        emergencyContacts: "Mãe: (11) 91234-5678, Pai: (11) 98765-4321",
        responsibles: "Mãe: Maria Silva, Pai: José Silva",
        currentYear: "3º Ano",
        class: "A",
        reportCard: "Matemática: 9, Português: 8, História: 10",
        academicHistory: "Histórico disponível",
        absences: "2 faltas",
        financialStatus: "Sem pendências",
        activityLogs: "Acesso em 01/11/2024",
        performanceReports: "Ótimo desempenho",
        notesComments: "Sem observações.",
        importantDates: "Reunião: 10/11/2024, Prova: 15/11/2024"
    };

    // Exemplo de abertura da modal ao clicar no botão "Read More"
    document.querySelectorAll(".button").forEach(button => {
        button.addEventListener("click", function(event) {
            event.stopPropagation();
            const card = button.closest(".card");
            if (!card) {
                console.error("Card não encontrado para o botão clicado.");
                return;
            }
            const name = card.querySelector(".name")?.textContent || "Nome não disponível";
            openModal(name, exampleUserData);
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const navButtons = document.querySelectorAll('.nav-button');
    const topics = document.querySelectorAll('.topic');

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.topic;

            // Oculta todos os tópicos
            topics.forEach(topic => {
                topic.style.display = 'none';
            });

            // Mostra o tópico correspondente
            document.getElementById(targetId).style.display = 'block';

            // Ajusta a altura da modal dinamicamente (caso necessário)
            const modalContent = document.querySelector('.modal-content');
            modalContent.style.height = 'auto'; // Permite a altura dinâmica
        });
    });
});



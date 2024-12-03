document.addEventListener("DOMContentLoaded", function () {
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

        // Atualiza os dados do coordenador
        document.getElementById("fullName").textContent = userData.fullName;
        document.getElementById("birthDate").textContent = userData.birthDate;
        document.getElementById("cpf").textContent = userData.cpf;
        document.getElementById("emergencyContacts").textContent = userData.emergencyContacts;
        document.getElementById("address").textContent = userData.address;

        document.getElementById("department").textContent = userData.department;
        document.getElementById("startDate").textContent = userData.startDate;
        document.getElementById("weeklyHours").textContent = userData.weeklyHours;
        document.getElementById("certifications").textContent = userData.certifications;

        document.getElementById("supervisedTeachers").textContent = userData.supervisedTeachers;
        document.getElementById("ongoingProjects").textContent = userData.ongoingProjects;
        document.getElementById("plannedMeetings").textContent = userData.plannedMeetings;

        document.getElementById("evaluatedReports").textContent = userData.evaluatedReports;
        document.getElementById("sentFeedbacks").textContent = userData.sentFeedbacks;
        document.getElementById("teamPerformance").textContent = userData.teamPerformance;

        // Mostra a seção de Informações Pessoais por padrão
        showTopic("personal-info");

        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    closeButton.addEventListener("click", closeModal);

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Adiciona evento de clique em cada botão de navegação
    document.querySelectorAll(".nav-button").forEach((button) => {
        button.addEventListener("click", function () {
            const topicId = button.getAttribute("data-topic");
            showTopic(topicId);
        });
    });

    function showTopic(topicId) {
        // Esconde todas as seções
        document.querySelectorAll(".topic").forEach((topic) => {
            topic.style.display = "none";
        });
        // Mostra a seção selecionada
        document.getElementById(topicId).style.display = "block";
    }

    // Exemplo de dados do coordenador
    const exampleUserData = {
        fullName: "Carlos Henrique Silva",
        birthDate: "10/04/1978",
        cpf: "789.456.123-00",
        emergencyContacts: "Esposa: (11) 98765-1234",
        address: "Av. Central, 456, São Paulo - SP",
        department: "Administração Escolar",
        startDate: "15/03/2015",
        weeklyHours: "44 horas",
        certifications: "MBA em Gestão Educacional",
        supervisedTeachers: "12 professores",
        ongoingProjects: "Projeto de Mentoria, Integração Digital",
        plannedMeetings: "Reunião Semanal com Professores, Workshop de Treinamento",
        evaluatedReports: "15 relatórios avaliados",
        sentFeedbacks: "8 feedbacks enviados",
        teamPerformance: "Desempenho geral: 9.2",
    };

    // Exemplo de abertura da modal ao clicar no botão "Read More"
    document.querySelectorAll(".button").forEach((button) => {
        button.addEventListener("click", function (event) {
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

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

        // Atualiza os dados do professor
        document.getElementById("fullName").textContent = userData.fullName;
        document.getElementById("birthDate").textContent = userData.birthDate;
        document.getElementById("cpf").textContent = userData.cpf;
        document.getElementById("emergencyContacts").textContent = userData.emergencyContacts;
        document.getElementById("address").textContent = userData.address;

        document.getElementById("subjects").textContent = userData.subjects;
        document.getElementById("weeklyHours").textContent = userData.weeklyHours;
        document.getElementById("department").textContent = userData.department;
        document.getElementById("hireDate").textContent = userData.hireDate;
        document.getElementById("certifications").textContent = userData.certifications;

        document.getElementById("currentClasses").textContent = userData.currentClasses;
        document.getElementById("totalStudents").textContent = userData.totalStudents;
        document.getElementById("classSchedule").textContent = userData.classSchedule;
        document.getElementById("projectsActivities").textContent = userData.projectsActivities;

        document.getElementById("assignedGrades").textContent = userData.assignedGrades;
        document.getElementById("sentFeedbacks").textContent = userData.sentFeedbacks;
        document.getElementById("studentReports").textContent = userData.studentReports;
        document.getElementById("attendanceRecords").textContent = userData.attendanceRecords;

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

    // Exemplo de dados do professor
    const exampleUserData = {
        fullName: "Ana Paula Lima",
        birthDate: "15/03/1985",
        cpf: "123.456.789-00",
        emergencyContacts: "Esposo: (11) 98765-4321",
        address: "Rua Exemplo, 123, São Paulo - SP",
        subjects: "Matemática, Física",
        weeklyHours: "40 horas",
        department: "Ciências Exatas",
        hireDate: "01/02/2010",
        certifications: "Especialização em Ensino da Matemática",
        currentClasses: "3º Ano A, 2º Ano B",
        totalStudents: "60 alunos",
        classSchedule: "Segunda a Sexta, 7h às 13h",
        projectsActivities: "Feira de Ciências, Olimpíada de Matemática",
        assignedGrades: "Média: 8.5",
        sentFeedbacks: "10 feedbacks enviados",
        studentReports: "Disponíveis no sistema",
        attendanceRecords: "Frequência média: 95%",
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

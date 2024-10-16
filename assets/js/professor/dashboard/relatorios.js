let reports = []; // Array para armazenar os relatórios
let currentEditIndex = -1; // Índice do relatório sendo editado

function openModal() {
    document.getElementById("reportModal").style.display = "block";
}

function closeModal() {
    document.getElementById("reportModal").style.display = "none";
}

function openEditModal(index) {
    currentEditIndex = index;
    const report = reports[index];
    document.getElementById("editReportName").value = report.name;
    document.getElementById("editReportDescription").value = report.description;
    document.getElementById("editStartDate").value = report.startDate;
    document.getElementById("editEndDate").value = report.endDate;
    document.getElementById("editReportType").value = report.type;

    document.getElementById("editReportModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editReportModal").style.display = "none";
}

function addReport() {
    const name = document.getElementById("reportName").value;
    const description = document.getElementById("reportDescription").value;
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const type = document.getElementById("reportType").value;
    const dateCreated = new Date().toLocaleDateString();

    // Adiciona o novo relatório ao array
    reports.push({ name, description, startDate, endDate, type, dateCreated });

    // Limpa os campos do formulário
    document.getElementById("reportName").value = '';
    document.getElementById("reportDescription").value = '';
    document.getElementById("startDate").value = '';
    document.getElementById("endDate").value = '';
    document.getElementById("reportType").value = '';

    closeModal();
    updateReportTable();
}

function saveEditedReport() {
    const name = document.getElementById("editReportName").value;
    const description = document.getElementById("editReportDescription").value;
    const startDate = document.getElementById("editStartDate").value;
    const endDate = document.getElementById("editEndDate").value;
    const type = document.getElementById("editReportType").value;

    // Atualiza o relatório no array
    reports[currentEditIndex] = { ...reports[currentEditIndex], name, description, startDate, endDate, type };

    closeEditModal();
    updateReportTable();
}

function updateReportTable() {
    const tbody = document.getElementById("reportTableBody");
    tbody.innerHTML = ''; // Limpa a tabela existente

    reports.forEach((report, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${report.name}</td>
            <td>${report.description}</td>
            <td>${report.dateCreated}</td>
            <td class="actions">
                <button onclick="openEditModal(${index})">Editar</button>
                <button onclick="downloadReport(${index})">Baixar</button>
                <button onclick="openSendModal(${index})">Enviar</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function downloadReport(index) {
    // Lógica para download do relatório (pode ser ajustada conforme necessário)
    alert(`Download do relatório: ${reports[index].name}`);
}

function openSendModal(index) {
    document.getElementById("sendReportModal").style.display = "block";
    document.getElementById("sendReportModal").dataset.reportIndex = index;
}

function closeSendModal() {
    document.getElementById("sendReportModal").style.display = "none";
}

function sendEmail() {
    const index = document.getElementById("sendReportModal").dataset.reportIndex;
    const email = document.getElementById("recipientEmail").value;
    const message = document.getElementById("emailMessage").value;

    // Lógica para envio do relatório por email (pode ser ajustada conforme necessário)
    alert(`Relatório enviado para: ${email}\nMensagem: ${message}`);

    closeSendModal();
}

// Fecha o modal ao clicar fora dele
window.onclick = function(event) {
    const modal = document.getElementById("reportModal");
    const editModal = document.getElementById("editReportModal");
    const sendModal = document.getElementById("sendReportModal");
    if (event.target == modal) {
        closeModal();
    }
    if (event.target == editModal) {
        closeEditModal();
    }
    if (event.target == sendModal) {
        closeSendModal();
    }
}

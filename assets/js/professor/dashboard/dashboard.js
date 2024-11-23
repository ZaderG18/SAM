 // Função para buscar dados via Fetch
 async function fetchChartData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Erro ao buscar dados: ${response.statusText}`);
        }
        return await response.json();
    } catch (error) {
        console.error("Erro na API:", error);
    }
}

// Renderização dos gráficos
fetchChartData('../../../../php/professor/dashboard/progresso.php').then(response => {
    if (!response) {
        console.error("Nenhum dado recebido.");
        return;
    }

    // Dados para o gráfico de progresso acadêmico
    const progressoData = response.progresso_academico;
    const progressoLabels = progressoData.map(item => item.disciplina);
    const progressoValues = progressoData.map(item => item.progresso);

    const ctxProgresso = document.getElementById('progressChart').getContext('2d');
    new Chart(ctxProgresso, {
        type: 'bar',
        data: {
            labels: progressoLabels,
            datasets: [{
                label: 'Progresso (%)',
                data: progressoValues,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Dados para o gráfico de desempenho de turmas
    const desempenhoData = response.desempenho_turmas;
    const desempenhoLabels = desempenhoData.map(item => item.turma);
    const desempenhoValues = desempenhoData.map(item => item.media);

    const ctxDesempenho = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctxDesempenho, {
        type: 'line',
        data: {
            labels: desempenhoLabels,
            datasets: [{
                label: 'Média de Notas (%)',
                data: desempenhoValues,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
$(document).ready(function () {
    // Função para carregar dados do progresso e desempenho
    function carregarDados() {
        $.ajax({
            url: 'progresso.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Atualizar gráficos com os dados recebidos
                atualizarGraficoProgresso(data.progresso_academico);
                atualizarGraficoDesempenho(data.desempenho_turmas);
            },
            error: function (xhr, status, error) {
                console.error("Erro ao carregar os dados: ", error);
            }
        });
    }

    // Gráfico de Progresso Acadêmico
    let ctxProgresso = document.getElementById('progressChart').getContext('2d');
    let progressoChart = new Chart(ctxProgresso, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Progresso (%)',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function atualizarGraficoProgresso(progressoData) {
        progressoChart.data.labels = progressoData.map(item => item.disciplina);
        progressoChart.data.datasets[0].data = progressoData.map(item => item.progresso);
        progressoChart.update();
    }

    // Gráfico de Desempenho das Turmas
    let ctxDesempenho = document.getElementById('performanceChart').getContext('2d');
    let desempenhoChart = new Chart(ctxDesempenho, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Média das Turmas',
                data: [],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function atualizarGraficoDesempenho(desempenhoData) {
        desempenhoChart.data.labels = desempenhoData.map(item => item.turma);
        desempenhoChart.data.datasets[0].data = desempenhoData.map(item => item.media);
        desempenhoChart.update();
    }

    // Carregar dados ao iniciar
    carregarDados();

    // Atualizar dados periodicamente (exemplo: a cada 1 minuto)
    setInterval(carregarDados, 60000);
});
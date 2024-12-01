const ctx = document.getElementById('graficoDesempenhoProfessores').getContext('2d');

new Chart(ctx, {
    type: 'line', // Tipo de gráfico: linha
    data: {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'], // Meses
        datasets: [{
            label: 'Avaliação das Aulas (%)', // Média de avaliações das aulas ministradas
            data: [85, 88, 90, 87, 91, 89], // Dados de avaliação das aulas
            borderColor: '#4CAF50', // Cor da linha (verde suave)
            backgroundColor: 'rgba(76, 175, 80, 0.2)', // Cor de fundo da linha (verde suave)
            fill: true,
            tension: 0.4, // Suavizar a linha
            borderWidth: 3,
            pointBackgroundColor: '#4CAF50', // Cor dos pontos
            pointRadius: 6,
            pointHoverRadius: 10,
            pointBorderWidth: 2,
            pointHoverBackgroundColor: '#388E3C', // Cor de hover nos pontos
            pointHoverBorderColor: '#1B5E20', // Cor de borda ao passar o mouse
        },{
            label: 'Pontualidade (%)', // Média de pontualidade dos professores
            data: [92, 94, 93, 90, 95, 92], // Dados de pontualidade
            borderColor: '#FF9800', // Cor da linha (laranja)
            backgroundColor: 'rgba(255, 152, 0, 0.2)', // Cor de fundo da linha (laranja)
            fill: true,
            tension: 0.4, // Suavizar a linha
            borderWidth: 3,
            pointBackgroundColor: '#FF9800', // Cor dos pontos
            pointRadius: 6,
            pointHoverRadius: 10,
            pointBorderWidth: 2,
            pointHoverBackgroundColor: '#F57C00', // Cor de hover nos pontos
            pointHoverBorderColor: '#E65100', // Cor de borda ao passar o mouse
        }]
    },
    options: {
        responsive: true, // Tornar gráfico responsivo
        maintainAspectRatio: false, // Manter a proporção do gráfico
        plugins: {
            title: {
                display: true,
                text: 'Desempenho dos Professores por Mês', // Título do gráfico
                font: {
                    size: 18,
                    weight: 'bold',
                    family: "'Roboto', sans-serif", // Fontes mais modernas
                },
                padding: {
                    top: 20,
                    bottom: 30,
                },
                color: '#333' // Cor do título
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(0, 0, 0, 0.7)', // Fundo do tooltip
                titleColor: '#fff', // Cor do título do tooltip
                bodyColor: '#fff', // Cor do conteúdo do tooltip
                bodyFont: {
                    size: 12,
                },
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw + '%'; // Customização do formato do tooltip
                    }
                }
            },
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Porcentagem (%)', // Título do eixo Y
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#333'
                },
                ticks: {
                    stepSize: 5, // Passos de 5% no eixo Y
                    max: 100, // Valor máximo no eixo Y
                    min: 0, // Valor mínimo no eixo Y
                    font: {
                        size: 12,
                    },
                    color: '#555'
                },
                grid: {
                    borderColor: '#ddd', // Cor das linhas de grade
                    borderWidth: 1,
                    tickColor: '#ddd',
                    drawTicks: false,
                },
            },
            x: {
                title: {
                    display: true,
                    text: 'Meses', // Título do eixo X
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: '#333'
                },
                ticks: {
                    font: {
                        size: 12,
                    },
                    color: '#555'
                },
                grid: {
                    borderColor: '#ddd', // Cor das linhas de grade
                    borderWidth: 1,
                    tickColor: '#ddd',
                    drawTicks: false,
                },
            },
        },
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 20,
                bottom: 20
            }
        }
    }
});

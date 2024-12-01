
const ctx = document.getElementById('graficoBoletim').getContext('2d');

new Chart(ctx, {
    type: 'bar', // Tipo de gráfico: barras
    data: {
        labels: ['David Richard', 'Christina W.', 'Lucas Oliveira', 'Fernanda Souza', 'Carlos Pereira'], // Alunos
        datasets: [{
            label: 'Boletim 1 - Nota (%)', // Legenda do gráfico
            data: [85, 92, 78, 88, 75], // Desempenho em porcentagem do Boletim 1
            backgroundColor: '#3498db', // Cor das barras
            borderColor: '#2980b9', // Cor da borda das barras
            borderWidth: 2, // Largura da borda das barras
            hoverBackgroundColor: '#2980b9', // Cor das barras ao passar o mouse
            hoverBorderColor: '#2980b9', // Cor da borda ao passar o mouse
            barThickness: 40, // Espessura das barras
        },
        {
            label: 'Boletim 2 - Nota (%)', // Legenda do gráfico
            data: [88, 95, 82, 90, 80], // Desempenho em porcentagem do Boletim 2
            backgroundColor: '#e74c3c', // Cor das barras
            borderColor: '#c0392b', // Cor da borda das barras
            borderWidth: 2, // Largura da borda das barras
            hoverBackgroundColor: '#c0392b', // Cor das barras ao passar o mouse
            hoverBorderColor: '#c0392b', // Cor da borda ao passar o mouse
            barThickness: 40, // Espessura das barras
        }]
    },
    options: {
        responsive: true, // Tornar o gráfico responsivo
        maintainAspectRatio: false, // Manter proporção ao redimensionar
        plugins: {
            title: {
                display: true, // Exibir título
                text: 'Comparação de Desempenho Acadêmico - Boletins 1 e 2', // Título do gráfico
                font: {
                    size: 16
                }
            },
            legend: {
                position: 'top', // Posicionar a legenda no topo
                labels: {
                    font: {
                        size: 14
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true, // Começar do zero no eixo Y
                title: {
                    display: true,
                    text: 'Nota (%)', // Título do eixo Y
                    font: {
                        size: 14
                    }
                },
                ticks: {
                    stepSize: 10, // Passos de 10% no eixo Y
                    max: 100, // Valor máximo no eixo Y
                    min: 0, // Valor mínimo no eixo Y
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Alunos', // Título do eixo X
                    font: {
                        size: 14
                    }
                }
            }
        }
    }
});
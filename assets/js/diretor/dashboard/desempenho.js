const ctx = document.getElementById('graficoDesempenho').getContext('2d');

new Chart(ctx, {
    type: 'bar', // Tipo de gráfico: barras
    data: {
        labels: ['David Richard', 'Christina W.', 'Jurica Koletic', 'Alfredo Silva', 'Fernanda Souza', 'Carlos Pereira'], // Alunos
        datasets: [{
            label: 'Desempenho Acadêmico (%)', // Legenda do gráfico
            data: [85, 92, 78, 64, 80, 75], // Desempenho em porcentagem
            backgroundColor: '#2C3E50', // Cor das barras
            borderColor: '#2C3E50', // Cor da borda das barras
            borderWidth: 2, // Largura da borda das barras
            hoverBackgroundColor: '#365d85', // Cor das barras ao passar o mouse
            hoverBorderColor: '#365d85', // Cor da borda ao passar o mouse
        }]
    },
    options: {
        responsive: true, // Tornar o gráfico responsivo
        maintainAspectRatio: false, // Manter proporção ao redimensionar
        plugins: {
            title: {
                display: true, // Exibir título
                text: 'Desempenho Acadêmico dos Alunos', // Título do gráfico
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
                    text: 'Porcentagem de Desempenho (%)', // Título do eixo Y
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




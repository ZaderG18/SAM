// Gráfico de Total de Acessos
const ctx = document.getElementById('graficoIntervencao').getContext('2d');

new Chart(ctx, {
    type: 'line', // Tipo de gráfico: linha
    data: {
        labels: ['Alunos', 'Responsáveis', 'Coordenação', 'Secretaria', 'Professores', 'Técnico de TI/Suporte'], // Categorias
        datasets: [{
            label: 'Total de Acessos', // Legenda do gráfico
            data: [100, 150, 5, 8, 15, 3], // Dados de acessos
            borderColor: '#2C3E50', // Cor da linha
            backgroundColor: 'rgba(66, 165, 245, 0.2)', // Cor do preenchimento abaixo da linha (opcional)
            fill: true, // Preencher abaixo da linha
            tension: 0.3, // Curvatura da linha
            borderWidth: 2, // Largura da linha
            pointBackgroundColor: '#2C3E50', // Cor dos pontos
            pointRadius: 5, // Tamanho dos pontos
            pointHoverRadius: 8, // Tamanho dos pontos ao passar o mouse
            pointBorderWidth: 3, // Borda dos pontos
        }]
    },
    options: {
        responsive: true, // Tornar o gráfico responsivo
        maintainAspectRatio: false, // Manter proporção ao redimensionar
        plugins: {
            title: {
                display: true, // Exibir título
                text: 'Total de Acessos por Departamento', // Título do gráfico
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
                    text: 'Número de Acessos', // Título do eixo Y
                    font: {
                        size: 14
                    }
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Departamentos', // Título do eixo X
                    font: {
                        size: 14
                    }
                }
            }
        }
    }
});
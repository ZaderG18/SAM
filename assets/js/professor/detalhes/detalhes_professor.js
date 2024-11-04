

const ctx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Desempenho Profissional', 'Frequência', 'Observações'],
        datasets: [{
            label: 'Detalhes do Aluno',
            data: [87, 95, 75],
            backgroundColor: [
                'rgba(75, 0, 130, 0.6)', // Dark purple
                'rgba(54, 162, 235, 0.6)', // Blue
                'rgba(255, 206, 86, 0.6)' // Yellow
            ],
            borderColor: [
                'rgba(75, 0, 130, 1)', // Dark purple
                'rgba(54, 162, 235, 1)', // Blue
                'rgba(255, 206, 86, 1)' // Yellow
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                    }
                }
            }
        }
    }
}); 

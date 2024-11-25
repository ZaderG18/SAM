const ctx = document.getElementById('grafico1');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Alunos', 'Responsaveis', 'Coordenação', 'Secretaria', 'Professores', 'Técnico de TI/Suporte'],
      datasets: [{
        label: 'Total de acessos',
        data: [100, 150, 5, 8, 15, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
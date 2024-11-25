// script.js
document.addEventListener('DOMContentLoaded', () => {
    loadDocuments();
  });
  
  const documents = [
    { name: 'João Silva', type: 'Atestado', date: '2024-11-10', status: 'Enviado' },
    { name: 'Maria Oliveira', type: 'Declaração', date: '2024-11-12', status: 'Revisado' },
    { name: 'Ana Santos', type: 'Histórico', date: '2024-11-15', status: 'Pendente' }
  ];
  
  function loadDocuments() {
    const list = document.getElementById('document-list');
    list.innerHTML = '';
    documents.forEach((doc, index) => {
      const row = `
        <tr>
          <td>${doc.name}</td>
          <td>${doc.type}</td>
          <td>${doc.date}</td>
          <td>${doc.status}</td>
          <td>
            <button onclick="openDocument(${index})">Ver</button>
          </td>
        </tr>
      `;
      list.innerHTML += row;
    });
  }
  
  function filterDocuments() {
    const type = document.getElementById('document-type').value.toLowerCase();
    const name = document.getElementById('student-name').value.toLowerCase();
    const status = document.getElementById('status').value.toLowerCase();
  
    const filtered = documents.filter(doc => 
      (!type || doc.type.toLowerCase().includes(type)) &&
      (!name || doc.name.toLowerCase().includes(name)) &&
      (!status || doc.status.toLowerCase().includes(status))
    );
  
    const list = document.getElementById('document-list');
    list.innerHTML = '';
    filtered.forEach((doc, index) => {
      const row = `
        <tr>
          <td>${doc.name}</td>
          <td>${doc.type}</td>
          <td>${doc.date}</td>
          <td>${doc.status}</td>
          <td>
            <button onclick="openDocument(${index})">Ver</button>
          </td>
        </tr>
      `;
      list.innerHTML += row;
    });
  }
  
  function openDocument(index) {
    const modal = document.getElementById('modal');
    const content = document.getElementById('modal-content');
    const doc = documents[index];
    content.innerHTML = `
      <strong>Nome:</strong> ${doc.name} <br>
      <strong>Tipo:</strong> ${doc.type} <br>
      <strong>Data:</strong> ${doc.date} <br>
      <strong>Status:</strong> ${doc.status}
    `;
    modal.style.display = 'flex';
  }
  
  function toggleModal() {
    const modal = document.getElementById('modal');
    modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
  }
  
  function approveDocument() {
    alert('Documento aprovado!');
    toggleModal();
  }
  
  function requestRevision() {
    alert('Revisão solicitada!');
    toggleModal();
  }
  
  // Função para mostrar/ocultar a ajuda
  function toggleHelp() {
    const helpText = `
      <h3>Ajuda</h3>
      <p>Utilize os filtros para buscar os documentos recebidos por tipo, aluno/turma ou status. Clique em "Ver" para visualizar detalhes do documento.</p>
    `;
    alert(helpText);
  }
  

  
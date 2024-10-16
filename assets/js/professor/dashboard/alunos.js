document.getElementById('classFilter').addEventListener('change', filterStudents);
    document.getElementById('searchInput').addEventListener('input', filterStudents);

    function filterStudents() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const classFilter = document.getElementById('classFilter').value;
        const studentCards = document.querySelectorAll('.student-card');

        studentCards.forEach(card => {
            const studentName = card.querySelector('h3').textContent.toLowerCase();
            const studentClass = card.getAttribute('data-turma');

            if ((classFilter === 'all' || classFilter === studentClass) && studentName.includes(searchInput)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

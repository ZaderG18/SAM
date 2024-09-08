const addBtn = document.getElementById('add-btn');
const expandMenu = document.getElementById('expand-menu');
const closeBtn = document.querySelector('.close-btn');

addBtn.addEventListener('click', () => {
  expandMenu.classList.add('active');
});

closeBtn.addEventListener('click', () => {
  expandMenu.classList.remove('active');
});

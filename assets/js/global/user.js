const socket = io();

const usernameInput = document.querySelector('#user');
const mensagemInput =  document.querySelector('#mensagem');
const enviarButton = document.querySelector('#enviar');

enviarButton.addEventListener('click', () =>{
    const username = usernameInput.value;
    const mensagem = mensagemInput.value;
    const data = `${username}: ${mensagem}`;
    socket.emit('chat mensagem', data);
    mensagemInput.value = '';
})
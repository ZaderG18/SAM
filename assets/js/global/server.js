const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io')(server);

server.listen(3000, ()=> {
    console.log('Servidor funcionando na porta 3000');
});

io.on('conexao', (socket) => {
    console.log('Conexão estabelecida com o cliente.');

    socket.on('desconectado', () =>{
        console.log('Conexão encerrada.');
        });

        socket.on('chat mensagem', (data) => {
            console.log(`Mensagem recebida: ${data}`);
            io.emit('chat mensagem', data);
        });
    });
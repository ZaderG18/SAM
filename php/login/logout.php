<?php
// Inicia a sessão ou continua a sessão existente.
session_start();

// Remove todas as variáveis de sessão atuais.
session_unset();

// Destrói a sessão atual, efetivamente removendo todos os dados da sessão.
session_destroy();

// Redireciona o usuário para a página 'index.html' na pasta pai (../).
header('Location: ../../index.html');

// Garante que o script pare de ser executado após o redirecionamento.
exit();
?>

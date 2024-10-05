<?php

// Inicia a sessão se ainda não estiver iniciada.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Declarando variáveis para conectar ao banco de dados.
$host = "localhost";
$username = "root";
$password = "";
$dbName = "SAM";

// Conectando ao servidor MySQL com MySQLi.
$conn = new mysqli($host, $username, $password);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
echo "Conectado ao servidor com sucesso!<br>";

// Criando o banco de dados 'SAM' se ele não existir.
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados '$dbName' criado com sucesso!<br>";
} else {
    echo "Erro ao criar o banco de dados: " . $conn->error . "<br>";
}

// Reestabelece a conexão ao banco de dados específico 'SAM'.
$conn->select_db($dbName);
function atualizarBanco($conn){
// Consultas para criar as tabelas, se não existirem.
$tableQueries = [
    "aluno" => "CREATE TABLE IF NOT EXISTS aluno (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255) DEFAULT NULL,
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        curso VARCHAR(50),
        cargo VARCHAR(30) NOT NULL,
        nota1 INT DEFAULT 0,
        nota2 INT DEFAULT 0,
        nota3 INT DEFAULT 0,
        nota4 INT DEFAULT 0,
        nota_media DECIMAL(5,2) DEFAULT 0,
        situacao ENUM('aprovado', 'reprovado', 'recuperacao') DEFAULT 'recuperacao',
        data_matricula DATE NOT NULL,
        data_rematricula DATE DEFAULT NULL,
        data_saida DATE DEFAULT NULL,
        frequencia INT DEFAULT 0,
        codigo INT NOT NULL UNIQUE,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (email),
        INDEX (cpf),
        INDEX (RM)
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        disciplina VARCHAR(50) NOT NULL,
        cargo VARCHAR(30) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (email),
        INDEX (cpf),
        INDEX (RM)
    )",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        cargo VARCHAR(30) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (email),
        INDEX (cpf),
        INDEX (RM)
    )",
    "diretor" => "CREATE TABLE IF NOT EXISTS diretor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(40) NOT NULL,
        sobrenome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        cargo VARCHAR(30) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (email),
        INDEX (cpf),
        INDEX (RM)
    )",
    "turma" => "CREATE TABLE IF NOT EXISTS turma (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        disciplina VARCHAR(30) NOT NULL,
        professor_id INT NOT NULL,
        coordenador_id INT NOT NULL,
        data_inicio DATE NOT NULL,
        data_fim DATE NOT NULL,
        status ENUM('ativa', 'concluida', 'cancelada') DEFAULT 'ativa',
        FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
        FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE
    )",
    "disciplina" => "CREATE TABLE IF NOT EXISTS disciplina (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_disciplina VARCHAR(30) NOT NULL,
        carga_horaria INT NOT NULL,
        semestre INT NOT NULL,
        ano INT NOT NULL,
        professor_id INT NOT NULL,
        coordenador_id INT NOT NULL,
        FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
        FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE
    )",
    "matricula" => "CREATE TABLE if NOT EXISTS matricula (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        modulo_id INT NOT NULL,
        data_matricula DATE NOT NULL,
        status ENUM('ativo', 'inativo', 'concluido') DEFAULT 'ativo',
        FOREIGN KEY (aluno_id) REFERENCES alunos(id),
        FOREIGN KEY (turma_id) REFERENCES turmas(id),
        FOREIGN KEY (modulo_id) REFERENCES modulos(id)    
    )",
    "avaliacao" => "CREATE TABLE IF NOT EXISTS avaliacao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        nota DECIMAL(3,2) NOT NULL CHECK (nota >= 0 AND nota <= 10),
        data_avaliacao DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "notas" => "CREATE TABLE IF NOT EXISTS notas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        disciplina_id INT NOT NULL,
        faltas INT DEFAULT 0,
        nota1 DECIMAL(5,2) DEFAULT NULL,
        nota2 DECIMAL(5,2) DEFAULT NULL,
        nota3 DECIMAL(5,2) DEFAULT NULL,
        nota4 DECIMAL(5,2) DEFAULT NULL,
        nota_media  DECIMAL(5,2) DEFAULT NULL,
        observacoes TEXT,
        data_avaliacao DATE DEFAULT CURRENT_DATE,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE
    )",        
    "atividade" => "CREATE TABLE IF NOT EXISTS atividade (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        descricao TEXT NOT NULL,
        data_entrega DATE NOT NULL,
        status ENUM('pendente', 'concluida') DEFAULT 'pendente',
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
"atualizacoes" => "CREATE TABLE IF NOT EXISTS atualizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT,
    descricao TEXT,
    data_atualizacao DATETIME,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id)
);
",
"horarios" => "CREATE TABLE if NOT EXISTS horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    disciplina VARCHAR(100) NOT NULL,
    dia_semana VARCHAR(15) NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) -- Altere para o nome correto da tabela de alunos
);
",
    "frequencia" => "CREATE TABLE IF NOT EXISTS frequencia (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        status VARCHAR (50) NOT NULL,
        aulas_dadas INT,
        disciplina VARCHAR(255),
        faltas INT;
        faltas_permitidas INT,
        frequencia_atual DECIMAL(5,2),
        frequencia_total INT,
        data DATE NOT NULL,
        presenca TINYINT(1) NOT NULL,  -- 1 para presente, 0 para ausente
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
        FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "mensao" => "CREATE TABLE IF NOT EXISTS mensao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        data DATE DEFAULT CURRENT_DATE,
        observacao TEXT NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE
    )"
];

// Executando as consultas para criar as tabelas
foreach ($tableQueries as $tableName => $query) {
    if ($conn->query($query) === TRUE) {
        echo "Tabela '$tableName' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar tabela '$tableName': " . $conn->error . "<br>";
    }
}

// Criando as Views
$viewQueries = [
    "view_alunos" => "CREATE OR REPLACE VIEW view_alunos AS
    SELECT id, RM, nome, sobrenome, email, cargo, data_matricula, status
    FROM aluno",
    
    "view_professores" => "CREATE OR REPLACE VIEW view_professores AS
    SELECT id, RM, nome, sobrenome, email, disciplina, cargo, status
    FROM professor",
    
    "view_coordenadores" => "CREATE OR REPLACE VIEW view_coordenadores AS
    SELECT id, RM, nome, sobrenome, email, cargo, status
    FROM coordenador",
    
    "view_turmas" => "CREATE OR REPLACE VIEW view_turmas AS
    SELECT t.id, t.nome, t.disciplina, p.nome AS professor, c.nome AS coordenador, t.data_inicio, t.data_fim, t.status
    FROM turma t
    JOIN professor p ON t.professor_id = p.id
    JOIN coordenador c ON t.coordenador_id = c.id",
    
    "view_matriculas" => "CREATE OR REPLACE VIEW view_matriculas AS
    SELECT m.id, a.nome AS aluno, t.nome AS turma, m.data_matricula, m.status
    FROM matricula m
    JOIN aluno a ON m.aluno_id = a.id
    JOIN turma t ON m.turma_id = t.id",
    
    "view_avaliacoes" => "CREATE OR REPLACE VIEW view_avaliacoes AS
    SELECT a.nome AS aluno, t.nome AS turma, av.nota, av.data_avaliacao
    FROM avaliacao av
    JOIN aluno a ON av.aluno_id = a.id
    JOIN turma t ON av.turma_id = t.id",
    
    "view_frequencias" => "CREATE OR REPLACE VIEW view_frequencias AS
    SELECT f.data, a.nome AS aluno, t.nome AS turma, f.presenca
    FROM frequencia f
    JOIN aluno a ON f.aluno_id = a.id
    JOIN turma t ON f.turma_id = t.id",
    
    "view_atividades" => "CREATE OR REPLACE VIEW view_atividades AS
    SELECT a.nome AS aluno, t.nome AS turma, at.descricao, at.data, at.status
    FROM atividade at
    JOIN aluno a ON at.aluno_id = a.id
    JOIN turma t ON at.turma_id = t.id"
];

// Executando as consultas para criar as views
foreach ($viewQueries as $viewName => $query) {
    if ($conn->query($query) === TRUE) {
        echo "View '$viewName' criada com sucesso!<br>";
    } else {
        echo "Erro ao criar view '$viewName': " . $conn->error . "<br>";
    }
}
}
atualizarBanco($conn);

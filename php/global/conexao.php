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
    foto VARCHAR(255) DEFAULT NULL,
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    nome VARCHAR(40) NOT NULL,
    telefone VARCHAR(15),
    data_nascimento DATE NOT NULL,
    genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
    endereco TEXT,
    curso_id INT NOT NULL,  -- Relacionando o aluno com o curso
    nota_id INT NOT NULL,
    cargo VARCHAR(30) NOT NULL,
    situacao ENUM('aprovado', 'reprovado', 'recuperacao') DEFAULT 'recuperacao',
    data_matricula DATE NOT NULL,
    data_rematricula DATE DEFAULT NULL,
    data_saida DATE DEFAULT NULL,
    frequencia INT DEFAULT 0,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    -- FOREIGN KEY (curso_id) REFERENCES curso(id) ON DELETE CASCADE
)",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    RM VARCHAR(10) NOT NULL UNIQUE,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    foto VARCHAR(255),
    email VARCHAR(40) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(40) NOT NULL,
    reset_token VARCHAR(255) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    telefone VARCHAR(15),
    data_nascimento DATE NOT NULL,
    genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
    endereco TEXT,
    cargo VARCHAR(30) NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        reset_token VARCHAR(255) DEFAULT NULL,
        reset_expires DATETIME DEFAULT NULL,
        nome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        cargo VARCHAR(30) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "diretor" => "CREATE TABLE IF NOT EXISTS diretor (
        id INT AUTO_INCREMENT PRIMARY KEY,
        RM VARCHAR(10) NOT NULL UNIQUE,
        cpf VARCHAR(11) NOT NULL UNIQUE,
        foto VARCHAR(255),
        email VARCHAR(40) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        reset_token VARCHAR(255) DEFAULT NULL,
        reset_expires DATETIME DEFAULT NULL,
        nome VARCHAR(40) NOT NULL,
        telefone VARCHAR(15),
        data_nascimento DATE NOT NULL,
        genero ENUM('masculino', 'feminino', 'nao-binario', 'prefiro-nao-dizer') NOT NULL,
        endereco TEXT,
        cargo VARCHAR(30) NOT NULL,
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
    curso_id INT NOT NULL,  
    FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE,
    FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES curso(id) ON DELETE CASCADE
)",
    "matricula" => "CREATE TABLE if NOT EXISTS matricula (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        modulo_id INT NOT NULL,
        data_matricula DATE NOT NULL,
        status ENUM('ativo', 'inativo', 'concluido') DEFAULT 'ativo',
        FOREIGN KEY (aluno_id) REFERENCES aluno(id),
        FOREIGN KEY (turma_id) REFERENCES turma(id),
        FOREIGN KEY (modulo_id) REFERENCES modulo(id)    
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
)",
"horarios" => "CREATE TABLE if NOT EXISTS horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    disciplina VARCHAR(100) NOT NULL,
    dia_semana VARCHAR(15) NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) -- Altere para o nome correto da tabela de alunos
)",
    "frequencia" => "CREATE TABLE IF NOT EXISTS frequencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    aulas_dadas INT,
    faltas INT,
    faltas_permitidas INT,
    frequencia_atual DECIMAL(5,2),
    frequencia_total INT,
    data DATE NOT NULL,
    presenca TINYINT(1) NOT NULL,  -- 1 para presente, 0 para ausente
    disciplina_id INT,  -- Agora referenciando a tabela disciplina
    FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE,
    FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE
    )",
    "mensao" => "CREATE TABLE IF NOT EXISTS mensao (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        data DATE DEFAULT CURRENT_DATE,
        observacao TEXT NOT NULL,
        FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE
    )",
    "curso" => "CREATE TABLE IF NOT EXISTS curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    descricao TEXT,
    carga_horaria INT NOT NULL
    )",
    "historico_academico" => "CREATE TABLE IF NOT EXISTS historico_academico (
    id INT AUTO_INCREMENT PRIMARY KEY,           
    aluno_id INT NOT NULL,                       
    disciplina_id INT NOT NULL,                  
    semestre VARCHAR(10) NOT NULL,  
    faltas INT DEFAULT 0,                        
    nota DECIMAL(4,2) DEFAULT NULL,              
    status ENUM('aprovado', 'reprovado', 'pendente') NOT NULL DEFAULT 'pendente',
    data_conclusao DATE DEFAULT NULL,
    CONSTRAINT fk_aluno_id FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE,
    CONSTRAINT fk_disciplina_id FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE
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
}
atualizarBanco($conn);

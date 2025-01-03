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
//echo "Conectado ao servidor com sucesso!<br>";

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

$tableQueries = [
    "usuarios" => "CREATE TABLE IF NOT EXISTS usuarios (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    RM varchar(10) NOT NULL UNIQUE,
    cpf varchar(11) DEFAULT NULL,
    foto varchar(255) DEFAULT NULL,
    email varchar(40) NOT NULL UNIQUE,
    senha varchar(255) NOT NULL,
    reset_token varchar(255) DEFAULT NULL,
    reset_expires datetime DEFAULT NULL,
    nome varchar(40) NOT NULL,
    telefone varchar(15) DEFAULT NULL,
    estado_civil VARCHAR(50),
    data_nascimento date NOT NULL,
    genero enum('masculino','feminino','nao-binario','prefiro-nao-dizer') NOT NULL,
    endereco text DEFAULT NULL,
    cargo enum('aluno','professor','diretor','coordenador') NOT NULL,
    status enum('ativo','inativo') DEFAULT 'ativo',
    data_matricula date DEFAULT NULL,
    data_rematricula date DEFAULT NULL,
    nacionalidade varchar(50) DEFAULT NULL,
    data_saida date DEFAULT NULL,
    data_criacao timestamp NOT NULL DEFAULT current_timestamp(),
    updated_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
  )",
  "cronograma" => "CREATE TABLE if not exists cronograma (
    id INT AUTO_INCREMENT PRIMARY KEY,
    horario VARCHAR(20) NOT NULL,
    dia VARCHAR(10) NOT NULL,
    disciplina VARCHAR(100) NOT NULL
)",
"enquetes" => "CREATE TABLE enquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta VARCHAR(255),
    tipo VARCHAR(50),
    resposta VARCHAR(255),
    comentario text,
    enquete_id INT
)",
    "academico" => "CREATE TABLE IF NOT EXISTS academico (
        id INT PRIMARY KEY AUTO_INCREMENT,
        aluno_id INT,
        curso VARCHAR(255),
        periodo VARCHAR(50),
        modulo_atual INT,
        turma VARCHAR(50),
        nome_professor VARCHAR(255),
        bolsas_auxilios VARCHAR(255),
        horas_complementares INT,
        estagio_atual VARCHAR(255)
    )",
    "materias" => "CREATE TABLE IF NOT EXISTS materias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        descricao VARCHAR(255) NOT NULL,
        nome VARCHAR(20),
        imagem ENUM('aula_01.jpg', 'aula_02.jpg', 'aula_03.jpg', 'aula_04.jpg', 'aula_05.jpg', 'aula_06.jpg'),
        professor_id INT(11),
        turma_id INT(11),
        codigo VARCHAR(100), 
        semestre VARCHAR(50), 
        professor VARCHAR(255),
        aluno_id INT(11),
        progresso INT DEFAULT 0
    )",
    "aluno" => "CREATE TABLE IF NOT EXISTS aluno (
        id INT(11) NOT NULL,
        matricula VARCHAR(20) NOT NULL UNIQUE
    )",
    "turma" => "CREATE TABLE IF NOT EXISTS turma (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome varchar(50) NOT NULL,
        disciplina_id int(11) NOT NULL,
        professor_id int(11) NOT NULL,
        progresso TINYINT(3) UNSIGNED DEFAULT 0,
        coordenador_id int(11) NOT NULL,
        data_inicio date NOT NULL,
        aluno_id int(11) NOT NULL,
        imagem ENUM('aula_01.jpg', 'aula_02.jpg', 'aula_03.jpg', 'aula_04.jpg', 'aula_05.jpg', 'aula_06.jpg'),
        data_fim date NOT NULL,
        status enum('ativa','concluida','cancelada') DEFAULT 'ativa',
        data_criacao timestamp NOT NULL DEFAULT current_timestamp()
    )",
    "avaliacao" => "CREATE TABLE IF NOT EXISTS avaliacao (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        aluno_id int(11) NOT NULL,
        turma_id int(11) NOT NULL,
        nota decimal(3,2) NOT NULL CHECK (`nota` >= 0 and `nota` <= 10),
        data_avaliacao date DEFAULT curdate()

    )",

    "atividade_extracurricular" => "CREATE TABLE IF NOT EXISTS atividade_extracurricular (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        tipo_atividade VARCHAR(100) NOT NULL,
        descricao TEXT,
        data_inicio DATE,
        data_fim DATE,
        carga_horaria INT,
        certificado LONGBLOB,  -- Caso você queira armazenar um certificado digital
        criacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        atualizacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        status ENUM('em_andamento', 'concluida', 'cancelada') DEFAULT 'em_andamento'
    )",
    "atualizacoes" => "CREATE TABLE IF NOT EXISTS atualizacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT,
        descricao TEXT,
        data_atualizacao DATETIME,
        professor_id INT
    )",
    
    "contato_emergencia"=>"CREATE TABLE if not exists contato_emergencia ( 
        id INT PRIMARY KEY AUTO_INCREMENT, 
        aluno_id INT, 
        professor_id INT, 
        nome_emergencia VARCHAR(255), 
        parente_emergencia VARCHAR(50), 
        telefone_emergencia VARCHAR(20), 
        email_emergencia VARCHAR(255)
    )",
    "coordenador" => "CREATE TABLE IF NOT EXISTS coordenador (
        id INT(11) NOT NULL,
            setor VARCHAR(50) NOT NULL
    )",
    "curso" => "CREATE TABLE IF NOT EXISTS curso (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome_curso VARCHAR(255) NOT NULL,
        codigo VARCHAR(50) NOT NULL,
        descricao TEXT NOT NULL,
        departamento VARCHAR(100) NOT NULL,
        carga_horaria INT(6) NOT NULL,
        pre_requisitos VARCHAR(255),
        tipo_curso VARCHAR(50) NOT NULL,
        nivel_curso VARCHAR(50) NOT NULL,
        aluno_id INT NOT NULL,
        periodo VARCHAR(100) NOT NULL,
        status_curso VARCHAR(50) NOT NULL,
        data_inicio DATE NOT NULL,
        data_termino DATE NOT NULL,
        vagas INT(6) NOT NULL,
        modalidade VARCHAR(100) NOT NULL,
        material_recurso TEXT,
        observacoes TEXT,
        imagem_curso VARCHAR(255) NOT NULL,  -- Alterado para VARCHAR para armazenar o caminho da imagem
        fk_professor_id INT NOT NULL
    )",
    "declaracao" => "CREATE TABLE IF NOT EXISTS declaracao (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tipo_declaracao VARCHAR(50),
            motivo TEXT,
            tipo_declaracao ENUM('atestado', 'historico', 'planoEnsino', 'relatorio', 'transporte', 'matricula', 'conclusao', 'frequencia' ),
            usuario_id INT NOT NULL,
            turma_id INT NOT NULL,
            protocolo VARCHAR(50) UNIQUE,
            data_solicitacao DATETIME DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pendente', 'pronto') DEFAULT 'pendente'
    )",
    "materias_complementares" => "CREATE TABLE materiais_complementares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    link VARCHAR(255),
    materias_id INT,
    data_publicacao DATE
)",
    "diretor" => "CREATE TABLE IF NOT EXISTS diretor (
        id INT(11) NOT NULL,
        nivel_acesso ENUM('junior', 'senior', 'executivo') NOT NULL
    )",
    "eventos" => "CREATE TABLE IF NOT EXISTS eventos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        data DATE NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT NOT NULL
    )",
    "solicitacoes" => "CREATE TABLE IF NOT EXISTS solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    id_usuario VARCHAR(20) NOT NULL,
    curso_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    arquivo VARCHAR(255),
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)",
    "atividade" => "CREATE TABLE IF NOT EXISTS atividade (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        descricao TEXT NOT NULL,
        professor_id INT NOT NULL,
        titulo VARCHAR(30) NOT NULL,
        conteudo TEXT NOT NULL,
        data_vencimento DATE,
        hora_vencimento TIME,
        arquivo LONGBLOB,  
        data_entrega DATE NOT NULL,
        criacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        atualizacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        status ENUM('pendente', 'concluida') DEFAULT 'pendente'
    )",
     "frequencia" => "CREATE TABLE IF NOT EXISTS frequencia (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT NOT NULL,
        status VARCHAR(50) NOT NULL,
        avaliacao_id INT(11) NOT NULL,
        declaracao_id INT(11) NOT NULL,
        aulas_dadas INT,
        faltas INT,
        observacao VARCHAR(200),
        professor_id INT,
        faltas_permitidas INT,
        frequencia_atual DECIMAL(5,2),
        frequencia_total INT,
        data DATE NOT NULL,
        presenca TINYINT(1) NOT NULL,  -- 1 para presente, 0 para ausente
        disciplina_id INT  
    )",
    "historico_academico" => "CREATE TABLE IF NOT EXISTS historico_academico (
        id INT AUTO_INCREMENT PRIMARY KEY,           
        aluno_id INT NOT NULL,                       
        disciplina_id INT NOT NULL,
        turma_id INT NOT NULL,
        avaliacao_id INT NOT NULL,
        declaracao_id INT NOT NULL,
        frequencia_id INT NOT NULL,                
        semestre VARCHAR(10) NOT NULL,  
        faltas INT DEFAULT 0,                        
        nota DECIMAL(4,2) DEFAULT NULL,              
        status ENUM('aprovado', 'reprovado', 'pendente') NOT NULL DEFAULT 'pendente',
        data_conclusao DATE DEFAULT NULL
    )",
    
    "disciplina" => "CREATE TABLE IF NOT EXISTS disciplina (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome_disciplina varchar(30) NOT NULL,
        carga_horaria int(11) NOT NULL,
        semestre int(11) NOT NULL,
        taxa_reprovacao FLOAT DEFAULT 0,
        ano int(11) NOT NULL,
        professor_id int(11) NOT NULL,
        coordenador_id int(11) NOT NULL,
        aluno_id int(11) NOT NULL,
        avaliacao_id int(11) NOT NULL,
        declaracao_id int(11) NOT NULL
    )",
    "horario" => "CREATE TABLE if NOT EXISTS horario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        aluno_id INT NOT NULL,
        turma_id INT (11) NOT NULL,
        avaliacao_id INT(11) NOT NULL,
        declaracao_id INT(11) NOT NULL,
        professor_id int(11) NOT NULL,
        frequencia_id INT(11) NOT NULL,
        disciplina_id INT (11) NOT NULL,
        dia_semana enum('Segunda','Terça','Quarta','Quinta','Sexta','Sábado') DEFAULT NULL,
        hora_inicio TIME NOT NULL,
        hora_fim TIME NOT NULL
    )",
    
    "matricula" => "CREATE TABLE if NOT EXISTS matricula (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        aluno_id int(11) NOT NULL,
        turma_id int(11) NOT NULL,
        avaliacao_id int(11) NOT NULL,
        frequencia_id int(11) NOT NULL,
        historico_academico_id int(11) NOT NULL,
        data_matricula date NOT NULL,
        status enum('ativo','inativo','concluido') DEFAULT 'ativo'
    )",
    "mensagens_chat" =>"CREATE TABLE IF NOT EXISTS mensagens_chat (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        receptor_id INT NOT NULL,
        tipo_chat ENUM('privado', 'grupo') DEFAULT 'privado',
        chat_turma INT NOT NULL,
        mensagem TEXT NOT NULL,
        data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "desempenho_alunos" => "CREATE TABLE desempenho_alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_disciplina VARCHAR(255),
    turma_id VARCHAR(10),
    desempenho DECIMAL(5,2),
    disciplinas_risco VARCHAR(255),
    observacoes TEXT,
    img_path VARCHAR(255)
)",
    "progresso_academico" => "CREATE TABLE IF NOT EXISTS progresso_academico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_disciplina VARCHAR(255) NOT NULL,
    progresso INT NOT NULL,
    aluno_id INT,
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id)
)",
"desempenho_turmas" => "CREATE TABLE desempenho_turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_turma VARCHAR(255) NOT NULL,
    media_notas DECIMAL(5,2) NOT NULL,
    professor_id INT,
    FOREIGN KEY (professor_id) REFERENCES professor(id)
)",
    "modulo" => "CREATE TABLE IF NOT EXISTS modulo ( 
        id INT AUTO_INCREMENT PRIMARY KEY, 
        nome_modulo VARCHAR(255) NOT NULL, 
        descricao_modulo TEXT, 
        aluno_id INT, 
        turma_id INT, 
        curso_id INT,
        matricula_id INT
    )",
    "notas" => "CREATE TABLE IF NOT EXISTS notas (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        aluno_id int(11) NOT NULL,
        disciplina_id int(11) NOT NULL,
        turma_id int(11) NOT NULL,
        modulo_id int(11) NOT NULL,
        recuperacao DECIMAL(5,2),
        disciplinas_risco VARCHAR(255),
        media_rec DECIMAL(5,2),
        nota1 decimal(5,2) DEFAULT NULL,
        nota2 decimal(5,2) DEFAULT NULL,
        nota_media decimal(5,2) DEFAULT NULL,
        observacoes text DEFAULT NULL,
        data_avaliacao date DEFAULT curdate()
    )",
    "relatorios" => "CREATE TABLE relatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kpis TEXT NOT NULL,
    frequencia_relatorios VARCHAR(255) NOT NULL
)",
"preferencias_notificacao" => "CREATE TABLE IF NOT EXISTS preferencias_notificacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    notificacao_email TINYINT(1) DEFAULT 0, -- 1 para sim, 0 para não
    notificacao_telefone TINYINT(1) DEFAULT 0, -- 1 para sim, 0 para não
    senha_segura TINYINT(1) DEFAULT 0, -- 1 para sim, 0 para não
    receber_notificacoes TINYINT(1) DEFAULT 0, -- 1 para sim, 0 para não
    compartilhar_dados TINYINT(1) DEFAULT 0, -- 1 para sim, 0 para não
    FOREIGN KEY (user_id) REFERENCES usuarios(id) -- Relacionamento com a tabela de usuários
)",
    "permissoes" => "CREATE TABLE IF NOT EXISTS permissoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    papel VARCHAR(255) NOT NULL,
    modulo_acesso VARCHAR(255) NOT NULL
)",
    "notificacoes" => "CREATE TABLE IF NOT EXISTS notificacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        tipo_usuarios ENUM('aluno', 'professor', 'coordenador', 'diretor') NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        mensagem TEXT NOT NULL,
        canais TEXT NOT NULL,
        frequencia_notif VARCHAR(255) NOT NULL,
        imagem VARCHAR(255) DEFAULT NULL,
        link VARCHAR(255) DEFAULT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        lida TINYINT(1) DEFAULT 0 -- 0 para não lida, 1 para lida
    )",
    "professor" => "CREATE TABLE IF NOT EXISTS professor (
        id INT(11) NOT NULL,
        departamento VARCHAR(50) NOT NULL,
        data_admissao DATE,
        disciplinas_id INT(11) NOT NULL,
        sala VARCHAR(50),
        orientacoes TEXT,
        projetos_pesquisa TEXT,
        publicacoes TEXT,
        desempenho TEXT,
        projetos TEXT
    )",
    "rematricula" => "CREATE TABLE IF NOT EXISTS rematricula (
        id INT PRIMARY KEY AUTO_INCREMENT,
        aluno_id INT NOT NULL,
        data_rematricula DATE NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pendente'
    )",
    "secretaria" => "CREATE TABLE IF NOT EXISTS secretaria (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo ENUM('horario', 'prazo_documentos', 'comunicado_rematricula', 'equipe', 'documentos_necessarios', 'eventos', 'faq', 'formulario_suporte') NOT NULL,
        titulo VARCHAR(255),         -- Usado para 'comunicado', 'evento', 'faq'
        descricao TEXT,              -- Usado para 'documento', 'comunicado', 'evento', 'faq'
        prazo INT,                   -- Usado para 'documento'
        data_inicio DATE,            -- Usado para 'comunicado', 'evento'
        data_fim DATE,               -- Usado para 'comunicado'
        hora TIME,                   -- Usado para 'evento'
        pergunta TEXT,               -- Usado para 'faq'
        resposta TEXT,               -- Usado para 'faq'
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Para controle
        diretor_id INT,
        coordenador_id INT,
        professor_id INT
    )",
"observacoes" => "CREATE TABLE observacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    observacao TEXT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)",
    "relatorio" => "CREATE TABLE IF NOT EXISTS relatorio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
     usuario_id INT NOT NULL,
     titulo VARCHAR(255) NOT NULL,
     mes_ano VARCHAR(7) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pendente', 'concluido') DEFAULT 'pendente'
)",
    "sistema" => "CREATE TABLE IF NOT EXISTS sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ano_letivo VARCHAR(255) NOT NULL,
    nota_minima DECIMAL(5,2) NOT NULL,
    frequencia_minima DECIMAL(5,2) NOT NULL,
    modulos TEXT NOT NULL
)",
    "reuniao" => "CREATE TABLE IF NOT EXISTS reuniao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    data DATETIME NOT NULL
)",
    "comunicado" => "CREATE TABLE IF NOT EXISTS comunicado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    data DATETIME NOT NULL
)",
"feedback" => "CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    atividade_id INT NOT NULL,
    feedback TEXT NOT NULL,
    data_feedback TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (atividade_id) REFERENCES atividade(id) ON DELETE CASCADE
)",
"tutores" => "CREATE TABLE tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    materia_id INT NOT NULL,
    FOREIGN KEY (materia_id) REFERENCES materias(id)
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

// Array com as consultas para adicionar chaves estrangeiras
$foreignKeys = [
    "ALTER TABLE academico ADD CONSTRAINT fk_academico_aluno FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE",
    "ALTER TABLE turma ADD CONSTRAINT fk_turma_disciplina FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE",
    "ALTER TABLE turma 
ADD CONSTRAINT fk_turma_professor 
FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE",
    "ALTER TABLE turma 
ADD CONSTRAINT fk_turma_coordenador 
FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE",
    "ALTER TABLE avaliacao 
ADD CONSTRAINT fk_avaliacao_aluno 
FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE",
    "ALTER TABLE avaliacao 
ADD CONSTRAINT fk_avaliacao_turma 
FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE enquetes ADD CONSTRAINT fk_enquetes FOREIGN KEY (enquete_id) REFERENCES enquetes(id) ON DELETE CASCADE",
    "ALTER TABLE secretaria 
ADD CONSTRAINT fk_secretaria_diretor 
FOREIGN KEY (diretor_id) REFERENCES diretor(id) ON DELETE CASCADE",
    "ALTER TABLE secretaria 
ADD CONSTRAINT fk_secretaria_coordenador 
FOREIGN KEY (coordenador_id) REFERENCES coordenador(id) ON DELETE CASCADE",
    "ALTER TABLE secretaria 
ADD CONSTRAINT fk_secretaria_professor 
FOREIGN KEY (professor_id) REFERENCES professor(id) ON DELETE CASCADE",
    "ALTER TABLE rematricula 
ADD CONSTRAINT fk_rematricula_aluno 
FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE",
    "ALTER TABLE notificacoes ADD CONSTRAINT fk_notificacoes_user FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE professor ADD CONSTRAINT fk_usuarios FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE notas 
ADD CONSTRAINT fk_notas_aluno 
FOREIGN KEY (aluno_id) REFERENCES aluno(id) ON DELETE CASCADE",
    "ALTER TABLE notas 
ADD CONSTRAINT fk_notas_disciplina 
FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE",
"ALTER TABLE relatorios ADD CONSTRAINT fk_relatorios_usuario ADD FOREIGN KEY (usuario_id) REFERENCES usuarios(id)",
    "ALTER TABLE notas 
ADD CONSTRAINT fk_notas_turma 
FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE notas ADD CONSTRAINT fk_notas_modulo FOREIGN KEY (modulo_id) REFERENCES modulo(id) ON DELETE CASCADE",
    "ALTER TABLE modulo 
ADD CONSTRAINT fk_modulo_turma 
FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE modulo 
ADD CONSTRAINT fk_modulo_matricula 
FOREIGN KEY (matricula_id) REFERENCES matricula(id) ON DELETE CASCADE",
"ALTER TABLE materias ADD CONSTRAINT fk_materias_professor FOREIGN KEY (professor_id) REFERENCES usuarios(id)",
"ALTER TABLE materias ADD CONSTRAINT fk_materias_turma FOREIGN KEY (turma_id) REFERENCES turma(id)",
"ALTER TABLE materias ADD CONSTRAINT fk_materias_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id)",
"ALTER TABLE turma ADD CONSTRAINT fk_turma_aluno FOREIGN key (aluno_id) REFERENCES usuarios(id)",
    "ALTER TABLE modulo ADD CONSTRAINT fk_modulo_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE curso ADD CONSTRAINT fk_aluno_curso FOREIGN KEY (aluno_id) REFERENCES usuarios (id) ON DELETE CASCADE",
    "ALTER TABLE mensagens_chat ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE professor ADD CONSTRAINT fk_professor_disciplina FOREIGN KEY (disciplinas_id) REFERENCES disciplina(id) ON DELETE CASCADE",
    "ALTER TABLE mensagens_chat ADD CONSTRAINT fk_receptor_id FOREIGN KEY (receptor_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE mensagens_chat ADD CONSTRAINT fk_mensagem_turma FOREIGN KEY (chat_turma) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE avaliacao ADD CONSTRAINT fk_materia FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE",
    "ALTER TABLE avaliacao ADD CONSTRAINT fk_materia FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE",
    "ALTER TABLE matricula ADD CONSTRAINT fk_matricula_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE matricula ADD CONSTRAINT fk_matricula_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE matricula ADD CONSTRAINT fk_matricula_historico FOREIGN KEY (historico_academico_id) REFERENCES historico_academico(id) ON DELETE CASCADE",
    "ALTER TABLE matricula ADD CONSTRAINT fk_matricula_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id) ON DELETE CASCADE",
    "ALTER TABLE matricula ADD CONSTRAINT fk_matricula_frequencia FOREIGN KEY (frequencia_id) REFERENCES frequencia(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_professor_horario FOREIGN KEY (professor_id) REFERENCES usuarios(id)",
    "ALTER TABLE solicitacoes ADD CONSTRAINT fk_solicitacao_curso_id FOREIGN KEY (curso_id) REFERENCES curso(id)",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_disciplina FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_declaracao FOREIGN KEY (declaracao_id) REFERENCES declaracao(id) ON DELETE CASCADE",
    "ALTER TABLE horario ADD CONSTRAINT fk_horario_frequencia FOREIGN KEY (frequencia_id) REFERENCES frequencia(id) ON DELETE CASCADE",
    "ALTER TABLE disciplina ADD CONSTRAINT fk_disciplina_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id) ON DELETE CASCADE",
    "ALTER TABLE disciplina ADD CONSTRAINT fk_disciplina_professor FOREIGN KEY (professor_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE disciplina ADD CONSTRAINT fk_disciplina_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE disciplina ADD CONSTRAINT fk_disciplina_coordenador FOREIGN KEY (coordenador_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE desempenho_alunos ADD CONSTRAINT fk_desempenho_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_aluno_id FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_disciplina_id FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_declaracao FOREIGN KEY (declaracao_id) REFERENCES declaracao(id) ON DELETE CASCADE",
    "ALTER TABLE historico_academico ADD CONSTRAINT fk_historico_frequencia FOREIGN KEY (frequencia_id) REFERENCES frequencia(id) ON DELETE CASCADE",
    "ALTER TABLE atividade ADD CONSTRAINT fk_atividade_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE atividade ADD CONSTRAINT fk_atividade_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE materiais_complementares ADD CONSTRAINT fk_materiais_materias FOREIGN KEY (materias_id) REFERENCES materias(id)",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_disciplina FOREIGN KEY (disciplina_id) REFERENCES disciplina(id) ON DELETE CASCADE",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_professor FOREIGN KEY (professor_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_declaracao FOREIGN KEY (declaracao_id) REFERENCES declaracao(id) ON DELETE CASCADE",
    "ALTER TABLE frequencia ADD CONSTRAINT fk_frequencia_avaliacao FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id) ON DELETE CASCADE",
    "ALTER TABLE eventos ADD CONSTRAINT fk_eventos_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE diretor ADD CONSTRAINT fk_diretor FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE declaracao ADD CONSTRAINT fk_declaracao_turma FOREIGN KEY (turma_id) REFERENCES turma(id) ON DELETE CASCADE",
    "ALTER TABLE declaracao ADD CONSTRAINT fk_declaracao_usuarios FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE curso ADD CONSTRAINT fk_curso_professor FOREIGN KEY (fk_professor_id) REFERENCES professor(id) ON DELETE CASCADE",
    "ALTER TABLE coordenador ADD CONSTRAINT fk_coordenador FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE contato_emergencia ADD CONSTRAINT fk_contato_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id)",
    "ALTER TABLE contato_emergencia ADD CONSTRAINT fk_contato_professor FOREIGN KEY (professor_id) REFERENCES usuarios(id)",
    "ALTER TABLE atualizacoes ADD CONSTRAINT fk_atualizacao_aluno FOREIGN KEY (aluno_id) REFERENCES usuarios(id)",
    "ALTER TABLE atualizacoes ADD CONSTRAINT fk_atualizacoes_professor FOREIGN KEY (professor_id) REFERENCES usuarios(id)",
    "ALTER TABLE atividade_extracurricular ADD CONSTRAINT fk_ati_extra_usuarios FOREIGN KEY (aluno_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE aluno ADD CONSTRAINT fk_aluno_usuarios FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE atividade ADD CONSTRAINT fk_atividade_id FOREIGN KEY (professor_id) REFERENCES usuarios(id) ON DELETE CASCADE"
];

// Executar consultas para criação das chaves estrangeiras
foreach ($foreignKeys as $query) {
    if ($conn->query($query) === TRUE) {
       echo "Chave estrangeira adicionada com sucesso.<br>";
    } else {
       echo "Erro ao adicionar chave estrangeira: " . $conn->error . "<br>";
    }
}

}
atualizarBanco($conn);

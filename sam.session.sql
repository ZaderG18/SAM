
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE if NOT exists `aluno` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `RM` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cargo` enum('aluno') NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','nao-binario','prefiro-nao-dizer') NOT NULL,
  `endereco` text DEFAULT NULL,
  `curso` varchar(50) DEFAULT NULL,
  `codigo` int(11) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Despejando dados para a tabela `aluno`
--


-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE if not exists `atividade` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `data` date NOT NULL,
  `status` enum('pendente','concluida') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE if not exists `avaliacao` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `nota` decimal(3,2) NOT NULL,
  `data_avaliacao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamada`
--

CREATE TABLE if not exists `chamada` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `nome_aluno` varchar(50) NOT NULL,
  `presente` tinyint(1) NOT NULL,
  `motivo_ausencia` varchar(50) DEFAULT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `coordenador`
--

CREATE TABLE if not exists `coordenador` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `RM` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cargo` enum('coordenador') NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cronograma`
--

CREATE TABLE if not exists `cronograma` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `turma_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `atividade` varchar(100) NOT NULL,
  `status` enum('pendente','concluida') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `declaracoes`
--

CREATE TABLE if not exists `declaracoes` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `declaracao` text NOT NULL,
  `data_emissao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `diretor`
--

CREATE TABLE if not exists `diretor` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `RM` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cargo` enum('diretor') NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

CREATE TABLE if not exists `disciplina` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `nome_disciplina` varchar(30) NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `ano` int(11) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `coordenador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `frequencia`
--

CREATE TABLE if not exists `frequencia` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `presenca` enum('presente','ausente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula`
--

CREATE TABLE if not exists `matricula` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `data_matricula` date DEFAULT curdate(),
  `status` enum('ativa','concluida','cancelada') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_chat`
--

CREATE TABLE if not exists `mensagens_chat` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `receptor_id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  `user_role` enum('aluno','professor','coordenador','diretor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensao`
--

CREATE TABLE if not exists `mensao` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `aluno_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `mensao` varchar(100) NOT NULL,
  `data_mensao` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE if not exists `professor` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `RM` varchar(10) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cargo` enum('professor') NOT NULL,
  `email` varchar(40) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `disciplina` varchar(50) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

CREATE TABLE if not exists `turma` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `nome` varchar(50) NOT NULL,
  `disciplina` varchar(30) NOT NULL,
  `professor_id` int(11) NOT NULL,
  `coordenador_id` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `status` enum('ativa','concluida','cancelada') DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



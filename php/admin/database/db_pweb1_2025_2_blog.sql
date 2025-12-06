-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

-- Copiando estrutura do banco de dados para db_pweb1_2025_2
CREATE DATABASE IF NOT EXISTS `db_pweb1_2025_2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_pweb1_2025_2`;

-- Copiando estrutura para tabela db_pweb1_2025_2.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) COLLATE utf8mb4_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Copiando dados para a tabela db_pweb1_2025_2.categoria: ~3 rows (aproximadamente)
INSERT INTO `categoria` (`id`, `nome`) VALUES
	(1, 'Tecnológia'),
	(2, 'Educação'),
	(3, 'Saúde');

-- Copiando estrutura para tabela db_pweb1_2025_2.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8mb4_bin NOT NULL DEFAULT '0',
  `descricao` text COLLATE utf8mb4_bin NOT NULL,
  `data_publicacao` date NOT NULL,
  `categoria_id` int NOT NULL DEFAULT '0',
  `usuario_id` int NOT NULL DEFAULT '0',
  `status` binary(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_post_categoria` (`categoria_id`),
  KEY `FK_post_usuario` (`usuario_id`),
  CONSTRAINT `FK_post_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`),
  CONSTRAINT `FK_post_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Copiando dados para a tabela db_pweb1_2025_2.post: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela db_pweb1_2025_2.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cpf` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `login` varchar(40) COLLATE utf8mb4_bin DEFAULT NULL,
  `senha` varchar(80) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Copiando dados para a tabela db_pweb1_2025_2.usuario: ~2 rows (aproximadamente)
INSERT INTO `usuario` (`id`, `nome`, `cpf`, `telefone`, `email`, `login`, `senha`) VALUES
	(1, 'admin', '123', '49 8866-5505', 'admi@admin.com', 'admin', '$2y$10$tKxcF8jtHkmgUOvCdGukYOGx1P7PT2uyjZHuw3CC.j.PhVoFrAlFa');

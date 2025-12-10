-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para pweb_athlos
CREATE DATABASE IF NOT EXISTS `pweb_athlos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pweb_athlos`;

-- Copiando estrutura para tabela pweb_athlos.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela pweb_athlos.blog: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela pweb_athlos.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `resumo` text NOT NULL,
  `conteudo` longtext NOT NULL,
  `imagem` varchar(500) DEFAULT NULL,
  `instrutor_id` int DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `instrutor_id` (`instrutor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela pweb_athlos.post: ~2 rows (aproximadamente)
INSERT INTO `post` (`id`, `titulo`, `categoria`, `resumo`, `conteudo`, `imagem`, `instrutor_id`, `criado_em`) VALUES
	(1, 'Treino de Hipertrofia Avançada — O Segredo para Ganhos Reais', 'treinos', 'Aprenda como estruturar um treino completo de hipertrofia avançada, usando técnicas modernas e estratégias que realmente funcionam para aumentar força e massa muscular.', 'A hipertrofia muscular não é apenas levantar peso. Ela exige estratégia, execução e progressão inteligente.⁣\r\n\r\nNeste guia criado especialmente para os alunos da Athlos Academy, você vai entender como montar um treino de alto desempenho, baseado nos pilares essenciais:\r\n\r\n🔥 **1. Sobrecarga Progressiva**\r\nPara evoluir, o músculo precisa ser constantemente desafiado. Aumente o peso gradualmente, ou aumente repetições/tempo sob tensão.\r\n\r\n🔥 **2. Técnica Perfeita**\r\nAntes de querer levantar mais, levante melhor. Execução correta aumenta recrutamento muscular e reduz risco de lesão.\r\n\r\n🔥 **3. Divisão de Treino Inteligente**\r\n- Peito + Tríceps  \r\n- Costas + Bíceps  \r\n- Pernas Completo  \r\n- Ombro + Abdômen\r\n\r\n🔥 4. Falha Muscular Controlada**\r\nUse métodos avançados como:\r\n- Drop Set  \r\n- Rest-Pause  \r\n- Bi-sets e Tri-sets  \r\n- Repetições Parciais  \r\n\r\n🔥 5. Alimentação e Recuperação\r\nVocê não cresce no treino — cresce NO DESCANSO. Proteína suficiente e sono de 7–9h são essenciais.\r\n\r\n---\r\n\r\n💪 **Treino Completo (Exemplo Avançado — Peito e Tríceps)**\r\n\r\n**Supino Reto** — 4x 6–8 reps  \r\n**Supino Inclinado Halter** — 4x 8–10 reps  \r\n**Crucifixo Máquina** — 3x 12–15 reps + drop set  \r\n**Paralelas** — 3 séries até a falha  \r\n**Tríceps Corda** — 4x 10–12 reps  \r\n**Tríceps Testa** — 3x 10 reps  \r\n**Tríceps Banco** — 2 séries até a falha⁣\r\n\r\n---\r\n\r\n🚀 Conclusão\r\nO segredo não é treinar mais… é treinar melhor.  \r\nAplique esse protocolo por 6 a 8 semanas e observe resultados sólidos na força, estética e definição muscular.\r\n\r\nSe quiser um treino totalmente personalizado, fale com seu instrutor no atendimento da Athlos Academy!', 'https://images.pexels.com/photos/4753893/pexels-photo-4753893.jpeg', 22, '2025-11-26 13:14:23'),
	(8, 'aasa', 'nutricao', 'as', 'dsfd', 'sd', 22, '2025-12-10 21:50:25');

-- Copiando estrutura para tabela pweb_athlos.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `descricao` text,
  `imagem` varchar(500) DEFAULT NULL,
  `estoque` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela pweb_athlos.produto: ~3 rows (aproximadamente)
INSERT INTO `produto` (`id`, `nome`, `categoria`, `preco`, `descricao`, `imagem`, `estoque`) VALUES
	(1, 'Whey 100%HD Black Skull - CHOCOLATE', 'whey', 78.90, 'Whey 100%HD Black Skull  sabor Chocolate, importado direto da fábrica, possui um ótimo sabor, boa diluição e alta quantidade de proteina comparando ao preço da porção.', 'https://blackskullusa.vtexassets.com/arquivos/ids/161074/Pote-900g-WHEY-100-HD-GOURMET-chocolate.jpg?v=638853372195770000', 45),
	(2, 'Pré treino Insane Clown -LIMÃO', 'pretreino', 139.90, 'Um pré treino apenas para os mais preparados, o formigamento e seus efeitos são de alta intensidade!', 'https://images.tcdn.com.br/img/img_prod/920697/insane_clown_350g_demons_lab_1905_2_5927835eb7d62b2a0d28f0b99e80112e.jpeg', 55),
	(3, 'Creatina Monohidratada', 'creatina', 67.90, 'A creatina importada da Growth, com selo CREAPURE alemão, um suplemento de extrema qualidade para melhorar seus rendimentos no treinamento', 'https://www.gsuplementos.com.br/upload/produto/imagem/creatina-250g-creapure-growth-supplements-1.webp', 34);

-- Copiando estrutura para tabela pweb_athlos.treino
CREATE TABLE IF NOT EXISTS `treino` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `instrutor_id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text,
  `categoria` varchar(100) DEFAULT NULL,
  `nivel` varchar(100) DEFAULT NULL,
  `imagem` varchar(500) DEFAULT NULL,
  `data_prevista` date DEFAULT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_treino_aluno` (`aluno_id`),
  KEY `fk_treino_instrutor` (`instrutor_id`),
  CONSTRAINT `fk_treino_aluno` FOREIGN KEY (`aluno_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_treino_instrutor` FOREIGN KEY (`instrutor_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela pweb_athlos.treino: ~3 rows (aproximadamente)
INSERT INTO `treino` (`id`, `aluno_id`, `instrutor_id`, `titulo`, `descricao`, `categoria`, `nivel`, `imagem`, `data_prevista`, `data_criacao`) VALUES
	(8, 24, 22, 'Treino de Hipertrofia – Peito e Tríceps', 'ALONGAMENTO\r\nManguito na polia 2x12 cada braço\r\n\r\nTREINO\r\nSupino Reto 3x12\r\nSupino Inclinado 3x12\r\nCrucifixo 4x12\r\nVoador Máquina 4x12\r\n\r\nTríceps Banco 3x12\r\nTríceps Polia 4x12\r\nTríceps Corda 4x12', 'hipertrofia', 'iniciante', 'https://images.pexels.com/photos/4753893/pexels-photo-4753893.jpeg', '2025-12-10', '2025-11-26 21:26:52'),
	(10, 25, 22, 'Peitinho saliente do mateuzin', 'peitinho do mateus ', 'hipertrofia', 'iniciante', '', '2025-12-10', '2025-12-10 15:20:03'),
	(11, 24, 22, 'Treino de Hipertrofia Avançada — O Segredo para Ganhos Reais', 'fhjh', 'resistencia', 'iniciante', 'vhgf', '2025-12-19', '2025-12-10 15:47:35');

-- Copiando estrutura para tabela pweb_athlos.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `cpf` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '0',
  `tipo` varchar(50) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `endereco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `login` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `senha` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela pweb_athlos.usuario: ~7 rows (aproximadamente)
INSERT INTO `usuario` (`id`, `nome`, `cpf`, `tipo`, `data`, `email`, `endereco`, `login`, `senha`, `telefone`) VALUES
	(1, 'Lucas', '12800667923', 'instrutor', '2025-11-26', 'suportelightdesigner@gmail.com', 'aa', 'light', '$2y$10$gkb7GvRwEXnar0VKiJL2xO4TgHBQ/Sgf2ZgRhi7leni.BMASMdS.G', '(32) 32323-2323'),
	(11, 'João Siqueiraa', '12800667923', 'cliente', '2025-11-17', 'suportelightdesigner@gmail.com', 'aa', 'siqueira', '$2y$10$ST7B0fx6cEUS7v6ikdeTcuVVtje777wWzKDvvI3iXu.abrXroqF.K', '(32) 32323-2323'),
	(22, 'Jackson Meires', '56546', 'instrutor', '2025-11-27', 'admin@admin.com', 'Rua Jardim Itália, CEP 89806243', 'admin', '$2y$10$CI/QWe0rl6e1IAYGa0McJuq2pDyWtCopIrGzL5cRuISux55LN12R6', '4352342534251'),
	(23, 'testejackson', '123', 'instrutor', '2025-11-28', 'teste', 'aaa', 'jack', '$2y$10$FZ9x/UH4f5vV7dXkEPxqaOWMva4OcjrAlfcOepX9LvNSQY8dfWKOa', '123'),
	(24, 'Jackson Meires', '1231', 'cliente', '2025-11-27', 'cliente@cliente.com', 'asdasdas', 'cliente', '$2y$10$NXdRIRW33QFtLrxizfjYG.gG3UVGPmp.MsYgNipILy7jndGoswERa', '123'),
	(25, 'meteus ', '14013049902', 'cliente', '2008-04-29', 'mateusfranscisco@gmail.com', 'quedas palmital', 'mateuzin', '$2y$10$KRWDC7xFKVsLRIJEgn9vBuD10Jga6gyKklKbyVAy34JtKq/4bkPri', '(32) 32323-2323'),
	(26, 'aaa', '1212', 'cliente', '2025-12-11', '23we', 'asdsds', 'jackson', '$2y$10$htef8BEhnnUE9EGhSyP6autlR4vCfkm1ImyzpCIKsQaXtlyIbPoTu', '(32) 32323-2323');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

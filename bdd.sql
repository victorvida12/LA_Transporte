-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para la_transportes
CREATE DATABASE IF NOT EXISTS `la_transportes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `la_transportes`;

-- Copiando estrutura para tabela la_transportes.entregas
CREATE TABLE IF NOT EXISTS `entregas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `motorista_id` int DEFAULT NULL,
  `veiculo_id` int DEFAULT NULL,
  `origem` varchar(120) DEFAULT NULL,
  `destino` varchar(120) DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `data_chegada` date DEFAULT NULL,
  `status` enum('pendente','em_rota','concluída','cancelada') DEFAULT 'pendente',
  PRIMARY KEY (`id`),
  KEY `motorista_id` (`motorista_id`),
  KEY `veiculo_id` (`veiculo_id`),
  CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`motorista_id`) REFERENCES `motoristas` (`id`),
  CONSTRAINT `entregas_ibfk_2` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.financeiro
CREATE TABLE IF NOT EXISTS `financeiro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('Entrada','Saida') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_lancamento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.manutencoes
CREATE TABLE IF NOT EXISTS `manutencoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `veiculo_id` int NOT NULL,
  `descricao` text NOT NULL,
  `data_manutencao` date NOT NULL,
  `custo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veiculo_id` (`veiculo_id`),
  CONSTRAINT `manutencoes_ibfk_1` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.maquinario
CREATE TABLE IF NOT EXISTS `maquinario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `veiculo_id` int NOT NULL,
  `periodo_inicio` date NOT NULL,
  `periodo_fim` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `veiculo_id` (`veiculo_id`),
  CONSTRAINT `maquinario_ibfk_1` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.motoristas
CREATE TABLE IF NOT EXISTS `motoristas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `categoria_cnh` varchar(20) DEFAULT NULL,
  `validade_cnh` date DEFAULT NULL,
  `status` enum('Disponível','Em Serviço') NOT NULL DEFAULT 'Disponível',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.relatorio_entregas
CREATE TABLE IF NOT EXISTS `relatorio_entregas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entrega_id` int DEFAULT NULL,
  `local` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`id`),
  KEY `entrega_id` (`entrega_id`),
  CONSTRAINT `relatorio_entregas_ibfk_1` FOREIGN KEY (`entrega_id`) REFERENCES `entregas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','operador') DEFAULT 'operador',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela la_transportes.veiculos
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(10) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `ano` int DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `status` enum('Disponível','Em serviço','Indisponível') DEFAULT 'Disponível',
  PRIMARY KEY (`id`),
  UNIQUE KEY `placa` (`placa`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07-Out-2025 às 14:09
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `senailancadeiro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `materias`
--

DROP TABLE IF EXISTS `materias`;
CREATE TABLE IF NOT EXISTS `materias` (
  `nome_materia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sigla` varchar(100) NOT NULL,
  `carga_horaria` int NOT NULL,
  `id_materia` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `materias`
--

INSERT INTO `materias` (`nome_materia`, `sigla`, `carga_horaria`, `id_materia`) VALUES
('Análise de Eduardos em Banheiras', 'ANAL-EB', 1200, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

DROP TABLE IF EXISTS `professores`;
CREATE TABLE IF NOT EXISTS `professores` (
  `id_professor` int NOT NULL AUTO_INCREMENT,
  `nome_professor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `cpf` varchar(100) NOT NULL,
  `horarios` varchar(100) NOT NULL,
  `materias` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id_professor`, `nome_professor`, `email`, `senha`, `admin`, `cpf`, `horarios`, `materias`) VALUES
(0, 'Administrador', 'admin@gmail.com', '$2y$10$9oDpF9dqdLI04iwAie/3A.aoD9Y/l2o8Nvx8UVaXPhMW4tdaa.5DC', 1, '000.000.000-00', '', ''),
(7, 'Eduardo Penis', 'eduardo@gmail.com', '$2y$10$sE0eSahfkBF5tv43X9Dc/uhQy0n372zl.HXAr.7x07JFupQPm65IO', 0, '000.000.000-00', 'sabado-noite', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor_materia`
--

DROP TABLE IF EXISTS `professor_materia`;
CREATE TABLE IF NOT EXISTS `professor_materia` (
  `id_professor` int NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id_professor`,`id_materia`),
  KEY `fk_materia` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `professor_materia`
--
ALTER TABLE `professor_materia`
  ADD CONSTRAINT `fk_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores` (`id_professor`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

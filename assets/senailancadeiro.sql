-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23-Set-2025 às 10:26
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `cpf` varchar(100) NOT NULL,
  `horarios` varchar(100) NOT NULL,
  `materias` varchar(1000) NOT NULL,
  PRIMARY KEY (`id_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor_materia`
--

DROP TABLE IF EXISTS `professor_materia`;
CREATE TABLE IF NOT EXISTS `professor_materia` (
    `id_professor` INT NOT NULL,
    `id_materia` INT NOT NULL,
    PRIMARY KEY (`id_professor`, `id_materia`),
    CONSTRAINT `fk_professor` FOREIGN KEY (`id_professor`) REFERENCES `professores`(`id_professor`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `fk_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias`(`id_materia`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

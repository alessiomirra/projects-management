-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mar 13, 2024 alle 08:59
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `projects`
--

CREATE TABLE `projects` (
  `id` int(4) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `start` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `user_id` int(4) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('compleated','working') NOT NULL DEFAULT 'working'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `start`, `deadline`, `user_id`, `notes`, `status`) VALUES
(1, 'Sample Project', 'Sample Project Description', '2024-03-07', '2025-04-09', 2, 'Sample project notes', 'working'),
(3, 'Testing project form', 'Description project testing. Edit Test Passed', '2024-03-10', '2024-03-15', 1, 'Some additional notes', 'working'),
(5, 'Second Redirect Test', 'Second Redirect Description', '2024-03-10', '2024-03-31', 2, 'Second Redirect Description             ', 'working'),
(6, 'Third Redirect Test', 'Third Redirect Test Description', '2024-03-10', '2024-04-18', 2, 'Third Redirect Test Description           ', 'working'),
(7, 'Test', 'Test description', '2024-03-10', '2024-04-26', 2, 'Test Notes', 'working'),
(8, 'Test2', 'Test2 description', '2024-03-10', '2024-03-04', 4, 'Test2 notes', 'working'),
(9, 'Test3', 'Test3 description', '2024-03-10', '2024-02-26', 4, 'Test3 Notes', 'working');

-- --------------------------------------------------------

--
-- Struttura della tabella `tasks`
--

CREATE TABLE `tasks` (
  `id` int(4) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `creation` date NOT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('completed','working') NOT NULL DEFAULT 'working',
  `user_id` int(4) UNSIGNED NOT NULL,
  `project_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `creation`, `deadline`, `status`, `user_id`, `project_id`) VALUES
(3, 'Edit Task Test', 'Second task description', '2024-03-11', '2024-03-28', 'working', 4, 1),
(4, 'Task Test', 'Task Test description', '2024-03-11', '2024-04-21', 'working', 1, 8),
(5, 'A task for that project', 'A description for that task', '2024-03-11', '2024-03-29', 'working', 1, 6),
(6, 'Task 1', 'Task 1 description', '2024-03-12', '2024-03-29', 'working', 4, 3),
(7, 'Task 2', 'Task 2 description', '2024-03-12', '2024-03-31', 'working', 1, 5),
(8, 'Task 3', 'Task 3 description', '2024-03-12', '2024-04-16', 'working', 4, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(4) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roletype` enum('admin','visitor') NOT NULL DEFAULT 'visitor',
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `roletype`, `first_name`, `last_name`) VALUES
(1, 'alessiomirra', 'alessio@gmail.com', '$2y$10$Zec6b1z5nyUQ5g1L8RUWfOtzm7uwxtQ/NKkqlQl74AUeAPf7HDhfS', 'visitor', 'Alessio', 'Mirra'),
(2, 'admin', 'admin@php.com', '$2y$10$Zec6b1z5nyUQ5g1L8RUWfOtzm7uwxtQ/NKkqlQl74AUeAPf7HDhfS', 'admin', NULL, NULL),
(4, 'tester', 'tester@gmail.com', '$2y$10$01DQcxgX/FGwBFRSqvVKweKYSRBkQkGjYtCOHNOzm82Upq2tkERG2', 'visitor', 'Giulio', 'Cesare'),
(10, 'test', 'test@gmail.com', '$2y$10$V6yAFQDXXYvay0U1HvUhDeoZe66RP2Bpvsw4QQQvpb.Y4GzJ59WXG', 'visitor', 'Pinco', 'Pallo'),
(12, 'test3', 'test3@gmail.com', '$2y$10$1TN5ojrG7LEkXVOmFjd8WuRke0YdFBrG6jkfIM/YeoJ7oEza.dgZ6', 'visitor', NULL, NULL),
(13, 'test4', 'test4@gmail.com', '$2y$10$XLanH5cxC0jLnJwW9NHCdOW7DsS66P1dZMSr5qhnsHiE1pfas41TW', 'visitor', 'Marco', 'Mazzoli');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indici per le tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_id` (`project_id`),
  ADD KEY `fk_user_id_task` (`user_id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id_task` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

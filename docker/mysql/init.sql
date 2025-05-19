-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 12 mai 2025 à 15:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12
CREATE DATABASE IF NOT EXISTS seminaire_db;
USE seminaire_db;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `seminaire_db`
--



--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `statut` enum('en_attente','valide','rejete') DEFAULT 'en_attente',
  `date_validation` date DEFAULT NULL,
  `date_souhaitee` date DEFAULT NULL,
  `date_soumission` timestamp NOT NULL DEFAULT current_timestamp(),
  `resume` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandes`
--

INSERT INTO `demandes` (`id`, `user_id`, `theme`, `statut`, `date_validation`, `date_souhaitee`, `date_soumission`, `resume`, `created_at`) VALUES
(3, 1, 'you', 'en_attente', NULL, '2025-06-11', '2025-05-11 22:05:48', 'bien fait vbg vfjk', '2025-05-11 22:05:48');

-- --------------------------------------------------------

--
-- Structure de la table `presentations`
--

CREATE TABLE `presentations` (
  `id` int(11) NOT NULL,
  `programmation_id` int(11) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `programmations`
--

CREATE TABLE `programmations` (
  `id` int(11) NOT NULL,
  `demande_id` int(11) NOT NULL,
  `date_seminaire` date NOT NULL,
  `resume` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','presenter') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `mot_de_passe`, `role`, `created_at`) VALUES
(1, 'barugo', 'barugo@gmail.com', '$2y$10$HWyvdud53FtfduCVeyGF3.upWZVYIORiqazYjueYx3qW0c79XMYjq', 'presenter', '2025-05-11 11:27:26'),
(2, 'berulle', 'berulle@gmail.com', '$2y$10$yjgZBO23jhfXql/f0yU6h..5R/ci55VMbgxiUHTip03hAjC8J3Vqy', 'presenter', '2025-05-12 08:09:52'),
(3, 'admin', 'admin@gmail.com', '$2y$10$TG9FtMAdER78tHr3rglBROveIm4Ga5bWwq/5fj3py2O1Y2ros19pC', 'presenter', '2025-05-12 09:16:14'),
(4, 'admin', 'admin2@gmail.com', '$2y$10$K9ErwikgNBWen//RlaNVG.gb1mTbILrRxEi040VYy5KMp/wapWay2', 'admin', '2025-05-12 12:22:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `presentations`
--
ALTER TABLE `presentations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programmation_id` (`programmation_id`);

--
-- Index pour la table `programmations`
--
ALTER TABLE `programmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `demande_id` (`demande_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `presentations`
--
ALTER TABLE `presentations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `programmations`
--
ALTER TABLE `programmations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD CONSTRAINT `demandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `presentations`
--
ALTER TABLE `presentations`
  ADD CONSTRAINT `presentations_ibfk_1` FOREIGN KEY (`programmation_id`) REFERENCES `programmations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `programmations`
--
ALTER TABLE `programmations`
  ADD CONSTRAINT `programmations_ibfk_1` FOREIGN KEY (`demande_id`) REFERENCES `demandes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
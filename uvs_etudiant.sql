-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 24 avr. 2025 à 13:53
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `uvs_etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `eno`
--

CREATE TABLE `eno` (
  `id` int(11) NOT NULL,
  `nomEno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `eno`
--

INSERT INTO `eno` (`id`, `nomEno`) VALUES
(1, 'Dakar'),
(2, 'Diourbel'),
(3, 'Guédiawaye'),
(4, 'Podor');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `ine` varchar(200) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telephone` int(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `filiere` varchar(50) NOT NULL,
  `eno` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `ine`, `nom`, `prenom`, `email`, `telephone`, `sexe`, `filiere`, `eno`) VALUES
(1, 'N0010A', 'FALL', 'Mouhamed', 'mouhamed@uvs.sn', 776319628, 'masculin', 'MIC', 'Diourbel'),
(2, 'N0010B', 'Ndiaye', 'Fatou', 'fatou@gmail.com', 776006060, 'feminin', 'AGN', 'Diourbel'),
(3, 'N012', 'CISSE', 'Rokhaya', 'dabadakh@gmail.com', 776319628, 'feminin', 'AGN', 'Dakar'),
(4, 'N0122', 'Ndiaye', 'Modou', 'modou.ndiaye@uvs.sn', 776319628, 'feminin', 'CD', 'Diourbel'),
(5, 'N01255', 'CISSE', 'Rokhaya', 'dabadakh@gmail.com', 776319628, 'masculin', 'MIC', 'Diourbel'),
(6, 'N013', 'CISSE', 'Rokhaya', 'dabadakh@gmail.com', 776319628, 'masculin', 'MIC', 'Diourbel'),
(7, 'n022', 'Cisse', 'Rokhaya', 'daba@gmail.com', 77, 'feminin', 'AGN', 'Dakar'),
(8, 'NO752932899', 'diop', 'amadou', 'amadou@unchk.edu.sn', 772596635, 'masculin', 'MAI', 'Dakar'),
(9, 'NO752932899', 'junior', 'ndiaye', 'junior@unchk.edu.sn', 772596635, 'masculin', 'AGN', 'Dakar');

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `id` int(11) NOT NULL,
  `nomfiliere` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id`, `nomfiliere`) VALUES
(1, 'AGN'),
(2, 'CD'),
(3, 'EPS'),
(4, 'MAI'),
(5, 'MIC'),
(6, 'rst');

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id` int(11) NOT NULL,
  `nom_matiere` varchar(100) DEFAULT NULL,
  `filiere` varchar(100) DEFAULT NULL,
  `semestre` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id`, `nom_matiere`, `filiere`, `semestre`) VALUES
(1, 'anglais', 'AGN', '1'),
(2, 'devweb', 'MIC', '1'),
(3, 'math', 'MAI', '1'),
(4, 'philo', 'MIC', '2'),
(5, 'chinoi', 'CD', '2');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `ine` varchar(20) DEFAULT NULL,
  `nom_matiere` varchar(100) DEFAULT NULL,
  `note` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id`, `ine`, `nom_matiere`, `note`) VALUES
(1, 'NO752932899', 'anglais', 10.00),
(2, 'N0122', 'math', 20.00),
(3, 'N0010A', 'anglais', 10.00),
(4, 'NO752932899', 'anglais', 20.00),
(5, 'NO752932899', 'philo', 20.00);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL,
  `role` enum('admin','etudiant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `mot_de_passe`, `role`) VALUES
(1, 'admin@site.com', 'admin123', 'admin'),
(2, 'amadou@unchk.edu.sn', 'amadou123', 'etudiant'),
(3, 'mouhamed@uvs.sn', 'mouhamed123', 'etudiant'),
(6, 'admin@us.com', '$2y$10$Gf28hVBtqXXIWYrW13tDbeP8/MjHgg6H6sOsTRT6TIfgS5AzTa/kK', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `eno`
--
ALTER TABLE `eno`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `eno`
--
ALTER TABLE `eno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

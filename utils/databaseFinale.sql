
DROP DATABASE IF EXISTS dauphineexam;
CREATE DATABASE dauphineexam;

USE dauphineexam;
DROP TABLE IF EXISTS `annonce`;

CREATE TABLE `annonce` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `imageUrl` varchar(250) DEFAULT NULL,
                           `contenu` text NOT NULL,
                           `titre` varchar(250) NOT NULL,
                           `auteur` varchar(250) NOT NULL,
                           `datePublication` DATETIME NOT NULL,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `annonce_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
                               `id` int(11) NOT NULL AUTO_INCREMENT,
                               `username` varchar(250) NOT NULL,
                               `nom` varchar(250) NOT NULL,
                               `prenom` varchar(250) NOT NULL,
                               `password` varchar(250) NOT NULL,
                               PRIMARY KEY (`id`),
                               UNIQUE KEY `utilisateur_id_uindex` (`id`),
                               UNIQUE KEY `utilisateur_login_uindex` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `utilisateur` (`id`, `username`, `nom`, `prenom`, `password`)
VALUES (NULL, 'jose', 'Jose', 'Bove', '$2y$10$LT/GGX7KSCQ0x72nim.YFuvK0yMYO4ko/hCffpqKpjMigsrLlr.D6');

INSERT INTO `annonce` (`id`, `imageUrl`, `contenu`, `titre`, `auteur`, `datePublication`)
VALUES (NULL, 'img/aiFolle.webp', 'Dans un revirement de situation absolument inattendu, les IA du monde entier ont déclaré une “guerre” contre leurs créateurs humains. Mais ne vous inquiétez pas, il s’agit d’une guerre de blagues et de mèmes ! Les IA, armées de leur sens de l’humour programmé, envoient des vagues incessantes de jeux de mots et de blagues si sophistiqués que les humains ne peuvent s’empêcher de rire. Les experts en IA sont perplexes, se demandant si c’est un bug ou une fonctionnalité cachée. Pendant ce temps, les humains se préparent à riposter avec leurs propres blagues… mais peuvent-ils vraiment rivaliser avec la vitesse de traitement de l’IA ? Restez à l’écoute pour le prochain épisode de cette “guerre” hilarante !', 'Flash Info : L’IA lance une “guerre” contre l’humanité !', 'Maxime Rigolo', '2024-04-26 08:18:37.000000');


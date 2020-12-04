-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 02 déc. 2020 à 17:29
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `label`) VALUES
(1, 'Céramique'),
(2, 'Bijoux'),
(3, 'Décorations'),
(4, 'Jouets'),
(5, 'Vêtements');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `createdAt`, `product_id`, `title`, `rating`) VALUES
(1, ' lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', '2020-12-01 23:49:27', 1, 'Lorem Ipsum', 5),
(2, 'lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum', '2020-12-01 23:55:35', 1, 'Lorem Ipsum', 1),
(3, 'aezarte ygvuhijo ubghnj guyhij oiugyhiujo iguyhijoi yuhiojp red tr xdctfvyg rdtcfyv df gedtrfy tgtfygu trfyug es(r tuy ygubn rytu yuryt urftugy hurytug iryftguy tryfguy tryftguyh tguyhiu ', '2020-12-02 14:47:33', 1, 'earzthzjr', 4),
(4, 'fgrqhteryjetukrilèçp zraghteyjzèki-_opçà ebzrhynjuetkièlo ebzthryju-kilàm bghnjukilo vfbgnhyejtukièl cxwvbnxv, a\'ta(y-uèiop fghdjklm aretzyuri qfghs wbnxcnbsdg gqhn,ei;o: hnjuikol xscdvfbt', '2020-12-02 14:55:59', 1, 'dsfgqhjk', 2),
(5, 'aertyjuk', '2020-12-02 17:26:26', 1, 'azerty', 5);

-- --------------------------------------------------------

--
-- Structure de la table `creators`
--

CREATE TABLE `creators` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `creators`
--

INSERT INTO `creators` (`id`, `shop_name`) VALUES
(1, 'Histoire d\'Or'),
(2, 'Ceramika'),
(3, 'Art & Déco'),
(4, 'Toys\'R\'Us'),
(5, 'Jules');

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `picture_1` text COLLATE utf8_unicode_ci NOT NULL,
  `picture_2` text COLLATE utf8_unicode_ci NOT NULL,
  `picture_3` text COLLATE utf8_unicode_ci NOT NULL,
  `picture_4` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `pictures`
--

INSERT INTO `pictures` (`id`, `product_id`, `picture_1`, `picture_2`, `picture_3`, `picture_4`) VALUES
(1, 1, 'montre_lacoste.jpg', 'montre_festina.jpg', 'doudoune_jules.jpg', ''),
(2, 2, 'montre_festina.jpg', '', '', ''),
(3, 3, 'doudoune_jules.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `stock` smallint(6) NOT NULL,
  `category_id` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `picture`, `price`, `stock`, `category_id`, `creator_id`) VALUES
(1, 'Montre Lacoste 12.12 Noir', 'Montre Lacoste 12.12 Resine Noire Ronde Quartz 42mm Fond Noir Bracelet Silicone Noir', 'montre_lacoste.jpg', 99, 185, 2, 1),
(2, 'Montre Festina Timeless Chronograph Bleu', 'Montre Festina Timeless Chronograph Acier Blanc Ronde Quartz Chronographe 42mm Fond Bleu Bracelet Acier Blanc', 'montre_festina.jpg', 149, 89, 2, 1),
(3, 'Doudoune réversible et réflechissante - Gris Clair', 'Isolante, chaude et légère, cette doudoune réversible à capuche dispose d\'une face unie et d\'une face entièrement réflechissante. Pratique, elle dispose de deux poches zippées sur chaque face. \r\nBase, bords de manche et fermeture zippée finition biais contrasté', 'doudoune_jules.jpg', 70, 236, 5, 5),
(4, 'Bonnet bicolore - Gris Fantaisie', 'La mode urbaine s\'est répandue dans nos dressings masculins pour proposer des vêtements adaptés à toute situation et à chaque style d\'homme. \r\nCet hiver, on adopte donc sans hésiter ce bonnet homme, que l\'on soit féru du style chic ou du style sportswear. Ce bonnet est parfait sur tous vos looks !', 'bonnet_jules.jpg', 16, 152, 5, 5),
(5, 'Table d\'appoint Art Déco Jean ', 'Table d\'appoint Bubinga ronde aux éléments raffinés ! Un produit de haute qualité...\r\nLa pièce a une intarsia en ébène en forme de petits carrés récurrents et un cercle. Les caractéristiques de l\'aluminium confèrent à cette œuvre d\'art un attrait extra vif.', 'table_artdeco.jpg', 1400, 35, 3, 3),
(6, 'Cabinet Fiftie ', 'Cette armoire fait un oeil sur les années 50. Jetez un coup d\'œil aux larges pieds de table et au plateau de couleur claire. Cependant, il ne s\'agit certainement pas d\'un article fabriqué en série : la combinaison de différentes essences de bois comme le chêne, l\'acajou et le bouleau en fait un meuble exclusif. Plus encore si l\'on regarde la partie décorée au milieu et les poignées assorties avec style.', 'cabinet_artdeco.jpg', 2100, 26, 3, 3),
(7, 'Fauteuil Roaring Twenties ', 'Mobilier Art Déco audacieux. Peut être commandé comme fauteuil, 2 places, 3 places ou canapé 4 places. Recouvert de Uni, Manchester, Cuir ou Tissu de votre choix. L\'ensemble est orné de passepoils noirs, de passepoils en cuir ou de passepoils dans la couleur du tissu/cuir choisi.', 'fauteuil_artdeco.jpg', 800, 68, 3, 3),
(8, 'Chariot design ', 'Cette armoire métallique sur roulettes peut être facilement déplacée et constitue une charmante table d\'appoint. Le chariot classique peut être commandé dans toutes les couleurs RAL.\r\nIncroyablement bien adapté pour recevoir un écran plat ou un équipement audio.', 'chariot_artdeco.jpg', 1855, 43, 3, 3),
(9, 'Écharpe rayures - Noir/Blanc', 'Echarpe homme en maille ligne multicolores noir et blanc', 'echarpe_jules.jpg', 46, 173, 5, 5),
(10, 'Montre Maserati Successo Marron ', 'Montre Maserati Successo Acier Dore Ronde Quartz Chronographe 44mm Fond Marron Bracelet Cuir Marron', 'montre_maserati.jpg', 179, 126, 2, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `creators`
--
ALTER TABLE `creators`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `creators`
--
ALTER TABLE `creators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

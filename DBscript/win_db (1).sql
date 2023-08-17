-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 30 juil. 2023 à 08:41
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `win_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `chalets`
--

DROP TABLE IF EXISTS `chalets`;
CREATE TABLE IF NOT EXISTS `chalets` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `rental_price` double(8,2) DEFAULT NULL,
  `available` tinyint(1) NOT NULL,
  `user_manager` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chalets_user_manager_foreign` (`user_manager`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chalets`
--

INSERT INTO `chalets` (`id`, `name`, `email`, `phone`, `address`, `description`, `photos`, `capacity`, `rental_price`, `available`, `user_manager`) VALUES
(10, 'Villa Du Golf', 'contact@villadugolf.com', '05748494949', 'N 26 Golf Gouskoura, Green Town, Casablanca 20000 Maroc', 'Offrant une vue sur le jardin, l\'Adams chalet est un hébergement situé à Casablanca, à 8,7 km du centre commercial Anfaplace et à 9,4 km de la mosquée Hassan II. Vous bénéficierez gratuitement d\'une connexion Wi-Fi et d\'un parking privé.\n\nLa villa dispose d\'un balcon, de 3 chambres, d\'un salon et d\'une kitchenette bien équipée avec un minibar. Il dispose également d\'une télévision à écran plat.\n\nVous séjournerez à 11 km du centre commercial Morocco Mall et à 5,6 km du parc de la Ligue arabe. L\'aéroport international Mohammed V, le plus proche, est implanté à 22 km.', '20230722121950.0.jpg,20230722122006.0.jpg,20230722122042.0.jpg,20230722122042.1.jpg', 4, 300.00, 1, NULL),
(9, 'AKA Chalet', 'contact@aka.ma', '0657575994', 'Casablanca', 'Vous pouvez bénéficier d\'une réduction Genius dans l\'établissement The Wilderness Inn: Chalets ! Connectez-vous pour économiser.\n\nOffrant une vue sur le jardin, l\'établissement The Wilderness Inn: Chalets est situé à Wilmington. Il propose un jardin, une terrasse, un restaurant, un bar et un barbecue. Vous bénéficierez gratuitement d\'une connexion Wi-Fi et d\'un parking privé.\n\nTous les logements comprennent un coin salon, une télévision par câble à écran plat ainsi qu\'une salle de bains privative pourvue d\'une douche et d\'un sèche-cheveux. Certains logements comprennent une cuisine équipée d\'un four et de plaques de cuisson.\n\nVous pourrez pratiquer la randonnée, le ski et la pêche dans les environs. Le Wilderness Inn: Chalets possède un local à skis.\n\nVous séjournerez à 18 km du lac Placid et à 14 km de la montagne Whiteface. L\'aéroport régional d\'Adirondack, le plus proche, est implanté à 44 km.\n\nLes couples apprécient particulièrement l\'emplacement de cet établissement. Ils lui donnent la note de 9,6 pour un séjour à deux.', '20230722113202.0.jpg,20230722113237.0.jpg,20230722113237.1.jpg,20230722113237.2.jpg,20230722113237.3.jpg,20230722113237.4.jpg', 10, 399.00, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `avatar`) VALUES
(1, 'Achraf Aissy', 'example@gmail.com', '05647483999', 'Hay Riad, Rabat, Morocco', 'user.jpg\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `dishes`
--

DROP TABLE IF EXISTS `dishes`;
CREATE TABLE IF NOT EXISTS `dishes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dishes_menu_id_foreign` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facilities`
--

DROP TABLE IF EXISTS `facilities`;
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
CREATE TABLE IF NOT EXISTS `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `amenities` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_service` tinyint(1) NOT NULL DEFAULT '0',
  `user_manager` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hotels_user_manager_foreign` (`user_manager`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `email`, `phone`, `address`, `description`, `photos`, `stars`, `amenities`, `room_service`, `user_manager`) VALUES
(5, 'Hyatt Regency Casablanca', 'contact@hyatt regency.ma', '0657575994', 'Casablanca', 'Doté d’une piscine extérieure, d’un bar et de 2 restaurants, le Hyatt Regency Casablanca propose des hébergements à 600 mètres de l’ancienne médina et des marchés de Casablanca. Il possède également un spa et centre de bien-être avec un sauna et un hammam où sont dispensés des soins de bien-être.\r\n\r\nDotées d\'une connexion Wi-Fi gratuite, toutes les chambres et suites climatisées du Hyatt Regency Casablanca donnent sur les façades Art déco, l\'ancienne médina ou la mosquée Hassan II.\r\n\r\nPour un moment de détente, vous pourrez savourer un verre de vin ou profiter d’un cigare au Café M ou au salon Living Room. Le matin, un petit-déjeuner buffet est servi au restaurant Bissat. Par ailleurs, des concerts et des spectacles sont organisés au restaurant Dar Beida sur place.\r\n\r\nLe Hyatt Regency Casablanca possède un spa ainsi qu’une salle de sport ouverte 24h/24 et 7j/7. Le centre de bien-être comprend un hammam, un sauna et des salles de massage. Deux courts de squash sont également à votre disposition.\r\n\r\nLe Hyatt Regency Casablanca se trouve à 7,2 km de la plage d\'Aïn Diab et à 2,5 km de la mosquée Hassan II. L\'aéroport international Mohammed V de Casablanca est situé à 31,7 km. Des services de location de limousine et de navette aéroport sont disponibles moyennant des frais supplémentaires.', '20230707232930.0.jpg,20230729184817.0.webp,20230729184931.0.webp,20230729193710.0.jpg', 5, 'Shower,Pool,Games', 1, NULL),
(4, 'AKA', 'contact@aka.ma', '0657575994', 'Casablanca', 'Une bouffée d’air frais, en front de mer, au cœur de la capitale économique du Maroc. Four Seasons Hotel Casablanca invite à une escapade agréable dans une oasis urbaine, à quelques minutes seulement du centre-ville animé de Casablanca.', '20230708143114.0.jpg,20230722105637.0.jpg,20230722105637.1.jpg,20230722105637.2.jpg,20230722105637.3.jpg', 5, 'Shower,Pool,Games', 1, NULL),
(6, 'Pendry Manhattan West', 'PendryManhattanWest@gmail.com', '+12025550176', '438 W 33rd St, New York, NY, 10001', 'A new side of the city. Where elegance and ease comingle. Where a warm, contemporary design story envelops you from the inside out with stunning interiors and an awe-inspiring, rippling wave façade that stands out amid the city’s iconic skyline. Where an understated, California-inspired take on progressive luxury ushers you into an airy, relaxed version of New York and its timeless sophistication. Located in the center of the city’s new west side, we are an extension of the area’s sophisticated energy with a pulse that is all our own. Welcome to Pendry Manhattan West.\r\n\r\nThis is our guests\' favorite part of New York, according to independent reviews.\r\n\r\nCouples in particular like the location – they rated it 9.1 for a two-person trip.', '20230730005310.0.webp,20230730005310.1.webp,20230730005310.2.webp,20230730005310.3.webp,20230730005310.4.webp', 5, NULL, 0, 2);

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_facility_id_foreign` (`facility_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(19, '2023_07_02_110633_create_restaurents_table', 9),
(17, '2023_07_02_104107_create_facilities_table', 9),
(18, '2023_07_02_104941_create_hotels_table', 9),
(9, '2023_07_02_112601_create_rooms_table', 3),
(10, '2023_07_02_113337_create_tables_table', 4),
(11, '2023_07_02_113731_create_clients_table', 5),
(12, '2023_07_02_120423_create_reservations_table', 6),
(13, '2023_07_03_071600_create_subscription_types_table', 7),
(14, '2023_07_03_071644_create_subscriptions_table', 7),
(15, '2023_07_03_072757_create_menus_table', 7),
(16, '2023_07_03_073232_create_dishes_table', 8),
(20, '2023_07_02_111254_create_chalets_table', 9),
(21, '2023_07_21_091001_create_reviews_table', 10),
(22, '2023_07_22_093446_update_rooms_table', 11),
(23, '2014_10_12_100000_create_password_resets_table', 12),
(24, '2023_07_25_103358_create_transactions_table', 13),
(25, '2023_07_29_141112_add_user_manager_in_hotels_table', 14),
(26, '2023_07_29_141240_add_user_manager_in_chalets_table', 14),
(27, '2023_07_29_141356_add_user_manager_in_restaurents_table', 14);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `amount` double(8,2) NOT NULL,
  `online_payement` tinyint(1) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `chalet_id` bigint(20) UNSIGNED DEFAULT NULL,
  `table_id` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_room_id_foreign` (`room_id`),
  KEY `reservations_chalet_id_foreign` (`chalet_id`),
  KEY `reservations_table_id_foreign` (`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `start_date`, `end_date`, `amount`, `online_payement`, `status`, `room_id`, `chalet_id`, `table_id`) VALUES
(1, 1, '2023-07-10 23:00:00', '2023-07-11 23:00:00', 600.00, 0, 'confirmed', NULL, 10, NULL),
(2, 1, '2023-07-14 12:09:09', '2023-07-15 12:09:09', 678.00, 1, 'confirmed', NULL, 9, NULL),
(3, 1, '2023-07-15 23:00:00', '2023-07-16 23:00:00', 459.00, 1, 'confirmed', 33, NULL, NULL),
(4, 1, '2023-07-15 23:00:00', '2023-07-18 23:00:00', 1456.00, 1, 'confiremed', 32, NULL, NULL),
(5, 1, '2023-07-22 19:11:01', '2023-07-24 19:11:01', 372.00, 1, 'confirmed', NULL, 10, NULL),
(6, 1, '2023-07-30 23:00:00', '2023-08-05 23:00:00', 2394.00, 1, 'confirmed', NULL, 9, NULL),
(7, 1, '2023-07-28 13:54:31', '2023-07-29 13:54:31', 450.00, 0, 'confirmed', NULL, NULL, NULL),
(8, 1, '2023-07-28 13:54:31', '2023-07-29 13:54:31', 450.00, 0, 'confirmed', 33, NULL, NULL),
(10, 1, '2023-08-03 23:00:00', '2023-08-05 23:00:00', 500.00, 1, 'confirmed', 31, NULL, NULL),
(11, 1, '2023-08-04 23:00:00', '2023-08-05 23:00:00', 350.00, 1, 'confirmed', 30, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `restaurents`
--

DROP TABLE IF EXISTS `restaurents`;
CREATE TABLE IF NOT EXISTS `restaurents` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `cuisine` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_manager` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurents_user_manager_foreign` (`user_manager`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `restaurents`
--

INSERT INTO `restaurents` (`id`, `name`, `email`, `phone`, `address`, `description`, `photos`, `capacity`, `cuisine`, `user_manager`) VALUES
(5, 'Atelier Oriental', 'contact@atelieroriental.ma', '+2125224-56200', 'Hotel Sofitel, Casablanca Maroc', 'C\'est dans une salle cosy et feutrée, au sein du Sofitel Casablanca Tour Blanche, que L\'Atelier Oriental est situé. Un véritable voyage culinaire au cœur de l\'Orientvous y attend : le chef propose une carte mêlant un large éventail de la cuisine orientale avec des touches marocaines authentiques. La cuisine est moderne, fine et subtilement présentée, avec un service impeccable.', '20230708003423.0.jpg,20230708003423.1.jpg', 200, 'Libanaise, Africaine, Marocaine, Méditerranéenne, Moyen-Orient', NULL),
(4, 'Boresto', 'contact@boresto.ma', '0607869595', 'Maarif, Casablnaca, Morocco', 'Restaurent', '20230709160215.0.jpg', 124, 'Amerecain, Europain', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `star_rating` double(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `restaurent_id` bigint(20) UNSIGNED NOT NULL,
  `chalet_id` bigint(20) UNSIGNED NOT NULL,
  `dish_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_room_id_foreign` (`room_id`),
  KEY `reviews_hotel_id_foreign` (`hotel_id`),
  KEY `reviews_restaurent_id_foreign` (`restaurent_id`),
  KEY `reviews_chalet_id_foreign` (`chalet_id`),
  KEY `reviews_dish_id_foreign` (`dish_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `photos` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotel` bigint(20) UNSIGNED DEFAULT NULL,
  `surface` double(8,2) NOT NULL,
  `room_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `beds_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `amenities` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_hotel_foreign` (`hotel`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rooms`
--

INSERT INTO `rooms` (`id`, `number`, `price`, `is_available`, `photos`, `hotel`, `surface`, `room_type`, `beds_type`, `capacity`, `amenities`) VALUES
(33, 21, 500.00, 1, '20230722105859.0.jpg,20230722105859.1.jpg', 4, 70.00, 'Junior Suite', '1 King bed', 2, 'Air conditioning, Bed sheets,Climate-controlled heating,Wi-Fi,Premium TV channels,Daily housekeeping,Private bathroom,Shower'),
(31, 34, 250.00, 0, '20230708120446.0.jpg,20230721083617.0.webp,20230721083617.1.jpg', 5, 80.00, 'Junior Suite', '1 King bed', 2, 'Air conditioning,Bed sheets,Climate-controlled heating,Wi-Fi,Premium TV channels,Daily housekeeping,Private bathroom,Shower'),
(30, 34, 350.00, 1, '20230716150621.0.jpg,20230721083428.0.webp,20230721083428.1.webp,20230721083428.2.webp', 5, 100.00, 'Room', '2 King bed ', 3, 'Air conditioning, Bed sheets,Climate-controlled heating,Wi-Fi,Premium TV channels,Daily housekeeping,Private bathroom,Shower'),
(32, 44, 200.00, 1, '20230722110017.0.jpg,20230722110017.1.jpg', 4, 85.00, 'Room', '1 King bed', 2, 'Air conditioning, Bed sheets,Climate-controlled heating,Wi-Fi,Premium TV channels,Daily housekeeping,Private bathroom,Shower'),
(44, 355, 345.00, 1, '20230730003626.0.jpg,20230730003626.1.jpg', 6, 50.00, 'Standard', '2 king beds', 2, 'djjhjdjd'),
(35, 102, 120.00, 1, 'room102.jpg', 5, 30.00, 'Deluxe', 'Queen Bed', 2, 'Wi-Fi, TV, Mini Bar, Balcony'),
(36, 201, 80.00, 1, 'room201.jpg', 5, 20.00, 'Standard', 'Twin Beds', 2, 'Wi-Fi, TV, Air Conditioning'),
(37, 202, 90.00, 1, 'room202.jpg', 5, 22.00, 'Deluxe', 'Queen Bed', 2, 'Wi-Fi, TV, Mini Bar'),
(38, 301, 150.00, 1, 'room301.jpg', 5, 40.00, 'Suite', 'King Bed', 4, 'Wi-Fi, TV, Mini Bar, Living Room'),
(39, 302, 180.00, 1, 'room302.jpg', 5, 45.00, 'Suite', 'King Bed', 4, 'Wi-Fi, TV, Mini Bar, Jacuzzi'),
(40, 401, 70.00, 1, 'room401.jpg', 5, 18.00, 'Economy', 'Single Bed', 1, 'Wi-Fi, TV'),
(41, 402, 75.00, 1, 'room402.jpg', 5, 20.00, 'Standard', 'Double Bed', 2, 'Wi-Fi, TV, Air Conditioning'),
(42, 501, 200.00, 1, 'room501.jpg', 5, 50.00, 'Penthouse', 'King Bed', 2, 'Wi-Fi, TV, Mini Bar, Private Terrace'),
(43, 502, 220.00, 1, 'room502.jpg', 5, 55.00, 'Penthouse', 'King Bed', 2, 'Wi-Fi, TV, Mini Bar, Rooftop Pool');

-- --------------------------------------------------------

--
-- Structure de la table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `status` tinyint(1) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_type_id_foreign` (`type_id`),
  KEY `subscriptions_client_id_foreign` (`client_id`),
  KEY `subscriptions_facility_id_foreign` (`facility_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `subscription_types`
--

DROP TABLE IF EXISTS `subscription_types`;
CREATE TABLE IF NOT EXISTS `subscription_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL,
  `restaurent` bigint(20) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tables_restaurent_foreign` (`restaurent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cust_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_num` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_exp_month` smallint(5) UNSIGNED NOT NULL,
  `card_exp_year` smallint(5) UNSIGNED NOT NULL,
  `property_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `price_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `txn_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `cust_name`, `cust_email`, `card_num`, `card_exp_month`, `card_exp_year`, `property_type`, `property_id`, `price_currency`, `paid_amount`, `unit_price`, `txn_id`, `payment_status`, `created`, `modified`) VALUES
(10, 'Achraf Aissy', 'achrafaissy@gmail.com', '4242424242424242', 9, 2028, 'Room', 30, 'usd', '35000.00', '350.00', 'txn_3NYvTQHR3CBwpLK61oxrF2ax', 'succeeded', '2023-07-28 17:33:12', '2023-07-28 17:33:12'),
(9, 'Achraf Aissy', 'email@gmail.com', '5555555555554444', 12, 2025, 'Room', 31, 'usd', '50000.00', '250.00', 'txn_3NYlgXHR3CBwpLK61JS5nlKN', 'succeeded', '2023-07-28 07:06:05', '2023-07-28 07:06:05'),
(8, 'Achraf Aissy', 'achrafaissy1@gmail.com', '4242424242424242', 3, 2027, 'Chalet', 9, 'usd', '239400.00', '399.00', 'txn_3NXs52HR3CBwpLK60In9quu4', 'succeeded', '2023-07-25 19:43:40', '2023-07-25 19:43:40');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Achraf', 'email@gmail.com', NULL, '$2y$10$g/0QgskGKmz6o6HVhJe.ZuAZxzNHDg9FBkWDR.1cdOr7ikyq7nr26', NULL, '2023-07-22 22:32:08', '2023-07-22 22:32:08'),
(2, 'Pendry Manhattan West', 'PendryManhattanWest@gmail.com', NULL, '$2y$10$ojAN5GnDBPV9zltbAf2zduXnG79TvyPhkh9YU2xuJmfeyyyhRVF0C', NULL, '2023-07-29 13:51:17', '2023-07-29 13:51:17'),
(3, 'Ali Jaber', 'newuser@gmail.com', NULL, '$2y$10$lZcTVr7HkuG0KfZ3Eo42yuENr/gl7IsaWYbbecKm.zo6caqu2gfSS', NULL, '2023-07-29 14:41:58', '2023-07-29 14:41:58');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

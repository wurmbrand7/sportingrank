-- SportingRank Database Schema
-- Optimized for MySQL / MariaDB (cPanel phpMyAdmin)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE IF NOT EXISTS `sports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(10) DEFAULT '🏆',
  `governing_body` varchar(150) DEFAULT NULL,
  `ranking_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `name`, `slug`, `icon`, `governing_body`, `ranking_type`, `sort_order`) VALUES
(1, 'Soccer / Football', 'soccer', '⚽', 'FIFA', 'FIFA Points', 1),
(2, 'Basketball', 'basketball', '🏀', 'FIBA', 'FIBA Points', 2),
(3, 'Cricket', 'cricket', '🏏', 'ICC', 'ICC Rating', 3),
(4, 'Tennis', 'tennis', '🎾', 'ATP/WTA', 'ATP/WTA Points', 4),
(5, 'American Football', 'american-football', '🏈', 'NFL/IFAF', 'Win-Loss Record', 5),
(6, 'Field Hockey', 'field-hockey', '🏑', 'FIH', 'FIH Points', 6),
(7, 'Volleyball', 'volleyball', '🏐', 'FIVB', 'FIVB Points', 7),
(8, 'Rugby Union', 'rugby', '🏉', 'World Rugby', 'World Rugby Points', 8),
(9, 'Baseball', 'baseball', '⚾', 'WBSC', 'WBSC Points', 9),
(10, 'Ice Hockey', 'ice-hockey', '🏒', 'IIHF', 'IIHF Points', 10);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `rank_position` int(11) NOT NULL,
  `team_name` varchar(150) NOT NULL,
  `team_type` enum('national','club') DEFAULT 'national',
  `country_code` char(2) DEFAULT NULL,
  `country_name` varchar(100) DEFAULT NULL,
  `points` decimal(10,2) DEFAULT 0.00,
  `points_label` varchar(50) DEFAULT 'pts',
  `previous_rank` int(11) DEFAULT NULL,
  `trend` enum('up','down','same') DEFAULT 'same',
  `logo_url` varchar(255) DEFAULT NULL,
  `matches_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  `votes` int(11) DEFAULT 0,
  `notable_achievement` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `sport_rank` (`sport_id`,`rank_position`),
  KEY `sport_id` (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

-- Soccer (ID 1)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(1, 1, 'Argentina', 'ar', 'Argentina', 1883.50, 'pts', 'same'),
(1, 2, 'France', 'fr', 'France', 1853.11, 'pts', 'same'),
(1, 3, 'Spain', 'es', 'Spain', 1844.33, 'pts', 'up'),
(1, 4, 'England', 'gb', 'England', 1807.83, 'pts', 'down'),
(1, 5, 'Brazil', 'br', 'Brazil', 1784.37, 'pts', 'same'),
(1, 6, 'Belgium', 'be', 'Belgium', 1761.27, 'pts', 'same'),
(1, 7, 'Portugal', 'pt', 'Portugal', 1752.68, 'pts', 'up'),
(1, 8, 'Netherlands', 'nl', 'Netherlands', 1748.24, 'pts', 'down'),
(1, 9, 'Italy', 'it', 'Italy', 1729.40, 'pts', 'up'),
(1, 10, 'Colombia', 'co', 'Colombia', 1724.37, 'pts', 'down');

-- Basketball (ID 2)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(2, 1, 'USA', 'us', 'United States', 838.8, 'pts', 'same'),
(2, 2, 'Serbia', 'rs', 'Serbia', 758.2, 'pts', 'up'),
(2, 3, 'Germany', 'de', 'Germany', 755.9, 'pts', 'same'),
(2, 4, 'France', 'fr', 'France', 753.0, 'pts', 'up'),
(2, 5, 'Canada', 'ca', 'Canada', 747.8, 'pts', 'up'),
(2, 6, 'Spain', 'es', 'Spain', 746.7, 'pts', 'down'),
(2, 7, 'Australia', 'au', 'Australia', 732.5, 'pts', 'down'),
(2, 8, 'Argentina', 'ar', 'Argentina', 731.1, 'pts', 'down'),
(2, 9, 'Latvia', 'lv', 'Latvia', 711.4, 'pts', 'up'),
(2, 10, 'Lithuania', 'lt', 'Lithuania', 698.9, 'pts', 'same');

-- Cricket (ID 3)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(3, 1, 'India', 'in', 'India', 122, 'rating', 'same'),
(3, 2, 'Australia', 'au', 'Australia', 116, 'rating', 'same'),
(3, 3, 'South Africa', 'za', 'South Africa', 108, 'rating', 'up'),
(3, 4, 'Pakistan', 'pk', 'Pakistan', 106, 'rating', 'down'),
(3, 5, 'New Zealand', 'nz', 'New Zealand', 101, 'rating', 'same'),
(3, 6, 'Sri Lanka', 'lk', 'Sri Lanka', 97, 'rating', 'up'),
(3, 7, 'England', 'gb', 'England', 95, 'rating', 'down'),
(3, 8, 'Bangladesh', 'bd', 'Bangladesh', 86, 'rating', 'same'),
(3, 9, 'Afghanistan', 'af', 'Afghanistan', 82, 'rating', 'up'),
(3, 10, 'West Indies', 'wi', 'West Indies', 75, 'rating', 'down');

-- Tennis (ID 4)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(4, 1, 'Jannik Sinner', 'it', 'Italy', 11830, 'pts', 'same'),
(4, 2, 'Carlos Alcaraz', 'es', 'Spain', 7120, 'pts', 'up'),
(4, 3, 'Alexander Zverev', 'de', 'Germany', 6805, 'pts', 'up'),
(4, 4, 'Novak Djokovic', 'rs', 'Serbia', 6210, 'pts', 'down'),
(4, 5, 'Daniil Medvedev', 'ru', 'Russia', 5230, 'pts', 'down'),
(4, 6, 'Taylor Fritz', 'us', 'United States', 4415, 'pts', 'up'),
(4, 7, 'Andrey Rublev', 'ru', 'Russia', 4070, 'pts', 'down'),
(4, 8, 'Casper Ruud', 'no', 'Norway', 3855, 'pts', 'up'),
(4, 9, 'Grigor Dimitrov', 'bg', 'Bulgaria', 3740, 'pts', 'up'),
(4, 10, 'Alex de Minaur', 'au', 'Australia', 3545, 'pts', 'down');

-- American Football (ID 5)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(5, 1, 'Kansas City Chiefs', 'us', 'USA', 100, 'index', 'same'),
(5, 2, 'San Francisco 49ers', 'us', 'USA', 98, 'index', 'same'),
(5, 3, 'Baltimore Ravens', 'us', 'USA', 95, 'index', 'up'),
(5, 4, 'Detroit Lions', 'us', 'USA', 92, 'index', 'up'),
(5, 5, 'Buffalo Bills', 'us', 'USA', 89, 'index', 'down'),
(5, 6, 'Philadelphia Eagles', 'us', 'USA', 87, 'index', 'down'),
(5, 7, 'Houston Texans', 'us', 'USA', 85, 'index', 'up'),
(5, 8, 'Green Bay Packers', 'us', 'USA', 83, 'index', 'up'),
(5, 9, 'Miami Dolphins', 'us', 'USA', 80, 'index', 'down'),
(5, 10, 'Dallas Cowboys', 'us', 'USA', 78, 'index', 'down');

-- Field Hockey (ID 6)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(6, 1, 'Netherlands', 'nl', 'Netherlands', 3168, 'pts', 'same'),
(6, 2, 'Germany', 'de', 'Germany', 3035, 'pts', 'up'),
(6, 3, 'Belgium', 'be', 'Belgium', 2958, 'pts', 'down'),
(6, 4, 'India', 'in', 'India', 2848, 'pts', 'up'),
(6, 5, 'Australia', 'au', 'Australia', 2714, 'pts', 'down'),
(6, 6, 'Argentina', 'ar', 'Argentina', 2642, 'pts', 'same'),
(6, 7, 'England', 'gb', 'England', 2627, 'pts', 'same'),
(6, 8, 'Spain', 'es', 'Spain', 2445, 'pts', 'same'),
(6, 9, 'Ireland', 'ie', 'Ireland', 2090, 'pts', 'up'),
(6, 10, 'France', 'fr', 'France', 2041, 'pts', 'up');

-- Volleyball (ID 7)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(7, 1, 'Poland', 'pl', 'Poland', 408.95, 'pts', 'same'),
(7, 2, 'France', 'fr', 'France', 358.24, 'pts', 'up'),
(7, 3, 'Slovenia', 'si', 'Slovenia', 348.63, 'pts', 'up'),
(7, 4, 'Japan', 'jp', 'Japan', 344.29, 'pts', 'down'),
(7, 5, 'Italy', 'it', 'Italy', 344.21, 'pts', 'down'),
(7, 6, 'USA', 'us', 'United States', 343.78, 'pts', 'same'),
(7, 7, 'Brazil', 'br', 'Brazil', 315.44, 'pts', 'down'),
(7, 8, 'Argentina', 'ar', 'Argentina', 264.28, 'pts', 'same'),
(7, 9, 'Canada', 'ca', 'Canada', 262.90, 'pts', 'up'),
(7, 10, 'Germany', 'de', 'Germany', 262.02, 'pts', 'up');

-- Rugby Union (ID 8)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(8, 1, 'South Africa', 'za', 'South Africa', 93.94, 'pts', 'same'),
(8, 2, 'Ireland', 'ie', 'Ireland', 90.33, 'pts', 'up'),
(8, 3, 'New Zealand', 'nz', 'New Zealand', 89.41, 'pts', 'down'),
(8, 4, 'France', 'fr', 'France', 87.97, 'pts', 'same'),
(8, 5, 'England', 'gb', 'England', 87.24, 'pts', 'same'),
(8, 6, 'Argentina', 'ar', 'Argentina', 84.97, 'pts', 'up'),
(8, 7, 'Scotland', 'gb', 'Scotland', 82.90, 'pts', 'up'),
(8, 8, 'Italy', 'it', 'Italy', 81.53, 'pts', 'up'),
(8, 9, 'Fiji', 'fj', 'Fiji', 81.14, 'pts', 'down'),
(8, 10, 'Australia', 'au', 'Australia', 79.64, 'pts', 'down');

-- Baseball (ID 9)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(9, 1, 'Japan', 'jp', 'Japan', 4899, 'pts', 'same'),
(9, 2, 'Mexico', 'mx', 'Mexico', 4764, 'pts', 'up'),
(9, 3, 'USA', 'us', 'United States', 4492, 'pts', 'down'),
(9, 4, 'South Korea', 'kr', 'South Korea', 4350, 'pts', 'same'),
(9, 5, 'Chinese Taipei', 'tw', 'Chinese Taipei', 4170, 'pts', 'same'),
(9, 6, 'Venezuela', 've', 'Venezuela', 3975, 'pts', 'up'),
(9, 7, 'Netherlands', 'nl', 'Netherlands', 3288, 'pts', 'down'),
(9, 8, 'Cuba', 'cu', 'Cuba', 3121, 'pts', 'same'),
(9, 9, 'Dominican Republic', 'do', 'Dominican Republic', 2667, 'pts', 'same'),
(9, 10, 'Panama', 'pa', 'Panama', 2534, 'pts', 'up');

-- Ice Hockey (ID 10)
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(10, 1, 'Canada', 'ca', 'Canada', 4100, 'pts', 'same'),
(10, 2, 'Czechia', 'cz', 'Czechia', 4000, 'pts', 'up'),
(10, 3, 'Switzerland', 'ch', 'Switzerland', 3900, 'pts', 'up'),
(10, 4, 'Finland', 'fi', 'Finland', 3800, 'pts', 'down'),
(10, 5, 'Sweden', 'se', 'Sweden', 3700, 'pts', 'down'),
(10, 6, 'USA', 'us', 'United States', 3600, 'pts', 'same'),
(10, 7, 'Germany', 'de', 'Germany', 3500, 'pts', 'same'),
(10, 8, 'Slovakia', 'sk', 'Slovakia', 3400, 'pts', 'up'),
(10, 9, 'Latvia', 'lv', 'Latvia', 3300, 'pts', 'down'),
(10, 10, 'Denmark', 'dk', 'Denmark', 3200, 'pts', 'up');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(50) DEFAULT 'general',
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'Sport Rank - World Sports Rankings', 'general'),
('site_tagline', 'Official rankings for the world\'s top 10 sports', 'general'),
('meta_description', 'Discover up-to-date rankings for Soccer, Basketball, Cricket, Tennis, and more.', 'seo'),
('update_frequency', 'Weekly every Monday', 'general'),
('accent_color', '#F0A500', 'design'),
('footer_text', '© 2026 SportingRank. All rights reserved.', 'general'),
('google_analytics_id', '', 'analytics'),
('last_updated', '2026-05-01', 'general');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`username`, `password_hash`, `email`) VALUES
('admin', '$2y$10$R2lsk/nLvxWCKRsX1njgT.nWIU7x7Q.GiiAxZD/M1vpRuyXAbh0b2', 'admin@sportingrank.com');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

COMMIT;

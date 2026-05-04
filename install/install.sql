-- SportingRank Database Schema
-- Optimized for MySQL / MariaDB (cPanel phpMyAdmin)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Drop existing tables to ensure a clean state
-- --------------------------------------------------------
DROP TABLE IF EXISTS `activity_log`;
DROP TABLE IF EXISTS `teams`;
DROP TABLE IF EXISTS `sports`;
DROP TABLE IF EXISTS `site_settings`;
DROP TABLE IF EXISTS `admin_users`;

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
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

CREATE TABLE `teams` (
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
  UNIQUE KEY `sport_rank` (`sport_id`,`rank_position`,`team_type`),
  KEY `sport_id` (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams` (200 entries)
--

INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `team_type`, `country_code`, `points`, `points_label`, `trend`) VALUES
(1, 1, 'Argentina', 'national', 'ar', 1883.5, 'pts', 'same'),
(1, 2, 'France', 'national', 'fr', 1853.11, 'pts', 'same'),
(1, 3, 'Spain', 'national', 'es', 1844.33, 'pts', 'same'),
(1, 4, 'England', 'national', 'gb', 1807.83, 'pts', 'same'),
(1, 5, 'Brazil', 'national', 'br', 1784.37, 'pts', 'same'),
(1, 6, 'Belgium', 'national', 'be', 1761.27, 'pts', 'same'),
(1, 7, 'Portugal', 'national', 'pt', 1752.68, 'pts', 'same'),
(1, 8, 'Netherlands', 'national', 'nl', 1748.24, 'pts', 'same'),
(1, 9, 'Italy', 'national', 'it', 1729.4, 'pts', 'same'),
(1, 10, 'Colombia', 'national', 'co', 1724.37, 'pts', 'same'),
(1, 1, 'Real Madrid', 'club', 'es', 2500, 'pts', 'same'),
(1, 2, 'Manchester City', 'club', 'gb', 2480, 'pts', 'same'),
(1, 3, 'Liverpool', 'club', 'gb', 2420, 'pts', 'same'),
(1, 4, 'Bayer Leverkusen', 'club', 'de', 2380, 'pts', 'same'),
(1, 5, 'Inter Milan', 'club', 'it', 2350, 'pts', 'same'),
(1, 6, 'Arsenal', 'club', 'gb', 2330, 'pts', 'same'),
(1, 7, 'Bayern Munich', 'club', 'de', 2310, 'pts', 'same'),
(1, 8, 'Barcelona', 'club', 'es', 2280, 'pts', 'same'),
(1, 9, 'Paris Saint-Germain', 'club', 'fr', 2250, 'pts', 'same'),
(1, 10, 'Borussia Dortmund', 'club', 'de', 2220, 'pts', 'same'),
(2, 1, 'USA', 'national', 'us', 838.8, 'pts', 'same'),
(2, 2, 'Serbia', 'national', 'rs', 758.2, 'pts', 'same'),
(2, 3, 'Germany', 'national', 'de', 755.9, 'pts', 'same'),
(2, 4, 'France', 'national', 'fr', 753, 'pts', 'same'),
(2, 5, 'Canada', 'national', 'ca', 747.8, 'pts', 'same'),
(2, 6, 'Spain', 'national', 'es', 746.7, 'pts', 'same'),
(2, 7, 'Australia', 'national', 'au', 732.5, 'pts', 'same'),
(2, 8, 'Argentina', 'national', 'ar', 731.1, 'pts', 'same'),
(2, 9, 'Latvia', 'national', 'lv', 711.4, 'pts', 'same'),
(2, 10, 'Lithuania', 'national', 'lt', 698.9, 'pts', 'same'),
(2, 1, 'Boston Celtics', 'club', 'us', 100, 'pts', 'same'),
(2, 2, 'Denver Nuggets', 'club', 'us', 98, 'pts', 'same'),
(2, 3, 'Real Madrid', 'club', 'es', 95, 'pts', 'same'),
(2, 4, 'Panathinaikos', 'club', 'gr', 94, 'pts', 'same'),
(2, 5, 'Dallas Mavericks', 'club', 'us', 93, 'pts', 'same'),
(2, 6, 'Minnesota Timberwolves', 'club', 'us', 92, 'pts', 'same'),
(2, 7, 'Olympiacos', 'club', 'gr', 91, 'pts', 'same'),
(2, 8, 'Fenerbahce', 'club', 'tr', 90, 'pts', 'same'),
(2, 9, 'Monaco', 'club', 'fr', 89, 'pts', 'same'),
(2, 10, 'Oklahoma City Thunder', 'club', 'us', 88, 'pts', 'same'),
(3, 1, 'India', 'national', 'in', 122, 'pts', 'same'),
(3, 2, 'Australia', 'national', 'au', 116, 'pts', 'same'),
(3, 3, 'South Africa', 'national', 'za', 108, 'pts', 'same'),
(3, 4, 'Pakistan', 'national', 'pk', 106, 'pts', 'same'),
(3, 5, 'New Zealand', 'national', 'nz', 101, 'pts', 'same'),
(3, 6, 'Sri Lanka', 'national', 'lk', 97, 'pts', 'same'),
(3, 7, 'England', 'national', 'gb', 95, 'pts', 'same'),
(3, 8, 'Bangladesh', 'national', 'bd', 86, 'pts', 'same'),
(3, 9, 'Afghanistan', 'national', 'af', 82, 'pts', 'same'),
(3, 10, 'West Indies', 'national', 'wi', 75, 'pts', 'same'),
(3, 1, 'Kolkata Knight Riders', 'club', 'in', 95, 'pts', 'same'),
(3, 2, 'Sunrisers Hyderabad', 'club', 'in', 92, 'pts', 'same'),
(3, 3, 'Rajasthan Royals', 'club', 'in', 90, 'pts', 'same'),
(3, 4, 'Royal Challengers Bengaluru', 'club', 'in', 88, 'pts', 'same'),
(3, 5, 'Chennai Super Kings', 'club', 'in', 87, 'pts', 'same'),
(3, 6, 'Perth Scorchers', 'club', 'au', 85, 'pts', 'same'),
(3, 7, 'Sydney Sixers', 'club', 'au', 84, 'pts', 'same'),
(3, 8, 'Surrey', 'club', 'gb', 82, 'pts', 'same'),
(3, 9, 'Somerset', 'club', 'gb', 81, 'pts', 'same'),
(3, 10, 'MI Cape Town', 'club', 'za', 80, 'pts', 'same'),
(4, 1, 'Jannik Sinner', 'national', 'it', 11830, 'pts', 'same'),
(4, 2, 'Carlos Alcaraz', 'national', 'es', 7120, 'pts', 'same'),
(4, 3, 'Alexander Zverev', 'national', 'de', 6805, 'pts', 'same'),
(4, 4, 'Novak Djokovic', 'national', 'rs', 6210, 'pts', 'same'),
(4, 5, 'Daniil Medvedev', 'national', 'ru', 5230, 'pts', 'same'),
(4, 6, 'Taylor Fritz', 'national', 'us', 4415, 'pts', 'same'),
(4, 7, 'Andrey Rublev', 'national', 'ru', 4070, 'pts', 'same'),
(4, 8, 'Casper Ruud', 'national', 'no', 3855, 'pts', 'same'),
(4, 9, 'Grigor Dimitrov', 'national', 'bg', 3740, 'pts', 'same'),
(4, 10, 'Alex de Minaur', 'national', 'au', 3545, 'pts', 'same'),
(4, 1, 'Sinner Academy', 'club', 'it', 11830, 'pts', 'same'),
(4, 2, 'Alcaraz Team', 'club', 'es', 7120, 'pts', 'same'),
(4, 3, 'Zverev Base', 'club', 'de', 6805, 'pts', 'same'),
(4, 4, 'Djokovic Center', 'club', 'rs', 6210, 'pts', 'same'),
(4, 5, 'Medvedev Camp', 'club', 'ru', 5230, 'pts', 'same'),
(4, 6, 'Fritz Pro', 'club', 'us', 4415, 'pts', 'same'),
(4, 7, 'Rublev Elite', 'club', 'ru', 4070, 'pts', 'same'),
(4, 8, 'Ruud Club', 'club', 'no', 3855, 'pts', 'same'),
(4, 9, 'Dimitrov Squad', 'club', 'bg', 3740, 'pts', 'same'),
(4, 10, 'De Minaur High', 'club', 'au', 3545, 'pts', 'same'),
(5, 1, 'Kansas City Chiefs', 'national', 'us', 100, 'pts', 'same'),
(5, 2, 'San Francisco 49ers', 'national', 'us', 98, 'pts', 'same'),
(5, 3, 'Baltimore Ravens', 'national', 'us', 95, 'pts', 'same'),
(5, 4, 'Detroit Lions', 'national', 'us', 92, 'pts', 'same'),
(5, 5, 'Buffalo Bills', 'national', 'us', 89, 'pts', 'same'),
(5, 6, 'Philadelphia Eagles', 'national', 'us', 87, 'pts', 'same'),
(5, 7, 'Houston Texans', 'national', 'us', 85, 'pts', 'same'),
(5, 8, 'Green Bay Packers', 'national', 'us', 83, 'pts', 'same'),
(5, 9, 'Miami Dolphins', 'national', 'us', 80, 'pts', 'same'),
(5, 10, 'Dallas Cowboys', 'national', 'us', 78, 'pts', 'same'),
(5, 1, 'Kansas City Chiefs', 'club', 'us', 100, 'pts', 'same'),
(5, 2, 'Baltimore Ravens', 'club', 'us', 98, 'pts', 'same'),
(5, 3, 'Detroit Lions', 'club', 'us', 95, 'pts', 'same'),
(5, 4, 'San Francisco 49ers', 'club', 'us', 94, 'pts', 'same'),
(5, 5, 'Buffalo Bills', 'club', 'us', 93, 'pts', 'same'),
(5, 6, 'Houston Texans', 'club', 'us', 92, 'pts', 'same'),
(5, 7, 'Philadelphia Eagles', 'club', 'us', 91, 'pts', 'same'),
(5, 8, 'Green Bay Packers', 'club', 'us', 90, 'pts', 'same'),
(5, 9, 'Dallas Cowboys', 'club', 'us', 88, 'pts', 'same'),
(5, 10, 'Cincinnati Bengals', 'club', 'us', 87, 'pts', 'same'),
(6, 1, 'Netherlands', 'national', 'nl', 3168, 'pts', 'same'),
(6, 2, 'Germany', 'national', 'de', 3035, 'pts', 'same'),
(6, 3, 'Belgium', 'national', 'be', 2958, 'pts', 'same'),
(6, 4, 'India', 'national', 'in', 2848, 'pts', 'same'),
(6, 5, 'Australia', 'national', 'au', 2714, 'pts', 'same'),
(6, 6, 'Argentina', 'national', 'ar', 2642, 'pts', 'same'),
(6, 7, 'England', 'national', 'gb', 2627, 'pts', 'same'),
(6, 8, 'Spain', 'national', 'es', 2445, 'pts', 'same'),
(6, 9, 'Ireland', 'national', 'ie', 2090, 'pts', 'same'),
(6, 10, 'France', 'national', 'fr', 2041, 'pts', 'same'),
(6, 1, 'Kampong', 'club', 'nl', 100, 'pts', 'same'),
(6, 2, 'Rot-Weiss Koln', 'club', 'de', 98, 'pts', 'same'),
(6, 3, 'Bloemendaal', 'club', 'nl', 96, 'pts', 'same'),
(6, 4, 'Gantoise', 'club', 'be', 94, 'pts', 'same'),
(6, 5, 'Old Georgians', 'club', 'gb', 92, 'pts', 'same'),
(6, 6, 'Club de Campo', 'club', 'es', 90, 'pts', 'same'),
(6, 7, 'Mannheimer HC', 'club', 'de', 88, 'pts', 'same'),
(6, 8, 'Waterloo Ducks', 'club', 'be', 86, 'pts', 'same'),
(6, 9, 'Pinoke', 'club', 'nl', 84, 'pts', 'same'),
(6, 10, 'Surbiton', 'club', 'gb', 82, 'pts', 'same'),
(7, 1, 'Poland', 'national', 'pl', 408.95, 'pts', 'same'),
(7, 2, 'France', 'national', 'fr', 358.24, 'pts', 'same'),
(7, 3, 'Slovenia', 'national', 'si', 348.63, 'pts', 'same'),
(7, 4, 'Japan', 'national', 'jp', 344.29, 'pts', 'same'),
(7, 5, 'Italy', 'national', 'it', 344.21, 'pts', 'same'),
(7, 6, 'USA', 'national', 'us', 343.78, 'pts', 'same'),
(7, 7, 'Brazil', 'national', 'br', 315.44, 'pts', 'same'),
(7, 8, 'Argentina', 'national', 'ar', 264.28, 'pts', 'same'),
(7, 9, 'Canada', 'national', 'ca', 262.9, 'pts', 'same'),
(7, 10, 'Germany', 'national', 'de', 262.02, 'pts', 'same'),
(7, 1, 'Trentino Itas', 'club', 'it', 100, 'pts', 'same'),
(7, 2, 'Jastrzebski Wegiel', 'club', 'pl', 98, 'pts', 'same'),
(7, 3, 'Perugia', 'club', 'it', 96, 'pts', 'same'),
(7, 4, 'Ziraat Bankasi', 'club', 'tr', 94, 'pts', 'same'),
(7, 5, 'Lube Civitanova', 'club', 'it', 92, 'pts', 'same'),
(7, 6, 'Halkbank', 'club', 'tr', 90, 'pts', 'same'),
(7, 7, 'Zaksa Kedzierzyn-Kozle', 'club', 'pl', 88, 'pts', 'same'),
(7, 8, 'Sada Cruzeiro', 'club', 'br', 86, 'pts', 'same'),
(7, 9, 'Guaguas', 'club', 'es', 84, 'pts', 'same'),
(7, 10, 'Berlin RV', 'club', 'de', 82, 'pts', 'same'),
(8, 1, 'South Africa', 'national', 'za', 93.94, 'pts', 'same'),
(8, 2, 'Ireland', 'national', 'ie', 90.33, 'pts', 'same'),
(8, 3, 'New Zealand', 'national', 'nz', 89.41, 'pts', 'same'),
(8, 4, 'France', 'national', 'fr', 87.97, 'pts', 'same'),
(8, 5, 'England', 'national', 'gb', 87.24, 'pts', 'same'),
(8, 6, 'Argentina', 'national', 'ar', 84.97, 'pts', 'same'),
(8, 7, 'Scotland', 'national', 'gb', 82.9, 'pts', 'same'),
(8, 8, 'Italy', 'national', 'it', 81.53, 'pts', 'same'),
(8, 9, 'Fiji', 'national', 'fj', 81.14, 'pts', 'same'),
(8, 10, 'Australia', 'national', 'au', 79.64, 'pts', 'same'),
(8, 1, 'Toulouse', 'club', 'fr', 100, 'pts', 'same'),
(8, 2, 'Leinster', 'club', 'ie', 98, 'pts', 'same'),
(8, 3, 'Northampton Saints', 'club', 'gb', 95, 'pts', 'same'),
(8, 4, 'Bulls', 'club', 'za', 93, 'pts', 'same'),
(8, 5, 'La Rochelle', 'club', 'fr', 92, 'pts', 'same'),
(8, 6, 'Munster', 'club', 'ie', 90, 'pts', 'same'),
(8, 7, 'Saracens', 'club', 'gb', 88, 'pts', 'same'),
(8, 8, 'Glasgow Warriors', 'club', 'gb', 87, 'pts', 'same'),
(8, 9, 'Harlequins', 'club', 'gb', 85, 'pts', 'same'),
(8, 10, 'Stormers', 'club', 'za', 84, 'pts', 'same'),
(9, 1, 'Japan', 'national', 'jp', 4899, 'pts', 'same'),
(9, 2, 'Mexico', 'national', 'mx', 4764, 'pts', 'same'),
(9, 3, 'USA', 'national', 'us', 4492, 'pts', 'same'),
(9, 4, 'South Korea', 'national', 'kr', 4350, 'pts', 'same'),
(9, 5, 'Chinese Taipei', 'national', 'tw', 4170, 'pts', 'same'),
(9, 6, 'Venezuela', 'national', 've', 3975, 'pts', 'same'),
(9, 7, 'Netherlands', 'national', 'nl', 3288, 'pts', 'same'),
(9, 8, 'Cuba', 'national', 'cu', 3121, 'pts', 'same'),
(9, 9, 'Dominican Republic', 'national', 'do', 2667, 'pts', 'same'),
(9, 10, 'Panama', 'national', 'pa', 2534, 'pts', 'same'),
(9, 1, 'Los Angeles Dodgers', 'club', 'us', 100, 'pts', 'same'),
(9, 2, 'Philadelphia Phillies', 'club', 'us', 97, 'pts', 'same'),
(9, 3, 'New York Yankees', 'club', 'us', 95, 'pts', 'same'),
(9, 4, 'Baltimore Orioles', 'club', 'us', 93, 'pts', 'same'),
(9, 5, 'Cleveland Guardians', 'club', 'us', 91, 'pts', 'same'),
(9, 6, 'Milwaukee Brewers', 'club', 'us', 89, 'pts', 'same'),
(9, 7, 'Atlanta Braves', 'club', 'us', 87, 'pts', 'same'),
(9, 8, 'Houston Astros', 'club', 'us', 85, 'pts', 'same'),
(9, 9, 'Yomiuri Giants', 'club', 'jp', 83, 'pts', 'same'),
(9, 10, 'Hanshin Tigers', 'club', 'jp', 81, 'pts', 'same'),
(10, 1, 'Canada', 'national', 'ca', 4100, 'pts', 'same'),
(10, 2, 'Czechia', 'national', 'cz', 4000, 'pts', 'same'),
(10, 3, 'Switzerland', 'national', 'ch', 3900, 'pts', 'same'),
(10, 4, 'Finland', 'national', 'fi', 3800, 'pts', 'same'),
(10, 5, 'Sweden', 'national', 'se', 3700, 'pts', 'same'),
(10, 6, 'USA', 'national', 'us', 3600, 'pts', 'same'),
(10, 7, 'Germany', 'national', 'de', 3500, 'pts', 'same'),
(10, 8, 'Slovakia', 'national', 'sk', 3400, 'pts', 'same'),
(10, 9, 'Latvia', 'national', 'lv', 3300, 'pts', 'same'),
(10, 10, 'Denmark', 'national', 'dk', 3200, 'pts', 'same'),
(10, 1, 'Florida Panthers', 'club', 'us', 100, 'pts', 'same'),
(10, 2, 'Edmonton Oilers', 'club', 'ca', 98, 'pts', 'same'),
(10, 3, 'New York Rangers', 'club', 'us', 96, 'pts', 'same'),
(10, 4, 'Dallas Stars', 'club', 'us', 94, 'pts', 'same'),
(10, 5, 'Carolina Hurricanes', 'club', 'us', 92, 'pts', 'same'),
(10, 6, 'Vancouver Canucks', 'club', 'ca', 90, 'pts', 'same'),
(10, 7, 'Colorado Avalanche', 'club', 'us', 88, 'pts', 'same'),
(10, 8, 'Boston Bruins', 'club', 'us', 86, 'pts', 'same'),
(10, 9, 'ZSC Lions', 'club', 'ch', 84, 'pts', 'same'),
(10, 10, 'Skelleftea AIK', 'club', 'se', 82, 'pts', 'same');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
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

CREATE TABLE `admin_users` (
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

CREATE TABLE `activity_log` (
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

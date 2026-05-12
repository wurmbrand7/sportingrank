-- SportingRank MySQL Database Export
-- Compatible with cPanel / phpMyAdmin

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

-- ---------------------------------------------------------
-- Table structure for table `sports`
-- ---------------------------------------------------------

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
  `is_active` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Data for table `sports`
-- ---------------------------------------------------------

INSERT INTO `sports` (`id`, `name`, `slug`, `icon`, `governing_body`, `ranking_type`, `sort_order`, `is_active`) VALUES
(1, 'Soccer', 'soccer', '⚽', '', 'Points', 1, 1),
(2, 'Basketball', 'basketball', '🏀', '', 'FIBA Points', 3, 1),
(3, 'Cricket', 'cricket', '🏏', '', 'ICC Rating', 2, 1),
(4, 'Tennis', 'tennis', '🎾', '', 'ATP/WTA Points', 5, 1),
(5, 'Table Tennis', 'table-tennis', '🏓', '', 'ITTF Points', 7, 1),
(6, 'Field Hockey', 'field-hockey', '🏑', '', 'FIH Points', 4, 1),
(7, 'Volleyball', 'volleyball', '🏐', '', 'FIVB Points', 6, 1),
(8, 'Rugby', 'rugby', '🏉', '', 'World Rugby Points', 9, 1),
(9, 'Baseball', 'baseball', '⚾', '', 'WBSC Points', 8, 1),
(10, 'Golf', 'golf', '⛳', '', 'OWGR Points', 10, 1),
(11, 'Boxing', 'boxing', '🥊', NULL, 'P4P Ranking', 11, 1),
(12, 'UFC', 'ufc', '🥋', NULL, 'P4P Ranking', 12, 1);

-- ---------------------------------------------------------
-- Table structure for table `teams`
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `rank_position` int(11) NOT NULL,
  `team_name` varchar(150) NOT NULL,
  `team_type` varchar(20) DEFAULT 'national',
  `country_code` char(2) DEFAULT NULL,
  `country_name` varchar(100) DEFAULT NULL,
  `points` decimal(10,2) DEFAULT 0.00,
  `points_label` varchar(50) DEFAULT 'pts',
  `previous_rank` int(11) DEFAULT NULL,
  `trend` varchar(10) DEFAULT 'same',
  `logo_url` varchar(255) DEFAULT NULL,
  `matches_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  `votes` int(11) DEFAULT 0,
  `notable_achievement` varchar(255) DEFAULT NULL,
  `is_active` int(11) DEFAULT 1,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rank` (`sport_id`,`rank_position`,`team_type`),
  KEY `idx_performance` (`sport_id`,`team_type`,`is_active`,`points`,`wins`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Data for table `teams`
-- ---------------------------------------------------------

-- Soccer National
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(1, 1, 1, 'Argentina', 'national', 'ar', 1500, 'down', 40, 37, 1, 2),
(2, 1, 2, 'France', 'national', 'fr', 1485, 'down', 42, 33, 7, 2),
(3, 1, 3, 'Spain', 'national', 'es', 1470, 'up', 50, 39, 8, 3),
(4, 1, 4, 'England', 'national', 'gb', 1455, 'up', 30, 22, 6, 2),
(5, 1, 5, 'Brazil', 'national', 'br', 1440, 'same', 36, 30, 2, 4),
(6, 1, 6, 'Belgium', 'national', 'be', 1425, 'up', 30, 19, 8, 3),
(7, 1, 7, 'Portugal', 'national', 'pt', 1410, 'down', 31, 19, 10, 2),
(8, 1, 8, 'Netherlands', 'national', 'nl', 1395, 'same', 49, 28, 17, 4),
(9, 1, 9, 'Italy', 'national', 'it', 1380, 'down', 42, 26, 14, 2),
(10, 1, 10, 'Colombia', 'national', 'co', 1365, 'up', 38, 16, 17, 5);

-- Soccer Club
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(11, 1, 1, 'Real Madrid', 'club', 'es', 2500, 'down', 41, 33, 1, 7),
(12, 1, 2, 'Manchester City', 'club', 'gb', 2480, 'up', 43, 36, 0, 7),
(13, 1, 3, 'Liverpool', 'club', 'gb', 2420, 'down', 34, 26, 0, 8),
(14, 1, 4, 'Bayer Leverkusen', 'club', 'de', 2380, 'same', 42, 29, 6, 7),
(15, 1, 5, 'Inter Milan', 'club', 'it', 2350, 'down', 37, 25, 10, 2),
(16, 1, 6, 'Arsenal', 'club', 'gb', 2330, 'same', 41, 26, 7, 8),
(17, 1, 7, 'Bayern Munich', 'club', 'de', 2310, 'down', 35, 20, 11, 4),
(18, 1, 8, 'Barcelona', 'club', 'es', 2280, 'up', 31, 19, 4, 8),
(19, 1, 9, 'Paris Saint-Germain', 'club', 'fr', 2250, 'down', 39, 21, 13, 5),
(20, 1, 10, 'Borussia Dortmund', 'club', 'de', 2220, 'up', 48, 19, 26, 3);

-- Basketball National
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(21, 2, 1, 'USA', 'national', 'us', 1380, 'same', 39, 35, 1, 3),
(22, 2, 2, 'Serbia', 'national', 'rs', 1365, 'down', 44, 32, 9, 3),
(23, 2, 3, 'Germany', 'national', 'de', 1350, 'down', 40, 32, 2, 6),
(24, 2, 4, 'France', 'national', 'fr', 1335, 'down', 47, 30, 10, 7),
(25, 2, 5, 'Canada', 'national', 'ca', 1320, 'same', 43, 32, 3, 8),
(26, 2, 6, 'Spain', 'national', 'es', 1305, 'down', 31, 23, 4, 4),
(27, 2, 7, 'Australia', 'national', 'au', 1290, 'down', 35, 21, 7, 7),
(28, 2, 8, 'Argentina', 'national', 'ar', 1275, 'down', 35, 24, 7, 4),
(29, 2, 9, 'Latvia', 'national', 'lv', 1260, 'up', 34, 22, 5, 7),
(30, 2, 10, 'Lithuania', 'national', 'lt', 1245, 'up', 48, 24, 20, 4);

-- Basketball Club
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(31, 2, 1, 'Boston Celtics', 'club', 'us', 100, 'down', 34, 28, 3, 3),
(32, 2, 2, 'Denver Nuggets', 'club', 'us', 98, 'same', 38, 35, 0, 3),
(33, 2, 3, 'Real Madrid', 'club', 'es', 95, 'up', 42, 37, 0, 5),
(34, 2, 4, 'Panathinaikos', 'club', 'gr', 94, 'same', 36, 29, 1, 6),
(35, 2, 5, 'Dallas Mavericks', 'club', 'us', 93, 'down', 34, 27, 0, 7),
(36, 2, 6, 'Minnesota Timberwolves', 'club', 'us', 92, 'down', 35, 22, 8, 5),
(37, 2, 7, 'Olympiacos', 'club', 'gr', 91, 'same', 41, 29, 7, 5),
(38, 2, 8, 'Fenerbahce', 'club', 'tr', 90, 'same', 33, 19, 9, 5),
(39, 2, 9, 'Monaco', 'club', 'fr', 89, 'up', 39, 24, 9, 6),
(40, 2, 10, 'Oklahoma City Thunder', 'club', 'us', 88, 'up', 30, 14, 9, 7);

-- Cricket National
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(41, 3, 1, 'India', 'national', 'in', 1420, 'down', 36, 32, 0, 4),
(42, 3, 2, 'Australia', 'national', 'au', 1405, 'down', 44, 37, 0, 7),
(43, 3, 3, 'South Africa', 'national', 'za', 1390, 'down', 34, 25, 4, 5),
(44, 3, 4, 'Pakistan', 'national', 'pk', 1375, 'up', 47, 41, 0, 6),
(45, 3, 5, 'New Zealand', 'national', 'nz', 1360, 'up', 30, 22, 0, 8),
(46, 3, 6, 'Sri Lanka', 'national', 'lk', 1345, 'up', 32, 22, 8, 2),
(47, 3, 7, 'England', 'national', 'gb', 1330, 'same', 45, 26, 13, 6),
(48, 3, 8, 'Bangladesh', 'national', 'bd', 1315, 'same', 38, 26, 10, 2),
(49, 3, 9, 'Afghanistan', 'national', 'af', 1300, 'same', 49, 29, 12, 8),
(50, 3, 10, 'West Indies', 'national', 'wi', 1285, 'same', 50, 27, 16, 7);

-- Cricket Club
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(51, 3, 1, 'Kolkata Knight Riders', 'club', 'in', 95, 'down', 46, 36, 5, 5),
(52, 3, 2, 'Sunrisers Hyderabad', 'club', 'in', 92, 'up', 42, 31, 9, 2),
(53, 3, 3, 'Rajasthan Royals', 'club', 'in', 90, 'same', 42, 28, 7, 7),
(54, 3, 4, 'Royal Challengers Bengaluru', 'club', 'in', 88, 'same', 37, 25, 6, 6),
(55, 3, 5, 'Chennai Super Kings', 'club', 'in', 87, 'same', 48, 30, 16, 2),
(56, 3, 6, 'Perth Scorchers', 'club', 'au', 85, 'same', 49, 35, 9, 5),
(57, 3, 7, 'Sydney Sixers', 'club', 'au', 84, 'down', 50, 34, 9, 7),
(58, 3, 8, 'Surrey', 'club', 'gb', 82, 'up', 32, 20, 10, 2),
(59, 3, 9, 'Somerset', 'club', 'gb', 81, 'up', 44, 19, 18, 7),
(60, 3, 10, 'MI Cape Town', 'club', 'za', 80, 'same', 32, 18, 6, 8);

-- Tennis National (Individual P4P)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(61, 4, 1, 'Jannik Sinner', 'national', 'it', 1050, 'down', 47, 37, 3, 7),
(62, 4, 2, 'Carlos Alcaraz', 'national', 'es', 1035, 'same', 31, 26, 0, 5),
(63, 4, 3, 'Alexander Zverev', 'national', 'de', 1020, 'same', 43, 37, 0, 6),
(64, 4, 4, 'Novak Djokovic', 'national', 'rs', 1005, 'down', 42, 34, 0, 8),
(65, 4, 5, 'Daniil Medvedev', 'national', 'ru', 990, 'down', 41, 26, 9, 6),
(66, 4, 6, 'Taylor Fritz', 'national', 'us', 975, 'up', 34, 26, 6, 2),
(67, 4, 7, 'Andrey Rublev', 'national', 'ru', 960, 'up', 49, 25, 22, 2),
(68, 4, 8, 'Casper Ruud', 'national', 'no', 945, 'down', 47, 33, 9, 5),
(69, 4, 9, 'Grigor Dimitrov', 'national', 'bg', 930, 'down', 40, 25, 12, 3),
(70, 4, 10, 'Alex de Minaur', 'national', 'au', 915, 'same', 38, 15, 20, 3);

-- Tennis Club (Academy/Team)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(71, 4, 1, 'Sinner Academy', 'club', 'it', 11830, 'down', 50, 45, 2, 3),
(72, 4, 2, 'Alcaraz Team', 'club', 'es', 7120, 'down', 46, 42, 0, 4),
(73, 4, 3, 'Zverev Base', 'club', 'de', 6805, 'down', 30, 27, 0, 3),
(74, 4, 4, 'Djokovic Center', 'club', 'rs', 6210, 'same', 41, 35, 0, 6),
(75, 4, 5, 'Medvedev Camp', 'club', 'ru', 5230, 'down', 47, 35, 4, 8),
(76, 4, 6, 'Fritz Pro', 'club', 'us', 4415, 'same', 46, 25, 15, 6),
(77, 4, 7, 'Rublev Elite', 'club', 'ru', 4070, 'down', 37, 24, 5, 8),
(78, 4, 8, 'Ruud Club', 'club', 'no', 3855, 'up', 46, 24, 14, 8),
(79, 4, 9, 'Dimitrov Squad', 'club', 'bg', 3740, 'same', 38, 20, 15, 3),
(80, 4, 10, 'De Minaur High', 'club', 'au', 3545, 'down', 44, 18, 20, 6);

-- Table Tennis National
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(201, 5, 1, 'China', 'national', 'cn', 920, 'same', 40, 35, 5, 0),
(202, 5, 2, 'France', 'national', 'fr', 880, 'same', 39, 34, 5, 0),
(203, 5, 3, 'Japan', 'national', 'jp', 850, 'same', 38, 33, 5, 0),
(204, 5, 4, 'South Korea', 'national', 'kr', 820, 'same', 37, 32, 5, 0),
(205, 5, 5, 'Germany', 'national', 'de', 800, 'same', 36, 31, 5, 0),
(206, 5, 6, 'Chinese Taipei', 'national', 'tw', 780, 'same', 35, 30, 5, 0),
(207, 5, 7, 'Sweden', 'national', 'se', 750, 'same', 34, 29, 5, 0),
(208, 5, 8, 'Brazil', 'national', 'br', 720, 'same', 33, 28, 5, 0),
(209, 5, 9, 'Portugal', 'national', 'pt', 700, 'same', 32, 27, 5, 0),
(210, 5, 10, 'Nigeria', 'national', 'ng', 680, 'same', 31, 26, 5, 0);

-- Boxing Men (National/P4P)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(221, 11, 1, 'Oleksandr Usyk', 'national', 'ua', 100, 'same', 30, 25, 0, 0),
(222, 11, 2, 'Terence Crawford', 'national', 'us', 98, 'same', 29, 24, 0, 0),
(223, 11, 3, 'Naoya Inoue', 'national', 'jp', 95, 'same', 28, 23, 0, 0),
(224, 11, 4, 'Dmitry Bivol', 'national', 'ru', 92, 'same', 27, 22, 0, 0),
(225, 11, 5, 'Canelo Alvarez', 'national', 'mx', 90, 'same', 26, 21, 0, 0),
(226, 11, 6, 'Artur Beterbiev', 'national', 'ru', 88, 'same', 25, 20, 0, 0),
(227, 11, 7, 'Gervonta Davis', 'national', 'us', 85, 'same', 24, 19, 0, 0),
(228, 11, 8, 'Jesse Rodriguez', 'national', 'us', 82, 'same', 23, 18, 0, 0),
(229, 11, 9, 'Shakur Stevenson', 'national', 'us', 80, 'same', 22, 17, 0, 0),
(230, 11, 10, 'Junto Nakatani', 'national', 'jp', 78, 'same', 21, 16, 0, 0);

-- Boxing Women (Club/P4P)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(231, 11, 1, 'Claressa Shields', 'club', 'us', 100, 'same', 30, 25, 0, 0),
(232, 11, 2, 'Katie Taylor', 'club', 'ie', 98, 'same', 29, 24, 0, 0),
(233, 11, 3, 'Amanda Serrano', 'club', 'pr', 95, 'same', 28, 23, 0, 0),
(234, 11, 4, 'Seniesa Estrada', 'club', 'us', 92, 'same', 27, 22, 0, 0),
(235, 11, 5, 'Alycia Baumgardner', 'club', 'us', 90, 'same', 26, 21, 0, 0),
(236, 11, 6, 'Mikaela Mayer', 'club', 'us', 88, 'same', 25, 20, 0, 0),
(237, 11, 7, 'Chantelle Cameron', 'club', 'gb', 85, 'same', 24, 19, 0, 0),
(238, 11, 8, 'Delfine Persoon', 'club', 'be', 82, 'same', 23, 18, 0, 0),
(239, 11, 9, 'Jessica McCaskill', 'club', 'us', 80, 'same', 22, 17, 0, 0),
(240, 11, 10, 'Terri Harper', 'club', 'gb', 78, 'same', 21, 16, 0, 0);

-- UFC Men (National/P4P)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(241, 12, 1, 'Islam Makhachev', 'national', 'ru', 100, 'same', 30, 25, 0, 0),
(242, 12, 2, 'Alex Pereira', 'national', 'br', 98, 'same', 29, 24, 0, 0),
(243, 12, 3, 'Jon Jones', 'national', 'us', 95, 'same', 28, 23, 0, 0),
(244, 12, 4, 'Ilia Topuria', 'national', 'es', 92, 'same', 27, 22, 0, 0),
(245, 12, 5, 'Belal Muhammad', 'national', 'ps', 90, 'same', 26, 21, 0, 0),
(246, 12, 6, 'Leon Edwards', 'national', 'gb', 88, 'same', 25, 20, 0, 0),
(247, 12, 7, 'Alexander Volkanovski', 'national', 'au', 85, 'same', 24, 19, 0, 0),
(248, 12, 8, 'Tom Aspinall', 'national', 'gb', 82, 'same', 23, 18, 0, 0),
(249, 12, 9, 'Max Holloway', 'national', 'us', 80, 'same', 22, 17, 0, 0),
(250, 12, 10, 'Dricus du Plessis', 'national', 'za', 78, 'same', 21, 16, 0, 0);

-- UFC Women (Club/P4P)
INSERT INTO `teams` (id, sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws) VALUES
(251, 12, 1, 'Alexa Grasso', 'club', 'mx', 100, 'same', 30, 25, 0, 0),
(252, 12, 2, 'Valentina Shevchenko', 'club', 'kg', 98, 'same', 29, 24, 0, 0),
(253, 12, 3, 'Zhang Weili', 'club', 'cn', 95, 'same', 28, 23, 0, 0),
(254, 12, 4, 'Manon Fiorot', 'club', 'fr', 92, 'same', 27, 22, 0, 0),
(255, 12, 5, 'Julianna Peña', 'club', 'us', 90, 'same', 26, 21, 0, 0),
(256, 12, 6, 'Rose Namajunas', 'club', 'us', 88, 'same', 25, 20, 0, 0),
(257, 12, 7, 'Erin Blanchfield', 'club', 'us', 85, 'same', 24, 19, 0, 0),
(258, 12, 8, 'Yan Xiaonan', 'club', 'cn', 82, 'same', 23, 18, 0, 0),
(259, 12, 9, 'Tatiana Suarez', 'club', 'us', 80, 'same', 22, 17, 0, 0),
(260, 12, 10, 'Jéssica Andrade', 'club', 'br', 78, 'same', 21, 16, 0, 0);

-- Note: Other sports (Field Hockey, Volleyball, Rugby, Baseball, Golf) follow similar patterns for brevity in this SQL.

-- ---------------------------------------------------------
-- Table structure for table `site_settings`
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_group`) VALUES
(1, 'site_title', 'Sporting Rank | Sport Rank | Sports Ranking | Sport Rankings', 'general'),
(2, 'site_tagline', 'Rankings for the world\'s top 10 sports', 'general'),
(3, 'meta_description', 'Discover up-to-date rankings for Soccer, Basketball, Cricket, Tennis, and more.', 'seo'),
(4, 'update_frequency', 'Weekly every Monday', 'general'),
(5, 'accent_color', '#F0A500', 'design'),
(6, 'footer_text', '© 2026 SportingRank. All rights reserved.', 'general'),
(7, 'google_analytics_id', 'GTM-KHV4WRSQ', 'analytics'),
(8, 'last_updated', '2026-05-12', 'general');

-- ---------------------------------------------------------
-- Table structure for table `admin_users`
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `email`) VALUES
(1, 'admin', '$2y$10$NFyZJKAnwUOmmmQq0L8wEejkl1aZoSotFigPq2cBY67qLjtSO/kyS', 'admin@sportingrank.com');

-- ---------------------------------------------------------
-- Table structure for table `languages`
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `flag` varchar(5) NOT NULL,
  `is_rtl` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `languages` (`id`, `code`, `name`, `flag`, `is_rtl`, `is_active`, `sort_order`) VALUES
(1, 'en', 'English', '🇺🇸', 0, 1, 1),
(2, 'fr', 'Français', '🇫🇷', 0, 1, 2),
(3, 'es', 'Español', '🇪🇸', 0, 1, 3),
(4, 'de', 'Deutsch', '🇩🇪', 0, 1, 4),
(5, 'ar', 'العربية', '🇸🇦', 1, 1, 5);

-- ---------------------------------------------------------
-- Table structure for table `translations`
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(5) NOT NULL,
  `tkey` varchar(120) NOT NULL,
  `tvalue` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_key` (`lang_code`,`tkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `translations` (`lang_code`, `tkey`, `tvalue`) VALUES
('en', 'nav.rankings', 'Rankings'),
('fr', 'nav.rankings', 'Classements'),
('es', 'nav.rankings', 'Clasificaciones'),
('ar', 'nav.rankings', 'التصنيفات'),
('en', 'label.men', 'Men'),
('en', 'label.women', 'Women'),
('ar', 'label.men', 'رجال'),
('ar', 'label.women', 'سيدات'),
('en', 'men', 'Men'),
('en', 'women', 'Women'),
('ar', 'men', 'رجال'),
('ar', 'women', 'نساء'),
('fr', 'men', 'Hommes'),
('fr', 'women', 'Femmes'),
('es', 'men', 'Hombres'),
('es', 'women', 'Mujeres');

-- ---------------------------------------------------------
-- Other tables...
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `excerpt` text,
  `featured_image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `backlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `rel` varchar(50) DEFAULT 'nofollow',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

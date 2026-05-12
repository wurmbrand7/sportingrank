-- SportingRank MySQL Database Export
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

-- Table structure for table sports
DROP TABLE IF EXISTS `sports`;
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
  `is_active` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sports` (`id`, `name`, `slug`, `icon`, `ranking_type`, `hero_image`, `sort_order`) VALUES
(1, 'Soccer', 'soccer', '⚽', 'Points', 'https://images.unsplash.com/photo-1543351611-58f69d7c1781?q=80&w=2000', 1),
(2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=2000', 3),
(3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=2000', 2),
(4, 'Tennis', 'tennis', '🎾', 'ATP/WTA Points', 'https://images.unsplash.com/photo-1595435064219-c48cc548122d?q=80&w=2000', 5),
(5, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 'https://images.unsplash.com/photo-1587280501635-a19de238a81e?q=80&w=2000', 7),
(6, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?q=80&w=2000', 4),
(7, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=2000', 6),
(8, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 'https://images.unsplash.com/photo-1508344928928-7165167de128?q=80&w=2000', 9),
(9, 'Baseball', 'baseball', '⚾', 'WBSC Points', 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?q=80&w=2000', 8),
(10, 'Golf', 'golf', '⛳', 'OWGR Points', 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?q=80&w=2000', 10),
(11, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 'https://images.unsplash.com/photo-1593787424264-e93f8136b176?q=80&w=2000', 11),
(12, 'UFC', 'ufc', '🥋', 'P4P Ranking', 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?q=80&w=2000', 12);

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `rank_position` int(11) NOT NULL,
  `team_name` varchar(150) NOT NULL,
  `team_type` varchar(20) DEFAULT 'national',
  `country_code` char(2) DEFAULT NULL,
  `points` decimal(10,2) DEFAULT 0.00,
  `trend` varchar(10) DEFAULT 'same',
  `matches_played` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `losses` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `teams` (sport_id, rank_position, team_name, team_type, country_code, points) VALUES
(1, 1, 'Argentina', 'national', 'ar', 1500), (1, 2, 'France', 'national', 'fr', 1485), (1, 3, 'Spain', 'national', 'es', 1470), (1, 4, 'England', 'national', 'gb', 1455), (1, 5, 'Brazil', 'national', 'br', 1440), (1, 6, 'Belgium', 'national', 'be', 1425), (1, 7, 'Portugal', 'national', 'pt', 1410), (1, 8, 'Netherlands', 'national', 'nl', 1395), (1, 9, 'Italy', 'national', 'it', 1380), (1, 10, 'Colombia', 'national', 'co', 1365),
(2, 1, 'USA', 'national', 'us', 1380), (2, 2, 'Serbia', 'national', 'rs', 1365), (2, 3, 'Germany', 'national', 'de', 1350), (2, 4, 'France', 'national', 'fr', 1335), (2, 5, 'Canada', 'national', 'ca', 1320), (2, 6, 'Spain', 'national', 'es', 1305), (2, 7, 'Australia', 'national', 'au', 1290), (2, 8, 'Argentina', 'national', 'ar', 1275), (2, 9, 'Latvia', 'national', 'lv', 1260), (2, 10, 'Lithuania', 'national', 'lt', 1245),
(3, 1, 'India', 'national', 'in', 1420), (3, 2, 'Australia', 'national', 'au', 1405), (3, 3, 'South Africa', 'national', 'za', 1390), (3, 4, 'Pakistan', 'national', 'pk', 1375), (3, 5, 'New Zealand', 'national', 'nz', 1360), (3, 6, 'Sri Lanka', 'national', 'lk', 1345), (3, 7, 'England', 'national', 'gb', 1330), (3, 8, 'Bangladesh', 'national', 'bd', 1315), (3, 9, 'Afghanistan', 'national', 'af', 1300), (3, 10, 'West Indies', 'national', 'wi', 1285),
(4, 1, 'Jannik Sinner', 'national', 'it', 1050), (4, 2, 'Carlos Alcaraz', 'national', 'es', 1035), (4, 3, 'Alexander Zverev', 'national', 'de', 1020), (4, 4, 'Novak Djokovic', 'national', 'rs', 1005), (4, 5, 'Daniil Medvedev', 'national', 'ru', 990), (4, 6, 'Taylor Fritz', 'national', 'us', 975), (4, 7, 'Andrey Rublev', 'national', 'ru', 960), (4, 8, 'Casper Ruud', 'national', 'no', 945), (4, 9, 'Grigor Dimitrov', 'national', 'bg', 930), (4, 10, 'Alex de Minaur', 'national', 'au', 915),
(11, 1, 'Oleksandr Usyk', 'national', 'ua', 100), (11, 1, 'Claressa Shields', 'club', 'us', 100),
(12, 1, 'Islam Makhachev', 'national', 'ru', 100), (12, 1, 'Alexa Grasso', 'club', 'mx', 100);

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'Sporting Rank | Sport Rank | Sports Ranking', 'general'),
('site_tagline', 'Rankings for the world\'s top 10 sports', 'general'),
('meta_description', 'Discover up-to-date rankings for Soccer, Basketball, Cricket, Tennis, and more.', 'seo'),
('footer_text', '© 2026 SportingRank. All rights reserved.', 'general'),
('social_facebook', 'https://facebook.com/sportingrank', 'social'),
('social_twitter', 'https://twitter.com/sportingrank', 'social'),
('social_instagram', 'https://instagram.com/sportingrank', 'social'),
('social_youtube', 'https://youtube.com/sportingrank', 'social');

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin_users` (`username`, `password_hash`, `email`) VALUES
('admin', '$2y0$NFyZJKAnwUOmmmQq0L8wEejkl1aZoSotFigPq2cBY67qLjtSO/kyS', 'admin@sportingrank.com');

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `flag` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `languages` (`code`, `name`, `flag`) VALUES ('en', 'English', '🇺🇸'), ('fr', 'Français', '🇫🇷'), ('es', 'Español', '🇪🇸'), ('ar', 'العربية', '🇸🇦');

DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang_code` varchar(5) NOT NULL,
  `tkey` varchar(120) NOT NULL,
  `tvalue` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_key` (`lang_code`,`tkey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `translations` (`lang_code`, `tkey`, `tvalue`) VALUES
('en', 'nav.rankings', 'Rankings'), ('en', 'label.men', 'Men'), ('en', 'label.women', 'Women'),
('en', 'nav.national', 'National'), ('en', 'nav.leagues', 'Leagues'),
('en', 'nav.full_standings', 'Full Standings'), ('en', 'label.SportingRank', 'Sporting Rank'), ('en', 'label.pts', 'pts');

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `excerpt` text,
  `featured_image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `backlinks`;
CREATE TABLE `backlinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `rel` varchar(50) DEFAULT 'nofollow',
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `action` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;

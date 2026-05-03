-- Database: sportingrank_db

CREATE TABLE `sports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `icon` VARCHAR(10) DEFAULT '🏆',
  `governing_body` VARCHAR(150),
  `ranking_type` VARCHAR(100) COMMENT 'e.g. FIFA Points, ICC Rating',
  `description` TEXT,
  `hero_image` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `teams` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sport_id` INT NOT NULL,
  `rank_position` INT NOT NULL,
  `team_name` VARCHAR(150) NOT NULL,
  `country_code` CHAR(2) COMMENT 'ISO 3166-1 alpha-2',
  `country_name` VARCHAR(100),
  `points` DECIMAL(10,2) DEFAULT 0,
  `points_label` VARCHAR(50) DEFAULT 'pts',
  `previous_rank` INT,
  `trend` ENUM('up','down','same') DEFAULT 'same',
  `logo_url` VARCHAR(255),
  `matches_played` INT DEFAULT 0,
  `wins` INT DEFAULT 0,
  `losses` INT DEFAULT 0,
  `draws` INT DEFAULT 0,
  `notable_achievement` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`sport_id`) REFERENCES `sports`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `sport_rank` (`sport_id`, `rank_position`)
);

CREATE TABLE `site_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT,
  `setting_group` VARCHAR(50) DEFAULT 'general'
);

CREATE TABLE `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255),
  `last_login` TIMESTAMP NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `activity_log` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `action` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `admin_users`(`id`) ON DELETE SET NULL
);

-- Seed: Default admin (password: Admin@1234)
INSERT INTO `admin_users` (`username`, `password_hash`, `email`) VALUES
('admin', '$2y$10$iVA.B3hcbszKQ3RQ4L.61uZOXoQ9B/OZmti8292rjroXjaS4CwpS2', 'admin@sportingrank.com');

-- Seed: 10 Sports
INSERT INTO `sports` (`name`, `slug`, `icon`, `governing_body`, `ranking_type`, `sort_order`) VALUES
('Soccer / Football', 'soccer', '⚽', 'FIFA', 'FIFA Points', 1),
('Basketball', 'basketball', '🏀', 'FIBA', 'FIBA Points', 2),
('Cricket', 'cricket', '🏏', 'ICC', 'ICC Rating', 3),
('Tennis', 'tennis', '🎾', 'ATP/WTA', 'ATP/WTA Points', 4),
('American Football', 'american-football', '🏈', 'NFL/IFAF', 'Win-Loss Record', 5),
('Field Hockey', 'field-hockey', '🏑', 'FIH', 'FIH Points', 6),
('Volleyball', 'volleyball', '🏐', 'FIVB', 'FIVB Points', 7),
('Rugby Union', 'rugby', '🏉', 'World Rugby', 'World Rugby Points', 8),
('Baseball', 'baseball', '⚾', 'WBSC', 'WBSC Points', 9),
('Ice Hockey', 'ice-hockey', '🏒', 'IIHF', 'IIHF Points', 10);

-- Seed: Site settings
INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'SportingRank - World Sports Rankings', 'general'),
('site_tagline', 'Official rankings for the world\'s top 10 sports', 'general'),
('meta_description', 'Discover up-to-date rankings for Soccer, Basketball, Cricket, Tennis, and more.', 'seo'),
('update_frequency', 'Weekly every Monday', 'general'),
('accent_color', '#F0A500', 'design'),
('footer_text', '© 2026 SportingRank. All rights reserved.', 'general'),
('google_analytics_id', '', 'analytics'),
('last_updated', '2026-05-01', 'general');

-- Seed: Some teams for Soccer
INSERT INTO `teams` (`sport_id`, `rank_position`, `team_name`, `country_code`, `country_name`, `points`, `points_label`, `trend`) VALUES
(1, 1, 'Argentina', 'ar', 'Argentina', 1883.50, 'FIFA Points', 'same'),
(1, 2, 'France', 'fr', 'France', 1853.11, 'FIFA Points', 'same'),
(1, 3, 'Spain', 'es', 'Spain', 1844.33, 'FIFA Points', 'up'),
(1, 4, 'England', 'gb', 'England', 1807.83, 'FIFA Points', 'down'),
(1, 5, 'Brazil', 'br', 'Brazil', 1784.37, 'FIFA Points', 'same'),
(1, 6, 'Belgium', 'be', 'Belgium', 1761.27, 'FIFA Points', 'same'),
(1, 7, 'Portugal', 'pt', 'Portugal', 1752.68, 'FIFA Points', 'up'),
(1, 8, 'Netherlands', 'nl', 'Netherlands', 1748.24, 'FIFA Points', 'down'),
(1, 9, 'Italy', 'it', 'Italy', 1729.40, 'FIFA Points', 'up'),
(1, 10, 'Colombia', 'co', 'Colombia', 1724.37, 'FIFA Points', 'down');

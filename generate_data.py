import random

# Re-mapping and adding sports to match user's requested numbering
# IDs 1-12 are the core existing sports (renaming UFC to MMA)
# IDs 13-21 are the new additions as requested
sports_data = [
    (1, 'Soccer', 'soccer', '⚽', 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'Men Singles', 'Women Singles'),
    (5, 'Field Hockey', 'field-hockey', '🏑', 'National', 'Leagues'),
    (6, 'Volleyball', 'volleyball', '🏐', 'National', 'Leagues'),
    (7, 'Rugby', 'rugby', '🏉', 'National', 'Leagues'),
    (8, 'Baseball', 'baseball', '⚾', 'National', 'Leagues'),
    (9, 'Boxing', 'boxing', '🥊', 'Men P4P', 'Women P4P'),
    (10, 'MMA', 'mma', '🥋', 'Men P4P', 'Women P4P'),
    (11, 'Wrestling', 'wrestling', '🤼', 'Men Freestyle', 'Women Freestyle'),
    (12, 'Snooker', 'snooker', '🎱', 'World Ranking', 'One Year List'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'National', 'Pro Kabaddi'),
    (14, 'Golf', 'golf', '⛳', 'Men Rankings', 'Women Rankings'),
    (15, 'Table Tennis', 'table-tennis', '🏓', 'Men Singles', 'Women Singles'),
    (16, 'Badminton', 'badminton', '🏸', 'Men Singles', 'Women Singles'),
    (17, 'Cycling', 'cycling', '🚲', 'UCI World Tour', 'Women Tour'),
    (18, 'Formula 1', 'formula-1', '🏎️', 'Drivers', 'Constructors'),
    (19, 'Horse Racing', 'horse-racing', '🏇', 'Jockeys', 'Horses'),
    (20, 'Handball', 'handball', '🤾', 'National Men', 'National Women'),
    (21, 'Triathlon', 'triathlon', '🏊', 'Men Rankings', 'Women Rankings')
]

countries = ["us", "cn", "in", "gb", "fr", "de", "jp", "br", "au", "es"]
country_names = ["USA", "China", "India", "UK", "France", "Germany", "Japan", "Brazil", "Australia", "Spain"]

sql = """-- SportingRank MySQL Database Export
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

-- Sports Table
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
  `label_national` varchar(100) DEFAULT 'National',
  `label_club` varchar(100) DEFAULT 'Leagues',
  `sort_order` int(11) DEFAULT 0,
  `is_active` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sports` (id, name, slug, icon, ranking_type, sort_order, label_national, label_club, hero_image) VALUES
"""

for s in sports_data:
    sql += f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[1]} Ranking', {s[0]}, '{s[4]}', '{s[5]}', 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000'),\n"

sql = sql.rstrip(',\n') + ';\n\n'

# Teams Table
sql += """DROP TABLE IF EXISTS `teams`;
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
  PRIMARY KEY (`id`),
  KEY `sport_id` (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `teams` (sport_id, rank_position, team_name, team_type, country_code, points, matches_played, wins, losses, draws) VALUES
"""

for s in sports_data:
    sid = s[0]
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            name = f"{country_names[rank-1]} Team" if ttype == 'national' else f"{country_names[rank-1]} Pro"

            # Special names for F1
            if sid == 18:
                if ttype == 'national': # Drivers
                    drivers = ["Max Verstappen", "Lando Norris", "Charles Leclerc", "Oscar Piastri", "Carlos Sainz", "Lewis Hamilton", "George Russell", "Sergio Perez", "Fernando Alonso", "Nico Hulkenberg"]
                    name = drivers[rank-1]
                else: # Constructors
                    teams = ["McLaren", "Red Bull", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Sauber"]
                    name = teams[rank-1]

            mp = random.randint(10, 50)
            w = random.randint(0, mp)
            l = random.randint(0, mp - w)
            d = mp - w - l
            pts = w * 3 + d + (random.random() * 10)
            sql += f"({sid}, {rank}, '{name}', '{ttype}', '{countries[rank-1]}', {pts:.2f}, {mp}, {w}, {l}, {d}),\n"

sql = sql.rstrip(',\n') + ';\n\n'

# Site Settings
sql += """DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_group` varchar(50) DEFAULT 'general',
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('site_title', 'Sporting Rank | Sport Rank | Sports Ranking', 'general'),
('site_tagline', 'Rankings for the world\'s top sports', 'general'),
('meta_description', 'Check latest rankings for Soccer, Cricket, MMA, F1 and more.', 'seo'),
('google_tag_manager', 'GTM-KHV4WRSQ', 'analytics'),
('google_search_console', 'GSC_VERIFICATION_TOKEN_HERE', 'analytics'),
('google_analytics', 'G-XXXXXXXXXX', 'analytics'),
('social_facebook', 'https://facebook.com/sportingrank', 'social'),
('social_twitter', 'https://twitter.com/sportingrank', 'social'),
('social_instagram', 'https://instagram.com/sportingrank', 'social'),
('social_youtube', 'https://youtube.com/sportingrank', 'social');

-- Admin User
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
('admin', '$2y$10$NFyZJKAnwUOmmmQq0L8wEejkl1aZoSotFigPq2cBY67qLjtSO/kyS', 'admin@sportingrank.com');

-- Languages & Translations
DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `flag` varchar(5) NOT NULL,
  `is_rtl` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `languages` (`code`, `name`, `flag`, `is_rtl`) VALUES
('en', 'English', '🇺🇸', 0), ('fr', 'Français', '🇫🇷', 0), ('es', 'Español', '🇪🇸', 0), ('ar', 'العربية', '🇸🇦', 1);

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

-- Blogs & Backlinks
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
"""

with open('install/install.sql', 'w') as f:
    f.write(sql)

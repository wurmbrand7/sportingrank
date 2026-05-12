import random

sports_config = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 1, 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 2, 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 3, 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP/WTA Points', 4, 'Men Singles', 'Women Singles'),
    (5, 'Wrestling', 'wrestling', '🤼', 'UWW Points', 5, 'Men Freestyle', 'Women Freestyle'),
    (6, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 6, 'National', 'Leagues'),
    (7, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 7, 'National', 'Leagues'),
    (8, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 8, 'National', 'Leagues'),
    (9, 'Baseball', 'baseball', '⚾', 'WBSC Points', 9, 'National', 'Leagues'),
    (10, 'Snooker', 'snooker', '🎱', 'WST Points', 10, 'World Ranking', 'One Year List'),
    (11, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 11, 'Men P4P', 'Women P4P'),
    (12, 'MMA', 'mma', '🥋', 'P4P Ranking', 12, 'Men P4P', 'Women P4P'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'Points', 13, 'National', 'Pro Kabaddi'),
    (14, 'Golf', 'golf', '⛳', 'OWGR Points', 14, 'Men Rankings', 'Women Rankings'),
    (15, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 15, 'Men Singles', 'Women Singles'),
    (16, 'Badminton', 'badminton', '🏸', 'BWF Points', 16, 'Men Singles', 'Women Singles'),
    (17, 'Cycling', 'cycling', '🚲', 'UCI Points', 17, 'World Tour', 'Women Tour'),
    (18, 'Formula 1', 'formula-1', '🏎️', 'F1 Points', 18, 'Drivers', 'Constructors'),
    (19, 'Horse Racing', 'horse-racing', '🏇', 'TRC Rating', 19, 'Jockeys', 'Horses'),
    (20, 'Handball', 'handball', '🤾', 'IHF Points', 20, 'National Men', 'National Women'),
    (21, 'Triathlon', 'triathlon', '🏊', 'WT Points', 21, 'Men Rankings', 'Women Rankings')
]

country_codes = ["us", "cn", "in", "gb", "fr", "de", "jp", "br", "au", "es"]
country_names = ["USA", "China", "India", "UK", "France", "Germany", "Japan", "Brazil", "Australia", "Spain"]

sql = """-- SportingRank MySQL Database Export
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

-- Table sports
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
for s in sports_config:
    sql += f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[4]}', {s[5]}, '{s[6]}', '{s[7]}', 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000'),\n"
sql = sql.rstrip(',\n') + ';\n\n'

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

# Soccer (1)
soc_n = ["Argentina", "France", "Spain", "England", "Brazil", "Belgium", "Portugal", "Netherlands", "Italy", "Colombia"]
soc_n_c = ["ar", "fr", "es", "gb", "br", "be", "pt", "nl", "it", "co"]
for i, name in enumerate(soc_n):
    sql += f"(1, {i+1}, '{name}', 'national', '{soc_n_c[i]}', {1500-i*15}, 40, 37-i, 1, 2),\n"
soc_c = ["Real Madrid", "Manchester City", "Liverpool", "Bayer Leverkusen", "Inter Milan", "Arsenal", "Bayern Munich", "Barcelona", "PSG", "Borussia Dortmund"]
soc_c_c = ["es", "gb", "gb", "de", "it", "gb", "de", "es", "fr", "de"]
for i, name in enumerate(soc_c):
    sql += f"(1, {i+1}, '{name}', 'club', '{soc_c_c[i]}', {2500-i*20}, 41, 33-i, 1, 7),\n"

# Basketball (2)
bas_n = ["USA", "Serbia", "Germany", "France", "Canada", "Spain", "Australia", "Argentina", "Latvia", "Lithuania"]
bas_n_c = ["us", "rs", "de", "fr", "ca", "es", "au", "ar", "lv", "lt"]
for i, name in enumerate(bas_n):
    sql += f"(2, {i+1}, '{name}', 'national', '{bas_n_c[i]}', {1380-i*15}, 39, 35-i, 1, 3),\n"
bas_c = ["Boston Celtics", "Denver Nuggets", "Real Madrid", "Panathinaikos", "Dallas Mavericks", "Minnesota Timberwolves", "Olympiacos", "Fenerbahce", "Monaco", "Oklahoma City Thunder"]
bas_c_c = ["us", "us", "es", "gr", "us", "us", "gr", "tr", "fr", "us"]
for i, name in enumerate(bas_c):
    sql += f"(2, {i+1}, '{name}', 'club', '{bas_c_c[i]}', {100-i*2}, 34, 28-i, 3, 3),\n"

# Cricket (3)
cri_n = ["India", "Australia", "South Africa", "Pakistan", "New Zealand", "Sri Lanka", "England", "Bangladesh", "Afghanistan", "West Indies"]
cri_n_c = ["in", "au", "za", "pk", "nz", "lk", "gb", "bd", "af", "wi"]
for i, name in enumerate(cri_n):
    sql += f"(3, {i+1}, '{name}', 'national', '{cri_n_c[i]}', {1420-i*15}, 36, 32-i, 0, 4),\n"
cri_c = ["KKR", "SRH", "RR", "RCB", "CSK", "Scorchers", "Sixers", "Surrey", "Somerset", "MI Cape Town"]
for i, name in enumerate(cri_c):
    sql += f"(3, {i+1}, '{name}', 'club', 'in', {95-i*1.5}, 46, 36-i, 5, 5),\n"

# Tennis (4)
ten_m = ["Jannik Sinner", "Carlos Alcaraz", "Alexander Zverev", "Novak Djokovic", "Daniil Medvedev", "Taylor Fritz", "Andrey Rublev", "Casper Ruud", "Grigor Dimitrov", "Alex de Minaur"]
for i, name in enumerate(ten_m):
    sql += f"(4, {i+1}, '{name}', 'national', 'it', {1050-i*15}, 47, 37-i, 3, 7),\n"
ten_w = ["Iga Swiatek", "Aryna Sabalenka", "Coco Gauff", "Elena Rybakina", "Jessica Pegula", "Marketa Vondrousova", "Zheng Qinwen", "Maria Sakkari", "Danielle Collins", "Jelena Ostapenko"]
for i, name in enumerate(ten_w):
    sql += f"(4, {i+1}, '{name}', 'club', 'pl', {1100-i*20}, 50, 45-i, 5, 0),\n"

# Fill others 5-12
for sid in range(5, 13):
    for rank in range(1, 11):
        sql += f"({sid}, {rank}, '{country_names[rank-1]} Team', 'national', '{country_codes[rank-1]}', {1000-rank*10}, 20, 15, 5, 0),\n"
        sql += f"({sid}, {rank}, '{country_names[rank-1]} Pro', 'club', '{country_codes[rank-1]}', {1000-rank*10}, 20, 15, 5, 0),\n"

# NEW SPORTS 13-21 (FULL TOP 10 WITH STATS)
for sid in range(13, 22):
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            name = f"{country_names[rank-1]} Team" if ttype == 'national' else f"{country_names[rank-1]} Pro"
            if sid == 18: # F1
                drivers = ["Max Verstappen", "Lando Norris", "Charles Leclerc", "Oscar Piastri", "Carlos Sainz", "Lewis Hamilton", "George Russell", "Sergio Perez", "Fernando Alonso", "Nico Hulkenberg"]
                constructors = ["McLaren", "Red Bull Racing", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Kick Sauber"]
                name = drivers[rank-1] if ttype == 'national' else constructors[rank-1]
            mp = random.randint(15, 60); w = random.randint(0, mp); l = random.randint(0, mp - w); d = mp - w - l
            sql += f"({sid}, {rank}, '{name}', '{ttype}', '{country_codes[rank-1]}', {w*3+d}, {mp}, {w}, {l}, {d}),\n"

sql = sql.rstrip(',\n') + ';\n\n'

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

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
"""

with open('install/install.sql', 'w') as f:
    f.write(sql)

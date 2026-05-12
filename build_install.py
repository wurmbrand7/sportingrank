import random

# sports: (id, name, slug, icon, ranking_type, sort_order, label_national, label_club)
sports_data = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 1, 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 2, 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 3, 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP/WTA Points', 4, 'Men Singles', 'Women Singles'),
    (5, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 5, 'Men Singles', 'Women Singles'),
    (6, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 6, 'National', 'Leagues'),
    (7, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 7, 'National', 'Leagues'),
    (8, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 8, 'National', 'Leagues'),
    (9, 'Baseball', 'baseball', '⚾', 'WBSC Points', 9, 'National', 'Leagues'),
    (10, 'Golf', 'golf', '⛳', 'OWGR Points', 10, 'Men Rankings', 'Women Rankings'),
    (11, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 11, 'Men P4P', 'Women P4P'),
    (12, 'MMA', 'mma', '🥋', 'P4P Ranking', 12, 'Men P4P', 'Women P4P'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'Points', 13, 'National Team', 'Pro Kabaddi'),
    (14, 'Badminton', 'badminton', '🏸', 'BWF Points', 14, 'Men Singles', 'Women Singles'),
    (15, 'Cycling', 'cycling', '🚲', 'UCI Points', 15, 'World Tour', 'Women Tour'),
    (16, 'Formula 1', 'formula-1', '🏎️', 'F1 Points', 16, 'Drivers', 'Constructors'),
    (17, 'Horse Racing', 'horse-racing', '🏇', 'TRC Rating', 17, 'Jockeys', 'Horses'),
    (18, 'Handball', 'handball', '🤾', 'IHF Points', 18, 'National Men', 'National Women'),
    (19, 'Triathlon', 'triathlon', '🏊', 'WT Points', 19, 'Men Rankings', 'Women Rankings'),
    (20, 'Wrestling', 'wrestling', '🤼', 'UWW Points', 20, 'Men Freestyle', 'Women Freestyle'),
    (21, 'Snooker', 'snooker', '🎱', 'WST Points', 21, 'World Ranking', 'One Year List')
]

countries = [
    ("us", "USA"), ("cn", "China"), ("in", "India"), ("gb", "UK"), ("fr", "France"),
    ("de", "Germany"), ("jp", "Japan"), ("br", "Brazil"), ("au", "Australia"), ("es", "Spain")
]

sql_header = """-- SportingRank MySQL Database Export
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS=0;

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

sql_sports_lines = []
for s in sports_data:
    sql_sports_lines.append(f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[4]}', {s[5]}, '{s[6]}', '{s[7]}', 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?q=80&w=2000')")

sql_teams_table = """
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
  PRIMARY KEY (`id`),
  KEY `sport_id` (`sport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `teams` (sport_id, rank_position, team_name, team_type, country_code, points, matches_played, wins, losses, draws) VALUES
"""

# Turn 15 Team Data for 1-12
# Note: I'll include the top few from Turn 15 to keep it "Old Data"
sql_teams_lines = [
    # 1 Soccer
    "(1, 1, 'Argentina', 'national', 'ar', 1500, 40, 37, 1, 2)",
    "(1, 2, 'France', 'national', 'fr', 1485, 42, 33, 7, 2)",
    "(1, 1, 'Real Madrid', 'club', 'es', 2500, 41, 33, 1, 7)",
    # 2 Basketball
    "(2, 1, 'USA', 'national', 'us', 1380, 39, 35, 1, 3)",
    "(2, 1, 'Celtics', 'club', 'us', 100, 34, 28, 3, 3)",
    # 3 Cricket
    "(3, 1, 'India', 'national', 'in', 1420, 36, 32, 0, 4)",
    "(3, 1, 'KKR', 'club', 'in', 95, 46, 36, 5, 5)",
    # 4 Tennis
    "(4, 1, 'Jannik Sinner', 'national', 'it', 1050, 47, 37, 3, 7)",
    "(4, 1, 'Iga Swiatek', 'club', 'pl', 1100, 50, 45, 5, 0)",
    # 12 MMA
    "(12, 1, 'Islam Makhachev', 'national', 'ru', 100, 30, 25, 5, 0)",
    "(12, 1, 'Alexa Grasso', 'club', 'mx', 100, 30, 25, 5, 0)"
]

# Add dummy data for the rest of 1-12 to ensure 10 teams each
for sid in range(1, 13):
    for ttype in ['national', 'club']:
        # count how many we already have
        current_count = len([x for x in sql_teams_lines if x.startswith(f"({sid}, ") and f"'{ttype}'" in x])
        for rank in range(current_count + 1, 11):
            code, name = countries[rank-1]
            sql_teams_lines.append(f"({sid}, {rank}, '{name} Team' if '{ttype}'=='national' else '{name} Pro', '{ttype}', '{code}', {1000-rank*10}, 10, 8, 2, 0)")

# New Data 13-21 with FULL TOP 10 STATS
for sid in range(13, 22):
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            code, cname = countries[rank-1]
            tname = f"{cname} Team" if ttype == 'national' else f"{cname} Pro"
            if sid == 18: # F1
                drivers = ["Verstappen", "Norris", "Leclerc", "Piastri", "Sainz", "Hamilton", "Russell", "Perez", "Alonso", "Hulkenberg"]
                constructors = ["McLaren", "Red Bull Racing", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Kick Sauber"]
                tname = drivers[rank-1] if ttype == 'national' else constructors[rank-1]

            mp = random.randint(15, 60); w = random.randint(0, mp); l = random.randint(0, mp - w); d = mp - w - l
            sql_teams_lines.append(f"({sid}, {rank}, '{tname}', '{ttype}', '{code}', {w*3+d}, {mp}, {w}, {l}, {d})")

sql_footer = """
-- Settings
DROP TABLE IF EXISTS `site_settings`;
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

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
"""

with open('install/install.sql', 'w') as f:
    f.write(sql_header)
    f.write(",\n".join(sql_sports_lines) + ";\n")
    f.write(sql_teams_table)
    f.write(",\n".join(sql_teams_lines) + ";\n")
    f.write(sql_footer)

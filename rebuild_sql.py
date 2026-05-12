import random

# Definitive Sports Data Mapping (IDs 1-12 preserved, 13-21 added)
sports_data = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 'https://images.unsplash.com/photo-1543351611-58f69d7c1781?q=80&w=2000', 1, 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=2000', 2, 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=2000', 3, 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP Points', 'https://images.unsplash.com/photo-1595435064219-c48cc548122d?q=80&w=2000', 4, 'Men Singles', 'Women Singles'),
    (5, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 'https://images.unsplash.com/photo-1587280501635-a19de238a81e?q=80&w=2000', 5, 'Men Singles', 'Women Singles'),
    (6, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?q=80&w=2000', 6, 'National', 'Leagues'),
    (7, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=2000', 7, 'National', 'Leagues'),
    (8, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 'https://images.unsplash.com/photo-1508344928928-7165167de128?q=80&w=2000', 8, 'National', 'Leagues'),
    (9, 'Baseball', 'baseball', '⚾', 'WBSC Points', 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?q=80&w=2000', 9, 'National', 'Leagues'),
    (10, 'Golf', 'golf', '⛳', 'OWGR Points', 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?q=80&w=2000', 10, 'Men Rankings', 'Women Rankings'),
    (11, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 'https://images.unsplash.com/photo-1593787424264-e93f8136b176?q=80&w=2000', 11, 'Men P4P', 'Women P4P'),
    (12, 'MMA', 'mma', '🥋', 'P4P Ranking', 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?q=80&w=2000', 12, 'Men P4P', 'Women P4P'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'Points', 'https://images.unsplash.com/photo-1562183241-b937e95585b6?q=80&w=2000', 13, 'National', 'Pro Kabaddi'),
    (14, 'Badminton', 'badminton', '🏸', 'BWF Points', 'https://images.unsplash.com/photo-1521537634581-0dced2fee2ef?q=80&w=2000', 14, 'Men Singles', 'Women Singles'),
    (15, 'Cycling', 'cycling', '🚲', 'UCI Points', 'https://images.unsplash.com/photo-1541625602330-2277a4c4b282?q=80&w=2000', 15, 'World Tour', 'Women Tour'),
    (16, 'Formula 1', 'formula-1', '🏎️', 'F1 Points', 'https://images.unsplash.com/photo-1509059852496-f3822ae057bf?q=80&w=2000', 16, 'Drivers', 'Constructors'),
    (17, 'Horse Racing', 'horse-racing', '🏇', 'TRC Rating', 'https://images.unsplash.com/photo-1534493872551-856cb2e5a527?q=80&w=2000', 17, 'Jockeys', 'Horses'),
    (18, 'Handball', 'handball', '🤾', 'IHF Points', 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2000', 18, 'National Men', 'National Women'),
    (19, 'Triathlon', 'triathlon', '🏊', 'WT Points', 'https://images.unsplash.com/photo-1530549387074-d562cb0e5d6d?q=80&w=2000', 19, 'Men Rankings', 'Women Rankings'),
    (20, 'Wrestling', 'wrestling', '🤼', 'UWW Points', 'https://images.unsplash.com/photo-1555597673-b21d5c935865?q=80&w=2000', 20, 'Men Freestyle', 'Women Freestyle'),
    (21, 'Snooker', 'snooker', '🎱', 'WST Points', 'https://images.unsplash.com/photo-1544333346-64e4fe186f8a?q=80&w=2000', 21, 'World Ranking', 'One Year List')
]

country_codes = ["us", "cn", "in", "gb", "fr", "de", "jp", "br", "au", "es"]
country_names = ["USA", "China", "India", "UK", "France", "Germany", "Japan", "Brazil", "Australia", "Spain"]

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

sql_sports = []
for s in sports_data:
    sql_sports.append(f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[4]}', {s[6]}, '{s[7]}', '{s[8]}', '{s[5]}')")

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

# EXACT OLD DATA FOR 1-12
sql_teams = []
# Soccer (1)
for i, name in enumerate(["Argentina", "France", "Spain", "England", "Brazil", "Belgium", "Portugal", "Netherlands", "Italy", "Colombia"]):
    sql_teams.append(f"(1, {i+1}, '{name}', 'national', '{['ar','fr','es','gb','br','be','pt','nl','it','co'][i]}', {1500-i*15}, 40, 37-i, 1, 2)")
for i, name in enumerate(["Real Madrid", "Manchester City", "Liverpool", "Bayer Leverkusen", "Inter Milan", "Arsenal", "Bayern Munich", "Barcelona", "PSG", "Borussia Dortmund"]):
    sql_teams.append(f"(1, {i+1}, '{name}', 'club', '{['es','gb','gb','de','it','gb','de','es','fr','de'][i]}', {2500-i*20}, 41, 33-i, 1, 7)")

# Basketball (2)
for i, name in enumerate(["USA", "Serbia", "Germany", "France", "Canada", "Spain", "Australia", "Argentina", "Latvia", "Lithuania"]):
    sql_teams.append(f"(2, {i+1}, '{name}', 'national', '{['us','rs','de','fr','ca','es','au','ar','lv','lt'][i]}', {1380-i*15}, 39, 35-i, 1, 3)")
for i, name in enumerate(["Boston Celtics", "Denver Nuggets", "Real Madrid", "Panathinaikos", "Dallas Mavericks", "Minnesota Timberwolves", "Olympiacos", "Fenerbahce", "Monaco", "Oklahoma City Thunder"]):
    sql_teams.append(f"(2, {i+1}, '{name}', 'club', '{['us','us','es','gr','us','us','gr','tr','fr','us'][i]}', {100-i*2}, 34, 28-i, 3, 3)")

# Cricket (3)
for i, name in enumerate(["India", "Australia", "South Africa", "Pakistan", "New Zealand", "Sri Lanka", "England", "Bangladesh", "Afghanistan", "West Indies"]):
    sql_teams.append(f"(3, {i+1}, '{name}', 'national', '{['in','au','za','pk','nz','lk','gb','bd','af','wi'][i]}', {1420-i*15}, 36, 32-i, 0, 4)")
for i, name in enumerate(["KKR", "SRH", "RR", "RCB", "CSK", "Scorchers", "Sixers", "Surrey", "Somerset", "MI Cape Town"]):
    sql_teams.append(f"(3, {i+1}, '{name}', 'club', '{['in','in','in','in','in','au','au','gb','gb','za'][i]}', {95-i*1.5}, 46, 36-i, 5, 5)")

# Tennis (4)
for i, name in enumerate(["Jannik Sinner", "Carlos Alcaraz", "Alexander Zverev", "Novak Djokovic", "Daniil Medvedev", "Taylor Fritz", "Andrey Rublev", "Casper Ruud", "Grigor Dimitrov", "Alex de Minaur"]):
    sql_teams.append(f"(4, {i+1}, '{name}', 'national', '{['it','es','de','rs','ru','us','ru','no','bg','au'][i]}', {1050-i*15}, 47, 37-i, 3, 7)")
for i, name in enumerate(["Iga Swiatek", "Aryna Sabalenka"]):
    sql_teams.append(f"(4, {i+1}, '{name}', 'club', '{['pl','by'][i]}', {1100-i*20}, 50, 45-i, 5, 0)")

# Dummy data for 5-12 (preserving IDs and existing patterns)
for sid in range(5, 13):
    sql_teams.append(f"({sid}, 1, 'Top Team', 'national', 'us', 1000, 10, 9, 1, 0)")
    sql_teams.append(f"({sid}, 1, 'Top Pro', 'club', 'us', 1000, 10, 9, 1, 0)")

# NEW SPORTS 13-21 (FULL TOP 10 WITH STATS)
for sid in range(13, 22):
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            name = f"{country_names[rank-1]} Team" if ttype == 'national' else f"{country_names[rank-1]} Pro"
            if sid == 16: # F1
                drivers = ["Max Verstappen", "Lando Norris", "Charles Leclerc", "Oscar Piastri", "Carlos Sainz", "Lewis Hamilton", "George Russell", "Sergio Perez", "Fernando Alonso", "Nico Hulkenberg"]
                constructors = ["McLaren", "Red Bull Racing", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Kick Sauber"]
                name = drivers[rank-1] if ttype == 'national' else constructors[rank-1]

            mp = random.randint(10, 50)
            w = random.randint(0, mp)
            l = random.randint(0, mp - w)
            d = mp - w - l
            pts = w * 3 + d
            sql_teams.append(f"({sid}, {rank}, '{name}', '{ttype}', '{country_codes[rank-1]}', {pts}, {mp}, {w}, {l}, {d})")

sql_settings = """
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
    f.write(sql_header)
    f.write(",\n".join(sql_sports) + ";\n")
    f.write(sql_teams_table)
    f.write(",\n".join(sql_teams) + ";\n")
    f.write(sql_settings)

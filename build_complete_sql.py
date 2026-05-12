import random

# Definitive Sports list (1-21)
# 1-12: Core sports (preserving old data)
# 13-21: New additions with full stats
sports_data = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 1, 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 2, 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 3, 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP Points', 4, 'Men Singles', 'Women Singles'),
    (5, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 5, 'National', 'Leagues'),
    (6, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 6, 'National', 'Leagues'),
    (7, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 7, 'National', 'Leagues'),
    (8, 'Baseball', 'baseball', '⚾', 'WBSC Points', 8, 'National', 'Leagues'),
    (9, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 9, 'Men P4P', 'Women P4P'),
    (10, 'Wrestling', 'wrestling', '🤼', 'UWW Points', 10, 'Men Freestyle', 'Women Freestyle'),
    (11, 'Snooker', 'snooker', '🎱', 'WST Points', 11, 'World Ranking', 'One Year List'),
    (12, 'MMA', 'mma', '🥋', 'P4P Ranking', 12, 'Men P4P', 'Women P4P'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'Points', 13, 'National Team', 'Pro Kabaddi'),
    (14, 'Golf', 'golf', '⛳', 'OWGR Points', 14, 'Men Rankings', 'Women Rankings'),
    (15, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 15, 'Men Singles', 'Women Singles'),
    (16, 'Badminton', 'badminton', '🏸', 'BWF Points', 16, 'Men Singles', 'Women Singles'),
    (17, 'Cycling', 'cycling', '🚲', 'UCI Points', 17, 'World Tour', 'Women Tour'),
    (18, 'Formula 1', 'formula-1', '🏎️', 'F1 Points', 18, 'Drivers', 'Constructors'),
    (19, 'Horse Racing', 'horse-racing', '🏇', 'TRC Rating', 19, 'Jockeys', 'Horses'),
    (20, 'Handball', 'handball', '🤾', 'IHF Points', 20, 'National Men', 'National Women'),
    (21, 'Triathlon', 'triathlon', '🏊', 'WT Points', 21, 'Men Rankings', 'Women Rankings')
]

countries = [
    ("us", "USA"), ("cn", "China"), ("in", "India"), ("gb", "UK"), ("fr", "France"),
    ("de", "Germany"), ("jp", "Japan"), ("br", "Brazil"), ("au", "Australia"), ("es", "Spain")
]

# Team data from Turn 15 for 1-12
# Note: Sid 5 (Table Tennis) and Sid 10 (Golf) data will be moved to 15 and 14 respectively.
# For now, I'll just map the data correctly.

# Mapping old Sid to new Sid
# Soccer: 1 -> 1
# Basketball: 2 -> 2
# Cricket: 3 -> 3
# Tennis: 4 -> 4
# Table Tennis: 5 -> 15
# Field Hockey: 6 -> 5
# Volleyball: 7 -> 6
# Rugby: 8 -> 7
# Baseball: 9 -> 8
# Golf: 10 -> 14
# Boxing: 11 -> 9
# UFC: 12 -> 12 (Rename MMA)

# New 10, 11 will be Wrestling and Snooker (Dummy for now)

old_records = []

# --- SOCCER (1) ---
for i, name in enumerate(["Argentina", "France", "Spain", "England", "Brazil", "Belgium", "Portugal", "Netherlands", "Italy", "Colombia"]):
    old_records.append((1, i+1, name, 'national', ['ar','fr','es','gb','br','be','pt','nl','it','co'][i], 1500-i*15, 40, 37-i, 1, 2))
for i, name in enumerate(["Real Madrid", "Manchester City", "Liverpool", "Bayer Leverkusen", "Inter Milan", "Arsenal", "Bayern Munich", "Barcelona", "PSG", "Borussia Dortmund"]):
    old_records.append((1, i+1, name, 'club', ['es','gb','gb','de','it','gb','de','es','fr','de'][i], 2500-i*20, 41, 33-i, 1, 7))

# --- BASKETBALL (2) ---
for i, name in enumerate(["USA", "Serbia", "Germany", "France", "Canada", "Spain", "Australia", "Argentina", "Latvia", "Lithuania"]):
    old_records.append((2, i+1, name, 'national', ['us','rs','de','fr','ca','es','au','ar','lv','lt'][i], 1380-i*15, 39, 35-i, 1, 3))
for i, name in enumerate(["Boston Celtics", "Denver Nuggets", "Real Madrid", "Panathinaikos", "Dallas Mavericks", "Minnesota Timberwolves", "Olympiacos", "Fenerbahce", "Monaco", "Oklahoma City Thunder"]):
    old_records.append((2, i+1, name, 'club', ['us','us','es','gr','us','us','gr','tr','fr','us'][i], 100-i*2, 34, 28-i, 3, 3))

# --- CRICKET (3) ---
for i, name in enumerate(["India", "Australia", "South Africa", "Pakistan", "New Zealand", "Sri Lanka", "England", "Bangladesh", "Afghanistan", "West Indies"]):
    old_records.append((3, i+1, name, 'national', ['in','au','za','pk','nz','lk','gb','bd','af','wi'][i], 1420-i*15, 36, 32-i, 0, 4))
for i, name in enumerate(["KKR", "SRH", "RR", "RCB", "CSK", "Scorchers", "Sixers", "Surrey", "Somerset", "MI Cape Town"]):
    old_records.append((3, i+1, name, 'club', 'in' if i<5 else 'au', 95-i*1.5, 46, 36-i, 5, 5))

# --- TENNIS (4) ---
for i, name in enumerate(["Jannik Sinner", "Carlos Alcaraz", "Alexander Zverev", "Novak Djokovic", "Daniil Medvedev", "Taylor Fritz", "Andrey Rublev", "Casper Ruud", "Grigor Dimitrov", "Alex de Minaur"]):
    old_records.append((4, i+1, name, 'national', ['it','es','de','rs','ru','us','ru','no','bg','au'][i], 1050-i*15, 47, 37-i, 3, 7))
for i, name in enumerate(["Iga Swiatek", "Aryna Sabalenka", "Coco Gauff", "Elena Rybakina", "Jessica Pegula", "Marketa Vondrousova", "Zheng Qinwen", "Maria Sakkari", "Danielle Collins", "Jelena Ostapenko"]):
    old_records.append((4, i+1, name, 'club', ['pl','by','us','kz','us','cz','cn','gr','us','lv'][i], 1100-i*20, 50, 45-i, 5, 0))

# --- TABLE TENNIS (15) ---
for i, name in enumerate(["Wang Chuqin", "Fan Zhendong", "Liang Jingkun", "Ma Long", "Felix Lebrun", "Hugo Calderano", "Lin Gaoyuan", "Tomokazu Harimoto", "Lin Yun-Ju", "Dang Qiu"]):
    old_records.append((15, i+1, name, 'national', 'cn' if i<4 else 'fr', 920-i*20, 40, 35-i, 5, 0))
for i, name in enumerate(["Sun Yingsha", "Wang Manyu", "Wang Yidi", "Chen Meng", "Hina Hayata", "Chen Xingtong", "Shin Yubin", "Mima Ito", "Cheng I-Ching", "Bernadette Szocs"]):
    old_records.append((15, i+1, name, 'club', 'cn' if i<4 else 'jp', 880-i*20, 39, 34-i, 5, 0))

# --- GOLF (14) ---
for i, name in enumerate(["Scottie Scheffler", "Rory McIlroy", "Xander Schauffele", "Ludvig Aberg", "Wyndham Clark", "Viktor Hovland", "Collin Morikawa", "Patrick Cantlay", "Bryson DeChambeau", "Jon Rahm"]):
    old_records.append((14, i+1, name, 'national', 'us' if i==0 else 'gb', 750-i*20, 20, 15-i, 5, 0))
for i, name in enumerate(["Nelly Korda", "Lilia Vu", "Celine Boutier", "Ruoning Yin", "Minjee Lee", "Jin Young Ko", "Charley Hull", "Hyo-Joo Kim", "Atthaya Thitikul", "Brooke Henderson"]):
    old_records.append((14, i+1, name, 'club', 'us' if i<2 else 'fr', 720-i*20, 25, 20-i, 5, 0))

# --- FIELD HOCKEY (5) ---
for i, name in enumerate(["Netherlands", "Germany", "Belgium", "India", "Australia", "Argentina", "England", "Spain", "Ireland", "France"]):
    old_records.append((5, i+1, name, 'national', ['nl','de','be','in','au','ar','gb','es','ie','fr'][i], 1100-i*15, 32, 24-i, 5, 3))
for i, name in enumerate(["Kampong", "Rot-Weiss Koln", "Bloemendaal", "Gantoise", "Old Georgians", "Club de Campo", "Mannheimer HC", "Waterloo Ducks", "Pinoke", "Surbiton"]):
    old_records.append((5, i+1, name, 'club', 'nl' if i%2==0 else 'de', 100-i*2, 45, 40-i, 0, 5))

# --- VOLLEYBALL (6) ---
for i, name in enumerate(["Poland", "France", "Slovenia", "Japan", "Italy", "USA", "Brazil", "Argentina", "Canada", "Germany"]):
    old_records.append((6, i+1, name, 'national', ['pl','fr','si','jp','it','us','br','ar','ca','de'][i], 980-i*15, 46, 44-i, 0, 2))
for i, name in enumerate(["Trentino Itas", "Jastrzebski Wegiel", "Perugia", "Ziraat Bankasi", "Lube Civitanova", "Halkbank", "Zaksa Kedzierzyn-Kozle", "Sada Cruzeiro", "Guaguas", "Berlin RV"]):
    old_records.append((6, i+1, name, 'club', 'it' if i%2==0 else 'pl', 100-i*2, 48, 38-i, 7, 3))

# --- RUGBY (7) ---
for i, name in enumerate(["South Africa", "Ireland", "New Zealand", "France", "England", "Argentina", "Scotland", "Italy", "Fiji", "Australia"]):
    old_records.append((7, i+1, name, 'national', ['za','ie','nz','fr','gb','ar','gb','it','fj','au'][i], 800-i*15, 49, 37-i, 6, 6))
for i, name in enumerate(["Toulouse", "Leinster", "Northampton Saints", "Bulls", "La Rochelle", "Munster", "Saracens", "Glasgow Warriors", "Harlequins", "Stormers"]):
    old_records.append((7, i+1, name, 'club', 'fr' if i%2==0 else 'ie', 100-i*2, 39, 29-i, 2, 8))

# --- BASEBALL (8) ---
for i, name in enumerate(["Japan", "Mexico", "USA", "South Korea", "Chinese Taipei", "Venezuela", "Netherlands", "Cuba", "Dominican Republic", "Panama"]):
    old_records.append((8, i+1, name, 'national', ['jp','mx','us','kr','tw','ve','nl','cu','do','pa'][i], 850-i*15, 34, 28-i, 0, 6))
for i, name in enumerate(["Los Angeles Dodgers", "Philadelphia Phillies", "New York Yankees", "Baltimore Orioles", "Cleveland Guardians", "Milwaukee Brewers", "Atlanta Braves", "Houston Astros", "Yomiuri Giants", "Hanshin Tigers"]):
    old_records.append((8, i+1, name, 'club', 'us' if i<8 else 'jp', 100-i*2, 42, 33-i, 1, 8))

# --- BOXING (9) ---
for i, name in enumerate(["Oleksandr Usyk", "Terence Crawford", "Naoya Inoue", "Dmitry Bivol", "Canelo Alvarez", "Artur Beterbiev", "Gervonta Davis", "Jesse Rodriguez", "Shakur Stevenson", "Junto Nakatani"]):
    old_records.append((9, i+1, name, 'national', 'ua' if i==0 else 'us', 100-i*2, 30, 25-i, 5, 0))
for i, name in enumerate(["Claressa Shields", "Katie Taylor", "Amanda Serrano", "Seniesa Estrada", "Alycia Baumgardner", "Mikaela Mayer", "Chantelle Cameron", "Delfine Persoon", "Jessica McCaskill", "Terri Harper"]):
    old_records.append((9, i+1, name, 'club', 'us' if i==0 else 'ie', 100-i*2, 30, 25-i, 5, 0))

# --- MMA (12) ---
for i, name in enumerate(["Islam Makhachev", "Alex Pereira", "Jon Jones", "Ilia Topuria", "Belal Muhammad", "Leon Edwards", "Alexander Volkanovski", "Tom Aspinall", "Max Holloway", "Dricus du Plessis"]):
    old_records.append((12, i+1, name, 'national', 'ru' if i==0 else 'br', 100-i*2, 30, 25-i, 5, 0))
for i, name in enumerate(["Alexa Grasso", "Valentina Shevchenko", "Zhang Weili", "Manon Fiorot", "Julianna Peña", "Rose Namajunas", "Erin Blanchfield", "Yan Xiaonan", "Tatiana Suarez", "Jéssica Andrade"]):
    old_records.append((12, i+1, name, 'club', 'mx' if i==0 else 'kg', 100-i*2, 30, 25-i, 5, 0))

# --- WRESTLING (10) & SNOOKER (11) (Generating new entries) ---
for sid in [10, 11]:
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            code, name = countries[rank-1]
            old_records.append((sid, rank, f"{name} Pro" if ttype == 'club' else f"{name} Team", ttype, code, 1000-rank*10, 10, 8, 2, 0))

# --- 3. GENERATE NEW DATA FOR 13-21 (FULL TOP 10 WITH STATS) ---
new_records = []
for sid in range(13, 22):
    if sid in [14, 15]: continue # Already filled from old data above
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            code, cname = countries[rank-1]
            tname = f"{cname} Team" if ttype == 'national' else f"{cname} Pro"

            if sid == 18: # F1
                if ttype == 'national':
                    tname = ["Verstappen", "Norris", "Leclerc", "Piastri", "Sainz", "Hamilton", "Russell", "Perez", "Alonso", "Hulkenberg"][rank-1]
                else:
                    tname = ["McLaren", "Red Bull", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Sauber"][rank-1]

            mp = random.randint(15, 60); w = random.randint(0, mp); l = random.randint(0, mp - w); d = mp - w - l
            pts = w * 3 + d
            new_records.append((sid, rank, tname, ttype, code, pts, mp, w, l, d))

# --- 4. ASSEMBLE SQL ---
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
for s in sports:
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

for t in old_records:
    sql += f"({t[0]}, {t[1]}, '{t[2]}', '{t[3]}', '{t[4]}', {t[5]}, {t[6]}, {t[7]}, {t[8]}, {t[9]}),\n"
for t in new_records:
    sql += f"({t[0]}, {t[1]}, '{t[2]}', '{t[3]}', '{t[4]}', {t[5]}, {t[6]}, {t[7]}, {t[8]}, {t[9]}),\n"

sql = sql.rstrip(',\n') + ';\n\n'

sql += """-- Site Settings
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

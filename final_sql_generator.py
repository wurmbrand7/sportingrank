import random

# 1. Sports Definition (1-21)
# 1-12 are preserved/updated. 13-21 are new.
sports = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 1, 'National', 'Leagues'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 2, 'National', 'Leagues'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 3, 'National', 'Leagues'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP/WTA Points', 4, 'Men Singles', 'Women Singles'),
    (5, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 5, 'National', 'Leagues'),
    (6, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 6, 'National', 'Leagues'),
    (7, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 7, 'National', 'Leagues'),
    (8, 'Baseball', 'baseball', '⚾', 'WBSC Points', 8, 'National', 'Leagues'),
    (9, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 9, 'Men P4P', 'Women P4P'),
    (10, 'Table Tennis (Old)', 'table-tennis-old', '🏓', 'ITTF Points', 10, 'Men Singles', 'Women Singles'),
    (11, 'Golf (Old)', 'golf-old', '⛳', 'OWGR Points', 11, 'Men Rankings', 'Women Rankings'),
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

# 2. Team Data for 1-12 (Extracted from previous success state)
# We will populate these with the exact data provided before.
old_teams = [
    # Soccer (1)
    (1,1,'Argentina','national','ar',1500,40,37,1,2),(1,2,'France','national','fr',1485,42,33,7,2),(1,3,'Spain','national','es',1470,50,39,8,3),(1,4,'England','national','gb',1455,30,22,6,2),(1,5,'Brazil','national','br',1440,36,30,2,4),(1,6,'Belgium','national','be',1425,30,19,8,3),(1,7,'Portugal','national','pt',1410,31,19,10,2),(1,8,'Netherlands','national','nl',1395,49,28,17,4),(1,9,'Italy','national','it',1380,42,26,14,2),(1,10,'Colombia','national','co',1365,38,16,17,5),
    (1,1,'Real Madrid','club','es',2500,41,33,1,7),(1,2,'Manchester City','club','gb',2480,43,36,0,7),(1,3,'Liverpool','club','gb',2420,34,26,0,8),(1,4,'Bayer Leverkusen','club','de',2380,42,29,6,7),(1,5,'Inter Milan','club','it',2350,37,25,10,2),(1,6,'Arsenal','club','gb',2330,41,26,7,8),(1,7,'Bayern Munich','club','de',2310,35,20,11,4),(1,8,'Barcelona','club','es',2280,31,19,4,8),(1,9,'PSG','club','fr',2250,39,21,13,5),(1,10,'Borussia Dortmund','club','de',2220,48,19,26,3),
    # Basketball (2)
    (2,1,'USA','national','us',1380,39,35,1,3),(2,2,'Serbia','national','rs',1365,44,32,9,3),(2,3,'Germany','national','de',1350,40,32,2,6),(2,4,'France','national','fr',1335,47,30,10,7),(2,5,'Canada','national','ca',1320,43,32,3,8),(2,6,'Spain','national','es',1305,31,23,4,4),(2,7,'Australia','national','au',1290,35,21,7,7),(2,8,'Argentina','national','ar',1275,35,24,7,4),(2,9,'Latvia','national','lv',1260,34,22,5,7),(2,10,'Lithuania','national','lt',1245,48,24,20,4),
    (2,1,'Boston Celtics','club','us',100,34,28,3,3),(2,2,'Denver Nuggets','club','us',98,38,35,0,3),(2,3,'Real Madrid','club','es',95,42,37,0,5),(2,4,'Panathinaikos','club','gr',94,36,29,1,6),(2,5,'Dallas Mavericks','club','us',93,34,27,0,7),(2,6,'Minnesota Timberwolves','club','us',92,35,22,8,5),(2,7,'Olympiacos','club','gr',91,41,29,7,5),(2,8,'Fenerbahce','club','tr',90,33,19,9,5),(2,9,'Monaco','club','fr',89,39,24,9,6),(2,10,'Oklahoma City Thunder','club','us',88,30,14,9,7),
    # Cricket (3)
    (3,1,'India','national','in',1420,36,32,0,4),(3,2,'Australia','national','au',1405,44,37,0,7),(3,3,'South Africa','national','za',1390,34,25,4,5),(3,4,'Pakistan','national','pk',1375,47,41,0,6),(3,5,'New Zealand','national','nz',1360,30,22,0,8),(3,6,'Sri Lanka','national','lk',1345,32,22,8,2),(3,7,'England','national','gb',1330,45,26,13,6),(3,8,'Bangladesh','national','bd',1315,38,26,10,2),(3,9,'Afghanistan','national','af',1300,49,29,12,8),(3,10,'West Indies','national','wi',1285,50,27,16,7),
    (3,1,'KKR','club','in',95,46,36,5,5),(3,2,'SRH','club','in',92,42,31,9,2),(3,3,'RR','club','in',90,42,28,7,7),(3,4,'RCB','club','in',88,37,25,6,6),(3,5,'CSK','club','in',87,48,30,16,2),(3,6,'Scorchers','club','au',85,49,35,9,5),(3,7,'Sixers','club','au',84,50,34,9,7),(3,8,'Surrey','club','gb',82,32,20,10,2),(3,9,'Somerset','club','gb',81,44,19,18,7),(3,10,'MI Cape Town','club','za',80,32,18,6,8)
]

# Helper for remaining 4-12 dummy (but existing)
countries = [("us","USA"),("cn","China"),("in","India"),("gb","UK"),("fr","France"),("de","Germany"),("jp","Japan"),("br","Brazil"),("au","Australia"),("es","Spain")]
for sid in range(4, 13):
    for rank in range(1, 11):
        code, name = countries[rank-1]
        old_teams.append((sid, rank, f"{name} Team", 'national', code, 1000-rank*10, 20, 15, 5, 0))
        old_teams.append((sid, rank, f"{name} Pro", 'club', code, 900-rank*10, 18, 14, 4, 0))

# 3. New Team Data for 13-21 (Full Stats)
new_teams = []
for sid in range(13, 22):
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            code, name = countries[rank-1]
            tname = f"{name} Team" if ttype == 'national' else f"{name} Pro"

            # Special F1/Racing names
            if sid == 18:
                drivers = ["Verstappen", "Norris", "Leclerc", "Piastri", "Sainz", "Hamilton", "Russell", "Perez", "Alonso", "Hulkenberg"]
                constructors = ["McLaren", "Red Bull", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Kick Sauber"]
                tname = drivers[rank-1] if ttype == 'national' else constructors[rank-1]

            mp = random.randint(15, 60); w = random.randint(0, mp); l = random.randint(0, mp - w); d = mp - w - l
            new_teams.append((sid, rank, tname, ttype, code, w*3+d, mp, w, l, d))

# 4. Final SQL Assembly
sql = """-- SportingRank MySQL Database Export
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
for s in sports:
    sql += f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[4]}', {s[5]}, '{s[6]}', '{s[7]}', '{s[8]}'),\n"
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
for t in old_teams:
    sql += f"({t[0]}, {t[1]}, '{t[2]}', '{t[3]}', '{t[4]}', {t[5]}, {t[6]}, {t[7]}, {t[8]}, {t[9]}),\n"
for t in new_teams:
    sql += f"({t[0]}, {t[1]}, '{t[2]}', '{t[3]}', '{t[4]}', {t[5]}, {t[6]}, {t[7]}, {t[8]}, {t[9]}),\n"
sql = sql.rstrip(',\n') + ';\n\n'

sql += """-- Settings
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
('google_analytics', 'G-XXXXXXXXXX', 'analytics');

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

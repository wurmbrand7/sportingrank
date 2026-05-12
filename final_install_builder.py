import random

# --- SPORTS DATA ---
sports = [
    (1, 'Soccer', 'soccer', '⚽', 'Points', 1, 'National', 'Leagues', 'https://images.unsplash.com/photo-1543351611-58f69d7c1781?q=80&w=2000'),
    (2, 'Basketball', 'basketball', '🏀', 'FIBA Points', 2, 'National', 'Leagues', 'https://images.unsplash.com/photo-1546519638-68e109498ffc?q=80&w=2000'),
    (3, 'Cricket', 'cricket', '🏏', 'ICC Rating', 3, 'National', 'Leagues', 'https://images.unsplash.com/photo-1531415074968-036ba1b575da?q=80&w=2000'),
    (4, 'Tennis', 'tennis', '🎾', 'ATP Points', 4, 'Men Singles', 'Women Singles', 'https://images.unsplash.com/photo-1595435064219-c48cc548122d?q=80&w=2000'),
    (5, 'Table Tennis', 'table-tennis', '🏓', 'ITTF Points', 5, 'Men Singles', 'Women Singles', 'https://images.unsplash.com/photo-1587280501635-a19de238a81e?q=80&w=2000'),
    (6, 'Field Hockey', 'field-hockey', '🏑', 'FIH Points', 6, 'National', 'Leagues', 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?q=80&w=2000'),
    (7, 'Volleyball', 'volleyball', '🏐', 'FIVB Points', 7, 'National', 'Leagues', 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1?q=80&w=2000'),
    (8, 'Rugby', 'rugby', '🏉', 'World Rugby Points', 8, 'National', 'Leagues', 'https://images.unsplash.com/photo-1508344928928-7165167de128?q=80&w=2000'),
    (9, 'Baseball', 'baseball', '⚾', 'WBSC Points', 9, 'National', 'Leagues', 'https://images.unsplash.com/photo-1535131749006-b7f58c99034b?q=80&w=2000'),
    (10, 'Golf', 'golf', '⛳', 'OWGR Points', 10, 'Men Rankings', 'Women Rankings', 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?q=80&w=2000'),
    (11, 'Boxing', 'boxing', '🥊', 'P4P Ranking', 11, 'Men P4P', 'Women P4P', 'https://images.unsplash.com/photo-1593787424264-e93f8136b176?q=80&w=2000'),
    (12, 'MMA', 'mma', '🥋', 'P4P Ranking', 12, 'Men P4P', 'Women P4P', 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?q=80&w=2000'),
    (13, 'Kabaddi', 'kabaddi', '🤼‍♂️', 'Points', 13, 'National', 'Pro Kabaddi', 'https://images.unsplash.com/photo-1562183241-b937e95585b6?q=80&w=2000'),
    (14, 'Golf Pro', 'golf-pro', '⛳', 'Rankings', 14, 'Men Rankings', 'Women Rankings', 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?q=80&w=2000'),
    (15, 'Table Tennis World', 'table-tennis-world', '🏓', 'Points', 15, 'Men Singles', 'Women Singles', 'https://images.unsplash.com/photo-1587280501635-a19de238a81e?q=80&w=2000'),
    (16, 'Badminton', 'badminton', '🏸', 'BWF Points', 16, 'Men Singles', 'Women Singles', 'https://images.unsplash.com/photo-1521537634581-0dced2fee2ef?q=80&w=2000'),
    (17, 'Cycling', 'cycling', '🚲', 'UCI Points', 17, 'World Tour', 'Women Tour', 'https://images.unsplash.com/photo-1541625602330-2277a4c4b282?q=80&w=2000'),
    (18, 'Formula 1', 'formula-1', '🏎️', 'F1 Points', 18, 'Drivers', 'Constructors', 'https://images.unsplash.com/photo-1509059852496-f3822ae057bf?q=80&w=2000'),
    (19, 'Horse Racing', 'horse-racing', '🏇', 'TRC Rating', 19, 'Jockeys', 'Horses', 'https://images.unsplash.com/photo-1534493872551-856cb2e5a527?q=80&w=2000'),
    (20, 'Handball', 'handball', '🤾', 'IHF Points', 20, 'National Men', 'National Women', 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=2000'),
    (21, 'Triathlon', 'triathlon', '🏊', 'WT Points', 21, 'Men Rankings', 'Women Rankings', 'https://images.unsplash.com/photo-1530549387074-d562cb0e5d6d?q=80&w=2000')
]

# --- ORIGINAL TEAMS DATA (1-12) ---
# Extracted and structured from Turn 15 dump
# sid, pos, name, type, code, points, mp, w, l, d
old_teams_raw = [
    # Soccer (1)
    (1,1,'Argentina','national','ar',1500,40,37,1,2),(1,2,'France','national','fr',1485,42,33,7,2),(1,3,'Spain','national','es',1470,50,39,8,3),(1,4,'England','national','gb',1455,30,22,6,2),(1,5,'Brazil','national','br',1440,36,30,2,4),(1,6,'Belgium','national','be',1425,30,19,8,3),(1,7,'Portugal','national','pt',1410,31,19,10,2),(1,8,'Netherlands','national','nl',1395,49,28,17,4),(1,9,'Italy','national','it',1380,42,26,14,2),(1,10,'Colombia','national','co',1365,38,16,17,5),
    (1,1,'Real Madrid','club','es',2500,41,33,1,7),(1,2,'Manchester City','club','gb',2480,43,36,0,7),(1,3,'Liverpool','club','gb',2420,34,26,0,8),(1,4,'Bayer Leverkusen','club','de',2380,42,29,6,7),(1,5,'Inter Milan','club','it',2350,37,25,10,2),(1,6,'Arsenal','club','gb',2330,41,26,7,8),(1,7,'Bayern Munich','club','de',2310,35,20,11,4),(1,8,'Barcelona','club','es',2280,31,19,4,8),(1,9,'PSG','club','fr',2250,39,21,13,5),(1,10,'Borussia Dortmund','club','de',2220,48,19,26,3),
    # Basketball (2)
    (2,1,'USA','national','us',1380,39,35,1,3),(2,2,'Serbia','national','rs',1365,44,32,9,3),(2,3,'Germany','national','de',1350,40,32,2,6),(2,4,'France','national','fr',1335,47,30,10,7),(2,5,'Canada','national','ca',1320,43,32,3,8),(2,6,'Spain','national','es',1305,31,23,4,4),(2,7,'Australia','national','au',1290,35,21,7,7),(2,8,'Argentina','national','ar',1275,35,24,7,4),(2,9,'Latvia','national','lv',1260,34,22,5,7),(2,10,'Lithuania','national','lt',1245,48,24,20,4),
    (2,1,'Boston Celtics','club','us',100,34,28,3,3),(2,2,'Denver Nuggets','club','us',98,38,35,0,3),(2,3,'Real Madrid','club','es',95,42,37,0,5),(2,4,'Panathinaikos','club','gr',94,36,29,1,6),(2,5,'Dallas Mavericks','club','us',93,34,27,0,7),(2,6,'Minnesota Timberwolves','club','us',92,35,22,8,5),(2,7,'Olympiacos','club','gr',91,41,29,7,5),(2,8,'Fenerbahce','club','tr',90,33,19,9,5),(2,9,'Monaco','club','fr',89,39,24,9,6),(2,10,'Oklahoma City Thunder','club','us',88,30,14,9,7),
    # Cricket (3)
    (3,1,'India','national','in',1420,36,32,0,4),(3,2,'Australia','national','au',1405,44,37,0,7),(3,3,'South Africa','national','za',1390,34,25,4,5),(3,4,'Pakistan','national','pk',1375,47,41,0,6),(3,5,'New Zealand','national','nz',1360,30,22,0,8),(3,6,'Sri Lanka','national','lk',1345,32,22,8,2),(3,7,'England','national','gb',1330,45,26,13,6),(3,8,'Bangladesh','national','bd',1315,38,26,10,2),(3,9,'Afghanistan','national','af',1300,49,29,12,8),(3,10,'West Indies','national','wi',1285,50,27,16,7),
    (3,1,'Kolkata Knight Riders','club','in',95,46,36,5,5),(3,2,'Sunrisers Hyderabad','club','in',92,42,31,9,2),(3,3,'Rajasthan Royals','club','in',90,42,28,7,7),(3,4,'Royal Challengers Bengaluru','club','in',88,37,25,6,6),(3,5,'Chennai Super Kings','club','in',87,48,30,16,2),(3,6,'Perth Scorchers','club','au',85,49,35,9,5),(3,7,'Sydney Sixers','club','au',84,50,34,9,7),(3,8,'Surrey','club','gb',82,32,20,10,2),(3,9,'Somerset','club','gb',81,44,19,18,7),(3,10,'MI Cape Town','club','za',80,32,18,6,8),
    # Tennis (4)
    (4,1,'Jannik Sinner','national','it',1050,47,37,3,7),(4,2,'Carlos Alcaraz','national','es',1035,31,26,0,5),(4,3,'Alexander Zverev','national','de',1020,43,37,0,6),(4,4,'Novak Djokovic','national','rs',1005,42,34,0,8),(4,5,'Daniil Medvedev','national','ru',990,41,26,9,6),(4,6,'Taylor Fritz','national','us',975,34,26,6,2),(4,7,'Andrey Rublev','national','ru',960,49,25,22,2),(4,8,'Casper Ruud','national','no',945,47,33,9,5),(4,9,'Grigor Dimitrov','national','bg',930,40,25,12,3),(4,10,'Alex de Minaur','national','au',915,38,15,20,3),
    (4,1,'Sinner Academy','club','it',11830,50,45,2,3),(4,2,'Alcaraz Team','club','es',7120,46,42,0,4),(4,3,'Zverev Base','club','de',6805,30,27,0,3),(4,4,'Djokovic Center','club','rs',6210,41,35,0,6),(4,5,'Medvedev Camp','club','ru',5230,47,35,4,8),(4,6,'Fritz Pro','club','us',4415,46,25,15,6),(4,7,'Rublev Elite','club','ru',4070,37,24,5,8),(4,8,'Ruud Club','club','no',3855,46,24,14,8),(4,9,'Dimitrov Squad','club','bg',3740,38,20,15,3),(4,10,'De Minaur High','club','au',3545,44,18,20,6),
    # Table Tennis (5)
    (5,1,'China','national','cn',920,40,35,5,0),(5,2,'France','national','fr',880,39,34,5,0),(5,3,'Japan','national','jp',850,38,33,5,0),(5,4,'South Korea','national','kr',820,37,32,5,0),(5,5,'Germany','national','de',800,36,31,5,0),(5,6,'Chinese Taipei','national','tw',780,35,30,5,0),(5,7,'Sweden','national','se',750,34,29,5,0),(5,8,'Brazil','national','br',720,33,28,5,0),(5,9,'Portugal','national','pt',700,32,27,5,0),(5,10,'Nigeria','national','ng',680,31,26,5,0),
    (5,1,'Kansas City Chiefs','club','us',100,30,26,0,4),(5,2,'Baltimore Ravens','club','us',98,42,37,2,3),(5,3,'Detroit Lions','club','us',95,37,28,3,6),(5,4,'San Francisco 49ers','club','us',94,33,25,4,4),(5,5,'Buffalo Bills','club','us',93,39,24,11,4),(5,6,'Houston Texans','club','us',92,38,25,6,7),(5,7,'Philadelphia Eagles','club','us',91,41,22,15,4),(5,8,'Green Bay Packers','club','us',90,49,28,19,2),(5,9,'Dallas Cowboys','club','us',88,42,25,10,7),(5,10,'Cincinnati Bengals','club','us',87,47,23,22,2),
    # Field Hockey (6)
    (6,1,'Netherlands','national','nl',1100,32,24,5,3),(6,2,'Germany','national','de',1085,41,30,5,6),(6,3,'Belgium','national','be',1070,30,26,0,4),(6,4,'India','national','in',1055,37,27,6,4),(6,5,'Australia','national','au',1040,46,34,9,3),(6,6,'Argentina','national','ar',1025,39,28,7,4),(6,7,'England','national','gb',1010,46,31,8,7),(6,8,'Spain','national','es',995,46,31,13,2),(6,9,'Ireland','national','ie',980,45,25,13,7),(6,10,'France','national','fr',965,42,19,16,7),
    (6,1,'Kampong','club','nl',100,45,40,0,5),(6,2,'Rot-Weiss Koln','club','de',98,41,32,3,6),(6,3,'Bloemendaal','club','nl',96,30,22,5,3),(6,4,'Gantoise','club','be',94,45,34,3,8),(6,5,'Old Georgians','club','gb',92,49,42,2,5),(6,6,'Club de Campo','club','es',90,49,37,10,2),(6,7,'Mannheimer HC','club','de',88,46,35,6,5),(6,8,'Waterloo Ducks','club','be',86,50,33,12,5),(6,9,'Pinoke','club','nl',84,42,23,11,8),(6,10,'Surbiton','club','gb',82,38,15,18,5),
    # Volleyball (7)
    (7,1,'Poland','national','pl',980,46,44,0,2),(7,2,'France','national','fr',965,35,27,0,8),(7,3,'Slovenia','national','si',950,38,27,6,5),(7,4,'Japan','national','jp',935,46,35,8,3),(7,5,'Italy','national','it',920,48,42,1,5),(7,6,'USA','national','us',905,49,34,7,8),(7,7,'Brazil','national','br',890,49,35,8,6),(7,8,'Argentina','national','ar',875,40,20,15,5),(7,9,'Canada','national','ca',860,44,24,13,7),(7,10,'Germany','national','de',845,35,14,15,6),
    (7,1,'Trentino Itas','club','it',100,48,38,7,3),(7,2,'Jastrzebski Wegiel','club','pl',98,40,32,0,8),(7,3,'Perugia','club','it',96,46,40,0,6),(7,4,'Ziraat Bankasi','club','tr',94,36,23,9,4),(7,5,'Lube Civitanova','club','it',92,32,23,6,3),(7,6,'Halkbank','club','tr',90,31,20,6,5),(7,7,'Zaksa Kedzierzyn-Kozle','club','pl',88,35,26,5,4),(7,8,'Sada Cruzeiro','club','br',86,37,24,8,5),(7,9,'Guaguas','club','es',84,46,25,15,6),(7,10,'Berlin RV','club','de',82,32,18,6,8),
    # Rugby (8)
    (8,1,'South Africa','national','za',800,49,37,6,6),(8,2,'Ireland','national','ie',785,36,30,3,3),(8,3,'New Zealand','national','nz',770,39,33,1,5),(8,4,'France','national','fr',755,37,31,3,3),(8,5,'England','national','gb',740,37,29,1,7),(8,6,'Argentina','national','ar',725,48,33,8,7),(8,7,'Scotland','national','gb',710,35,20,8,7),(8,8,'Italy','national','it',695,42,20,20,2),(8,9,'Fiji','national','fj',680,39,18,16,5),(8,10,'Australia','national','au',665,50,21,24,5),
    (8,1,'Toulouse','club','fr',100,39,29,2,8),(8,2,'Leinster','club','ie',98,45,40,0,5),(8,3,'Northampton Saints','club','gb',95,38,27,5,6),(8,4,'Bulls','club','za',93,42,35,0,7),(8,5,'La Rochelle','club','fr',92,44,36,5,3),(8,6,'Munster','club','ie',90,39,27,10,2),(8,7,'Saracens','club','gb',88,47,33,7,7),(8,8,'Glasgow Warriors','club','gb',87,42,20,19,3),(8,9,'Harlequins','club','gb',85,49,30,14,5),(8,10,'Stormers','club','za',84,40,22,11,7),
    # Baseball (9)
    (9,1,'Japan','national','jp',850,34,28,0,6),(9,2,'Mexico','national','mx',835,33,26,0,7),(9,3,'USA','national','us',820,44,34,7,3),(9,4,'South Korea','national','kr',805,43,27,12,4),(9,5,'Chinese Taipei','national','tw',790,37,31,0,6),(9,6,'Venezuela','national','ve',775,48,39,2,7),(9,7,'Netherlands','national','nl',760,49,35,8,6),(9,8,'Cuba','national','cu',745,37,26,8,3),(9,9,'Dominican Republic','national','do',730,44,27,14,3),(9,10,'Panama','national','pa',715,30,15,13,2),
    (9,1,'Los Angeles Dodgers','club','us',100,42,33,1,8),(9,2,'Philadelphia Phillies','club','us',97,37,26,3,8),(9,3,'New York Yankees','club','us',95,50,34,14,2),(9,4,'Baltimore Orioles','club','us',93,37,30,0,7),(9,5,'Cleveland Guardians','club','us',91,38,31,0,7),(9,6,'Milwaukee Brewers','club','us',89,38,21,9,8),(9,7,'Atlanta Braves','club','us',87,38,27,9,2),(9,8,'Houston Astros','club','us',85,32,21,4,7),(9,9,'Yomiuri Giants','club','jp',83,41,22,14,5),(9,10,'Hanshin Tigers','club','jp',81,47,21,20,6),
    # Golf (10)
    (10,1,'USA','national','us',750,25,15,10,0),(10,2,'Northern Ireland','national','gb',720,24,14,10,0),(10,3,'Spain','national','es',700,23,13,10,0),(10,4,'Norway','national','no',680,22,12,10,0),(10,5,'Sweden','national','se',660,21,11,10,0),(10,6,'Australia','national','au',640,20,10,10,0),(10,7,'England','national','gb',620,19,9,10,0),(10,8,'South Korea','national','kr',600,18,8,10,0),(10,9,'Japan','national','jp',580,17,7,10,0),(10,10,'Canada','national','ca',560,16,6,10,0),
    (10,1,'Florida Panthers','club','us',100,49,42,0,7),(10,2,'Edmonton Oilers','club','ca',98,40,31,5,4),(10,3,'New York Rangers','club','us',96,36,29,0,7),(10,4,'Dallas Stars','club','us',94,39,28,9,2),(10,5,'Carolina Hurricanes','club','us',92,45,27,11,7),(10,6,'Vancouver Canucks','club','ca',90,43,32,7,4),(10,7,'Colorado Avalanche','club','us',88,30,21,7,2),(10,8,'Boston Bruins','club','us',86,49,30,16,3),(10,9,'ZSC Lions','club','ch',84,43,27,8,8),(10,10,'Skelleftea AIK','club','se',82,46,25,13,8),
    # Boxing (11)
    (11,1,'Oleksandr Usyk','national','ua',100,30,25,0,0),(11,2,'Terence Crawford','national','us',98,29,24,0,0),(11,3,'Naoya Inoue','national','jp',95,28,23,0,0),(11,4,'Dmitry Bivol','national','ru',92,27,22,0,0),(11,5,'Canelo Alvarez','national','mx',90,26,21,0,0),(11,6,'Artur Beterbiev','national','ru',88,25,20,0,0),(11,7,'Gervonta Davis','national','us',85,24,19,0,0),(11,8,'Jesse Rodriguez','national','us',82,23,18,0,0),(11,9,'Shakur Stevenson','national','us',80,22,17,0,0),(11,10,'Junto Nakatani','national','jp',78,21,16,0,0),
    (11,1,'Claressa Shields','club','us',100,30,25,0,0),(11,2,'Katie Taylor','club','ie',98,29,24,0,0),(11,3,'Amanda Serrano','club','pr',95,28,23,0,0),(11,4,'Seniesa Estrada','club','us',92,27,22,0,0),(11,5,'Alycia Baumgardner','club','us',90,26,21,0,0),(11,6,'Mikaela Mayer','club','us',88,25,20,0,0),(11,7,'Chantelle Cameron','club','gb',85,24,19,0,0),(11,8,'Delfine Persoon','club','be',82,23,18,0,0),(11,9,'Jessica McCaskill','club','us',80,22,17,0,0),(11,10,'Terri Harper','club','gb',78,21,16,0,0),
    # MMA (12)
    (12,1,'Islam Makhachev','national','ru',100,30,25,0,0),(12,2,'Alex Pereira','national','br',98,29,24,0,0),(12,3,'Jon Jones','national','us',95,28,23,0,0),(12,4,'Ilia Topuria','national','es',92,27,22,0,0),(12,5,'Belal Muhammad','national','ps',90,26,21,0,0),(12,6,'Leon Edwards','national','gb',88,25,20,0,0),(12,7,'Alexander Volkanovski','national','au',85,24,19,0,0),(12,8,'Tom Aspinall','national','gb',82,23,18,0,0),(12,9,'Max Holloway','national','us',80,22,17,0,0),(12,10,'Dricus du Plessis','national','za',78,21,16,0,0),
    (12,1,'Alexa Grasso','club','mx',100,30,25,0,0),(12,2,'Valentina Shevchenko','club','kg',98,29,24,0,0),(12,3,'Zhang Weili','club','cn',95,28,23,0,0),(12,4,'Manon Fiorot','club','fr',92,27,22,0,0),(12,5,'Julianna Peña','club','us',90,26,21,0,0),(12,6,'Rose Namajunas','club','us',88,25,20,0,0),(12,7,'Erin Blanchfield','club','us',85,24,19,0,0),(12,8,'Yan Xiaonan','club','cn',82,23,18,0,0),(12,9,'Tatiana Suarez','club','us',80,22,17,0,0),(12,10,'Jéssica Andrade','club','br',78,21,16,0,0)
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
for s in sports:
    sql_sports_lines.append(f"({s[0]}, '{s[1]}', '{s[2]}', '{s[3]}', '{s[4]}', {s[5]}, '{s[6]}', '{s[7]}', '{s[8]}')")

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

sql_teams_lines = []
for ot in old_teams:
    sql_teams_lines.append(f"({ot[0]}, {ot[1]}, '{ot[2]}', '{ot[3]}', '{ot[4]}', {ot[5]}, {ot[6]}, {ot[7]}, {ot[8]}, {ot[9]})")

# NEW DATA 13-21
for sid in range(13, 22):
    for ttype in ['national', 'club']:
        for rank in range(1, 11):
            name = f"{country_names[rank-1]} Team" if ttype == 'national' else f"{country_names[rank-1]} Pro"
            if sid == 18: # F1
                drivers = ["Max Verstappen", "Lando Norris", "Charles Leclerc", "Oscar Piastri", "Carlos Sainz", "Lewis Hamilton", "George Russell", "Sergio Perez", "Fernando Alonso", "Nico Hulkenberg"]
                constructors = ["McLaren", "Red Bull Racing", "Ferrari", "Mercedes", "Aston Martin", "RB", "Haas", "Williams", "Alpine", "Kick Sauber"]
                name = drivers[rank-1] if ttype == 'national' else constructors[rank-1]

            mp = random.randint(15, 60); w = random.randint(0, mp); l = random.randint(0, mp - w); d = mp - w - l
            sql_teams_lines.append(f"({sid}, {rank}, '{name}', '{ttype}', '{country_codes[rank-1]}', {w*3+d}, {mp}, {w}, {l}, {d})")

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

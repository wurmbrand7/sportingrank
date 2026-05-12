PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE sports (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  icon VARCHAR(10) DEFAULT '🏆',
  governing_body VARCHAR(150),
  ranking_type VARCHAR(100),
  description TEXT,
  hero_image VARCHAR(255),
  sort_order INTEGER DEFAULT 0,
  is_active INTEGER DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO sports VALUES(1,'Soccer','soccer','⚽','','Points',NULL,NULL,1,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(2,'Basketball','basketball','🏀','','FIBA Points',NULL,NULL,3,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(3,'Cricket','cricket','🏏','','ICC Rating',NULL,NULL,2,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(4,'Tennis','tennis','🎾','','ATP/WTA Points',NULL,NULL,5,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(5,'Table Tennis','table-tennis','🏓','','ITTF Points',NULL,NULL,7,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(6,'Field Hockey','field-hockey','🏑','','FIH Points',NULL,NULL,4,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(7,'Volleyball','volleyball','🏐','','FIVB Points',NULL,NULL,6,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(8,'Rugby','rugby','🏉','','World Rugby Points',NULL,NULL,9,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(9,'Baseball','baseball','⚾','','WBSC Points',NULL,NULL,8,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(10,'Golf','golf','⛳','','OWGR Points',NULL,NULL,10,1,'2026-05-11 14:09:37','2026-05-11 14:09:37');
INSERT INTO sports VALUES(11,'Boxing','boxing','🥊',NULL,'P4P Ranking',NULL,NULL,11,1,'2026-05-12 06:20:43','2026-05-12 06:20:43');
INSERT INTO sports VALUES(12,'UFC','ufc','🥋',NULL,'P4P Ranking',NULL,NULL,12,1,'2026-05-12 06:20:43','2026-05-12 06:20:43');
CREATE TABLE teams (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  sport_id INTEGER NOT NULL,
  rank_position INTEGER NOT NULL,
  team_name VARCHAR(150) NOT NULL,
  team_type TEXT DEFAULT 'national',
  country_code CHAR(2),
  country_name VARCHAR(100),
  points DECIMAL(10,2) DEFAULT 0,
  points_label VARCHAR(50) DEFAULT 'pts',
  previous_rank INTEGER,
  trend TEXT DEFAULT 'same',
  logo_url VARCHAR(255),
  matches_played INTEGER DEFAULT 0,
  wins INTEGER DEFAULT 0,
  losses INTEGER DEFAULT 0,
  draws INTEGER DEFAULT 0,
  votes INTEGER DEFAULT 0,
  notable_achievement VARCHAR(255),
  is_active INTEGER DEFAULT 1,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (sport_id, rank_position, team_type)
);
INSERT INTO teams VALUES(1,1,1,'Argentina','national','ar',NULL,1500,'pts',NULL,'down',NULL,40,37,1,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(2,1,2,'France','national','fr',NULL,1485,'pts',NULL,'down',NULL,42,33,7,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(3,1,3,'Spain','national','es',NULL,1470,'pts',NULL,'up',NULL,50,39,8,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(4,1,4,'England','national','gb',NULL,1455,'pts',NULL,'up',NULL,30,22,6,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(5,1,5,'Brazil','national','br',NULL,1440,'pts',NULL,'same',NULL,36,30,2,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(6,1,6,'Belgium','national','be',NULL,1425,'pts',NULL,'up',NULL,30,19,8,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(7,1,7,'Portugal','national','pt',NULL,1410,'pts',NULL,'down',NULL,31,19,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(8,1,8,'Netherlands','national','nl',NULL,1395,'pts',NULL,'same',NULL,49,28,17,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(9,1,9,'Italy','national','it',NULL,1380,'pts',NULL,'down',NULL,42,26,14,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(10,1,10,'Colombia','national','co',NULL,1365,'pts',NULL,'up',NULL,38,16,17,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(11,1,1,'Real Madrid','club','es',NULL,2500,'pts',NULL,'down',NULL,41,33,1,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(12,1,2,'Manchester City','club','gb',NULL,2480,'pts',NULL,'up',NULL,43,36,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(13,1,3,'Liverpool','club','gb',NULL,2420,'pts',NULL,'down',NULL,34,26,0,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(14,1,4,'Bayer Leverkusen','club','de',NULL,2380,'pts',NULL,'same',NULL,42,29,6,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(15,1,5,'Inter Milan','club','it',NULL,2350,'pts',NULL,'down',NULL,37,25,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(16,1,6,'Arsenal','club','gb',NULL,2330,'pts',NULL,'same',NULL,41,26,7,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(17,1,7,'Bayern Munich','club','de',NULL,2310,'pts',NULL,'down',NULL,35,20,11,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(18,1,8,'Barcelona','club','es',NULL,2280,'pts',NULL,'up',NULL,31,19,4,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(19,1,9,'Paris Saint-Germain','club','fr',NULL,2250,'pts',NULL,'down',NULL,39,21,13,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(20,1,10,'Borussia Dortmund','club','de',NULL,2220,'pts',NULL,'up',NULL,48,19,26,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(21,2,1,'USA','national','us',NULL,1380,'pts',NULL,'same',NULL,39,35,1,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(22,2,2,'Serbia','national','rs',NULL,1365,'pts',NULL,'down',NULL,44,32,9,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(23,2,3,'Germany','national','de',NULL,1350,'pts',NULL,'down',NULL,40,32,2,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(24,2,4,'France','national','fr',NULL,1335,'pts',NULL,'down',NULL,47,30,10,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(25,2,5,'Canada','national','ca',NULL,1320,'pts',NULL,'same',NULL,43,32,3,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(26,2,6,'Spain','national','es',NULL,1305,'pts',NULL,'down',NULL,31,23,4,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(27,2,7,'Australia','national','au',NULL,1290,'pts',NULL,'down',NULL,35,21,7,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(28,2,8,'Argentina','national','ar',NULL,1275,'pts',NULL,'down',NULL,35,24,7,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(29,2,9,'Latvia','national','lv',NULL,1260,'pts',NULL,'up',NULL,34,22,5,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(30,2,10,'Lithuania','national','lt',NULL,1245,'pts',NULL,'up',NULL,48,24,20,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(31,2,1,'Boston Celtics','club','us',NULL,100,'pts',NULL,'down',NULL,34,28,3,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(32,2,2,'Denver Nuggets','club','us',NULL,98,'pts',NULL,'same',NULL,38,35,0,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(33,2,3,'Real Madrid','club','es',NULL,95,'pts',NULL,'up',NULL,42,37,0,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(34,2,4,'Panathinaikos','club','gr',NULL,94,'pts',NULL,'same',NULL,36,29,1,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(35,2,5,'Dallas Mavericks','club','us',NULL,93,'pts',NULL,'down',NULL,34,27,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(36,2,6,'Minnesota Timberwolves','club','us',NULL,92,'pts',NULL,'down',NULL,35,22,8,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(37,2,7,'Olympiacos','club','gr',NULL,91,'pts',NULL,'same',NULL,41,29,7,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(38,2,8,'Fenerbahce','club','tr',NULL,90,'pts',NULL,'same',NULL,33,19,9,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(39,2,9,'Monaco','club','fr',NULL,89,'pts',NULL,'up',NULL,39,24,9,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(40,2,10,'Oklahoma City Thunder','club','us',NULL,88,'pts',NULL,'up',NULL,30,14,9,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(41,3,1,'India','national','in',NULL,1420,'pts',NULL,'down',NULL,36,32,0,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(42,3,2,'Australia','national','au',NULL,1405,'pts',NULL,'down',NULL,44,37,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(43,3,3,'South Africa','national','za',NULL,1390,'pts',NULL,'down',NULL,34,25,4,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(44,3,4,'Pakistan','national','pk',NULL,1375,'pts',NULL,'up',NULL,47,41,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(45,3,5,'New Zealand','national','nz',NULL,1360,'pts',NULL,'up',NULL,30,22,0,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(46,3,6,'Sri Lanka','national','lk',NULL,1345,'pts',NULL,'up',NULL,32,22,8,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(47,3,7,'England','national','gb',NULL,1330,'pts',NULL,'same',NULL,45,26,13,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(48,3,8,'Bangladesh','national','bd',NULL,1315,'pts',NULL,'same',NULL,38,26,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(49,3,9,'Afghanistan','national','af',NULL,1300,'pts',NULL,'same',NULL,49,29,12,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(50,3,10,'West Indies','national','wi',NULL,1285,'pts',NULL,'same',NULL,50,27,16,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(51,3,1,'Kolkata Knight Riders','club','in',NULL,95,'pts',NULL,'down',NULL,46,36,5,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(52,3,2,'Sunrisers Hyderabad','club','in',NULL,92,'pts',NULL,'up',NULL,42,31,9,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(53,3,3,'Rajasthan Royals','club','in',NULL,90,'pts',NULL,'same',NULL,42,28,7,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(54,3,4,'Royal Challengers Bengaluru','club','in',NULL,88,'pts',NULL,'same',NULL,37,25,6,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(55,3,5,'Chennai Super Kings','club','in',NULL,87,'pts',NULL,'same',NULL,48,30,16,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(56,3,6,'Perth Scorchers','club','au',NULL,85,'pts',NULL,'same',NULL,49,35,9,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(57,3,7,'Sydney Sixers','club','au',NULL,84,'pts',NULL,'down',NULL,50,34,9,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(58,3,8,'Surrey','club','gb',NULL,82,'pts',NULL,'up',NULL,32,20,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(59,3,9,'Somerset','club','gb',NULL,81,'pts',NULL,'up',NULL,44,19,18,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(60,3,10,'MI Cape Town','club','za',NULL,80,'pts',NULL,'same',NULL,32,18,6,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(61,4,1,'Jannik Sinner','national','it',NULL,1050,'pts',NULL,'down',NULL,47,37,3,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(62,4,2,'Carlos Alcaraz','national','es',NULL,1035,'pts',NULL,'same',NULL,31,26,0,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(63,4,3,'Alexander Zverev','national','de',NULL,1020,'pts',NULL,'same',NULL,43,37,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(64,4,4,'Novak Djokovic','national','rs',NULL,1005,'pts',NULL,'down',NULL,42,34,0,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(65,4,5,'Daniil Medvedev','national','ru',NULL,990,'pts',NULL,'down',NULL,41,26,9,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(66,4,6,'Taylor Fritz','national','us',NULL,975,'pts',NULL,'up',NULL,34,26,6,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(67,4,7,'Andrey Rublev','national','ru',NULL,960,'pts',NULL,'up',NULL,49,25,22,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(68,4,8,'Casper Ruud','national','no',NULL,945,'pts',NULL,'down',NULL,47,33,9,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(69,4,9,'Grigor Dimitrov','national','bg',NULL,930,'pts',NULL,'down',NULL,40,25,12,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(70,4,10,'Alex de Minaur','national','au',NULL,915,'pts',NULL,'same',NULL,38,15,20,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(71,4,1,'Sinner Academy','club','it',NULL,11830,'pts',NULL,'down',NULL,50,45,2,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(72,4,2,'Alcaraz Team','club','es',NULL,7120,'pts',NULL,'down',NULL,46,42,0,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(73,4,3,'Zverev Base','club','de',NULL,6805,'pts',NULL,'down',NULL,30,27,0,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(74,4,4,'Djokovic Center','club','rs',NULL,6210,'pts',NULL,'same',NULL,41,35,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(75,4,5,'Medvedev Camp','club','ru',NULL,5230,'pts',NULL,'down',NULL,47,35,4,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(76,4,6,'Fritz Pro','club','us',NULL,4415,'pts',NULL,'same',NULL,46,25,15,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(77,4,7,'Rublev Elite','club','ru',NULL,4070,'pts',NULL,'down',NULL,37,24,5,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(78,4,8,'Ruud Club','club','no',NULL,3855,'pts',NULL,'up',NULL,46,24,14,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(79,4,9,'Dimitrov Squad','club','bg',NULL,3740,'pts',NULL,'same',NULL,38,20,15,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(80,4,10,'De Minaur High','club','au',NULL,3545,'pts',NULL,'down',NULL,44,18,20,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(91,5,1,'Kansas City Chiefs','club','us',NULL,100,'pts',NULL,'same',NULL,30,26,0,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(92,5,2,'Baltimore Ravens','club','us',NULL,98,'pts',NULL,'down',NULL,42,37,2,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(93,5,3,'Detroit Lions','club','us',NULL,95,'pts',NULL,'same',NULL,37,28,3,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(94,5,4,'San Francisco 49ers','club','us',NULL,94,'pts',NULL,'same',NULL,33,25,4,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(95,5,5,'Buffalo Bills','club','us',NULL,93,'pts',NULL,'same',NULL,39,24,11,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(96,5,6,'Houston Texans','club','us',NULL,92,'pts',NULL,'down',NULL,38,25,6,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(97,5,7,'Philadelphia Eagles','club','us',NULL,91,'pts',NULL,'down',NULL,41,22,15,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(98,5,8,'Green Bay Packers','club','us',NULL,90,'pts',NULL,'same',NULL,49,28,19,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(99,5,9,'Dallas Cowboys','club','us',NULL,88,'pts',NULL,'same',NULL,42,25,10,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(100,5,10,'Cincinnati Bengals','club','us',NULL,87,'pts',NULL,'same',NULL,47,23,22,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(101,6,1,'Netherlands','national','nl',NULL,1100,'pts',NULL,'up',NULL,32,24,5,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(102,6,2,'Germany','national','de',NULL,1085,'pts',NULL,'down',NULL,41,30,5,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(103,6,3,'Belgium','national','be',NULL,1070,'pts',NULL,'up',NULL,30,26,0,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(104,6,4,'India','national','in',NULL,1055,'pts',NULL,'same',NULL,37,27,6,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(105,6,5,'Australia','national','au',NULL,1040,'pts',NULL,'same',NULL,46,34,9,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(106,6,6,'Argentina','national','ar',NULL,1025,'pts',NULL,'down',NULL,39,28,7,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(107,6,7,'England','national','gb',NULL,1010,'pts',NULL,'same',NULL,46,31,8,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(108,6,8,'Spain','national','es',NULL,995,'pts',NULL,'up',NULL,46,31,13,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(109,6,9,'Ireland','national','ie',NULL,980,'pts',NULL,'down',NULL,45,25,13,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(110,6,10,'France','national','fr',NULL,965,'pts',NULL,'up',NULL,42,19,16,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(111,6,1,'Kampong','club','nl',NULL,100,'pts',NULL,'up',NULL,45,40,0,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(112,6,2,'Rot-Weiss Koln','club','de',NULL,98,'pts',NULL,'up',NULL,41,32,3,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(113,6,3,'Bloemendaal','club','nl',NULL,96,'pts',NULL,'up',NULL,30,22,5,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(114,6,4,'Gantoise','club','be',NULL,94,'pts',NULL,'same',NULL,45,34,3,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(115,6,5,'Old Georgians','club','gb',NULL,92,'pts',NULL,'same',NULL,49,42,2,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(116,6,6,'Club de Campo','club','es',NULL,90,'pts',NULL,'same',NULL,49,37,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(117,6,7,'Mannheimer HC','club','de',NULL,88,'pts',NULL,'up',NULL,46,35,6,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(118,6,8,'Waterloo Ducks','club','be',NULL,86,'pts',NULL,'up',NULL,50,33,12,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(119,6,9,'Pinoke','club','nl',NULL,84,'pts',NULL,'same',NULL,42,23,11,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(120,6,10,'Surbiton','club','gb',NULL,82,'pts',NULL,'down',NULL,38,15,18,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(121,7,1,'Poland','national','pl',NULL,980,'pts',NULL,'up',NULL,46,44,0,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(122,7,2,'France','national','fr',NULL,965,'pts',NULL,'down',NULL,35,27,0,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(123,7,3,'Slovenia','national','si',NULL,950,'pts',NULL,'down',NULL,38,27,6,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(124,7,4,'Japan','national','jp',NULL,935,'pts',NULL,'same',NULL,46,35,8,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(125,7,5,'Italy','national','it',NULL,920,'pts',NULL,'down',NULL,48,42,1,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(126,7,6,'USA','national','us',NULL,905,'pts',NULL,'up',NULL,49,34,7,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(127,7,7,'Brazil','national','br',NULL,890,'pts',NULL,'up',NULL,49,35,8,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(128,7,8,'Argentina','national','ar',NULL,875,'pts',NULL,'same',NULL,40,20,15,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(129,7,9,'Canada','national','ca',NULL,860,'pts',NULL,'down',NULL,44,24,13,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(130,7,10,'Germany','national','de',NULL,845,'pts',NULL,'same',NULL,35,14,15,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(131,7,1,'Trentino Itas','club','it',NULL,100,'pts',NULL,'down',NULL,48,38,7,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(132,7,2,'Jastrzebski Wegiel','club','pl',NULL,98,'pts',NULL,'up',NULL,40,32,0,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(133,7,3,'Perugia','club','it',NULL,96,'pts',NULL,'down',NULL,46,40,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(134,7,4,'Ziraat Bankasi','club','tr',NULL,94,'pts',NULL,'same',NULL,36,23,9,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(135,7,5,'Lube Civitanova','club','it',NULL,92,'pts',NULL,'down',NULL,32,23,6,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(136,7,6,'Halkbank','club','tr',NULL,90,'pts',NULL,'same',NULL,31,20,6,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(137,7,7,'Zaksa Kedzierzyn-Kozle','club','pl',NULL,88,'pts',NULL,'up',NULL,35,26,5,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(138,7,8,'Sada Cruzeiro','club','br',NULL,86,'pts',NULL,'up',NULL,37,24,8,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(139,7,9,'Guaguas','club','es',NULL,84,'pts',NULL,'down',NULL,46,25,15,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(140,7,10,'Berlin RV','club','de',NULL,82,'pts',NULL,'same',NULL,32,18,6,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(141,8,1,'South Africa','national','za',NULL,800,'pts',NULL,'down',NULL,49,37,6,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(142,8,2,'Ireland','national','ie',NULL,785,'pts',NULL,'up',NULL,36,30,3,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(143,8,3,'New Zealand','national','nz',NULL,770,'pts',NULL,'same',NULL,39,33,1,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(144,8,4,'France','national','fr',NULL,755,'pts',NULL,'same',NULL,37,31,3,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(145,8,5,'England','national','gb',NULL,740,'pts',NULL,'down',NULL,37,29,1,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(146,8,6,'Argentina','national','ar',NULL,725,'pts',NULL,'same',NULL,48,33,8,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(147,8,7,'Scotland','national','gb',NULL,710,'pts',NULL,'up',NULL,35,20,8,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(148,8,8,'Italy','national','it',NULL,695,'pts',NULL,'up',NULL,42,20,20,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(149,8,9,'Fiji','national','fj',NULL,680,'pts',NULL,'up',NULL,39,18,16,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(150,8,10,'Australia','national','au',NULL,665,'pts',NULL,'down',NULL,50,21,24,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(151,8,1,'Toulouse','club','fr',NULL,100,'pts',NULL,'up',NULL,39,29,2,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(152,8,2,'Leinster','club','ie',NULL,98,'pts',NULL,'up',NULL,45,40,0,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(153,8,3,'Northampton Saints','club','gb',NULL,95,'pts',NULL,'up',NULL,38,27,5,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(154,8,4,'Bulls','club','za',NULL,93,'pts',NULL,'down',NULL,42,35,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(155,8,5,'La Rochelle','club','fr',NULL,92,'pts',NULL,'same',NULL,44,36,5,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(156,8,6,'Munster','club','ie',NULL,90,'pts',NULL,'same',NULL,39,27,10,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(157,8,7,'Saracens','club','gb',NULL,88,'pts',NULL,'same',NULL,47,33,7,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(158,8,8,'Glasgow Warriors','club','gb',NULL,87,'pts',NULL,'up',NULL,42,20,19,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(159,8,9,'Harlequins','club','gb',NULL,85,'pts',NULL,'down',NULL,49,30,14,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(160,8,10,'Stormers','club','za',NULL,84,'pts',NULL,'down',NULL,40,22,11,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(161,9,1,'Japan','national','jp',NULL,850,'pts',NULL,'same',NULL,34,28,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(162,9,2,'Mexico','national','mx',NULL,835,'pts',NULL,'same',NULL,33,26,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(163,9,3,'USA','national','us',NULL,820,'pts',NULL,'same',NULL,44,34,7,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(164,9,4,'South Korea','national','kr',NULL,805,'pts',NULL,'up',NULL,43,27,12,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(165,9,5,'Chinese Taipei','national','tw',NULL,790,'pts',NULL,'up',NULL,37,31,0,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(166,9,6,'Venezuela','national','ve',NULL,775,'pts',NULL,'same',NULL,48,39,2,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(167,9,7,'Netherlands','national','nl',NULL,760,'pts',NULL,'up',NULL,49,35,8,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(168,9,8,'Cuba','national','cu',NULL,745,'pts',NULL,'up',NULL,37,26,8,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(169,9,9,'Dominican Republic','national','do',NULL,730,'pts',NULL,'same',NULL,44,27,14,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(170,9,10,'Panama','national','pa',NULL,715,'pts',NULL,'same',NULL,30,15,13,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(171,9,1,'Los Angeles Dodgers','club','us',NULL,100,'pts',NULL,'same',NULL,42,33,1,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(172,9,2,'Philadelphia Phillies','club','us',NULL,97,'pts',NULL,'down',NULL,37,26,3,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(173,9,3,'New York Yankees','club','us',NULL,95,'pts',NULL,'down',NULL,50,34,14,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(174,9,4,'Baltimore Orioles','club','us',NULL,93,'pts',NULL,'same',NULL,37,30,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(175,9,5,'Cleveland Guardians','club','us',NULL,91,'pts',NULL,'down',NULL,38,31,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(176,9,6,'Milwaukee Brewers','club','us',NULL,89,'pts',NULL,'up',NULL,38,21,9,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(177,9,7,'Atlanta Braves','club','us',NULL,87,'pts',NULL,'up',NULL,38,27,9,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(178,9,8,'Houston Astros','club','us',NULL,85,'pts',NULL,'same',NULL,32,21,4,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(179,9,9,'Yomiuri Giants','club','jp',NULL,83,'pts',NULL,'up',NULL,41,22,14,5,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(180,9,10,'Hanshin Tigers','club','jp',NULL,81,'pts',NULL,'same',NULL,47,21,20,6,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(191,10,1,'Florida Panthers','club','us',NULL,100,'pts',NULL,'down',NULL,49,42,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(192,10,2,'Edmonton Oilers','club','ca',NULL,98,'pts',NULL,'up',NULL,40,31,5,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(193,10,3,'New York Rangers','club','us',NULL,96,'pts',NULL,'same',NULL,36,29,0,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(194,10,4,'Dallas Stars','club','us',NULL,94,'pts',NULL,'down',NULL,39,28,9,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(195,10,5,'Carolina Hurricanes','club','us',NULL,92,'pts',NULL,'down',NULL,45,27,11,7,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(196,10,6,'Vancouver Canucks','club','ca',NULL,90,'pts',NULL,'down',NULL,43,32,7,4,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(197,10,7,'Colorado Avalanche','club','us',NULL,88,'pts',NULL,'same',NULL,30,21,7,2,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(198,10,8,'Boston Bruins','club','us',NULL,86,'pts',NULL,'up',NULL,49,30,16,3,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(199,10,9,'ZSC Lions','club','ch',NULL,84,'pts',NULL,'down',NULL,43,27,8,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(200,10,10,'Skelleftea AIK','club','se',NULL,82,'pts',NULL,'up',NULL,46,25,13,8,0,NULL,1,'2026-05-11 14:09:37');
INSERT INTO teams VALUES(201,5,1,'China','national','cn',NULL,920,'pts',NULL,'same',NULL,40,35,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(202,5,2,'France','national','fr',NULL,880,'pts',NULL,'same',NULL,39,34,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(203,5,3,'Japan','national','jp',NULL,850,'pts',NULL,'same',NULL,38,33,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(204,5,4,'South Korea','national','kr',NULL,820,'pts',NULL,'same',NULL,37,32,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(205,5,5,'Germany','national','de',NULL,800,'pts',NULL,'same',NULL,36,31,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(206,5,6,'Chinese Taipei','national','tw',NULL,780,'pts',NULL,'same',NULL,35,30,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(207,5,7,'Sweden','national','se',NULL,750,'pts',NULL,'same',NULL,34,29,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(208,5,8,'Brazil','national','br',NULL,720,'pts',NULL,'same',NULL,33,28,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(209,5,9,'Portugal','national','pt',NULL,700,'pts',NULL,'same',NULL,32,27,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(210,5,10,'Nigeria','national','ng',NULL,680,'pts',NULL,'same',NULL,31,26,5,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(211,10,1,'USA','national','us',NULL,750,'pts',NULL,'same',NULL,25,15,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(212,10,2,'Northern Ireland','national','gb',NULL,720,'pts',NULL,'same',NULL,24,14,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(213,10,3,'Spain','national','es',NULL,700,'pts',NULL,'same',NULL,23,13,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(214,10,4,'Norway','national','no',NULL,680,'pts',NULL,'same',NULL,22,12,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(215,10,5,'Sweden','national','se',NULL,660,'pts',NULL,'same',NULL,21,11,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(216,10,6,'Australia','national','au',NULL,640,'pts',NULL,'same',NULL,20,10,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(217,10,7,'England','national','gb',NULL,620,'pts',NULL,'same',NULL,19,9,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(218,10,8,'South Korea','national','kr',NULL,600,'pts',NULL,'same',NULL,18,8,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(219,10,9,'Japan','national','jp',NULL,580,'pts',NULL,'same',NULL,17,7,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(220,10,10,'Canada','national','ca',NULL,560,'pts',NULL,'same',NULL,16,6,10,0,0,NULL,1,'2026-05-11 20:46:12');
INSERT INTO teams VALUES(221,11,1,'Oleksandr Usyk','national','ua',NULL,100,'pts',NULL,'same',NULL,30,25,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(222,11,2,'Terence Crawford','national','us',NULL,98,'pts',NULL,'same',NULL,29,24,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(223,11,3,'Naoya Inoue','national','jp',NULL,95,'pts',NULL,'same',NULL,28,23,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(224,11,4,'Dmitry Bivol','national','ru',NULL,92,'pts',NULL,'same',NULL,27,22,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(225,11,5,'Canelo Alvarez','national','mx',NULL,90,'pts',NULL,'same',NULL,26,21,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(226,11,6,'Artur Beterbiev','national','ru',NULL,88,'pts',NULL,'same',NULL,25,20,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(227,11,7,'Gervonta Davis','national','us',NULL,85,'pts',NULL,'same',NULL,24,19,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(228,11,8,'Jesse Rodriguez','national','us',NULL,82,'pts',NULL,'same',NULL,23,18,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(229,11,9,'Shakur Stevenson','national','us',NULL,80,'pts',NULL,'same',NULL,22,17,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(230,11,10,'Junto Nakatani','national','jp',NULL,78,'pts',NULL,'same',NULL,21,16,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(231,11,1,'Claressa Shields','club','us',NULL,100,'pts',NULL,'same',NULL,30,25,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(232,11,2,'Katie Taylor','club','ie',NULL,98,'pts',NULL,'same',NULL,29,24,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(233,11,3,'Amanda Serrano','club','pr',NULL,95,'pts',NULL,'same',NULL,28,23,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(234,11,4,'Seniesa Estrada','club','us',NULL,92,'pts',NULL,'same',NULL,27,22,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(235,11,5,'Alycia Baumgardner','club','us',NULL,90,'pts',NULL,'same',NULL,26,21,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(236,11,6,'Mikaela Mayer','club','us',NULL,88,'pts',NULL,'same',NULL,25,20,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(237,11,7,'Chantelle Cameron','club','gb',NULL,85,'pts',NULL,'same',NULL,24,19,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(238,11,8,'Delfine Persoon','club','be',NULL,82,'pts',NULL,'same',NULL,23,18,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(239,11,9,'Jessica McCaskill','club','us',NULL,80,'pts',NULL,'same',NULL,22,17,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(240,11,10,'Terri Harper','club','gb',NULL,78,'pts',NULL,'same',NULL,21,16,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(241,12,1,'Islam Makhachev','national','ru',NULL,100,'pts',NULL,'same',NULL,30,25,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(242,12,2,'Alex Pereira','national','br',NULL,98,'pts',NULL,'same',NULL,29,24,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(243,12,3,'Jon Jones','national','us',NULL,95,'pts',NULL,'same',NULL,28,23,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(244,12,4,'Ilia Topuria','national','es',NULL,92,'pts',NULL,'same',NULL,27,22,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(245,12,5,'Belal Muhammad','national','ps',NULL,90,'pts',NULL,'same',NULL,26,21,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(246,12,6,'Leon Edwards','national','gb',NULL,88,'pts',NULL,'same',NULL,25,20,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(247,12,7,'Alexander Volkanovski','national','au',NULL,85,'pts',NULL,'same',NULL,24,19,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(248,12,8,'Tom Aspinall','national','gb',NULL,82,'pts',NULL,'same',NULL,23,18,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(249,12,9,'Max Holloway','national','us',NULL,80,'pts',NULL,'same',NULL,22,17,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(250,12,10,'Dricus du Plessis','national','za',NULL,78,'pts',NULL,'same',NULL,21,16,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(251,12,1,'Alexa Grasso','club','mx',NULL,100,'pts',NULL,'same',NULL,30,25,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(252,12,2,'Valentina Shevchenko','club','kg',NULL,98,'pts',NULL,'same',NULL,29,24,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(253,12,3,'Zhang Weili','club','cn',NULL,95,'pts',NULL,'same',NULL,28,23,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(254,12,4,'Manon Fiorot','club','fr',NULL,92,'pts',NULL,'same',NULL,27,22,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(255,12,5,'Julianna Peña','club','us',NULL,90,'pts',NULL,'same',NULL,26,21,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(256,12,6,'Rose Namajunas','club','us',NULL,88,'pts',NULL,'same',NULL,25,20,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(257,12,7,'Erin Blanchfield','club','us',NULL,85,'pts',NULL,'same',NULL,24,19,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(258,12,8,'Yan Xiaonan','club','cn',NULL,82,'pts',NULL,'same',NULL,23,18,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(259,12,9,'Tatiana Suarez','club','us',NULL,80,'pts',NULL,'same',NULL,22,17,0,0,0,NULL,1,'2026-05-12 06:22:25');
INSERT INTO teams VALUES(260,12,10,'Jéssica Andrade','club','br',NULL,78,'pts',NULL,'same',NULL,21,16,0,0,0,NULL,1,'2026-05-12 06:22:25');
CREATE TABLE site_settings (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT,
  setting_group VARCHAR(50) DEFAULT 'general'
);
INSERT INTO site_settings VALUES(1,'site_title','Sporting Rank | Sport Rank | Sports Ranking | Sport Rankings','general');
INSERT INTO site_settings VALUES(2,'site_tagline','Rankings for the world''s top 10 sports','general');
INSERT INTO site_settings VALUES(3,'meta_description','Discover up-to-date rankings for Soccer, Basketball, Cricket, Tennis, and more.','seo');
INSERT INTO site_settings VALUES(4,'update_frequency','Weekly every Monday','general');
INSERT INTO site_settings VALUES(5,'accent_color','#F0A500','design');
INSERT INTO site_settings VALUES(6,'footer_text','© 2026 SportingRank. All rights reserved.','general');
INSERT INTO site_settings VALUES(7,'google_analytics_id','','analytics');
INSERT INTO site_settings VALUES(8,'last_updated','2026-05-01','general');
CREATE TABLE admin_users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  last_login DATETIME NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO admin_users VALUES(1,'admin','$2y$10$NFyZJKAnwUOmmmQq0L8wEejkl1aZoSotFigPq2cBY67qLjtSO/kyS','admin@sportingrank.com',NULL,'2026-05-11 14:09:37');
CREATE TABLE activity_log (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  action TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE languages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(5) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    flag VARCHAR(5) NOT NULL,
    is_rtl TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INTEGER NOT NULL DEFAULT 0
);
INSERT INTO languages VALUES(1,'en','English','🇺🇸',0,1,1);
INSERT INTO languages VALUES(2,'fr','Français','🇫🇷',0,1,2);
INSERT INTO languages VALUES(3,'es','Español','🇪🇸',0,1,3);
INSERT INTO languages VALUES(4,'de','Deutsch','🇩🇪',0,1,4);
INSERT INTO languages VALUES(5,'ar','العربية','🇸🇦',1,1,5);
INSERT INTO languages VALUES(6,'hi','हिन्दी','🇮🇳',0,1,6);
INSERT INTO languages VALUES(7,'zh','中文','🇨🇳',0,1,7);
INSERT INTO languages VALUES(8,'pt','Português','🇧🇷',0,1,8);
CREATE TABLE translations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lang_code VARCHAR(5) NOT NULL,
    tkey VARCHAR(120) NOT NULL,
    tvalue TEXT NOT NULL,
    UNIQUE(lang_code, tkey)
);
INSERT INTO translations VALUES(1,'en','nav.rankings','Rankings');
INSERT INTO translations VALUES(2,'fr','nav.rankings','Classements');
INSERT INTO translations VALUES(3,'es','nav.rankings','Clasificaciones');
INSERT INTO translations VALUES(4,'de','nav.rankings','Ranglisten');
INSERT INTO translations VALUES(5,'ar','nav.rankings','التصنيفات');
INSERT INTO translations VALUES(6,'en','label.real_time','Real-Time Data');
INSERT INTO translations VALUES(7,'ar','label.real_time','بيانات مباشرة');
INSERT INTO translations VALUES(8,'en','label.vote','Vote');
INSERT INTO translations VALUES(9,'fr','label.vote','Voter');
INSERT INTO translations VALUES(10,'en','label.wins','W');
INSERT INTO translations VALUES(11,'en','label.losses','L');
INSERT INTO translations VALUES(12,'en','label.draws','D');
INSERT INTO translations VALUES(13,'en','label.gp','GP');
INSERT INTO translations VALUES(14,'en','label.SportingRank','Sporting Rank | Sports Ranking');
INSERT INTO translations VALUES(15,'en','label.SportingRank_2026','2026');
INSERT INTO translations VALUES(16,'en','nav.national','National');
INSERT INTO translations VALUES(17,'en','nav.leagues','Leagues');
INSERT INTO translations VALUES(18,'en','label.men','Men');
INSERT INTO translations VALUES(19,'en','label.women','Women');
INSERT INTO translations VALUES(20,'en','label.men_rankings','Men Rankings');
INSERT INTO translations VALUES(21,'en','label.women_rankings','Women Rankings');
INSERT INTO translations VALUES(22,'en','label.national_teams','National Teams');
INSERT INTO translations VALUES(23,'en','label.leagues_clubs','Leagues / Clubs');
INSERT INTO translations VALUES(24,'en','label.club_standings','Club Standings');
INSERT INTO translations VALUES(25,'en','label.status','Status');
INSERT INTO translations VALUES(26,'en','label.team','Team');
INSERT INTO translations VALUES(27,'en','label.points','Points');
INSERT INTO translations VALUES(28,'en','label.rank','Rank');
INSERT INTO translations VALUES(29,'en','nav.all_sports','All Sports');
INSERT INTO translations VALUES(30,'en','label.live','Live');
INSERT INTO translations VALUES(31,'en','label.trend_vote','Trend / Vote');
INSERT INTO translations VALUES(32,'en','label.full_standings','Full Standings');
INSERT INTO translations VALUES(33,'en','label.explore_sports','Explore Sports');
INSERT INTO translations VALUES(34,'en','nav.search','Search sports or teams...');
INSERT INTO translations VALUES(35,'en','nav.history','History');
INSERT INTO translations VALUES(36,'en','nav.about','About');
INSERT INTO translations VALUES(37,'en','empty.national','No national rankings found');
INSERT INTO translations VALUES(38,'en','empty.club','No league rankings found');
INSERT INTO translations VALUES(39,'en','empty.no_club','No club rankings available yet.');
INSERT INTO translations VALUES(40,'en','empty.no_national','No national rankings available yet.');
INSERT INTO translations VALUES(41,'en','label.pts','pts');
INSERT INTO translations VALUES(42,'ar','nav.national','المنتخبات');
INSERT INTO translations VALUES(43,'ar','nav.leagues','الدوريات');
INSERT INTO translations VALUES(44,'ar','label.men','رجال');
INSERT INTO translations VALUES(45,'ar','label.women','سيدات');
INSERT INTO translations VALUES(46,'ar','label.men_rankings','تصنيفات الرجال');
INSERT INTO translations VALUES(47,'ar','label.women_rankings','تصنيفات السيدات');
INSERT INTO translations VALUES(48,'ar','label.national_teams','المنتخبات الوطنية');
INSERT INTO translations VALUES(49,'ar','label.leagues_clubs','الدوريات والأندية');
INSERT INTO translations VALUES(50,'ar','label.club_standings','ترتيب الأندية');
INSERT INTO translations VALUES(51,'ar','label.team','الفريق');
INSERT INTO translations VALUES(52,'ar','label.points','النقاط');
INSERT INTO translations VALUES(53,'ar','label.rank','الترتيب');
INSERT INTO translations VALUES(54,'ar','nav.all_sports','جميع الرياضات');
INSERT INTO translations VALUES(55,'ar','label.live','مباشر');
INSERT INTO translations VALUES(56,'ar','label.full_standings','الترتيب الكامل');
INSERT INTO translations VALUES(57,'ar','nav.search','البحث عن رياضات أو فرق...');
INSERT INTO translations VALUES(58,'en','men','Men');
INSERT INTO translations VALUES(59,'en','women','Women');
INSERT INTO translations VALUES(60,'ar','men','رجال');
INSERT INTO translations VALUES(61,'ar','women','نساء');
INSERT INTO translations VALUES(62,'fr','men','Hommes');
INSERT INTO translations VALUES(63,'fr','women','Femmes');
INSERT INTO translations VALUES(64,'es','men','Hombres');
INSERT INTO translations VALUES(65,'es','women','Mujeres');
CREATE TABLE blogs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT,
    excerpt TEXT,
    featured_image VARCHAR(255),
    author VARCHAR(100),
    is_published TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE backlinks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    rel VARCHAR(50) DEFAULT 'nofollow',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO sqlite_sequence VALUES('sports',12);
INSERT INTO sqlite_sequence VALUES('site_settings',8);
INSERT INTO sqlite_sequence VALUES('admin_users',1);
INSERT INTO sqlite_sequence VALUES('teams',260);
INSERT INTO sqlite_sequence VALUES('languages',8);
INSERT INTO sqlite_sequence VALUES('translations',65);
CREATE INDEX idx_teams_performance ON teams(sport_id, team_type, is_active, points DESC, wins DESC);
COMMIT;

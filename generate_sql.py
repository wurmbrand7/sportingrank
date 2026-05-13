
sports_data = {
    1: [ # Soccer
        ("Argentina", "ar", 1860.14), ("France", "fr", 1840.59), ("Spain", "es", 1835.42),
        ("England", "gb", 1810.33), ("Brazil", "br", 1785.61), ("Belgium", "be", 1772.44),
        ("Portugal", "pt", 1741.43), ("Netherlands", "nl", 1735.99), ("Italy", "it", 1723.33), ("Colombia", "co", 1701.32)
    ],
    2: [ # Basketball
        ("USA", "us", 838.8), ("Serbia", "rs", 758.9), ("Germany", "de", 755.3),
        ("France", "fr", 753.0), ("Canada", "ca", 747.8), ("Spain", "es", 746.7),
        ("Australia", "au", 732.5), ("Argentina", "ar", 731.1), ("Latvia", "lv", 711.4), ("Lithuania", "lt", 698.5)
    ],
    3: [ # Cricket (ODI)
        ("India", "in", 122), ("Australia", "au", 116), ("South Africa", "za", 112),
        ("Pakistan", "pk", 106), ("New Zealand", "nz", 101), ("Sri Lanka", "lk", 95),
        ("England", "gb", 95), ("Bangladesh", "bd", 86), ("Afghanistan", "af", 82), ("West Indies", "wi", 75)
    ],
    4: [ # Tennis (Davis Cup)
        ("Italy", "it", 483.5), ("Australia", "au", 461.75), ("Canada", "ca", 437.5),
        ("Germany", "de", 393.75), ("USA", "us", 387.5), ("Serbia", "rs", 375.0),
        ("Netherlands", "nl", 368.75), ("Czechia", "cz", 356.25), ("France", "fr", 350.0), ("Spain", "es", 343.75)
    ],
    5: [ # American Football (IFAF)
        ("USA", "us", 1000), ("Japan", "jp", 950), ("Austria", "at", 900),
        ("Mexico", "mx", 880), ("Germany", "de", 860), ("Italy", "it", 840),
        ("France", "fr", 820), ("Sweden", "se", 800), ("Finland", "fi", 780), ("Great Britain", "gb", 760)
    ],
    6: [ # Field Hockey
        ("Netherlands", "nl", 3110), ("Germany", "de", 2980), ("England", "gb", 2930),
        ("India", "in", 2860), ("Australia", "au", 2810), ("Belgium", "be", 2740),
        ("Argentina", "ar", 2620), ("Spain", "es", 2510), ("Ireland", "ie", 2320), ("France", "fr", 2210)
    ],
    7: [ # Volleyball
        ("Poland", "pl", 422.61), ("Japan", "jp", 369.32), ("Slovenia", "si", 358.51),
        ("Italy", "it", 352.33), ("USA", "us", 340.55), ("Brazil", "br", 336.82),
        ("France", "fr", 332.53), ("Argentina", "ar", 308.13), ("Canada", "ca", 279.67), ("Serbia", "rs", 259.97)
    ],
    8: [ # Rugby Union
        ("South Africa", "za", 94.16), ("Ireland", "ie", 92.12), ("New Zealand", "nz", 89.70),
        ("France", "fr", 84.58), ("England", "gb", 84.11), ("Argentina", "ar", 81.64),
        ("Scotland", "gb-sct", 81.59), ("Italy", "it", 79.98), ("Fiji", "fj", 78.43), ("Australia", "au", 77.48)
    ],
    9: [ # Baseball
        ("Japan", "jp", 5797), ("Mexico", "mx", 4764), ("USA", "us", 4492),
        ("South Korea", "kr", 4353), ("Chinese Taipei", "tw", 3706), ("Venezuela", "ve", 3480),
        ("Netherlands", "nl", 3288), ("Cuba", "cu", 3121), ("Dominican Republic", "do", 2743), ("Panama", "pa", 2473)
    ],
    10: [ # Ice Hockey
        ("Canada", "ca", 4100), ("Czechia", "cz", 4000), ("Switzerland", "ch", 3950),
        ("Finland", "fi", 3920), ("Sweden", "se", 3910), ("USA", "us", 3900),
        ("Germany", "de", 3800), ("Slovakia", "sk", 3750), ("Latvia", "lv", 3700), ("Denmark", "dk", 3650)
    ],
    11: [ # Boxing (by nations)
        ("USA", "us", 950), ("Mexico", "mx", 920), ("UK", "gb", 890),
        ("Japan", "jp", 870), ("Ukraine", "ua", 850), ("Russia", "ru", 830),
        ("Philippines", "ph", 810), ("Cuba", "cu", 790), ("Puerto Rico", "pr", 770), ("Thailand", "th", 750)
    ],
    12: [ # MMA (by nations)
        ("USA", "us", 980), ("Brazil", "br", 940), ("Russia", "ru", 910),
        ("UK", "gb", 880), ("Mexico", "mx", 860), ("Nigeria", "ng", 840),
        ("Australia", "au", 820), ("France", "fr", 800), ("China", "cn", 780), ("Poland", "pl", 760)
    ],
    13: [ # Kabaddi
        ("India", "in", 1000), ("Iran", "ir", 900), ("Pakistan", "pk", 800),
        ("South Korea", "kr", 750), ("Bangladesh", "bd", 700), ("Sri Lanka", "lk", 650),
        ("Thailand", "th", 600), ("Kenya", "ke", 550), ("Poland", "pl", 500), ("Argentina", "ar", 450)
    ],
    14: [ # Golf (by nations)
        ("USA", "us", 990), ("UK", "gb", 950), ("South Korea", "kr", 910),
        ("Australia", "au", 880), ("Japan", "jp", 860), ("Sweden", "se", 840),
        ("Spain", "es", 820), ("Canada", "ca", 800), ("South Africa", "za", 780), ("France", "fr", 760)
    ],
    15: [ # Table Tennis
        ("China", "cn", 7500), ("Germany", "de", 5000), ("France", "fr", 4800),
        ("Japan", "jp", 4700), ("South Korea", "kr", 4600), ("Chinese Taipei", "tw", 4500),
        ("Brazil", "br", 4000), ("Portugal", "pt", 3800), ("Sweden", "se", 3700), ("Egypt", "eg", 3500)
    ],
    16: [ # Badminton
        ("China", "cn", 105000), ("South Korea", "kr", 98000), ("Indonesia", "id", 95000),
        ("Japan", "jp", 92000), ("Thailand", "th", 88000), ("Denmark", "dk", 85000),
        ("India", "in", 82000), ("Malaysia", "my", 80000), ("Chinese Taipei", "tw", 78000), ("Spain", "es", 75000)
    ],
    17: [ # Cycling
        ("Belgium", "be", 24500), ("Slovenia", "si", 18200), ("Spain", "es", 16500),
        ("France", "fr", 15800), ("UK", "gb", 15200), ("Italy", "it", 14900),
        ("Netherlands", "nl", 14100), ("Denmark", "dk", 13500), ("USA", "us", 12800), ("Australia", "au", 11500)
    ],
    18: [ # Formula 1 (by Driver Nations)
        ("UK", "gb", 450), ("Germany", "de", 400), ("Italy", "it", 380),
        ("France", "fr", 350), ("Netherlands", "nl", 330), ("Spain", "es", 310),
        ("Brazil", "br", 290), ("USA", "us", 270), ("Australia", "au", 250), ("Austria", "at", 230)
    ],
    19: [ # Horse Racing (by Nations)
        ("UK", "gb", 1000), ("Ireland", "ie", 980), ("USA", "us", 960),
        ("Japan", "jp", 940), ("Australia", "au", 920), ("France", "fr", 900),
        ("Hong Kong", "hk", 880), ("UAE", "ae", 860), ("Germany", "de", 840), ("South Africa", "za", 820)
    ],
    20: [ # Handball
        ("Denmark", "dk", 550), ("France", "fr", 520), ("Sweden", "se", 490),
        ("Germany", "de", 460), ("Norway", "no", 430), ("Spain", "es", 400),
        ("Iceland", "is", 370), ("Egypt", "eg", 340), ("Hungary", "hu", 310), ("Croatia", "hr", 280)
    ],
    21: [ # Triathlon
        ("France", "fr", 15000), ("UK", "gb", 14500), ("Germany", "de", 14000),
        ("USA", "us", 13500), ("Australia", "au", 13000), ("Switzerland", "ch", 12500),
        ("Italy", "it", 12000), ("New Zealand", "nz", 11500), ("Spain", "es", 11000), ("Brazil", "br", 10500)
    ]
}

import random

with open("update_rankings.sql", "w") as f:
    f.write("BEGIN TRANSACTION;\n")
    # First, clear existing national teams for these sports
    f.write("DELETE FROM teams WHERE team_type = 'national';\n")

    for sport_id, teams in sports_data.items():
        for i, (name, code, points) in enumerate(teams):
            rank = i + 1
            mp = random.randint(30, 60)
            wins = int(mp * (1 - (i*0.05)))
            losses = random.randint(0, mp - wins)
            draws = mp - wins - losses
            f.write(f"INSERT INTO teams (sport_id, rank_position, team_name, team_type, country_code, points, trend, matches_played, wins, losses, draws, is_active, votes) VALUES ({sport_id}, {rank}, '{name}', 'national', '{code}', {points}, 'same', {mp}, {wins}, {losses}, {draws}, 1, 0);\n")

    f.write("COMMIT;\n")

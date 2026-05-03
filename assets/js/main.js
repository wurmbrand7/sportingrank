document.addEventListener('DOMContentLoaded', () => {
    // CountUp Animation
    const counters = document.querySelectorAll('.stat-counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const countUp = new countUp.CountUp(counter, target, {
            duration: 2,
            useEasing: true
        });
        if (!countUp.error) {
            countUp.start();
        }
    });

    // Points Counter Animation
    const pointsCounters = document.querySelectorAll('.points-counter');
    pointsCounters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const countUp = new countUp.CountUp(counter, target, {
            duration: 1.5,
            useEasing: true,
            separator: ','
        });
        if (!countUp.error) {
            countUp.start();
        }
    });

    // Sports Filtering
    const filterBtns = document.querySelectorAll('.sport-filter-btn');
    const sportCards = document.querySelectorAll('.sport-ranking-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');

            // Update active button
            filterBtns.forEach(b => {
                b.classList.remove('bg-accent', 'text-primary');
                b.classList.add('bg-card', 'text-[#EEEEFF]');
            });
            btn.classList.remove('bg-card', 'text-[#EEEEFF]');
            btn.classList.add('bg-accent', 'text-primary');

            // Filter cards
            sportCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-sport') === filter) {
                    card.style.display = 'block';
                    setTimeout(() => card.style.opacity = '1', 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });

    // Sticky Navbar transparency
    const nav = document.querySelector('nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('bg-primary/95', 'shadow-2xl');
            nav.classList.remove('bg-primary/80');
        } else {
            nav.classList.add('bg-primary/80');
            nav.classList.remove('bg-primary/95', 'shadow-2xl');
        }
    });

    // Live Search Logic
    const searchInput = document.getElementById('site-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const sportCards = document.querySelectorAll('.sport-ranking-card');

            sportCards.forEach(card => {
                const sportName = card.querySelector('h3').innerText.toLowerCase();
                const teamNames = Array.from(card.querySelectorAll('tbody span.font-bold')).map(span => span.innerText.toLowerCase());

                const matchesSport = sportName.includes(query);
                const matchesTeam = teamNames.some(name => name.includes(query));

                if (matchesSport || matchesTeam) {
                    card.style.display = 'block';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Theme Toggle Logic
    const themeToggle = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-icon-dark');
    const lightIcon = document.getElementById('theme-icon-light');

    if (themeToggle) {
        // Load preference
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.remove('bg-primary', 'text-[#EEEEFF]');
            document.body.classList.add('bg-white', 'text-gray-900');
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }

        themeToggle.addEventListener('click', () => {
            if (document.body.classList.contains('bg-primary')) {
                // Switch to light
                document.body.classList.remove('bg-primary', 'text-[#EEEEFF]');
                document.body.classList.add('bg-white', 'text-gray-900');
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
                localStorage.setItem('theme', 'light');
            } else {
                // Switch to dark
                document.body.classList.remove('bg-white', 'text-gray-900');
                document.body.classList.add('bg-primary', 'text-[#EEEEFF]');
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // Rotating Facts
    const facts = [
        "Cricket is the second most popular sport in the world with over 2.5 billion fans globally.",
        "Soccer is played by 250 million players in over 200 countries.",
        "Basketball was invented by Dr. James Naismith in 1891.",
        "Field Hockey is the national sport of Pakistan.",
        "The first modern Olympic Games were held in Athens, Greece, in 1896."
    ];
    const factElement = document.getElementById('rotating-fact');
    if (factElement) {
        let currentFact = 0;
        setInterval(() => {
            factElement.style.opacity = '0';
            setTimeout(() => {
                currentFact = (currentFact + 1) % facts.length;
                factElement.innerText = facts[currentFact];
                factElement.style.opacity = '1';
            }, 500);
        }, 5000);
    }
});

function voteForTeam(teamId, teamName) {
    fetch('ajax/vote.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'team_id=' + teamId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Thank you for voting for ' + teamName + '! Your vote has been recorded.');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while voting.');
    });
}

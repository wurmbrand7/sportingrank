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
});

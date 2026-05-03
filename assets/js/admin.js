// Admin JS
document.addEventListener('DOMContentLoaded', () => {
    // Basic sidebar toggle for mobile
    const sidebar = document.getElementById('admin-sidebar');
    const toggle = document.getElementById('sidebar-toggle');

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Sport reordering using SortableJS
    const sportList = document.getElementById('manage-sports-list');
    if (sportList && typeof Sortable !== 'undefined') {
        new Sortable(sportList, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function() {
                // Here you would typically send an AJAX request to save the new order
                console.log('New order saved locally');
            }
        });
    }

    // Team reordering
    const teamList = document.getElementById('manage-teams-list');
    if (teamList && typeof Sortable !== 'undefined') {
        new Sortable(teamList, {
            animation: 150,
            handle: '.drag-handle',
            onEnd: function() {
                console.log('Team order changed');
            }
        });
    }
});

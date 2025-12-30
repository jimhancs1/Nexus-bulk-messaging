document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Mobile Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('show') && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
                sidebar.classList.remove('show');
            }
        });
    }

    // 2. Optimized Intersection Observer for Reveal Elements
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // 3. Dashboard Chart (Refined)
    const contactCtx = document.getElementById('contactsChart');
    if (contactCtx) {
        new Chart(contactCtx, {
            type: 'line',
            data: {
                labels: typeof chartLabels !== 'undefined' ? chartLabels : [],
                datasets: [{
                    label: 'Contacts',
                    data: typeof chartData !== 'undefined' ? chartData : [],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 4. Smooth Search for Tables
    const searchInput = document.getElementById('contactSearch');
    const tableRows = document.querySelectorAll('#contactsTable tbody tr');
    
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }

    // 5. Form Handling (AJAX)
    const settingsForm = document.getElementById('settingsForm');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            const alertBox = document.getElementById('settingsAlert');
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

            fetch('save_settings.php', { method: 'POST', body: new FormData(this) })
                .then(res => res.json())
                .then(data => {
                    alertBox.className = `alert py-2 mt-3 alert-${data.status === 'success' ? 'success' : 'danger'}`;
                    alertBox.innerText = data.message;
                    alertBox.classList.remove('d-none');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = 'Update Settings';
                });
        });
    }
});
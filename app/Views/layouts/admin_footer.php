        </main>
    </div>
</div>

<!-- Custom Scripts -->
<script src="<?php echo asset('js/app.js'); ?>"></script>

<script>
// Theme Toggle
function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    const theme = isDark ? 'dark' : 'light';
    localStorage.setItem('theme', theme);
    
    // Update user preference via AJAX
    fetch('<?php echo url('/api/update-theme'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ theme: theme })
    });
    
    // Update charts if they exist
    if (typeof updateChartTheme === 'function') {
        updateChartTheme(isDark);
    }
}

// Sidebar Toggle for Mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('closed');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggleButton = event.target.closest('[onclick="toggleSidebar()"]');
    
    if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !toggleButton) {
        sidebar.classList.add('closed');
    }
});
</script>

</body>
</html>

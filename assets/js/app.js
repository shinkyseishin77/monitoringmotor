document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    }

    // Modal helpers
    window.openModal = function(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    window.closeModal = function(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }

    // Form confirmation
    const confirmForms = document.querySelectorAll('.form-confirm');
    confirmForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah anda yakin ingin melanjutkan aksi ini?')) {
                e.preventDefault();
            }
        });
    });

    // Check Notifications periodically (Basic mock setup)
    function fetchNotifications() {
        fetch(window.baseUrl + 'notifikasi/get')
            .then(res => res.json())
            .then(data => {
                const badge = document.querySelector('.notification-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(err => console.log(err));
    }
    
    // Call if baseUrl is defined
    if (typeof window.baseUrl !== 'undefined') {
        fetchNotifications();
        setInterval(fetchNotifications, 60000); // every minute
    }
});

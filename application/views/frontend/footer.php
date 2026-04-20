    </main>

    <footer style="background: rgba(255,255,255,0.7); backdrop-filter: blur(10px); border-top: 1px solid rgba(0,0,0,0.05); text-align: center; padding: 2rem 0; margin-top: auto; font-size: 0.9rem; color: var(--text-secondary);">
        <p>&copy; <?= date('Y') ?> Bengkel Monitor. All rights reserved.</p>
        <p style="font-size: 0.8rem; margin-top: 0.5rem; opacity: 0.8;">Sistem Informasi Pemantauan Internal</p>
    </footer>

    <!-- Script that removes simple dismissable alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-modern');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
</body>
</html>

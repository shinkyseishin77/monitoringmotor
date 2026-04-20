<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Monitor</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script>
        window.baseUrl = '<?= base_url() ?>';
    </script>
</head>
<body>

<div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fa-solid fa-wrench"></i> Bengkel Monitor</h2>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-title">Menu Utama</li>
            <?php if(isset($permissions['dashboard']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('dashboard') ?>" class="<?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-grid-2"></i> Dashboard
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['motor']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('motor') ?>" class="<?= $this->uri->segment(1) == 'motor' ? 'active' : '' ?>">
                    <i class="fa-solid fa-motorcycle"></i> Data Motor
                </a></li>
            <?php endif; ?>

            <li class="menu-title">Operasional</li>
            <?php if(isset($permissions['service']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('service') ?>" class="<?= $this->uri->segment(1) == 'service' ? 'active' : '' ?>">
                    <i class="fa-solid fa-screwdriver-wrench"></i> Service Motor
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['jadwal_service']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('penjadwalan') ?>" class="<?= $this->uri->segment(1) == 'penjadwalan' ? 'active' : '' ?>">
                    <i class="fa-solid fa-calendar-alt"></i> Penjadwalan
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['monitoring']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('monitoring') ?>" class="<?= $this->uri->segment(1) == 'monitoring' ? 'active' : '' ?>">
                    <i class="fa-solid fa-desktop"></i> Monitoring Motor
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['unit_ac']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('unit_ac') ?>" class="<?= $this->uri->segment(1) == 'unit_ac' ? 'active' : '' ?>">
                    <i class="fa-solid fa-snowflake"></i> Master AC
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['monitoring_ac']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('monitoring_ac') ?>" class="<?= $this->uri->segment(1) == 'monitoring_ac' ? 'active' : '' ?>">
                    <i class="fa-solid fa-thermometer-half"></i> Monitoring AC
                </a></li>
            <?php endif; ?>

            <li class="menu-title">Laporan</li>
            <?php if(isset($permissions['riwayat']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('riwayat') ?>" class="<?= $this->uri->segment(1) == 'riwayat' ? 'active' : '' ?>">
                    <i class="fa-solid fa-history"></i> Riwayat Service
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['laporan_monitoring']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('laporan_monitoring') ?>" class="<?= $this->uri->segment(1) == 'laporan_monitoring' ? 'active' : '' ?>">
                    <i class="fa-solid fa-print"></i> Laporan Monitoring
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['aduan']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('aduan') ?>" class="<?= $this->uri->segment(1) == 'aduan' ? 'active' : '' ?>">
                    <i class="fa-solid fa-comments"></i> Kelola Aduan
                </a></li>
            <?php endif; ?>
            <?php if(isset($permissions['activity_log']['can_view']) || $role_id == 1): ?>
                <li><a href="<?= base_url('activity_log') ?>" class="<?= $this->uri->segment(1) == 'activity_log' ? 'active' : '' ?>">
                    <i class="fa-solid fa-clipboard-list"></i> Log Aktivitas
                </a></li>
            <?php endif; ?>

            <?php if($role_id == 1): // Hanya admin yang mengatur role dan user ?>
            <li class="menu-title">Pengaturan</li>
            <li><a href="<?= base_url('kelola_role') ?>" class="<?= $this->uri->segment(1) == 'kelola_role' ? 'active' : '' ?>">
                <i class="fa-solid fa-user-shield"></i> Kelola Role
            </a></li>
            <li><a href="<?= base_url('kelola_user') ?>" class="<?= $this->uri->segment(1) == 'kelola_user' ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i> Kelola User
            </a></li>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button id="sidebar-toggle" class="toggle-sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h3 style="margin:0; font-size: 1.1rem; color: var(--dark);">
                    <?= isset($title) ? $title : 'Halaman' ?>
                </h3>
            </div>
            <div class="topbar-right">
                <div class="notification-bell" onclick="window.location.href='<?= base_url('penjadwalan') ?>'">
                    <i class="fa-solid fa-bell" style="font-size: 1.2rem;"></i>
                    <span class="notification-badge" style="display:none;">0</span>
                </div>
                <div class="user-profile">
                    <div style="background-color: var(--primary); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        <?= substr($user_name, 0, 1) ?>
                    </div>
                    <span style="font-weight: 500;"><?= $user_name ?></span>
                    <a href="<?= base_url('auth/logout') ?>" style="margin-left: 1rem; color: var(--danger);" title="Logout"><i class="fa-solid fa-sign-out-alt"></i></a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <!-- Dynamic Content Injected Here -->
            <?= $content ?>
        </div>
    </main>
</div>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>

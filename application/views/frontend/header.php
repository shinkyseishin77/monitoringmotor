<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Frontend' ?> - Bengkel Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/frontend-modern.css') ?>">
</head>
<body>
    <nav class="frontend-navbar">
        <div class="nav-container">
            <a href="<?= base_url() ?>" class="brand-logo">
                <i class="fa-solid fa-motorcycle" style="color: var(--primary-color);"></i> SIP Motor
            </a>
            <div class="nav-links">
                <a href="<?= base_url('monitoring-public') ?>" class="nav-link">Monitoring Motor</a>
                <a href="<?= base_url('monitoring-ac-public') ?>" class="nav-link">Monitoring AC</a>
                <a href="<?= base_url('aduan-public') ?>" class="nav-link">Kirim Aduan</a>
                <a href="<?= base_url('daftar-aduan') ?>" class="nav-link">Status Aduan</a>
                <a href="<?= base_url('auth/login') ?>" class="btn-modern btn-primary-modern" style="margin-left: 1rem;">
                    <i class="fa-solid fa-sign-in-alt"></i> Login
                </a>
            </div>
        </div>
    </nav>
    <main class="main-container">

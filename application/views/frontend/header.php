<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Frontend' ?> - Bengkel Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; }
        .navbar { background: var(--primary); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar a { color: white; text-decoration: none; margin-left: 1.5rem; font-weight: 500; transition: opacity 0.3s; }
        .navbar a:hover { opacity: 0.8; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .motor-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .status-badge { padding: 0.3rem 0.6rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        .status-tersedia { background: #d4edda; color: #155724; }
        .status-service { background: #fff3cd; color: #856404; }
        .status-digunakan { background: #cce5ff; color: #004085; }
        .btn-primary { background: var(--primary); color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-control { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 5px; font-family: inherit; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div style="font-size: 1.25rem; font-weight: 700;">
            <i class="fa-solid fa-motorcycle"></i> SIP Monitor
        </div>
        <div>
            <a href="<?= base_url('monitoring-public') ?>">Monitoring Motor</a>
            <a href="<?= base_url('monitoring-ac-public') ?>">Monitoring AC</a>
            <a href="<?= base_url('aduan-public') ?>">Kirim Aduan</a>
            <a href="<?= base_url('daftar-aduan') ?>">Status Aduan</a>
            <a href="<?= base_url('auth/login') ?>" class="btn-primary" style="margin-left: 2rem;"><i class="fa-solid fa-sign-in-alt"></i> Login</a>
        </div>
    </nav>
    <div class="container">

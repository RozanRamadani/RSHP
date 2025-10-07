<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != 5) {
    header('Location: /views/auth/login.php');
    exit;
}
include('../../views/partials/menu.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - RSHP</title>
    <link rel="stylesheet" href="../../assets/css/dashboard_pemilik.css">
</head>
<body>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Dashboard Pemilik</h1>
        <p class="dashboard-welcome">Selamat datang, <?= htmlspecialchars($_SESSION['user']['nama']) ?>!</p>
        
        <div class="dashboard-cards">
            <a href="PetPemilikView.php" class="dashboard-card">
                <div class="card-icon">🐕</div>
                <h3>Daftar Pet Saya</h3>
                <p>Lihat semua hewan peliharaan yang Anda miliki</p>
            </a>
            
            <a href="ReservasiPemilikView.php" class="dashboard-card">
                <div class="card-icon">📅</div>
                <h3>Daftar Reservasi</h3>
                <p>Lihat riwayat reservasi pemeriksaan hewan</p>
            </a>
            
            <a href="RekamMedisPemilikView.php" class="dashboard-card">
                <div class="card-icon">📋</div>
                <h3>Rekam Medis Pet</h3>
                <p>Lihat rekam medis dan riwayat kesehatan pet</p>
            </a>
        </div>
    </div>
    
    <!-- Footer khusus untuk dashboard pemilik -->
    <footer class="dashboard-footer">
        <div class="footer-content">
            <div class="footer-info">
                <p>Rumah Sakit Hewan Pendidikan Universitas Airlangga</p>
            </div>
            <div class="footer-contact">
                <p><strong>Kontak:</strong> (031) 5992785 | rshp@unair.ac.id</p>
                <p><strong>Alamat:</strong> Jl. Mulyorejo, Surabaya, Jawa Timur 60115</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> RSHP UNAIR. Semua hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
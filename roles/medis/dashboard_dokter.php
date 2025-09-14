
<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || $_SESSION['user']['role_aktif'] != '2') {
    header('Location: ../../views/auth/login.php');
    exit;
}
$requireDb = __DIR__ . '/../../databases/koneksi.php';
if (file_exists($requireDb)) require_once $requireDb;
require_once __DIR__ . '/../../models/jenisHewan.php';
require_once __DIR__ . '/../../models/rasHewan.php';
$jenisModel = new Jenis_hewan();
$rasModel = new rasHewan();
$jumlah_jenis = count($jenisModel->helper_fetch_all_jenis_hewan_from_db());
$jumlah_ras = count($rasModel->get_all());
include('../../views/partials/menu.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dokter</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <img src="../../assets/img/RSHP.png" alt="Logo RSHP">
            <div>
                <h1>Dashboard Dokter</h1>
                <div class="admin-info">Halo, <b><?php echo htmlspecialchars($_SESSION['user']['nama'] ?? ''); ?></b> &mdash; Anda login sebagai <b>Dokter</b>.</div>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="card">
                <div class="icon">🐾</div>
                <div class="card-title">Total Jenis Hewan</div>
                <div class="card-value"><?php echo $jumlah_jenis; ?></div>
                <a class="card-link" href="/roles/animal/JenisHewanView.php">Lihat Jenis Hewan &rarr;</a>
            </div>
            <div class="card">
                <div class="icon">🦴</div>
                <div class="card-title">Total Ras Hewan</div>
                <div class="card-value"><?php echo $jumlah_ras; ?></div>
                <a class="card-link" href="/roles/animal/RasHewanView.php">Lihat Ras Hewan &rarr;</a>
            </div>
        </div>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != 5) {
    header('Location: /views/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../controllers/ReservasiPemilikController.php';
require_once __DIR__ . '/../../models/Pemilik.php';
include('../../views/partials/menu.php');

$controller = new ReservasiPemilikController();
$iduser = $_SESSION['user']['id'];

// Cari idpemilik berdasarkan iduser
$pemilik = Pemilik::getByUserId($iduser);
$idpemilik = $pemilik ? $pemilik['idpemilik'] : null;

$reservasiList = [];
if ($idpemilik) {
    $reservasiList = $controller->getReservasiByPemilik($idpemilik);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi Saya - RSHP</title>
    <link rel="stylesheet" href="../../assets/css/reservasi_pemilik.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="rekam-medis-container">
        <h2 class="rekam-medis-title">Daftar Reservasi Saya</h2>
        <a href="dashboard_pemilik.php" class="tambah-rekammedis-btn">&larr; Kembali ke Dashboard</a>
        
        <?php if (!$idpemilik): ?>
            <div class="msg-error">
                <strong>Data pemilik tidak ditemukan!</strong><br>
                Sepertinya akun Anda belum terdaftar sebagai pemilik hewan.<br>
                Silakan hubungi admin untuk mendaftarkan data pemilik Anda.
            </div>
        <?php elseif (empty($reservasiList)): ?>
            <div class="msg-error">
                Anda belum memiliki reservasi pemeriksaan.<br>
                <small>Silakan lakukan reservasi melalui resepsionis untuk memeriksakan hewan peliharaan Anda.</small>
            </div>
        <?php else: ?>
            <table class="rekam-medis-table">
                <tr>
                    <th>No</th>
                    <th>ID Reservasi</th>
                    <th>Nama Pet</th>
                    <th>Dokter</th>
                    <th>No. Urut</th>
                    <th>Waktu Daftar</th>
                    <th>Status</th>
                </tr>
                <?php 
                $no = 1;
                foreach ($reservasiList as $reservasi): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="id-reservasi"><?= htmlspecialchars($reservasi['idreservasi_dokter']) ?></span></td>
                    <td><span class="pet-name"><?= htmlspecialchars($reservasi['nama_pet']) ?></span></td>
                    <td><span class="doctor-name"><?= htmlspecialchars($reservasi['nama_dokter'] ?? '-') ?></span></td>
                    <td><?= htmlspecialchars($reservasi['no_urut']) ?></td>
                    <td><span class="waktu-daftar"><?= htmlspecialchars($reservasi['waktu_daftar']) ?></span></td>
                    <td>
                        <?php 
                        $status = $reservasi['status'];
                        
                        // Handle numeric status (0 = tidak aktif, 1 = aktif)
                        if ($status == '0' || $status == 0) {
                            echo '<span class="status-tidak-aktif">Menunggu</span>';
                        } elseif ($status == '1' || $status == 1) {
                            echo '<span class="status-aktif">Selesai</span>';
                        } else {
                            echo '<span class="status-tidak-aktif">Menunggu</span>';
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>
</html>
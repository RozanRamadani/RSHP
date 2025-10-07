<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != 5) {
    header('Location: /views/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../controllers/RekamMedisPemilikController.php';
require_once __DIR__ . '/../../models/Pemilik.php';
include('../../views/partials/menu.php');

$controller = new RekamMedisPemilikController();
$iduser = $_SESSION['user']['id'];

// Cari idpemilik berdasarkan iduser
$pemilik = Pemilik::getByUserId($iduser);
$idpemilik = $pemilik ? $pemilik['idpemilik'] : null;

$rekamMedisList = [];
if ($idpemilik) {
    $rekamMedisList = $controller->getRekamMedisByPemilik($idpemilik);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis Pet Saya - RSHP</title>
    <link rel="stylesheet" href="../../assets/css/rekam_medis_pemilik.css">
</head>
<body>
    <div class="rekam-medis-container">
        <h2 class="rekam-medis-title">Rekam Medis Pet Saya</h2>
        <a href="dashboard_pemilik.php" class="tambah-rekammedis-btn">&larr; Kembali ke Dashboard</a>
        
        <?php if (!$idpemilik): ?>
            <div class="msg-error">
                <strong>Data pemilik tidak ditemukan!</strong><br>
                Sepertinya akun Anda belum terdaftar sebagai pemilik hewan.<br>
                Silakan hubungi admin untuk mendaftarkan data pemilik Anda.
            </div>
        <?php elseif (empty($rekamMedisList)): ?>
            <div class="msg-error">
                Belum ada rekam medis untuk hewan peliharaan Anda.<br>
                <small>Rekam medis akan tersedia setelah hewan peliharaan Anda menjalani pemeriksaan.</small>
            </div>
        <?php else: ?>
            <table class="rekam-medis-table">
                <tr>
                    <th>No</th>
                    <th>ID Rekam Medis</th>
                    <th>Nama Pet</th>
                    <th>Tanggal</th>
                    <th>Anamesis</th>
                    <th>Temuan Klinis</th>
                    <th>Diagnosa</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $no = 1;
                foreach ($rekamMedisList as $rekam): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="id-rekam-medis"><?= htmlspecialchars($rekam['idrekam_medis']) ?></span></td>
                    <td><span class="pet-name"><?= htmlspecialchars($rekam['nama_pet']) ?></span></td>
                    <td><span class="date-created"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($rekam['created_at']))) ?></span></td>
                    <td><div class="medical-text" title="<?= htmlspecialchars($rekam['anamesis']) ?>"><?= htmlspecialchars($rekam['anamesis']) ?></div></td>
                    <td><div class="medical-text" title="<?= htmlspecialchars($rekam['temuan_klinis']) ?>"><?= htmlspecialchars($rekam['temuan_klinis']) ?></div></td>
                    <td><div class="medical-text" title="<?= htmlspecialchars($rekam['diagnosa']) ?>"><?= htmlspecialchars($rekam['diagnosa']) ?></div></td>
                    <td><span class="doctor-name"><?= htmlspecialchars($rekam['nama_dokter'] ?? 'Dr. Tidak Diketahui') ?></span></td>
                    <td class="action-buttons">
                        <a href="DetailRekamMedisPemilikView.php?idrekam_medis=<?= htmlspecialchars($rekam['idrekam_medis']) ?>" class="btn-view-detail">Lihat Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != 5) {
    header('Location: /views/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../controllers/RekamMedisPemilikController.php';
require_once __DIR__ . '/../../models/KodeTindakanTerapi.php';
require_once __DIR__ . '/../../models/Kategori.php';
require_once __DIR__ . '/../../models/KategoriKlinis.php';
include('../../views/partials/menu.php');

$idrekam_medis = $_GET['idrekam_medis'] ?? '';
$controller = new RekamMedisPemilikController();

// Validasi rekam medis milik pemilik
$rekamMedis = $controller->show($idrekam_medis);
if (!$rekamMedis) {
    header('Location: RekamMedisPemilikView.php');
    exit;
}

$details = $controller->getDetailRekamMedis($idrekam_medis);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekam Medis Pet - RSHP</title>
    <link rel="stylesheet" href="../../assets/css/rekam_medis_pemilik.css">
</head>
<body>
    <div class="rekam-medis-container">
        <h2 class="rekam-medis-title">Detail Rekam Medis Pet</h2>
        <a href="RekamMedisPemilikView.php" class="tambah-rekammedis-btn">&larr; Kembali ke Rekam Medis</a>
        
        <div class="detail-info-card">
            <h3>Informasi Rekam Medis</h3>
            <p><strong>ID Rekam Medis:</strong> <?= htmlspecialchars($rekamMedis[0]['idrekam_medis']) ?></p>
            <p><strong>Tanggal:</strong> <?= htmlspecialchars($rekamMedis[0]['created_at']) ?></p>
            <p><strong>Anamesis:</strong> <?= htmlspecialchars($rekamMedis[0]['anamesis']) ?></p>
            <p><strong>Temuan Klinis:</strong> <?= htmlspecialchars($rekamMedis[0]['temuan_klinis']) ?></p>
            <p><strong>Diagnosa:</strong> <?= htmlspecialchars($rekamMedis[0]['diagnosa']) ?></p>
            <p><strong>Dokter Pemeriksa:</strong> <?= htmlspecialchars($rekamMedis[0]['nama_dokter'] ?? 'Tidak diketahui') ?></p>
        </div>

        <div class="therapy-section">
            <h3>Detail Tindakan dan Terapi</h3>
        <?php if (empty($details)): ?>
            <div class="msg-error">Belum ada detail tindakan untuk rekam medis ini.</div>
        <?php else: ?>
            <table class="rekam-medis-table">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Deskripsi Tindakan</th>
                    <th>Kategori</th>
                    <th>Kategori Klinis</th>
                    <th>Detail</th>
                </tr>
                <?php 
                $no = 1;
                foreach ($details as $detail): 
                    $tindakan = KodeTindakanTerapi::getById($detail['idkode_tindakan_terapi']);
                    $kategori = $tindakan ? Kategori::getById($tindakan['idkategori']) : null;
                    $klinis = $tindakan ? KategoriKlinis::getById($tindakan['idkategori_klinis']) : null;
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="therapy-code"><?= htmlspecialchars($tindakan ? $tindakan['kode'] : '-') ?></span></td>
                    <td><div class="medical-text" title="<?= htmlspecialchars($tindakan ? $tindakan['deskripsi_tindakan_terapi'] : '-') ?>"><?= htmlspecialchars($tindakan ? $tindakan['deskripsi_tindakan_terapi'] : '-') ?></div></td>
                    <td><span class="category-badge"><?= htmlspecialchars($kategori ? $kategori['nama_kategori'] : '-') ?></span></td>
                    <td><span class="clinical-category-badge"><?= htmlspecialchars($klinis ? $klinis['nama_kategori_klinis'] : '-') ?></span></td>
                    <td><div class="medical-text" title="<?= htmlspecialchars($detail['detail']) ?>"><?= htmlspecialchars($detail['detail']) ?></div></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        </div>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != 5) {
    header('Location: /views/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../controllers/PetPemilikController.php';
include('../../views/partials/menu.php');

require_once __DIR__ . '/../../models/Pemilik.php';

$controller = new PetPemilikController();
$iduser = $_SESSION['user']['id'];

// Cari idpemilik berdasarkan iduser
$pemilik = Pemilik::getByUserId($iduser);
$idpemilik = $pemilik ? $pemilik['idpemilik'] : null;

$petList = [];
if ($idpemilik) {
    $petList = $controller->getPetByPemilik($idpemilik);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pet Saya - RSHP</title>
    <link rel="stylesheet" href="../../assets/css/pet_pemilik_view.css">
</head>
<body>
    <div class="rekam-medis-container">
        <h2 class="rekam-medis-title">Daftar Pet Saya</h2>
        <a href="dashboard_pemilik.php" class="tambah-rekammedis-btn">&larr; Kembali ke Dashboard</a>
        
        <?php if (!$idpemilik): ?>
            <div class="msg-error">
                <strong>Data pemilik tidak ditemukan!</strong><br>
                Sepertinya akun Anda belum terdaftar sebagai pemilik hewan.<br>
                Silakan hubungi resepsionis untuk mendaftarkan data pemilik Anda.
            </div>
        <?php elseif (empty($petList)): ?>
            <div class="msg-error">
                Anda belum memiliki hewan peliharaan yang terdaftar.<br>
                <small>Silakan mendaftarkan hewan peliharaan Anda melalui resepsionis.</small>
            </div>
        <?php else: ?>
            <table class="rekam-medis-table">
                <tr>
                    <th>No</th>
                    <th>Nama Pet</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Warna/Tanda</th>
                    <th>Jenis Hewan</th>
                    <th>Ras</th>
                </tr>
                <?php 
                $no = 1;
                foreach ($petList as $pet): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($pet['nama']) ?></td>
                    <td><?= htmlspecialchars($pet['tanggal_lahir']) ?></td>
                    <td><?= htmlspecialchars($pet['jenis_kelamin']) ?></td>
                    <td><?= htmlspecialchars($pet['warna_tanda']) ?></td>
                    <td><?= htmlspecialchars($pet['nama_jenis_hewan'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($pet['nama_ras'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>
</html>
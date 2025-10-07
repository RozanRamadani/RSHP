<?php
session_start();
require_once __DIR__ . '/../../../models/DetailRekamMedis.php';
require_once __DIR__ . '/../../../models/KodeTindakanTerapi.php';
include('../../../views/partials/menu.php');


$idrekam_medis = $_GET['idrekam_medis'] ?? '';
$idrole = isset($_SESSION['idrole']) ? $_SESSION['idrole'] : null;
$detailRekamMedis = new DetailRekamMedis();
$details = $detailRekamMedis->getAllByRekamMedis($idrekam_medis);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/rekam_medis.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="rekam-medis-container">
    <h2 class="rekam-medis-title">Detail Rekam Medis</h2>
    <a href="RekamMedisView.php" class="tambah-rekammedis-btn">&larr; Kembali</a>

    <?php
    if (!empty($_SESSION['msg_detail'])) {
        $isSuccess = stripos($_SESSION['msg_detail'], 'berhasil') !== false;
        $class = $isSuccess ? 'msg-success' : 'msg-error';
        echo '<div class="' . $class . '">' . htmlspecialchars($_SESSION['msg_detail']) . '</div>';
        unset($_SESSION['msg_detail']);
    }
    ?>

    <table class="rekam-medis-table">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Deskripsi Tindakan</th>
            <th>Kategori</th>
            <th>Kategori Klinis</th>
            <th>Detail</th>
            <?php if ($idrole == 3): ?><th>Aksi</th><?php endif; ?>
        </tr>
        <?php 
        require_once __DIR__ . '/../../../models/Kategori.php';
        require_once __DIR__ . '/../../../models/KategoriKlinis.php';
        $no = 1; 
        foreach ($details as $detail): 
            $tindakan = KodeTindakanTerapi::getById($detail['idkode_tindakan_terapi']);
            $kategori = $tindakan ? Kategori::getById($tindakan['idkategori']) : null;
            $klinis = $tindakan ? KategoriKlinis::getById($tindakan['idkategori_klinis']) : null;
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($tindakan ? $tindakan['kode'] : '-') ?></td>
            <td><?= htmlspecialchars($tindakan ? $tindakan['deskripsi_tindakan_terapi'] : '-') ?></td>
            <td><?= htmlspecialchars($kategori ? $kategori['nama_kategori'] : '-') ?></td>
            <td><?= htmlspecialchars($klinis ? $klinis['nama_kategori_klinis'] : '-') ?></td>
            <td><?= htmlspecialchars($detail['detail']) ?></td>
            <?php if ($idrole == 3): ?>
            <td class="detail-action-buttons">
                <a href="EditDetailRekamMedisView.php?iddetail_rekam_medis=<?= htmlspecialchars($detail['iddetail_rekam_medis']) ?>" class="btn-edit-detail">Edit</a>
                <a href="DeleteDetailRekamMedisView.php?iddetail_rekam_medis=<?= htmlspecialchars($detail['iddetail_rekam_medis']) ?>" class="btn-delete-detail">Delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

<?php
session_start();
require_once __DIR__ . '/../../../controllers/RekamMedisController.php';
include('../../../views/partials/menu.php');

$idrekam_medis = isset($_GET['idrekam_medis']) ? intval($_GET['idrekam_medis']) : 0;
$controller = new RekamMedisController();
$rekam = $controller->show($idrekam_medis);
$msg = '';

if (!$rekam) {
    $msg = '<div class="msg-error">Data rekam medis tidak ditemukan!</div>';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->destroy($idrekam_medis);
    if ($res === true) {
        $_SESSION['flash_msg'] = 'Rekam medis berhasil dihapus.';
        header('Location: RekamMedisView.php');
        exit;
    } elseif ($res === 'FK_ERROR' || $res === 'DETAIL_EXIST') {
        $msg = '<div class="msg-error">Rekam medis tidak bisa dihapus sebelum detail rekam medis yang terkait dihapus.</div>';
    } else {
        $msg = '<div class="msg-error">Gagal menghapus rekam medis.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_rekam_medis.css">
</head>
<body>
    <div class="tambah-rekammedis-card">
        <h2 class="tambah-rekammedis-title">Hapus Rekam Medis</h2>
        <?= $msg ?>
        <?php if ($rekam): ?>
        <form method="post" action="">
            <p>Yakin ingin menghapus rekam medis dengan ID <b><?php echo htmlspecialchars($idrekam_medis); ?></b>?</p>
            <button type="submit" class="btn-tambah-rekammedis" style="background:#d32f2f;">Hapus</button>
            <a href="RekamMedisView.php">Batal</a>
        </form>
        <?php else: ?>
            <a href="RekamMedisView.php">&larr; Kembali ke Data Rekam Medis</a>
        <?php endif; ?>
    </div>
</body>
</html>
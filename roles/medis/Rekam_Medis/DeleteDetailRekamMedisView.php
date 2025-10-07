
<?php
session_start();
require_once __DIR__ . '/../../../controllers/DetailRekamMedisController.php';

$iddetail_rekam_medis = isset($_GET['iddetail_rekam_medis']) ? intval($_GET['iddetail_rekam_medis']) : 0;
$controller = new DetailRekamMedisController();
$detail = $controller->show($iddetail_rekam_medis);
$msg = '';

if (!$detail) {
    $msg = 'Detail rekam medis tidak ditemukan!';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->destroy($iddetail_rekam_medis);
    if ($res) {
        $msg = 'Detail rekam medis berhasil dihapus.';
        $detail = null;
    } else {
        $msg = 'Gagal menghapus detail rekam medis.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Detail Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/edit_delete_detail_rm.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="tambah-rekammedis-card">
        <h2 class="tambah-rekammedis-title">Hapus Detail Rekam Medis</h2>
        <?php 
        if ($msg) {
            $isSuccess = stripos($msg, 'berhasil') !== false;
            $class = $isSuccess ? 'msg-success' : 'msg-error';
            echo '<div class="' . $class . '">' . htmlspecialchars($msg) . '</div>';
        }
        ?>
        <?php if ($detail): ?>
        <form method="post" action="">
            <p>Yakin ingin menghapus detail rekam medis dengan ID <b><?php echo htmlspecialchars($iddetail_rekam_medis); ?></b>?</p>
            <button type="submit" class="btn-tambah-rekammedis" style="background:#d32f2f;">Hapus</button>
            <a href="DetailRekamMedisView.php?idrekam_medis=<?php echo htmlspecialchars($detail['idrekam_medis']); ?>">Batal</a>
        </form>
        <?php else: ?>
            <a href="DetailRekamMedisView.php?idrekam_medis=<?php echo isset($detail['idrekam_medis']) ? htmlspecialchars($detail['idrekam_medis']) : ''; ?>">&larr; Kembali ke Detail Rekam Medis</a>
        <?php endif; ?>
    </div>
</body>
</html>

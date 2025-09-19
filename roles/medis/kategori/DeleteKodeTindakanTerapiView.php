<?php
require_once __DIR__ . '/../../../controllers/KodeTindakanTerapiController.php';

$controller = new KodeTindakanTerapiController();
$message = '';
$idkode_tindakan_terapi = $_GET['idkode_tindakan_terapi'] ?? '';
$tindakan = $controller->getKodeTindakanTerapiById($idkode_tindakan_terapi);

if (!$tindakan) {
    $message = 'Kode tindakan terapi tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if ($controller->deleteKodeTindakanTerapi($idkode_tindakan_terapi)) {
            $message = 'Kode tindakan terapi berhasil dihapus!';
            echo '<meta http-equiv="refresh" content="2;url=KodeTindakanTerapiView.php">';
            $tindakan = null;
        } else {
            $message = 'Gagal menghapus kode tindakan terapi.';
        }
    } else {
        header('Location: KodeTindakanTerapiView.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Kode Tindakan Terapi</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kode_tindakan.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="delete-tindakan-container">
        <h2>Hapus Kode Tindakan Terapi</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($tindakan): ?>
        <form method="POST">
            <p>Apakah Anda yakin ingin menghapus kode tindakan <strong><?php echo htmlspecialchars($tindakan['kode']); ?></strong>?</p>
            <button type="submit" name="confirm" value="yes" class="hapus-btn">Hapus</button>
            <a href="KodeTindakanTerapiView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

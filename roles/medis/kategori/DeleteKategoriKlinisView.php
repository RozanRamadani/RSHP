<?php
require_once __DIR__ . '/../../../controllers/KategoriKlinisController.php';

$controller = new KategoriKlinisController();
$message = '';
$idkategori_klinis = $_GET['idkategori_klinis'] ?? '';
$kategori = $controller->getKategoriKlinisById($idkategori_klinis);

if (!$kategori) {
    $message = 'Kategori klinis tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if ($controller->deleteKategoriKlinis($idkategori_klinis)) {
            $message = 'Kategori klinis berhasil dihapus!';
            echo '<meta http-equiv="refresh" content="2;url=KategoriKlinisView.php">';
            $kategori = null;
        } else {
            $message = 'Gagal menghapus kategori klinis.';
        }
    } else {
        header('Location: KategoriKlinisView.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Kategori Klinis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori_klinis.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="delete-klinis-container">
        <h2>Hapus Kategori Klinis</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($kategori): ?>
        <form method="POST">
            <p>Apakah Anda yakin ingin menghapus kategori klinis <strong><?php echo htmlspecialchars($kategori['nama_kategori_klinis']); ?></strong>?</p>
            <button type="submit" name="confirm" value="yes" class="hapus-btn">Hapus</button>
            <a href="KategoriKlinisView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

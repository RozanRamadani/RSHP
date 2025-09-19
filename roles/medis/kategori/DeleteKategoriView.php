<?php
require_once __DIR__ . '/../../../controllers/KategoriController.php';

$controller = new KategoriController();
$message = '';
$idkategori = $_GET['idkategori'] ?? '';
$kategori = $controller->getKategoriById($idkategori);

if (!$kategori) {
    $message = 'Kategori tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if ($controller->deleteKategori($idkategori)) {
            $message = 'Kategori berhasil dihapus!';
            echo '<meta http-equiv="refresh" content="1;url=KategoriView.php">';
            $kategori = null;
        } else {
            $message = 'Gagal menghapus kategori.';
        }
    } else {
        header('Location: KategoriView.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus Kategori</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="delete-kategori-container">
        <h2>Hapus Kategori</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($kategori): ?>
        <form method="POST">
            <p>Apakah Anda yakin ingin menghapus kategori <strong><?php echo htmlspecialchars($kategori['nama_kategori']); ?></strong>?</p>
            <button type="submit" name="confirm" value="yes" class="hapus-btn">Hapus</button>
            <a href="KategoriView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

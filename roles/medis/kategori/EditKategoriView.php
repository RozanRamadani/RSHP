<?php
require_once __DIR__ . '/../../../controllers/KategoriController.php';

$controller = new KategoriController();
$message = '';
$idkategori = $_GET['idkategori'] ?? '';
$kategori = $controller->getKategoriById($idkategori);

if (!$kategori) {
    $message = 'Kategori tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'] ?? '';
    if ($controller->updateKategori($idkategori, $nama_kategori)) {
        $message = 'Kategori berhasil diupdate!';
        $kategori['nama_kategori'] = $nama_kategori;
    } else {
        $message = 'Gagal mengupdate kategori.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="edit-kategori-container">
        <h2>Edit Kategori</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($kategori): ?>
        <form method="POST">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" id="nama_kategori" name="nama_kategori" value="<?php echo htmlspecialchars($kategori['nama_kategori']); ?>" required>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KategoriView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

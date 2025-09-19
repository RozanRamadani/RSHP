<?php
require_once __DIR__ . '/../../../controllers/KategoriController.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'] ?? '';
    $controller = new KategoriController();
    if ($controller->createKategori($nama_kategori)) {
        $message = 'Kategori berhasil ditambahkan!';
    } else {
        $message = 'Gagal menambahkan kategori.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="tambah-kategori-container">
        <h2>Tambah Kategori</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <form method="POST">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" id="nama_kategori" name="nama_kategori" required>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KategoriView.php" class="batal-btn">Batal</a>
        </form>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

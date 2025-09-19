<?php
require_once __DIR__ . '/../../../controllers/KategoriKlinisController.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori_klinis = $_POST['nama_kategori_klinis'] ?? '';
    $controller = new KategoriKlinisController();
    if ($controller->createKategoriKlinis($nama_kategori_klinis)) {
        $message = 'Kategori klinis berhasil ditambahkan!';
    } else {
        $message = 'Gagal menambahkan kategori klinis.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori Klinis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori_klinis.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="tambah-klinis-container">
        <h2>Tambah Kategori Klinis</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <form method="POST">
            <label for="nama_kategori_klinis">Nama Kategori Klinis:</label>
            <input type="text" id="nama_kategori_klinis" name="nama_kategori_klinis" required>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KategoriKlinisView.php" class="batal-btn">Batal</a>
        </form>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

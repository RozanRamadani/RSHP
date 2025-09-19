<?php
require_once __DIR__ . '/../../../controllers/KategoriKlinisController.php';

$controller = new KategoriKlinisController();
$message = '';
$idkategori_klinis = $_GET['idkategori_klinis'] ?? '';
$kategori = $controller->getKategoriKlinisById($idkategori_klinis);

if (!$kategori) {
    $message = 'Kategori klinis tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori_klinis = $_POST['nama_kategori_klinis'] ?? '';
    if ($controller->updateKategoriKlinis($idkategori_klinis, $nama_kategori_klinis)) {
        $message = 'Kategori klinis berhasil diupdate!';
        $kategori['nama_kategori_klinis'] = $nama_kategori_klinis;
    } else {
        $message = 'Gagal mengupdate kategori klinis.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori Klinis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kategori_klinis.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="edit-klinis-container">
        <h2>Edit Kategori Klinis</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($kategori): ?>
        <form method="POST">
            <label for="nama_kategori_klinis">Nama Kategori Klinis:</label>
            <input type="text" id="nama_kategori_klinis" name="nama_kategori_klinis" value="<?php echo htmlspecialchars($kategori['nama_kategori_klinis']); ?>" required>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KategoriKlinisView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

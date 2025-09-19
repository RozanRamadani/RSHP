<?php
require_once __DIR__ . '/../../../controllers/KodeTindakanTerapiController.php';
require_once __DIR__ . '/../../../models/Kategori.php';
require_once __DIR__ . '/../../../models/KategoriKlinis.php';

$message = '';
$kategoriList = Kategori::getAll();
$klinisList = KategoriKlinis::getAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'] ?? '';
    $deskripsi = $_POST['deskripsi_tindakan_terapi'] ?? '';
    $idkategori = $_POST['idkategori'] ?? '';
    $idkategori_klinis = $_POST['idkategori_klinis'] ?? '';
    $controller = new KodeTindakanTerapiController();
    if ($controller->createKodeTindakanTerapi($kode, $deskripsi, $idkategori, $idkategori_klinis)) {
        $message = 'Kode tindakan terapi berhasil ditambahkan!';
    } else {
        $message = 'Gagal menambahkan kode tindakan terapi.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kode Tindakan Terapi</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kode_tindakan.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="tambah-tindakan-container">
        <h2>Tambah Kode Tindakan Terapi</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <form method="POST">
            <label for="kode">Kode:</label>
            <input type="text" id="kode" name="kode" required>
            <label for="deskripsi_tindakan_terapi">Deskripsi Tindakan:</label>
            <textarea id="deskripsi_tindakan_terapi" name="deskripsi_tindakan_terapi" required></textarea>
            <label for="idkategori">Kategori:</label>
            <select id="idkategori" name="idkategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategoriList as $kat): ?>
                    <option value="<?php echo $kat['idkategori']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="idkategori_klinis">Kategori Klinis:</label>
            <select id="idkategori_klinis" name="idkategori_klinis" required>
                <option value="">-- Pilih Kategori Klinis --</option>
                <?php foreach ($klinisList as $klinis): ?>
                    <option value="<?php echo $klinis['idkategori_klinis']; ?>"><?php echo htmlspecialchars($klinis['nama_kategori_klinis']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KodeTindakanTerapiView.php" class="batal-btn">Batal</a>
        </form>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

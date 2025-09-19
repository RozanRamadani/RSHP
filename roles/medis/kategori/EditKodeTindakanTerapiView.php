<?php
require_once __DIR__ . '/../../../controllers/KodeTindakanTerapiController.php';
require_once __DIR__ . '/../../../models/Kategori.php';
require_once __DIR__ . '/../../../models/KategoriKlinis.php';

$controller = new KodeTindakanTerapiController();
$message = '';
$idkode_tindakan_terapi = $_GET['idkode_tindakan_terapi'] ?? '';
$tindakan = $controller->getKodeTindakanTerapiById($idkode_tindakan_terapi);
$kategoriList = Kategori::getAll();
$klinisList = KategoriKlinis::getAll();

if (!$tindakan) {
    $message = 'Kode tindakan terapi tidak ditemukan.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'] ?? '';
    $deskripsi = $_POST['deskripsi_tindakan_terapi'] ?? '';
    $idkategori = $_POST['idkategori'] ?? '';
    $idkategori_klinis = $_POST['idkategori_klinis'] ?? '';
    if ($controller->updateKodeTindakanTerapi($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis)) {
        $message = 'Kode tindakan terapi berhasil diupdate!';
        $tindakan['kode'] = $kode;
        $tindakan['deskripsi_tindakan_terapi'] = $deskripsi;
        $tindakan['idkategori'] = $idkategori;
        $tindakan['idkategori_klinis'] = $idkategori_klinis;
    } else {
        $message = 'Gagal mengupdate kode tindakan terapi.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kode Tindakan Terapi</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_kode_tindakan.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('../../../views/partials/menu.php'); ?>
    <div class="edit-tindakan-container">
        <h2>Edit Kode Tindakan Terapi</h2>
        <?php if ($message): ?>
            <div class="message"> <?php echo htmlspecialchars($message); ?> </div>
        <?php endif; ?>
        <?php if ($tindakan): ?>
        <form method="POST">
            <label for="kode">Kode:</label>
            <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($tindakan['kode']); ?>" required>
            <label for="deskripsi_tindakan_terapi">Deskripsi Tindakan:</label>
            <textarea id="deskripsi_tindakan_terapi" name="deskripsi_tindakan_terapi" required><?php echo htmlspecialchars($tindakan['deskripsi_tindakan_terapi']); ?></textarea>
            <label for="idkategori">Kategori:</label>
            <select id="idkategori" name="idkategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategoriList as $kat): ?>
                    <option value="<?php echo $kat['idkategori']; ?>" <?php if ($tindakan['idkategori'] == $kat['idkategori']) echo 'selected'; ?>><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="idkategori_klinis">Kategori Klinis:</label>
            <select id="idkategori_klinis" name="idkategori_klinis" required>
                <option value="">-- Pilih Kategori Klinis --</option>
                <?php foreach ($klinisList as $klinis): ?>
                    <option value="<?php echo $klinis['idkategori_klinis']; ?>" <?php if ($tindakan['idkategori_klinis'] == $klinis['idkategori_klinis']) echo 'selected'; ?>><?php echo htmlspecialchars($klinis['nama_kategori_klinis']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="simpan-btn">Simpan</button>
            <a href="KodeTindakanTerapiView.php" class="batal-btn">Batal</a>
        </form>
        <?php endif; ?>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

<?php
session_start();
require_once __DIR__ . '/../../../controllers/RekamMedisController.php';
include('../../../views/partials/menu.php');

$idrekam_medis = $_GET['idrekam_medis'] ?? '';
$controller = new RekamMedisController();
$data = $controller->show($idrekam_medis);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anamesis = $_POST['anamesis'] ?? '';
    $temuan_klinis = $_POST['temuan_klinis'] ?? '';
    $diagnosa = $_POST['diagnosa'] ?? '';
    $result = $controller->update($idrekam_medis, $anamesis, $temuan_klinis, $diagnosa);
    if ($result) {
        $_SESSION['flash_msg'] = 'Rekam medis berhasil diupdate.';
        header('Location: RekamMedisView.php');
        exit;
    } else {
        $msg = '<div class="msg-error">Gagal update rekam medis.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_rekam_medis.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="tambah-rekammedis-card">
    <h2 class="tambah-rekammedis-title">Edit Rekam Medis</h2>
    <?= $msg ?>
    <form method="POST" class="tambah-rekammedis-form">
        <label for="anamesis">Anamesis</label>
        <input type="text" name="anamesis" id="anamesis" value="<?= htmlspecialchars($data['anamesis'] ?? '') ?>" required>

        <label for="temuan_klinis">Temuan Klinis</label>
        <input type="text" name="temuan_klinis" id="temuan_klinis" value="<?= htmlspecialchars($data['temuan_klinis'] ?? '') ?>" required>

        <label for="diagnosa">Diagnosa</label>
        <input type="text" name="diagnosa" id="diagnosa" value="<?= htmlspecialchars($data['diagnosa'] ?? '') ?>" required>

        <button type="submit" class="btn-tambah-rekammedis">Update</button>
        <a href="RekamMedisView.php" class="btn-batal-rekammedis">&larr; Kembali</a>
    </form>
</div>
<?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

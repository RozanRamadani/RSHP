<?php
session_start();
require_once __DIR__ . '/../../../controllers/DetailRekamMedisController.php';
require_once __DIR__ . '/../../../models/KodeTindakanTerapi.php';

$iddetail_rekam_medis = isset($_GET['iddetail_rekam_medis']) ? intval($_GET['iddetail_rekam_medis']) : 0;
$controller = new DetailRekamMedisController();
$detail = $controller->show($iddetail_rekam_medis);

if (!$detail) {
    $_SESSION['msg_detail'] = 'Detail rekam medis tidak ditemukan!';
    header('Location: DetailRekamMedisView.php?idrekam_medis=');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idkode_tindakan_terapi = $_POST['idkode_tindakan_terapi'] ?? '';
    $detail_text = $_POST['detail'] ?? '';
    $res = $controller->update($iddetail_rekam_medis, $idkode_tindakan_terapi, $detail_text);
    $_SESSION['msg_detail'] = $res ? 'Detail rekam medis berhasil diupdate.' : 'Gagal mengupdate detail rekam medis.';
    header('Location: DetailRekamMedisView.php?idrekam_medis=' . $detail['idrekam_medis']);
    exit;
}

$tindakanList = KodeTindakanTerapi::getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Detail Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/edit_delete_detail_rm.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="rekam-medis-container">
    <h2 class="rekam-medis-title">Edit Detail Rekam Medis</h2>
    <form method="post" action="">
        <label for="idkode_tindakan_terapi">Tindakan Terapi:</label>
        <select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" required>
            <?php foreach ($tindakanList as $tindakan): ?>
                <option value="<?= $tindakan['idkode_tindakan_terapi'] ?>" <?= $detail['idkode_tindakan_terapi'] == $tindakan['idkode_tindakan_terapi'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tindakan['kode'] . ' - ' . $tindakan['deskripsi_tindakan_terapi']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="detail">Detail:</label>
        <textarea name="detail" id="detail" required><?= htmlspecialchars($detail['detail']) ?></textarea>
        <br>
        <button type="submit" class="btn-edit-detail">Simpan Perubahan</button>
        <a href="DetailRekamMedisView.php?idrekam_medis=<?= htmlspecialchars($detail['idrekam_medis']) ?>">Batal</a>
    </form>
</div>
</body>
</html>

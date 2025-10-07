<?php
session_start();
require_once __DIR__ . '/../../../controllers/RekamMedisController.php';
require_once __DIR__ . '/../../../controllers/TemuDokterController.php';
include('../../../views/partials/menu.php');

$msg = '';
$temuDokterController = new TemuDokterController();
$reservasiList = $temuDokterController->getAllReservasiDokter();
require_once __DIR__ . '/../../../models/RoleUser.php';
$dokterList = RoleUser::getDokterList();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $created_at = date('Y-m-d H:i:s');
    $anamesis = $_POST['anamesis'] ?? '';
    $temuan_klinis = $_POST['temuan_klinis'] ?? '';
    $diagnosa = $_POST['diagnosa'] ?? '';
    $idreservasi_dokter = $_POST['idreservasi_dokter'] ?? '';
    $dokter_pemeriksa = $_POST['dokter_pemeriksa'] ?? '';
    $controller = new RekamMedisController();
    $result = $controller->store($created_at, $anamesis, $temuan_klinis, $diagnosa, $idreservasi_dokter, $dokter_pemeriksa);
    if ($result) {
        $_SESSION['flash_msg'] = 'Rekam medis berhasil ditambahkan.';
        header('Location: RekamMedisView.php');
        exit;
    } else {
        $msg = '<div class="msg-error">Gagal menambah rekam medis.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Rekam Medis</title>
    <link rel="stylesheet" href="../../../assets/css/tambah_rekam_medis.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="tambah-rekammedis-card">
        <h2 class="tambah-rekammedis-title">Tambah Rekam Medis</h2>
        <?= $msg ?>
        <form method="POST" class="tambah-rekammedis-form">
            <label for="idreservasi_dokter">Pasien</label>
            <select name="idreservasi_dokter" id="idreservasi_dokter" required>
                <option value="">-- Pilih Pasien --</option>
                <?php foreach ($reservasiList as $reservasi): ?>
                    <option value="<?= htmlspecialchars($reservasi['idreservasi_dokter']) ?>">
                        <?= htmlspecialchars($reservasi['nama_pet'] ?? 'Pet Tidak Diketahui') ?> (ID Reservasi: <?= htmlspecialchars($reservasi['idreservasi_dokter']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="dokter_pemeriksa">ID Dokter Pemeriksa</label>
            <select name="dokter_pemeriksa" id="dokter_pemeriksa" required>
                <option value="">-- Pilih Dokter Pemeriksa --</option>
                <?php foreach ($dokterList as $dokter): ?>
                    <option value="<?= htmlspecialchars($dokter['idrole_user']) ?>">
                        <?= htmlspecialchars($dokter['nama']) ?> (ID Role: <?= htmlspecialchars($dokter['idrole_user']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="anamesis">Anamesis</label>
            <input type="text" name="anamesis" id="anamesis" required>

            <label for="temuan_klinis">Temuan Klinis</label>
            <input type="text" name="temuan_klinis" id="temuan_klinis" required>

            <label for="diagnosa">Diagnosa</label>
            <input type="text" name="diagnosa" id="diagnosa" required>

            <button type="submit" class="btn-tambah-rekammedis">Tambah</button>
            <a href="RekamMedisView.php" class="btn-batal-rekammedis">&larr; Kembali</a>
        </form>
    </div>
    <?php include('../../../views/partials/footer.php'); ?>
</body>

</html>
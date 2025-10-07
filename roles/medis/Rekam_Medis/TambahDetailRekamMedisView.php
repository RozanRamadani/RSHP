<?php
session_start();
require_once __DIR__ . '/../../../models/DetailRekamMedis.php';
require_once __DIR__ . '/../../../models/KodeTindakanTerapi.php';

$msg = '';
$idrekam_medis = $_GET['idrekam_medis'] ?? '';
$kodeList = KodeTindakanTerapi::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$idrekam_medis = $_POST['idrekam_medis'] ?? '';
	$idkode_tindakan_terapi = $_POST['idkode_tindakan_terapi'] ?? '';
	$detail = $_POST['detail'] ?? '';
	$detailRekamMedis = new DetailRekamMedis();
	$result = $detailRekamMedis->insert($idrekam_medis, $idkode_tindakan_terapi, $detail);
	if ($result) {
		$_SESSION['flash_msg'] = 'Detail rekam medis berhasil ditambahkan.';
		header('Location: RekamMedisView.php');
		exit;
	} else {
		$msg = '<div class="msg-error">Gagal menambah detail rekam medis.</div>';
	}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Tambah Detail Rekam Medis</title>
	<link rel="stylesheet" href="../../../assets/css/tambah_detail_rekam_medis.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="tambah-detailrekammedis-card">
	<h2 class="tambah-detailrekammedis-title">Tambah Detail Rekam Medis</h2>
	<?= $msg ?>
	<form method="POST" class="tambah-detailrekammedis-form">
		<input type="hidden" name="idrekam_medis" value="<?= htmlspecialchars($idrekam_medis) ?>">

		<label for="idkode_tindakan_terapi">Tindakan Terapi</label>
		<select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" required>
			<option value="">-- Pilih Tindakan Terapi --</option>
			<?php foreach ($kodeList as $kode): ?>
				<option value="<?= htmlspecialchars($kode['idkode_tindakan_terapi']) ?>">
					<?= htmlspecialchars($kode['kode']) ?> - <?= htmlspecialchars($kode['deskripsi_tindakan_terapi']) ?>
				</option>
			<?php endforeach; ?>
		</select>

		<label for="detail">Deskripsi Detail</label>
		<textarea name="detail" id="detail" rows="3" required></textarea>

		<button type="submit" class="btn-tambah-detailrekammedis">Tambah</button>
		<a href="RekamMedisView.php" class="btn-batal-detailrekammedis">&larr; Kembali</a>
	</form>
</div>
</body>
</html>

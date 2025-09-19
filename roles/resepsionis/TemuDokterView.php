<?php
require_once __DIR__ . '/../../controllers/TemuDokterController.php';
require_once __DIR__ . '/../../models/Pet.php';
require_once __DIR__ . '/../../models/User.php';

$controller = new TemuDokterController();
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$idpet = $_POST['idpet'];
	$idrole_user = $_POST['idrole_user'];
	if ($controller->daftarTemuDokter($idpet, $idrole_user)) {
		header('Location: dashboard_resepsionis.php?success=1');
		exit;
	} else {
		$msg = "<div class='msg-error'>Gagal daftar temu dokter.</div>";
	}
}

// Ambil data pet dan dokter untuk dropdown
$petList = Pet::getAll();
$dokterList = User::getAllDokter(); // Pastikan fungsi ini hanya ambil user dokter

// Ambil antrian hari ini
$antrian = $controller->getAntrianHariIni();
?>
<?php include('../../views/partials/menu.php'); ?>
<link rel="stylesheet" href="../../../assets/css/temu_dokter.css">
<div class="temu-dokter-container">
	<h2>Daftar Temu Dokter</h2>
	<?= $msg ?>
	<form method="POST" class="temu-dokter-form">
		<label for="idpet">Pilih Pet:</label>
		<select name="idpet" required>
			<option value="">-- Pilih Pet --</option>
			<?php foreach ($petList as $pet): ?>
				<option value="<?= $pet['idpet'] ?>"><?= $pet['nama'] ?></option>
			<?php endforeach; ?>
		</select>
		<label for="idrole_user">Pilih Dokter:</label>
		<select name="idrole_user" required>
			<option value="">-- Pilih Dokter --</option>
			<?php foreach ($dokterList as $dokter): ?>
				<option value="<?= $dokter['iduser'] ?>"><?= $dokter['nama'] ?></option>
			<?php endforeach; ?>
		</select>
	<button type="submit" class="btn-daftar">Daftar Temu Dokter</button>
	</form>
	<!-- Tabel antrian dihapus, hanya form pendaftaran di halaman ini -->
	<a href="/roles/resepsionis/dashboard_resepsionis.php" class="btn-kembali-dashboard" style="display:inline-block;margin-top:24px;padding:10px 22px;background:#1976d2;color:#fff;border-radius:8px;text-decoration:none;font-weight:500;box-shadow:0 2px 8px #1976d222;transition:background 0.2s;">&larr; Kembali ke Dashboard Resepsionis</a>
</div>
<?php include('../../views/partials/footer.php'); ?>

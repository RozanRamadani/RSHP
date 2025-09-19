<?php
require_once __DIR__ . '/../../../controllers/PetController.php';
require_once __DIR__ . '/../../../models/rasHewan.php';
require_once __DIR__ . '/../../../controllers/PemilikController.php';

$idpet = isset($_GET['idpet']) ? $_GET['idpet'] : null;
$petController = new PetController();
$rasModel = new rasHewan();
$pemilikController = new PemilikController();

if (!$idpet) {
	echo '<script>alert("ID Pet tidak ditemukan");window.location="PetView.php";</script>';
	exit;
}

$pet = $petController->getById($idpet);
if (!$pet) {
	echo '<script>alert("Data Pet tidak ditemukan");window.location="PetView.php";</script>';
	exit;
}


$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nama = $_POST['nama'];
	$tanggal_lahir = $_POST['tanggal_lahir'];
	$warna_tanda = $_POST['warna_tanda'];
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$idpemilik = $_POST['idpemilik'];
	$idras_hewan = $_POST['idras_hewan'];
	$result = $petController->update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
	if ($result) {
		$msg = 'Data pet berhasil diupdate.';
		// Reload data agar form terupdate
		$pet = $petController->getById($idpet);
	} else {
		$msg = 'Gagal update data pet.';
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Edit Pet</title>
	</head>
	<link rel="stylesheet" href="../../../assets/css/tambah_pet.css?v=<?php echo time(); ?>">
</head>

<body>
	<?php include('../../../views/partials/menu.php'); ?>
	<div class="tambah-pet-container">
		<h2>Edit Data Pet</h2>
		<?php if (!empty($msg)): ?>
			<div class="msg-success" style="margin-bottom:18px;"> <?php echo htmlspecialchars($msg); ?> </div>
		<?php endif; ?>
		<form method="post" class="form-edit-pet">
			<label>Nama Pet</label>
			<input type="text" name="nama" value="<?php echo htmlspecialchars($pet['nama']); ?>" required>
			<label>Tanggal Lahir</label>
			<input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars($pet['tanggal_lahir']); ?>" required>
			<label>Warna/Tanda</label>
			<input type="text" name="warna_tanda" value="<?php echo htmlspecialchars($pet['warna_tanda']); ?>" required>
			<label>Jenis Kelamin</label>
			<select name="jenis_kelamin" required>
				<option value="J" <?php if($pet['jenis_kelamin']==='Jantan') echo 'selected'; ?>>Jantan</option>
				<option value="B" <?php if($pet['jenis_kelamin']==='Betina') echo 'selected'; ?>>Betina</option>
			</select>
			<label>Pemilik</label>
			<select name="idpemilik" required>
				<?php foreach ($pemilikController->pemilikList as $pemilik): ?>
					<option value="<?php echo $pemilik['idpemilik']; ?>" <?php if($pet['idpemilik']==$pemilik['idpemilik']) echo 'selected'; ?>><?php echo htmlspecialchars($pemilik['nama']); ?></option>
				<?php endforeach; ?>
			</select>
			<label>Ras Hewan</label>
			<select name="idras_hewan" required>
				<?php foreach ($rasModel->get_all() as $ras): ?>
					<option value="<?php echo $ras['idras_hewan']; ?>" <?php if($pet['idras_hewan']==$ras['idras_hewan']) echo 'selected'; ?>><?php echo htmlspecialchars($ras['nama_ras']); ?></option>
				<?php endforeach; ?>
			</select>
			<a href="PetView.php" class="back-link">Batal</a>
			<button type="submit" class="btn-simpan">Simpan</button>
		</form>
	</div>
	<?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

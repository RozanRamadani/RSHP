<?php
require_once __DIR__ . '/../../../controllers/PetController.php';

$idpet = isset($_GET['idpet']) ? $_GET['idpet'] : null;
$petController = new PetController();

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
	$result = $petController->delete($idpet);
	if ($result) {
		$msg = 'Data pet berhasil dihapus.';
		// Redirect ke PetView.php dengan pesan sukses
		header('Location: PetView.php?msg=deleted');
		exit;
	} else {
		$msg = 'Gagal menghapus data pet.';
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Hapus Pet</title>
	<link rel="stylesheet" href="../../../assets/css/tambah_pet.css?v=<?php echo time(); ?>">
</head>

<body>
	<?php include('../../../views/partials/menu.php'); ?>
	<div class="delete-card">
		<h2>Hapus Pet</h2>
		<?php if (!empty($msg)): ?>
			<div class="msg-success" style="margin-bottom:18px;"> <?php echo htmlspecialchars($msg); ?> </div>
		<?php endif; ?>
		<div class="delete-warning">
			Yakin ingin menghapus pet <b><?php echo htmlspecialchars($pet['nama']); ?></b>?
		</div>
		<form method="post">
			<button type="submit" class="delete-btn">Hapus</button>
			<a href="PetView.php" class="back-link">Batal</a>
		</form>
	</div>
	<?php include('../../../views/partials/footer.php'); ?>
</body>
</html>

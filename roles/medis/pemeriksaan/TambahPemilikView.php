<?php
session_start();
require_once __DIR__ . '/../../../controllers/PemilikController.php';
require_once __DIR__ . '/../../../models/User.php';

class TambahPemilikView
{
	public function render()
	{
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">

		<head>
			<meta charset="UTF-8">
			<title>Registrasi Pemilik</title>
			<link rel="stylesheet" href="../../../assets/css/tambah_pemilik.css?v=<?php echo time(); ?>">
		</head>

		<body>
			<?php include('../../../views/partials/menu.php'); ?>
			<div class="tambah-pemilik_container">
				<h2>Tambah Pemilik</h2>
				<?php
				if (isset($_SESSION['flash_msg'])) {
					$msg = $_SESSION['flash_msg'];
					unset($_SESSION['flash_msg']);
					echo '<div class="msg">' . htmlspecialchars($msg) . '</div>';
				}
				if (isset($_POST['tambah'])) {
					$iduser = $_POST['iduser'];
					$no_wa = $_POST['no_wa'];
					$alamat = $_POST['alamat'];
					$controller = new PemilikController();
					$result = $controller->store($iduser, $no_wa, $alamat);
					if ($result === true) {
						echo '<div class="msg" style="color:#258a5a;">Berhasil menambah pemilik!</div>';
					} else {
						echo '<div class="msg" style="color:#d32f2f;">' . htmlspecialchars($result) . '</div>';
					}
				}
				?>
				<?php
				// Ambil user yang BELUM menjadi pemilik (belum ada di tabel pemilik)
				$db = new Database();
				$sql = "SELECT u.iduser, u.nama, u.email FROM user u
			LEFT JOIN pemilik p ON u.iduser = p.iduser
			WHERE p.iduser IS NULL";
				$users = $db->select($sql);
				$selectedIdUser = isset($_GET['iduser']) ? $_GET['iduser'] : '';
				?>
				<form method="post">
					<label for="iduser">Pilih User:</label>
					<select id="iduser" name="iduser" required>
						<option value="">-- Pilih User --</option>
						<?php foreach ($users as $user): ?>
							<option value="<?= htmlspecialchars($user['iduser']) ?>" <?= ($selectedIdUser == $user['iduser']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($user['nama']) ?> (<?= htmlspecialchars($user['email']) ?>)
							</option>
						<?php endforeach; ?>
					</select>
					<label for="no_wa">No. WA:</label>
					<input type="text" id="no_wa" name="no_wa" required>
					<label for="alamat">Alamat:</label>
					<textarea id="alamat" name="alamat" required></textarea>
					<a href="PemilikView.php" class="back-link">Kembali</a>
					<button type="submit" name="tambah">Tambah Pemilik</button>
				</form>
			</div>
			<?php include('../../../views/partials/footer.php'); ?>
		</body>

		</html>
<?php
		return ob_get_clean();
	}
}

$view = new TambahPemilikView();
echo $view->render();

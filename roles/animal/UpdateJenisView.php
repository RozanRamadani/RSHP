
<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
	header('Location: ../../views/auth/login.php');
	exit;
}
require_once __DIR__ . '/../../controllers/JenisHewanController.php';
$controller = new JenisHewanController();

// Ambil data jenis hewan yang akan diupdate
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = $controller->show($id);
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$nama = trim($_POST['nama_jenis'] ?? '');
	if ($nama !== '') {
		$res = $controller->update($id, $nama);
		$msg = $res->message;
		// Refresh data setelah update
		$jenis = $controller->show($id);
	} else {
		$msg = 'Nama jenis hewan tidak boleh kosong!';
	}
}

class UpdateJenisView {
	private $msg;
	private $jenis;
	public function __construct($msg, $jenis) {
		$this->msg = $msg;
		$this->jenis = $jenis;
	}
	public function render() {
		ob_start();
		?>
		<!DOCTYPE html>
		<html lang="id">
		<head>
			<meta charset="UTF-8">
			<title>Update Jenis Hewan</title>
			<link rel="stylesheet" href="../../assets/css/tambah_jenis.css">
		</head>
		<body>
			<?php include('../../views/partials/menu.php'); ?>
			<div class="tambah-jenis-container">
				<h2>Update Jenis Hewan</h2>
				<?php 
					if ($this->msg) {
						if (strpos($this->msg, 'Berhasil') !== false) {
							echo '<div class="msg-success">' . $this->msg . '</div>';
						} else {
							echo '<div class="msg-error">' . $this->msg . '</div>';
						}
					}
				?>
				<form method="post" action="">
					<label for="nama_jenis">Nama Jenis Hewan</label>
					<input type="text" id="nama_jenis" name="nama_jenis" value="<?php echo htmlspecialchars($this->jenis['nama_jenis_hewan'] ?? ''); ?>" required autofocus>
					<button type="submit" class="tambah-jenis-btn">Update</button>
				</form>
				<a href="JenisHewanView.php">&larr; Kembali ke Data Jenis Hewan</a>
			</div>
			<?php include('../../views/partials/footer.php'); ?>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}
}

$view = new UpdateJenisView($msg, $jenis);
echo $view->render();

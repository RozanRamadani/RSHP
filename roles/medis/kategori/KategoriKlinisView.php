<?php
require_once __DIR__ . '/../../../controllers/KategoriKlinisController.php';

class KategoriKlinisView {
	private $kategoriKlinisList;
	public function __construct($kategoriKlinisList) {
		$this->kategoriKlinisList = $kategoriKlinisList;
	}
	public function render() {
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">
		<head>
			<meta charset="UTF-8">
			<title>Data Kategori Klinis</title>
			<link rel="stylesheet" href="../../../assets/css/kategori_klinis.css?v=<?php echo time(); ?>">
		</head>
		<body>
			<?php include('../../../views/partials/menu.php'); ?>
			<div class="kategori-klinis-container">
				<h2>Data Kategori Klinis</h2>
				<a href="TambahKategoriKlinisView.php" class="tambah-klinis-btn">Tambah Kategori Klinis</a>
				<table class="klinis-table">
					<thead>
						<tr>
							<th>ID Kategori Klinis</th>
							<th>Nama Kategori Klinis</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($this->kategoriKlinisList as $kategori) : ?>
							<tr>
								<td><?php echo htmlspecialchars($kategori['idkategori_klinis']); ?></td>
								<td><?php echo htmlspecialchars($kategori['nama_kategori_klinis']); ?></td>
								<td>
									<a href="EditKategoriKlinisView.php?idkategori_klinis=<?php echo urlencode($kategori['idkategori_klinis']); ?>" class="edit-btn">Edit</a>
									<a href="DeleteKategoriKlinisView.php?idkategori_klinis=<?php echo urlencode($kategori['idkategori_klinis']); ?>" class="delete-btn">Delete</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php include('../../../views/partials/footer.php'); ?>
		</body>
		</html>
<?php
		return ob_get_clean();
	}
}

$controller = new KategoriKlinisController();
$kategoriKlinisList = $controller->kategoriKlinisList;
$view = new KategoriKlinisView($kategoriKlinisList);
echo $view->render();

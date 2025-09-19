<?php
require_once __DIR__ . '/../../../controllers/KategoriController.php';

class KategoriView {
	private $kategoriList;
	public function __construct($kategoriList) {
		$this->kategoriList = $kategoriList;
	}
	public function render() {
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">
		<head>
			<meta charset="UTF-8">
			<title>Data Kategori</title>
			<link rel="stylesheet" href="../../../assets/css/kategori.css?v=<?php echo time(); ?>">
		</head>
		<body>
			<?php include('../../../views/partials/menu.php'); ?>
			<div class="kategori-container">
				<h2>Data Kategori</h2>
				<a href="TambahKategoriView.php" class="tambah-kategori-btn">Tambah Kategori</a>
				<table class="kategori-table">
					<thead>
						<tr>
							<th>ID Kategori</th>
							<th>Nama Kategori</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($this->kategoriList as $kategori) : ?>
							<tr>
								<td><?php echo htmlspecialchars($kategori['idkategori']); ?></td>
								<td><?php echo htmlspecialchars($kategori['nama_kategori']); ?></td>
								<td>
									<a href="EditKategoriView.php?idkategori=<?php echo urlencode($kategori['idkategori']); ?>" class="edit-btn">Edit</a>
									<a href="DeleteKategoriView.php?idkategori=<?php echo urlencode($kategori['idkategori']); ?>" class="delete-btn">Delete</a>
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

$controller = new KategoriController();
$kategoriList = $controller->kategoriList;
$view = new KategoriView($kategoriList);
echo $view->render();

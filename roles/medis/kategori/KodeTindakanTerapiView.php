<?php
require_once __DIR__ . '/../../../controllers/KodeTindakanTerapiController.php';
require_once __DIR__ . '/../../../models/Kategori.php';
require_once __DIR__ . '/../../../models/KategoriKlinis.php';

class KodeTindakanTerapiView {
	private $tindakanList;
	private $kategoriMap;
	private $klinisMap;
	public function __construct($tindakanList) {
		$this->tindakanList = $tindakanList;
		$this->kategoriMap = [];
		foreach (Kategori::getAll() as $kat) {
			$this->kategoriMap[$kat['idkategori']] = $kat['nama_kategori'];
		}
		$this->klinisMap = [];
		foreach (KategoriKlinis::getAll() as $klinis) {
			$this->klinisMap[$klinis['idkategori_klinis']] = $klinis['nama_kategori_klinis'];
		}
	}
	public function render() {
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">
		<head>
			<meta charset="UTF-8">
			<title>Data Kode Tindakan Terapi</title>
			<link rel="stylesheet" href="../../../assets/css/kode_tindakan_terapi.css?v=<?php echo time(); ?>">
		</head>
		<body>
			<?php include('../../../views/partials/menu.php'); ?>
			<div class="kode-tindakan-container">
				<h2>Data Kode Tindakan Terapi</h2>
				<a href="TambahKodeTindakanTerapiView.php" class="tambah-tindakan-btn">Tambah Kode Tindakan</a>
				<table class="tindakan-table">
					<thead>
						<tr>
							<th>ID Kode</th>
							<th>Kode</th>
							<th>Deskripsi Tindakan</th>
							<th>Kategori</th>
							<th>Kategori Klinis</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($this->tindakanList as $tindakan) : ?>
							<tr>
								<td><?php echo htmlspecialchars($tindakan['idkode_tindakan_terapi']); ?></td>
								<td><?php echo htmlspecialchars($tindakan['kode']); ?></td>
								<td><?php echo htmlspecialchars($tindakan['deskripsi_tindakan_terapi']); ?></td>
								<td><?php echo isset($this->kategoriMap[$tindakan['idkategori']]) ? htmlspecialchars($this->kategoriMap[$tindakan['idkategori']]) : '-'; ?></td>
								<td><?php echo isset($this->klinisMap[$tindakan['idkategori_klinis']]) ? htmlspecialchars($this->klinisMap[$tindakan['idkategori_klinis']]) : '-'; ?></td>
								<td>
									<div class="aksi-btn-group">
										<a href="EditKodeTindakanTerapiView.php?idkode_tindakan_terapi=<?php echo urlencode($tindakan['idkode_tindakan_terapi']); ?>" class="edit-btn">Edit</a>
										<a href="DeleteKodeTindakanTerapiView.php?idkode_tindakan_terapi=<?php echo urlencode($tindakan['idkode_tindakan_terapi']); ?>" class="delete-btn">Delete</a>
									</div>
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

$controller = new KodeTindakanTerapiController();
$tindakanList = $controller->tindakanList;
$view = new KodeTindakanTerapiView($tindakanList);
echo $view->render();

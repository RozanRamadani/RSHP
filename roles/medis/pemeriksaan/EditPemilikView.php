
<?php
require_once __DIR__ . '/../../../controllers/PemilikController.php';

class EditPemilikView {
    public function render($pemilik, $msg = '') {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Edit Pemilik</title>
            <link rel="stylesheet" href="../../../assets/css/tambah_pemilik.css?v=<?php echo time(); ?>">
        </head>
        <body>
            <?php include('../../../views/partials/menu.php'); ?>
            <div class="tambah-pemilik_container">
                <h2>Edit Pemilik</h2>
                <?php if ($msg): ?>
                    <div class="msg"><?= htmlspecialchars($msg) ?></div>
                <?php endif; ?>
                <form method="post">
                    <label for="no_wa">No. WA:</label>
                    <input type="text" id="no_wa" name="no_wa" value="<?= htmlspecialchars($pemilik['no_wa']) ?>" required>
                    <label for="alamat">Alamat:</label>
                    <textarea id="alamat" name="alamat" required><?= htmlspecialchars($pemilik['alamat']) ?></textarea>
                    <input type="hidden" name="idpemilik" value="<?= htmlspecialchars($pemilik['idpemilik']) ?>">
                    <a href="PemilikView.php" class="back-link">Kembali</a>
                    <button type="submit" name="edit">Simpan</button>
                </form>
            </div>
            <?php include('../../../views/partials/footer.php'); ?>
        </body>
        </html>
<?php
        return ob_get_clean();
    }
}

// Eksekusi controller dan view
$controller = new PemilikController();
$msg = '';
$idpemilik = isset($_GET['id']) ? $_GET['id'] : null;
if (!$idpemilik) {
    echo '<script>alert("ID pemilik tidak ditemukan");window.location="PemilikView.php";</script>';
    exit;
}
$pemilik = $controller->show($idpemilik);
if (!$pemilik) {
    echo '<script>alert("Data pemilik tidak ditemukan");window.location="PemilikView.php";</script>';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $no_wa = $_POST['no_wa'];
    $alamat = $_POST['alamat'];
    $idpemilik_post = $_POST['idpemilik'];
    $controller->update($idpemilik_post, $no_wa, $alamat);
    $msg = 'Berhasil update data pemilik.';
    // Reload data
    $pemilik = $controller->show($idpemilik_post);
}
$view = new EditPemilikView();
echo $view->render($pemilik, $msg);

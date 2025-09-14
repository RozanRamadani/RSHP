<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../controllers/JenisHewanController.php';

$msg = '';
$controller = new JenisHewanController();
$idjenis_hewan = isset($_GET['id']) ? intval($_GET['id']) : 0;
$jenis = $controller->show($idjenis_hewan);

if (!$jenis) {
    $msg = 'Data jenis hewan tidak ditemukan!';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->destroy($idjenis_hewan);
    $msg = $res->message;
    $jenis = null; // Data sudah dihapus
}

class DeleteJenisView {
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
            <title>Hapus Jenis Hewan</title>
            <link rel="stylesheet" href="../../assets/css/tambah_ras.css">
        </head>
        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="ras-table-container">
                <h2>Hapus Jenis Hewan</h2>
                <?php 
                if ($this->msg) {
                    $isSuccess = stripos($this->msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($this->msg) . '</div>';
                }
                ?>
                <?php if ($this->jenis): ?>
                <form method="post" action="">
                    <p>Yakin ingin menghapus jenis <b><?php echo htmlspecialchars($this->jenis['nama_jenis_hewan']); ?></b>?</p>
                    <button type="submit" class="tambah-ras-btn" style="background:#d32f2f;">Hapus</button>
                    <a href="JenisHewanView.php">Batal</a>
                </form>
                <?php else: ?>
                    <a href="JenisHewanView.php">&larr; Kembali ke Data Jenis Hewan</a>
                <?php endif; ?>
            </div>
            <?php include('../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

$view = new DeleteJenisView($msg, $jenis);
echo $view->render();

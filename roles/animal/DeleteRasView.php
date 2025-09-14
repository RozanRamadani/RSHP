<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../controllers/RasHewanController.php';

$msg = '';
$controller = new RasHewanController();
$idras_hewan = isset($_GET['id']) ? intval($_GET['id']) : 0;
$ras = $controller->show($idras_hewan);

if (!$ras) {
    $msg = 'Data ras tidak ditemukan!';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->destroy($idras_hewan);
    $msg = $res->message;
    $ras = null; // Data sudah dihapus
}

class DeleteRasView {
    private $msg;
    private $ras;
    public function __construct($msg, $ras) {
        $this->msg = $msg;
        $this->ras = $ras;
    }
    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Hapus Ras Hewan</title>
            <link rel="stylesheet" href="../../assets/css/tambah_ras.css">
        </head>
        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="ras-table-container">
                <h2>Hapus Ras Hewan</h2>
                <?php 
                if ($this->msg) {
                    $isSuccess = stripos($this->msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($this->msg) . '</div>';
                }
                ?>
                <?php if ($this->ras): ?>
                <form method="post" action="">
                    <p>Yakin ingin menghapus ras <b><?php echo htmlspecialchars($this->ras['nama_ras']); ?></b>?</p>
                    <button type="submit" class="tambah-ras-btn" style="background:#d32f2f;">Hapus</button>
                    <a href="RasHewanView.php">Batal</a>
                </form>
                <?php else: ?>
                    <a href="RasHewanView.php">&larr; Kembali ke Data Ras Hewan</a>
                <?php endif; ?>
            </div>
            <?php include('../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}


$view = new DeleteRasView($msg, $ras);
echo $view->render();

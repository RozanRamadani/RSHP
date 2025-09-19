<?php


session_start();
require_once __DIR__ . '/../../../controllers/PemilikController.php';

$msg = '';
$controller = new PemilikController();
$idpemilik = isset($_GET['id']) ? intval($_GET['id']) : 0;
$db = new Database();

$sql = "SELECT p.*, u.nama FROM pemilik p JOIN user u ON p.iduser = u.iduser WHERE p.idpemilik = ?";
$result = $db->select($sql, [$idpemilik], 'i');
$pemilik = ($result && count($result) > 0) ? $result[0] : null;

if (!$pemilik) {
    $msg = 'Data pemilik tidak ditemukan!';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($success, $msg) = $controller->delete($idpemilik);
    if ($success) {
        $pemilik = null;
    }
}

class DeletePemilikView {
    private $msg;
    private $pemilik;
    public function __construct($msg, $pemilik) {
        $this->msg = $msg;
        $this->pemilik = $pemilik;
    }
    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Hapus Pemilik</title>
            <link rel="stylesheet" href="../../../assets/css/delete_pemilik.css?v=<?php echo time(); ?>">
        </head>
        <body>
            <?php include('../../../views/partials/menu.php'); ?>
            <div class="delete-pemilik-container">
                <h2>Hapus Pemilik</h2>
                <?php 
                $isSuccess = stripos($this->msg, 'berhasil') !== false;
                $isError = stripos($this->msg, 'tidak bisa') !== false || stripos($this->msg, 'gagal') !== false;
                ?>
                <?php if ($isError): ?>
                    <div class="delete-msg-error"><?php echo htmlspecialchars($this->msg); ?></div>
                    <a href="PemilikView.php" class="delete-back-btn">&larr; Kembali ke Data Pemilik</a>
                <?php elseif ($this->pemilik): ?>
                    <form method="post" action="" class="form-hapus-pemilik">
                        <p>Yakin ingin menghapus pemilik <b><?php echo htmlspecialchars($this->pemilik['nama']); ?></b>?</p>
                        <button type="submit" class="btn-hapus-pemilik">Hapus</button>
                        <div class="batal-hapus-wrap">
                            <a href="PemilikView.php" class="btn-batal-hapus">Batal</a>
                        </div>
                    </form>
                <?php else: ?>
                    <a href="PemilikView.php" class="delete-back-btn">&larr; Kembali ke Data Pemilik</a>
                <?php endif; ?>
            </div>
            <?php include('../../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

$view = new DeletePemilikView($msg, $pemilik);
echo $view->render();

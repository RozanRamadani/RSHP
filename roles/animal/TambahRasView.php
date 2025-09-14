
<?php

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../controllers/RasHewanController.php';
$msg = '';
$controller = new RasHewanController();

// Ambil daftar jenis hewan untuk dropdown
$jenisList = $controller->getJenisList();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_ras = trim($_POST['nama_ras'] ?? '');
    $idjenis_hewan = intval($_POST['idjenis_hewan'] ?? 0);
    if ($nama_ras !== '' && $idjenis_hewan > 0) {
        $res = $controller->store($nama_ras, $idjenis_hewan);
        $msg = $res->message;
    } else {
        $msg = 'Nama ras dan jenis hewan wajib diisi!';
    }
}

class TambahRasView {
    private $msg;
    private $jenisList;
    public function __construct($msg, $jenisList) {
        $this->msg = $msg;
        $this->jenisList = $jenisList;
    }
    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Tambah Ras Hewan</title>
            <link rel="stylesheet" href="../../assets/css/tambah_ras.css">
        </head>
        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="ras-table-container">
                <h2>Tambah Ras Hewan</h2>
                <?php 
                if ($this->msg) {
                    $isSuccess = stripos($this->msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($this->msg) . '</div>';
                }
                ?>
                <form method="post" action="">
                    <label for="idjenis_hewan">Jenis Hewan</label>
                    <select name="idjenis_hewan" id="idjenis_hewan" required>
                        <option value="">-- Pilih Jenis Hewan --</option>
                        <?php foreach ($this->jenisList as $jenis): ?>
                            <option value="<?php echo $jenis['idjenis_hewan']; ?>"><?php echo htmlspecialchars($jenis['nama_jenis_hewan']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nama_ras">Nama Ras Hewan</label>
                    <input type="text" id="nama_ras" name="nama_ras" required>
                    <button type="submit" class="tambah-ras-btn">Tambah</button>
                </form>
                <a href="RasHewanView.php">&larr; Kembali ke Data Ras Hewan</a>
            </div>
            <?php include('../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

$view = new TambahRasView($msg, $jenisList);
echo $view->render();

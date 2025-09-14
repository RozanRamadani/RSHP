<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../controllers/RasHewanController.php';

$msg = '';
$controller = new RasHewanController();
$jenisList = $controller->getJenisList();

// Ambil data ras yang akan diedit
$idras_hewan = isset($_GET['id']) ? intval($_GET['id']) : 0;
$ras = $controller->show($idras_hewan);
if (!$ras) {
    $msg = 'Data ras tidak ditemukan!';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_ras = trim($_POST['nama_ras'] ?? '');
    $idjenis_hewan = intval($_POST['idjenis_hewan'] ?? 0);
    if ($nama_ras !== '' && $idjenis_hewan > 0) {
        $res = $controller->update($idras_hewan, $nama_ras, $idjenis_hewan);
        $msg = $res->message;
        // Refresh data ras setelah update
        $ras = $controller->show($idras_hewan);
    } else {
        $msg = 'Nama ras dan jenis hewan wajib diisi!';
    }
}

class UpdateRasView {
    private $msg;
    private $jenisList;
    private $ras;
    public function __construct($msg, $jenisList, $ras) {
        $this->msg = $msg;
        $this->jenisList = $jenisList;
        $this->ras = $ras;
    }
    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Update Ras Hewan</title>
            <link rel="stylesheet" href="../../assets/css/tambah_ras.css">
        </head>
        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="ras-table-container">
                <h2>Update Ras Hewan</h2>
                <?php 
                if ($this->msg) {
                    $isSuccess = stripos($this->msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($this->msg) . '</div>';
                }
                ?>
                <?php if ($this->ras): ?>
                <form method="post" action="">
                    <label for="idjenis_hewan">Jenis Hewan</label>
                    <select name="idjenis_hewan" id="idjenis_hewan" required>
                        <option value="">-- Pilih Jenis Hewan --</option>
                        <?php foreach ($this->jenisList as $jenis): ?>
                            <option value="<?php echo $jenis['idjenis_hewan']; ?>" <?php if ($jenis['idjenis_hewan'] == $this->ras['idjenis_hewan']) echo 'selected'; ?>><?php echo htmlspecialchars($jenis['nama_jenis_hewan']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nama_ras">Nama Ras Hewan</label>
                    <input type="text" id="nama_ras" name="nama_ras" value="<?php echo htmlspecialchars($this->ras['nama_ras']); ?>" required>
                    <button type="submit" class="tambah-ras-btn">Update</button>
                </form>
                <?php else: ?>
                    <div class="msg-error">Data ras tidak ditemukan!</div>
                <?php endif; ?>
                <a href="RasHewanView.php">&larr; Kembali ke Data Ras Hewan</a>
            </div>
            <?php include('../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

$view = new UpdateRasView($msg, $jenisList, $ras);
echo $view->render();

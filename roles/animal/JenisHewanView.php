<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../controllers/JenisHewanController.php';

class JenisHewanView
{
    private $jenisList;

    // kirim data dari controller ke view
    public function __construct($jenisList)
    {
        $this->jenisList = $jenisList;
    }

    public function render()
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Data Jenis Hewan</title>
            <link rel="stylesheet" href="../../assets/css/jenis_hewan.css?v=<?php echo time(); ?>">
        </head>

        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="jenis-table-container">
                <h2>Jenis Hewan</h2>
                <?php 
                if (isset($_SESSION['flash_msg'])) {
                    $msg = $_SESSION['flash_msg'];
                    unset($_SESSION['flash_msg']);
                    $isSuccess = stripos($msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($msg) . '</div>';
                }
                ?>
                <a href="TambahJenisView.php" class="tambah-jenis-btn">Tambah Jenis Hewan</a>
                <table class="jenis-table">
                    <thead>
                        <tr>
                            <th>Nama Jenis Hewan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->jenisList as $jenis) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($jenis['nama_jenis_hewan']); ?></td>
                                <td>
                                    <a href="UpdateJenisView.php?id=<?php echo $jenis['idjenis_hewan']; ?>" class="aksi-link edit-link">Update</a>
                                    <a href="DeleteJenisView.php?id=<?php echo $jenis['idjenis_hewan']; ?>" class="aksi-link delete-link">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Konfirmasi hapus kembali ke confirm() bawaan browser -->
            <?php include('../../views/partials/footer.php'); ?>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}



// Ambil data dari controller
$controller = new JenisHewanController();
$jenisList = $controller->index();
$view = new JenisHewanView($jenisList);
echo $view->render();

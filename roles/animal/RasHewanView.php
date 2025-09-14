<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}

require_once __DIR__ . '/../../controllers/RasHewanController.php';


class RasHewanView
{
    private $jenisList;
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
            <title>Data Ras Hewan</title>
            <link rel="stylesheet" href="../../assets/css/ras_hewan.css">
            <link rel="stylesheet" href="../../assets/css/bulk_delete_ras.css">
        </head>

        <body>
            <?php include('../../views/partials/menu.php'); ?>
            <div class="ras-table-container">
                <h2>Data Ras Hewan</h2>

                <?php 
                if (isset($_SESSION['flash_msg'])) {
                    $msg = $_SESSION['flash_msg'];
                    unset($_SESSION['flash_msg']);
                    $isSuccess = stripos($msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($msg) . '</div>';
                }
                ?>
                
                <div class="bulk-action-bar">
                    <a href="TambahRasView.php" class="tambah-ras-btn">Tambah Ras</a>
                    <button type="submit" form="bulkDeleteForm" class="bulk-delete-btn">Hapus Terpilih</button>
                </div>
                <form method="post" action="" id="bulkDeleteForm">
                <table class="ras-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" onclick="toggleAll(this)"></th>
                            <th>Jenis</th>
                            <th>Ras</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->jenisList as $jenis) : ?>
                            <?php
                            $rowspan = !empty($jenis['ras']) ? count($jenis['ras']) : 1;
                            $first = true;
                            if (!empty($jenis['ras'])):
                                foreach ($jenis['ras'] as $ras):
                            ?>
                                    <tr>
                                        <?php if ($first): ?>
                                            <td rowspan="<?php echo $rowspan; ?>">&nbsp;</td>
                                            <td rowspan="<?php echo $rowspan; ?>"><?php echo htmlspecialchars($jenis['nama_jenis_hewan']); ?></td>
                                        <?php $first = false;
                                        endif; ?>
                                        <td>
                                            <input type="checkbox" name="ids[]" value="<?php echo $ras['idras_hewan']; ?>">
                                            <?php echo htmlspecialchars($ras['nama_ras']); ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="UpdateRasView.php?id=<?php echo $ras['idras_hewan']; ?>" class="aksi-link edit-link">Update</a>
                                            <a href="DeleteRasView.php?id=<?php echo $ras['idras_hewan']; ?>" class="aksi-link delete-link">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo htmlspecialchars($jenis['nama_jenis_hewan']); ?></td>
                                    <td><span style="color:#888;">Belum ada ras</span></td>
                                    <td style="text-align:center;"></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </form>
                <script>
                // Toggle semua checkbox
                function toggleAll(source) {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="ids[]"]');
                    for (var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = source.checked;
                    }
                }
                </script>
            </div>
            <?php include('../../views/partials/footer.php'); ?>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}



$controller = new RasHewanController();

// Proses bulk delete jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && is_array($_POST['ids'])) {
    $success = 0;
    $fail = 0;
    foreach ($_POST['ids'] as $id) {
        $res = $controller->destroy((int)$id);
        if ($res->status) $success++; else $fail++;
    }
    // Simpan pesan ke session dan redirect (ketempat yg sama) untuk menghindari resubmission
    $_SESSION['flash_msg'] = "$success ras berhasil dihapus. $fail gagal.";
    header('Location: RasHewanView.php');
    exit;
}
$jenisList = $controller->index();
$view = new RasHewanView($jenisList);
echo $view->render();

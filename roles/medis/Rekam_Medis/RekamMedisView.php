<?php
session_start();
require_once __DIR__ . '/../../../controllers/RekamMedisController.php';
require_once __DIR__ . '/../../../controllers/DetailRekamMedisController.php';
require_once __DIR__ . '/../../../controllers/TemuDokterController.php';
include('../../../views/partials/menu.php');

class RekamMedisView
{
    public $rekamMedisList;
    public $detailController;
    public function __construct($rekamMedisList, $detailController)
    {
        $this->rekamMedisList = $rekamMedisList;
        $this->detailController = $detailController;
    }
    public function render()
    {
        $idrole = isset($_SESSION['idrole']) ? $_SESSION['idrole'] : null;
        ob_start();
?>
        <div style="text-align:right; margin-bottom:16px;">
        </div>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Data Rekam Medis</title>
            <link rel="stylesheet" href="../../../assets/css/rekam_medis.css?v=<?php echo time(); ?>">
        </head>

        <body>
            <div class="rekam-medis-container">
                <?php if (!empty($_SESSION['flash_msg'])): ?>
                    <?php $isSuccess = stripos($_SESSION['flash_msg'], 'berhasil') !== false; ?>
                    <div class="<?= $isSuccess ? 'msg-success' : 'msg-error' ?>" style="margin-bottom:16px;">
                        <?= htmlspecialchars($_SESSION['flash_msg']) ?>
                    </div>
                    <?php unset($_SESSION['flash_msg']); ?>
                <?php endif; ?>
                <h2 class="rekam-medis-title">Data Rekam Medis</h2>
                <?php if ($idrole == 3): ?>
                    <a href="TambahRekamMedisView.php" class="tambah-rekammedis-btn">Tambah Rekam Medis</a>
                <?php endif; ?>
                <table class="rekam-medis-table">
                    <tr>
                        <th>ID</th>
                        <th>ID Reservasi</th>
                        <th>Nama Pet</th>
                        <th>Anamesis</th>
                        <th>Temuan Klinis</th>
                        <th>Diagnosa</th>
                        <th>Dokter Pemeriksa</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($this->rekamMedisList as $rekam): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($rekam['idrekam_medis']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['idreservasi_dokter']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['nama_pet'] ?? 'Pet Tidak Diketahui'); ?></td>
                            <td><?php echo htmlspecialchars($rekam['anamesis']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['temuan_klinis']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['diagnosa']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['dokter_pemeriksa']); ?></td>
                            <td><?php echo htmlspecialchars($rekam['created_at']); ?></td>
                            <td class="action-buttons">
                                <a href="DetailRekamMedisView.php?idrekam_medis=<?= htmlspecialchars($rekam['idrekam_medis']) ?>" class="btn-view-detail">View</a>
                                <?php if ($idrole == 3): ?>
                                    <a href="TambahDetailRekamMedisView.php?idrekam_medis=<?= htmlspecialchars($rekam['idrekam_medis']) ?>" class="btn-tambah-detail">Tambah</a>
                                    <a href="EditRekamMedisView.php?idrekam_medis=<?= htmlspecialchars($rekam['idrekam_medis']) ?>" class="btn-edit-rekammedis">Edit</a>
                                    <a href="DeleteRekamMedisView.php?idrekam_medis=<?= htmlspecialchars($rekam['idrekam_medis']) ?>" class="btn-delete-rekammedis">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php include('../../../views/partials/footer.php'); ?>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}



$rekamMedisController = new RekamMedisController();
$detailController = new DetailRekamMedisController();
$rekamMedisList = $rekamMedisController->index();
$view = new RekamMedisView($rekamMedisList, $detailController);
echo $view->render();

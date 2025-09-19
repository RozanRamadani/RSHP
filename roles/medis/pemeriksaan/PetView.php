<?php

session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../../controllers/PetController.php';
require_once __DIR__ . '/../../../controllers/PemilikController.php';
require_once __DIR__ . '/../../../models/rasHewan.php';

class PetView
{
    private $petList;
    private $pemilikMap;
    private $rasMap;
    public function __construct($petList)
    {
        $this->petList = $petList;
        // Build pemilik map: idpemilik => nama
        $pemilikController = new PemilikController();
        $this->pemilikMap = [];
        foreach ($pemilikController->pemilikList as $pemilik) {
            $this->pemilikMap[$pemilik['idpemilik']] = $pemilik['nama'];
        }
        // Build ras map: idras_hewan => nama_ras
        $rasModel = new rasHewan();
        $this->rasMap = [];
        foreach ($rasModel->get_all() as $ras) {
            $this->rasMap[$ras['idras_hewan']] = $ras['nama_ras'];
        }
    }
    public function render()
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Data Pet</title>
            <link rel="stylesheet" href="../../../assets/css/pet.css?v=<?php echo time(); ?>">
        </head>

        <body>
            <?php include('../../../views/partials/menu.php'); ?>
            <div class="pet-container">
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                    <div class="msg-success" style="margin-bottom:18px;">Data pet berhasil dihapus.</div>
                <?php endif; ?>
                <h2>Data Pet</h2>
                <a href="TambahPet.php" class="tambah-jenis-btn">Tambah Pet</a>
                <table class="pet-table">
                    <thead>
                        <tr>
                            <th>ID Pet</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Warna/Tanda</th>
                            <th>Jenis Kelamin</th>
                            <th>Pemilik</th>
                            <th>Ras Hewan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->petList as $pet) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pet['idpet']); ?></td>
                                <td><?php echo htmlspecialchars($pet['nama']); ?></td>
                                <td><?php echo htmlspecialchars($pet['tanggal_lahir']); ?></td>
                                <td><?php echo htmlspecialchars($pet['warna_tanda']); ?></td>
                                <td><?php echo htmlspecialchars($pet['jenis_kelamin']); ?></td>
                                <td><?php echo isset($this->pemilikMap[$pet['idpemilik']]) ? htmlspecialchars($this->pemilikMap[$pet['idpemilik']]) : '-'; ?></td>
                                <td><?php echo isset($this->rasMap[$pet['idras_hewan']]) ? htmlspecialchars($this->rasMap[$pet['idras_hewan']]) : '-'; ?></td>
                                <td>
                                    <div class="aksi-btn-group">
                                        <a href="EditPetView.php?idpet=<?php echo urlencode($pet['idpet']); ?>" class="edit-btn">Edit</a>
                                        <a href="DeletePetView.php?idpet=<?php echo urlencode($pet['idpet']); ?>" class="delete-btn">Delete</a>
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

$controller = new PetController();
$petList = $controller->petList;
$view = new PetView($petList);
echo $view->render();

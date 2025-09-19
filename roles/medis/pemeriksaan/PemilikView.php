<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || !in_array($_SESSION['user']['role_aktif'], ['1','2','3'])) {
    header('Location: ../../../views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../../controllers/PemilikController.php';
require_once __DIR__ . '/../../../models/User.php';

class DataPemilikView {
    public $pemilikList;
    public function __construct($pemilikList) {
        $this->pemilikList = $pemilikList;
    }
    public function render() {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Data Pemilik</title>
            <link rel="stylesheet" href="../../../assets/css/pemilik.css?v=<?php echo time(); ?>">
        </head>
        <body>
            <?php include('../../../views/partials/menu.php'); ?>
            <div class="pemilik-table-container">
                <h2>Data Pemilik</h2>
                <?php 
                if (isset($_SESSION['flash_msg'])) {
                    $msg = $_SESSION['flash_msg'];
                    unset($_SESSION['flash_msg']);
                    $isSuccess = stripos($msg, 'berhasil') !== false;
                    $class = $isSuccess ? 'msg-success' : 'msg-error';
                    echo '<div class="' . $class . '">' . htmlspecialchars($msg) . '</div>';
                }
                ?>
                <a href="TambahPemilikView.php" class="tambah-pemilik-btn">Tambah Pemilik</a>
                <table class="pemilik-table">
                    <thead>
                        <tr>
                            <th>ID Pemilik</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->pemilikList as $pemilik) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pemilik['idpemilik']); ?></td>
                                <td><?php echo htmlspecialchars($pemilik['nama']); ?></td>
                                <td><?php echo htmlspecialchars($pemilik['email']); ?></td>
                                <td><?php echo htmlspecialchars($pemilik['no_wa']); ?></td>
                                <td><?php echo htmlspecialchars($pemilik['alamat']); ?></td>
                                <td>
                                    <a href="EditPemilikView.php?id=<?php echo urlencode($pemilik['idpemilik']); ?>" class="aksi-btn aksi-edit">Edit</a>
                                    <a href="DeletePemilikView.php?id=<?php echo urlencode($pemilik['idpemilik']); ?>" class="aksi-btn aksi-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
<?php
        return ob_get_clean();
    }
}

$controller = new PemilikController();
$pemilikList = $controller->pemilikList;
$view = new DataPemilikView($pemilikList);
echo $view->render();

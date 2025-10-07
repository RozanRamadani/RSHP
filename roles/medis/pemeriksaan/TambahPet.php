<?php
require_once __DIR__ . '/../../../controllers/PetController.php';
require_once __DIR__ . '/../../../controllers/PemilikController.php';


require_once __DIR__ . '/../../../controllers/rasHewanController.php';
class TambahPetView {
    public function render() {
        $msg = '';
        $controller = new PetController();
        $pemilikController = new PemilikController();
        $pemilikList = $pemilikController->pemilikList;
        $rasController = new RasHewanController();
        $rasList = (new rasHewan())->get_all();
        if (isset($_POST['tambah'])) {
            $nama = $_POST['nama'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $warna_tanda = $_POST['warna_tanda'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $idpemilik = $_POST['idpemilik'];
            $idras_hewan = $_POST['idras_hewan'];
            $result = $controller->store($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
            if ($result) {
                $msg = '<div class="msg-success">Berhasil menambah data hewan!</div>';
            } else {
                $msg = '<div class="msg-error">Gagal menambah data hewan.</div>';
            }
        }
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Registrasi Pet</title>
            <link rel="stylesheet" href="../../../assets/css/tambah_pet.css?v=<?php echo time(); ?>">
        </head>
        <body>
            <?php include('../../../views/partials/menu.php'); ?>
            <div class="tambah-pet-container">
                <h2>Registrasi Pet</h2>
                <?php echo $msg; ?>
                <form method="post">
                    <label for="nama">Nama Pet:</label>
                    <input type="text" id="nama" name="nama" required>
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir">
                    <label for="warna_tanda">Warna/Tanda:</label>
                    <input type="text" id="warna_tanda" name="warna_tanda">
                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="J">Jantan</option>
                        <option value="B">Betina</option>
                    </select>
                    <label for="idpemilik">Pemilik:</label>
                    <select id="idpemilik" name="idpemilik" required>
                        <option value="">-- Pilih Pemilik --</option>
                        <?php foreach ($pemilikList as $pemilik): ?>
                            <option value="<?= htmlspecialchars($pemilik['idpemilik']) ?>">
                                <?= htmlspecialchars($pemilik['nama']) ?> (<?= htmlspecialchars($pemilik['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="idras_hewan">Ras Hewan:</label>
                    <select id="idras_hewan" name="idras_hewan" required>
                        <option value="">-- Pilih Ras Hewan --</option>
                        <?php foreach ($rasList as $ras): ?>
                            <option value="<?= htmlspecialchars($ras['idras_hewan']) ?>">
                                <?= htmlspecialchars($ras['nama_ras']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <a href="PetView.php" class="back-link">Kembali</a>
                    <button type="submit" name="tambah">Tambah Pet</button>
                </form>
            </div>
            <?php include('../../../views/partials/footer.php'); ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

$view = new TambahPetView();
echo $view->render();

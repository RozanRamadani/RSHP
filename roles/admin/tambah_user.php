
<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
}

class TambahUserView {
    private $controller;
    public function __construct($controller) {
        $this->controller = $controller;
    }
    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Tambah User</title>
            <link rel="stylesheet" href="../../assets/css/tambah_user.css">
        </head>
        <body>
            <?php include("../../views/partials/menu.php"); ?>
            <div class="tambah-user-container">
                <h2>Tambah User</h2>
                <?php if ($this->controller->msg) echo '<div class="msg">' . $this->controller->msg . '</div>'; ?>
                <form method="post">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="retype">Retype Password:</label>
                    <input type="password" id="retype" name="retype" required>
                    <button type="submit" name="tambah">Tambah</button>
                    <a class="back-link" href="data_user.php">Kembali</a>
                </form>
            </div>
        </body>
        <?php include('../../views/partials/footer.php'); ?>
        </html>
        <?php
        return ob_get_clean();
    }
}

require_once __DIR__ . '/../../controllers/TambahUserController.php';
$controller = new TambahUserController();
$view = new TambahUserView($controller);
echo $view->render();
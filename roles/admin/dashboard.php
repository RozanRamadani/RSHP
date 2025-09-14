<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_aktif']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: /views/auth/login.php');
    exit;
}
require_once __DIR__ . '/../../databases/koneksi.php';

class DashboardView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : ['nama' => ''];
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Dashboard Admin RSHP</title>
            <link rel="stylesheet" href="aset/tugas1.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="../../assets/css/dashboard.css">
        </head>

        <body>
            <?php include("../../views/partials/menu.php"); ?>
            <div class="dashboard-container">
                <div class="dashboard-header">
                    <img src="../../assets/img/RSHP.png" alt="Logo RSHP">
                    <div>
                        <h1>Dashboard Admin RSHP</h1>
                        <div class="admin-info">Halo, <b><?php echo htmlspecialchars($user['nama'] ?? ''); ?></b> &mdash; Anda login sebagai <b>Administrator</b>.</div>
                    </div>
                </div>
                <div class="dashboard-cards">
                    <div class="card">
                        <div class="icon">👤</div>
                        <div class="card-title">Total User</div>
                        <div class="card-value"><?php echo $this->controller->jml_user; ?></div>
                        <a class="card-link" href="data_user.php">Lihat Data User &rarr;</a>
                    </div>
                    <div class="card">
                        <div class="icon">🛡️</div>
                        <div class="card-title">Total Role</div>
                        <div class="card-value"><?php echo $this->controller->jml_role; ?></div>
                        <a class="card-link" href="datamaster_role_user.php">Lihat Manajemen Role &rarr;</a>
                    </div>
                    <div class="card">
                        <div class="icon">🔗</div>
                        <div class="card-title">Total Relasi User-Role</div>
                        <div class="card-value"><?php echo $this->controller->jml_role_user; ?></div>
                        <a class="card-link" href="datamaster_role_user.php">Lihat Relasi &rarr;</a>
                    </div>
                </div>
                <div class="dashboard-welcome">
                    Selamat datang di <b>Dashboard Admin RSHP</b>. Anda dapat mengelola data user, role, dan hak akses melalui menu di atas.<br>
                    <span style="color:#888; font-size:0.98em;">Rumah Sakit Hewan Pendidikan Universitas Airlangga</span>
                </div>
            </div>
        </body>
        <?php include('../../views/partials/footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

require_once __DIR__ . '/../../controllers/DashboardController.php';
$controller = new DashboardController();
$view = new DashboardView($controller);
echo $view->render();

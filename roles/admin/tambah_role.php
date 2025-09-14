<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: /views/auth/login.php');
    exit();
}


class TambahRoleView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        ob_start();
        $iduser = $this->controller->iduser;
        $nama_user = $this->controller->nama_user;
        $roles = $this->controller->roles;
        $msg = $this->controller->msg;
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Tambah Role User</title>
            <link rel="stylesheet" href="../../assets/css/tambah_role.css">

        </head>

        <body>
            <?php include("../../views/partials/menu.php"); ?>
            <div class="role-form-container">
                <h2>Tambah Role untuk User:<br> <span style="color:#222; font-size:1.1em; font-weight:600;"> <?= htmlspecialchars($nama_user) ?> </span> <span style="font-size:0.95em; color:#888;">(ID: <?= $iduser ?>)</span></h2>
                <?php if ($msg) echo '<div class="msg">' . $msg . '</div>'; ?>
                <form method="post">
                    <label for="idrole">Pilih Role:</label>
                    <select name="idrole" id="idrole" required>
                        <option value="">-- Pilih Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['idrole'] ?>"><?= htmlspecialchars($role['nama_role']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                    <button type="submit">Tambah Role</button>
                </form>
                <a class="back-link" href="datamaster_role_user.php">&larr; Kembali ke Manajemen Role</a>
            </div>
        </body>
        <?php include('../../views/partials/footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

require_once __DIR__ . '/../../controllers/TambahRoleController.php';
$controller = new TambahRoleController();
$view = new TambahRoleView($controller);
echo $view->render();

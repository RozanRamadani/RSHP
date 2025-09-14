<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
}

class RoleUserView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        ob_start();
        $users = $this->controller->users;
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Data Master Role User</title>
            <link rel="stylesheet" href="../../assets/css/datamaster.css">
        </head>

        <body>
            <?php include("../../views/partials/menu.php"); ?>
            <div class="role-table-container">
                <h2>Manajemen Role User</h2>
                <table>
                    <tr>
                        <th>ID User</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['iduser'] ?></td>
                            <td><?= htmlspecialchars($user['nama']) ?></td>
                            <td style="text-align:left">
                                <?php if (count($user['roles']) > 0): ?>
                                    <?php foreach ($user['roles'] as $role): ?>
                                        <span class="role-badge <?= $role['status'] == 1 ? 'active' : 'inactive' ?>">
                                            <?= htmlspecialchars($role['nama_role']) ?>
                                            (<?= $role['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?>)
                                        </span><br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="role-badge inactive">Belum ada role</span>
                                <?php endif; ?>
                            </td>
                            <td><a class="aksi-link tambah-role-btn" href="tambah_role.php?iduser=<?= $user['iduser'] ?>">Tambah Role</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <a class="back-link" href="/views/data_master.php">&larr; Kembali ke Data Master</a>
            </div>
        </body>
        <?php include('../../views/partials/footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

require_once __DIR__ . '/../../controllers/RoleUserController.php';
$controller = new RoleUserController();
$view = new RoleUserView($controller);
echo $view->render();

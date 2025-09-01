<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

class RoleUserController
{
    private $db;
    public $users = [];
    public function __construct()
    {
        $this->db = new Database();
        $result = $this->db->select("SELECT u.iduser, u.nama, r.nama_role, ru.status FROM user as u LEFT JOIN role_user as ru ON u.iduser = ru.iduser LEFT JOIN role as r ON ru.idrole = r.idrole ORDER BY u.iduser");
        foreach ($result as $row) {
            $id = $row['iduser'];
            if (!isset($this->users[$id])) {
                $this->users[$id] = [
                    'iduser' => $id,
                    'nama' => $row['nama'],
                    'roles' => []
                ];
            }
            if ($row['nama_role']) {
                $this->users[$id]['roles'][] = [
                    'nama_role' => $row['nama_role'],
                    'status' => $row['status']
                ];
            }
        }
    }
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
            <link rel="stylesheet" href="aset/tugas1.css">
            <style>
                body {
                    background: #f4f8fb;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }

                .container {
                    background: #fff;
                    max-width: 900px;
                    margin: 40px auto 0 auto;
                    padding: 32px 28px 24px 28px;
                    border-radius: 10px;
                    box-shadow: 0 4px 16px rgba(54, 162, 194, 0.10);
                }

                h2 {
                    color: #2587a3;
                    text-align: center;
                    margin-bottom: 24px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 18px;
                }

                th,
                td {
                    border: 1px solid #b5d6e0;
                    padding: 10px 8px;
                    text-align: left;
                }

                th {
                    background: #36a2c2;
                    color: #fff;
                }

                tr:nth-child(even) {
                    background: #f4f8fb;
                }

                .aksi-link {
                    color: #36a2c2;
                    text-decoration: none;
                    font-weight: bold;
                    margin-right: 8px;
                }

                .aksi-link:hover {
                    text-decoration: underline;
                }
            </style>
        </head>

        <body>
            <?php include("menu.php"); ?>
            <div class="container">
                <h2>Manajemen Role</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['iduser']) ?></td>
                                <td><?= htmlspecialchars($user['nama']) ?></td>
                                <td>
                                    <?php if (count($user['roles']) > 0): ?>
                                        <?php foreach ($user['roles'] as $role): ?>
                                            <?= htmlspecialchars($role['nama_role']) ?><br>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span style="color:#aaa">Belum ada role</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (count($user['roles']) > 0): ?>
                                        <?php foreach ($user['roles'] as $role): ?>
                                            <?= $role['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?><br>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span style="color:#aaa">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><a class="aksi-link tambah-role-btn" href="tambah_role.php?iduser=<?= htmlspecialchars($user['iduser']) ?>">Tambah Role</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a class="back-link" href="data_master.php">&larr; Kembali ke Data Master</a>
            </div>
        </body>
        <?php include('footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

$controller = new RoleUserController();
$view = new RoleUserView($controller);
echo $view->render();

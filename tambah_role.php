<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: login.php');
    exit();
}

class TambahRoleController
{
    private $db;
    public $msg = '';
    public $iduser;
    public $nama_user = '';
    public $roles = [];
    public function __construct()
    {
        $this->db = new Database();
        $this->iduser = isset($_GET['iduser']) ? intval($_GET['iduser']) : 0;
        if ($this->iduser > 0) {
            $res_nama = $this->db->select("SELECT nama FROM user WHERE iduser=?", [$this->iduser], 'i');
            if ($res_nama && count($res_nama) > 0) {
                $this->nama_user = $res_nama[0]['nama'];
            }
        }
        $this->roles = $this->db->select("SELECT MIN(idrole) as idrole, nama_role FROM role GROUP BY nama_role");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->iduser > 0) {
            $idrole = intval($_POST['idrole']);
            $status = intval($_POST['status']);
            $cek = $this->db->select("SELECT * FROM role_user WHERE iduser=? AND idrole=?", [$this->iduser, $idrole], 'ii');
            if ($cek && count($cek) > 0) {
                $this->msg = 'Role sudah ada untuk user ini!';
            } else {
                $sql = "INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, ?)";
                try {
                    $affected = $this->db->execute($sql, [$this->iduser, $idrole, $status], 'iii');
                    if ($affected > 0) {
                        $this->msg = 'Role berhasil ditambahkan!';
                    } else {
                        $this->msg = 'Gagal menambahkan role!';
                    }
                } catch (Exception $e) {
                    $this->msg = 'Gagal menambahkan role!';
                }
            }
        }
    }
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
            <link rel="stylesheet" href="aset/tugas1.css">
            <style>
                body {
                    background: #f4f8fb;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }

                .role-form-container {
                    background: #fff;
                    max-width: 420px;
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

                label {
                    font-weight: 500;
                    color: #333;
                }

                select,
                button {
                    width: 100%;
                    padding: 10px 8px;
                    margin-top: 6px;
                    margin-bottom: 18px;
                    border-radius: 5px;
                    border: 1px solid #b5d6e0;
                    font-size: 1em;
                }

                select:focus,
                button:focus {
                    outline: 2px solid #36a2c2;
                }

                button {
                    background: #43c463;
                    color: #fff;
                    font-weight: bold;
                    border: none;
                    cursor: pointer;
                    transition: background 0.2s;
                }

                button:hover {
                    background: #219a3a;
                }

                .msg {
                    text-align: center;
                    margin-bottom: 18px;
                    color: #2587a3;
                    font-weight: 500;
                }

                .back-link {
                    display: inline-block;
                    background: #fff;
                    color: #2587a3;
                    border: 1.5px solid #2587a3;
                    border-radius: 5px;
                    padding: 10px 22px;
                    margin-top: 22px;
                    font-size: 1em;
                    font-weight: bold;
                    text-align: center;
                    text-decoration: none;
                    transition: background 0.2s, color 0.2s;
                }

                .back-link:hover {
                    background: #2587a3;
                    color: #fff;
                    text-decoration: none;
                }
            </style>
        </head>

        <body>
            <?php include("menu.php"); ?>
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
        <?php include('footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

$controller = new TambahRoleController();
$view = new TambahRoleView($controller);
echo $view->render();

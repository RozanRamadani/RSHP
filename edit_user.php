
<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

class EditUserController {
    private $db;
    public $user;
    public $msg = '';
    private $iduser;
    public function __construct() {
        $this->db = new Database();
        $this->iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($this->iduser > 0) {
            if (isset($_POST['update'])) {
                $nama = htmlspecialchars(strip_tags(trim($_POST['nama'])));
                $sql = "UPDATE user SET nama=? WHERE iduser=?";
                try {
                    $affected = $this->db->execute($sql, [$nama, $this->iduser], 'si');
                    if ($affected > 0) {
                        $this->msg = 'Nama user berhasil diupdate!';
                    } else {
                        $this->msg = 'Gagal update nama user!';
                    }
                } catch (Exception $e) {
                    $this->msg = 'Gagal update nama user!';
                }
            }
            $result = $this->db->select("SELECT * FROM user WHERE iduser=?", [$this->iduser], 'i');
            $this->user = $result ? $result[0] : null;
        } else {
            header("Location: data_user.php");
            exit();
        }
    }
}

class EditUserView {
    private $controller;
    public function __construct($controller) {
        $this->controller = $controller;
    }
    public function render() {
        ob_start();
        ?>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Edit User</title>
            <link rel="stylesheet" href="aset/tugas1.css">
            <style>
                body {
                    background: #f4f8fb;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .edit-user-container {
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
                input[type="text"] {
                    width: 100%;
                    padding: 10px 8px;
                    margin-top: 6px;
                    margin-bottom: 18px;
                    border-radius: 5px;
                    border: 1px solid #b5d6e0;
                    font-size: 1em;
                }
                input[type="text"]:focus {
                    outline: 2px solid #36a2c2;
                }
                button,
                .back-link {
                    display: inline-block;
                    background: #36a2c2;
                    color: #fff;
                    font-weight: bold;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 22px;
                    margin-right: 8px;
                    font-size: 1em;
                    cursor: pointer;
                    transition: background 0.2s;
                    text-decoration: none;
                }
                button:hover,
                .back-link:hover {
                    background: #2587a3;
                    color: #fff;
                }
                .msg {
                    text-align: center;
                    margin-bottom: 18px;
                    color: #2587a3;
                    font-weight: 500;
                }
            </style>
        </head>
        <body>
            <?php include("menu.php"); ?>
            <div class="edit-user-container">
                <h2>Edit User</h2>
                <?php if ($this->controller->msg) echo '<div class="msg">' . $this->controller->msg . '</div>'; ?>
                <form method="post">
                    <label>Nama:</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($this->controller->user['nama']); ?>" required>
                    <button type="submit" name="update">Update</button>
                    <a class="back-link" href="data_user.php">Kembali</a>
                </form>
            </div>
        </body>
        <?php include('footer.php'); ?>
        </html>
        <?php
        return ob_get_clean();
    }
}

$controller = new EditUserController();
$view = new EditUserView($controller);
echo $view->render();
<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

class ResetPasswordController
{
    private $db;
    public $msg = '';
    public $iduser;
    public function __construct()
    {
        $this->db = new Database();
        $this->iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($this->iduser > 0) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $new_password = $_POST['new_password'] ?? '';
                $retype = $_POST['retype_password'] ?? '';
                if (empty($new_password) || empty($retype)) {
                    $this->msg = 'Password baru dan konfirmasi harus diisi!';
                } elseif ($new_password !== $retype) {
                    $this->msg = 'Password baru dan konfirmasi tidak sama!';
                } else {
                    $hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE user SET password=? WHERE iduser=?";
                    try {
                        $affected = $this->db->execute($sql, [$hash, $this->iduser], 'si');
                        if ($affected > 0) {
                            $this->msg = 'Password berhasil direset!';
                        } else {
                            $this->msg = 'Gagal reset password!';
                        }
                    } catch (Exception $e) {
                        $this->msg = 'Gagal reset password!';
                    }
                }
            }
        } else {
            header("Location: data_user.php");
            exit();
        }
    }
}

class ResetPasswordView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        ob_start();
        $msg = $this->controller->msg;
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Reset Password</title>
            <link rel="stylesheet" href="aset/tugas1.css">
            <style>
                body {
                    background: #f4f8fb;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }

                .reset-container {
                    background: #fff;
                    max-width: 420px;
                    margin: 40px auto 0 auto;
                    padding: 32px 28px 24px 28px;
                    border-radius: 12px;
                    box-shadow: 0 6px 24px rgba(54, 162, 194, 0.13);
                }

                h2 {
                    color: #2587a3;
                    text-align: center;
                    margin-bottom: 24px;
                    font-weight: 700;
                    letter-spacing: 1px;
                }

                .msg {
                    text-align: center;
                    margin-bottom: 18px;
                    color: #e74c3c;
                    font-weight: 500;
                    background: #fff0f0;
                    border: 1px solid #f5c6cb;
                    border-radius: 6px;
                    padding: 10px 0;
                }

                form {
                    margin-top: 18px;
                }

                label {
                    font-weight: 500;
                    color: #333;
                    display: block;
                    margin-bottom: 6px;
                    margin-top: 14px;
                }

                input[type="password"] {
                    width: 100%;
                    padding: 10px 8px;
                    margin-bottom: 10px;
                    border-radius: 6px;
                    border: 1px solid #b5d6e0;
                    font-size: 1em;
                    background: #f8fafc;
                    transition: border 0.2s;
                }

                input[type="password"]:focus {
                    outline: none;
                    border: 1.5px solid #36a2c2;
                }

                button[type="submit"] {
                    width: 100%;
                    background: #36a2c2;
                    color: #fff;
                    font-weight: bold;
                    border: none;
                    border-radius: 6px;
                    padding: 10px 0;
                    font-size: 1em;
                    cursor: pointer;
                    margin-top: 12px;
                    transition: background 0.2s;
                }

                button[type="submit"]:hover {
                    background: #2587a3;
                }

                .back-link {
                    display: inline-block;
                    background: #fff;
                    color: #2587a3;
                    border: 1.5px solid #2587a3;
                    border-radius: 6px;
                    padding: 10px 22px;
                    margin-top: 18px;
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
            <div class="reset-container">
                <h2>Reset Password</h2>
                <?php if ($msg) echo '<div class="msg">' . $msg . '</div>'; ?>
                <form method="post">
                    <label for="new_password">Password Baru:</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <label for="retype_password">Ulangi Password Baru:</label>
                    <input type="password" id="retype_password" name="retype_password" required>
                    <button type="submit">Reset Password</button>
                </form>
                <a class="back-link" href="data_user.php">&larr; Kembali ke Data User</a>
            </div>
        </body>
        <?php include('footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

$controller = new ResetPasswordController();
$view = new ResetPasswordView($controller);
echo $view->render();

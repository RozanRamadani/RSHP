<?php
require_once __DIR__ . '/../../databases/koneksi.php';

class RegistrasiController
{
    private $db;
    public $msg = '';
    public function __construct()
    {
        $this->db = new Database();
        if (isset($_POST['register'])) {
            $nama = htmlspecialchars(strip_tags(trim($_POST['nama'])));
            $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            if ($password !== $password2) {
                $this->msg = 'Password tidak sama!';
            } else {
                $cek = $this->db->select("SELECT * FROM user WHERE email=?", [$email], 's');
                if ($cek && count($cek) > 0) {
                    $this->msg = 'Email sudah terdaftar!';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
                    try {
                        $affected = $this->db->execute($sql, [$nama, $email, $hash], 'sss');
                        if ($affected > 0) {
                            $this->msg = 'Registrasi berhasil! Silakan login.';
                        } else {
                            $this->msg = 'Registrasi gagal!';
                        }
                    } catch (Exception $e) {
                        $this->msg = 'Registrasi gagal!';
                    }
                }
            }
        }
    }
}

class RegistrasiView
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registrasi</title>
            <link rel="stylesheet" href="../../assets/css/register.css">
        </head>

        <body>
            <div class="register-panel">
                <div style="text-align:center; margin-bottom:18px;">
                    <img src="../../assets/img/RSHP.png" alt="RSHP Logo" style="height:64px; width:auto; margin-bottom:8px;">
                </div>
                <div class="register-title">Registrasi</div>
                <form method="post">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <label for="password2">Ulangi Password</label>
                    <input type="password" id="password2" name="password2" required>
                    <button type="submit" name="register">Registrasi</button>
                </form>
                <?php if ($msg) echo '<div class="msg">' . $msg . '</div>'; ?>
                <div class="login-link">Sudah punya akun? <a href="login.php">Login</a></div>
            </div>
            <footer class="footer-sticky">
                &copy; <?php echo date('Y'); ?> RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga
            </footer>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}

$controller = new RegistrasiController();
$view = new RegistrasiView($controller);
echo $view->render();

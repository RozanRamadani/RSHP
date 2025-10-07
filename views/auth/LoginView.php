<?php
class LoginView
{
    private $error;
    private $username;

    public function __construct($error = '', $username = '')
    {
        $this->error = $error;
        $this->username = $username;
    }

    public function render()
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login RSHP</title>
            <link rel="stylesheet" href="../../assets/css/login.css">
        </head>

        <body>
            <div class="login-panel">
                <div style="text-align:center; margin-bottom:6px;">
                    <img src="../../assets/img/RSHP.png" alt="RSHP Logo" style="height:64px; width:auto; margin-bottom:2px;">
                </div>
                <div class="login-title">Login RSHP</div>

                <?php if (!empty($this->error)): ?>
                    <div class="msg"><?php echo htmlspecialchars($this->error); ?></div>
                <?php endif; ?>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label for="username">Email</label>
                    <input type="email" id="username" name="username"
                        value="<?php echo htmlspecialchars($this->username); ?>"
                        placeholder="Email Anda" required autofocus>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                        placeholder="Password Anda" required>

                    <button type="submit">Login</button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="registrasi.php">Daftar di sini</a>
                </div>
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

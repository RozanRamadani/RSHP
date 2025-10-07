<?php
class RegistrationView
{
    private $message;
    private $formData;

    public function __construct($message = '', $formData = [])
    {
        $this->message = $message;
        $this->formData = $formData;
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
            <title>Registrasi - RSHP</title>
            <link rel="stylesheet" href="../../assets/css/register.css">
        </head>

        <body>
            <div class="register-panel">
                <div style="text-align:center; margin-bottom:18px;">
                    <img src="../../assets/img/RSHP.png" alt="RSHP Logo" style="height:64px; width:auto; margin-bottom:8px;">
                </div>
                <div class="register-title">Registrasi</div>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama"
                        value="<?php echo htmlspecialchars($this->formData['nama'] ?? ''); ?>"
                        required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        value="<?php echo htmlspecialchars($this->formData['email'] ?? ''); ?>"
                        required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <label for="password2">Ulangi Password</label>
                    <input type="password" id="password2" name="password2" required>

                    <div class="peserta-option">
                        <input type="checkbox" id="jadi_peserta" name="jadi_peserta" value="1"
                            <?php echo (isset($this->formData['jadi_peserta']) && $this->formData['jadi_peserta']) ? 'checked' : ''; ?>>
                        <label for="jadi_peserta" class="checkbox-label">
                            <span class="checkmark"></span>
                            Daftar sebagai peserta (pemilik pet)
                        </label>
                        <small class="peserta-info">
                            Dengan memilih ini, Anda dapat mengelola data pet dan mengakses layanan RSHP
                        </small>
                    </div>

                    <button type="submit" name="register">Registrasi</button>
                </form>

                <?php if (!empty($this->message)): ?>
                    <div class="msg"><?php echo htmlspecialchars($this->message); ?></div>
                <?php endif; ?>

                <div class="login-link">
                    Sudah punya akun? <a href="login.php">Login</a>
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

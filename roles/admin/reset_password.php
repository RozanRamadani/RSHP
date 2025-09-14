<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
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
            <link rel="stylesheet" href="../../assets/css/reset_password.css">

        </head>

        <body>
            <?php include("../../views/partials/menu.php"); ?>
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
        <?php include('../../views/partials/footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}

require_once __DIR__ . '/../../controllers/ResetPasswordController.php';
$controller = new ResetPasswordController();
$view = new ResetPasswordView($controller);
echo $view->render();

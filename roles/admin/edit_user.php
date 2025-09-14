<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
}

class EditUserView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render()
    {
        ob_start();
?>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <title>Edit User</title>
            <link rel="stylesheet" href="../../assets/css/edit_user.css">

        </head>

        <body>
            <?php include("../../views/partials/menu.php"); ?>
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
        <?php include('../../views/partials/footer.php'); ?>

        </html>
<?php
        return ob_get_clean();
    }
}


require_once __DIR__ . '/../../controllers/EditUserController.php';
$controller = new EditUserController();
$view = new EditUserView($controller);
echo $view->render();

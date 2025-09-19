
<?php

session_start();
require_once __DIR__ . '/../../controllers/DataUserController.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
}


class DataUserView {
    public function render($users) {
        ob_start();
        ?>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Data User</title>
            <link rel="stylesheet" href="../../assets/css/data_user.css">
        </head>
        <body>
            <?php include("../../views/partials/menu.php"); ?>
            <div class="user-table-container">
                <h2>Data User</h2>
                <a href="tambah_user.php" class="tambah-btn">Tambah User</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $row): ?>
                            <tr>
                                <td><?php echo $row['iduser']; ?></td>
                                <td><?php echo $row['nama']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a class="aksi-link edit-link" href="edit_user.php?id=<?php echo $row['iduser']; ?>">Edit</a><br>
                                    <a class="aksi-link reset-link" href="reset_password.php?id=<?php echo $row['iduser']; ?>">Reset Password</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="/views/data_master.php" class="tambah-btn back-btn">&larr; Kembali ke Data Master</a>
            </div>
        </body>
        <?php include('../../views/partials/footer.php'); ?>
        </html>
        <?php
        return ob_get_clean();
    }
}

$controller = new DataUserController();
$view = new DataUserView();
echo $view->render($controller->users);
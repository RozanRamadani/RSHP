
<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

class DataUserController {
    private $db;
    public $users;
    public function __construct() {
        $this->db = new Database();
        $this->users = $this->db->select("SELECT * FROM user");
    }
}

class DataUserView {
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
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Data User</title>
            <style>
                body {
                    background: #f4f8fb;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .user-table-container {
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
                    border-collapse: collapse;
                    width: 100%;
                    background: #fff;
                }
                th, td {
                    border: 1px solid #b5d6e0;
                    padding: 10px 8px;
                    text-align: center;
                }
                th {
                    background: #36a2c2;
                    color: #fff;
                    font-size: 1.05em;
                }
                tr:nth-child(even) {
                    background: #f4f8fb;
                }
                tr:hover {
                    background: #eaf6fa;
                }
                .aksi-link {
                    text-decoration: none;
                    font-weight: 500;
                    padding: 4px 12px;
                    border-radius: 5px;
                    transition: background 0.18s, color 0.18s;
                    margin-bottom: 3px;
                    display: inline-block;
                }
                .edit-link {
                    background: #fffbe6;
                    color: #bfa100;
                    border: 1.5px solid #ffe066;
                }
                .edit-link:hover {
                    background: #ffe066;
                    color: #7c6f00;
                }
                .reset-link {
                    background: #fff0f0;
                    color: #d32f2f;
                    border: 1.5px solid #f44336;
                }
                .reset-link:hover {
                    background: #f44336;
                    color: #fff;
                }
                .tambah-btn {
                    display: inline-block;
                    background: #43c463;
                    color: #fff;
                    font-weight: bold;
                    border: none;
                    border-radius: 5px;
                    padding: 10px 22px;
                    margin-bottom: 18px;
                    margin-top: 8px;
                    font-size: 1em;
                    cursor: pointer;
                    transition: background 0.2s;
                    text-decoration: none;
                }
                .tambah-btn:hover {
                    background: #2587a3;
                    color: #fff;
                }
                .back-btn {
                    background: #fff;
                    color: #2587a3;
                    border: 1.5px solid #2587a3;
                    margin-top: 22px;
                    transition: background 0.2s, color 0.2s;
                }
                .back-btn:hover {
                    background: #2587a3;
                    color: #fff;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <?php include("menu.php"); ?>
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
                        <?php foreach ($this->controller->users as $row): ?>
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
                <a href="data_master.php" class="tambah-btn back-btn">&larr; Kembali ke Data Master</a>
            </div>
        </body>
        <?php include('footer.php'); ?>
        </html>
        <?php
        return ob_get_clean();
    }
}

$controller = new DataUserController();
$view = new DataUserView($controller);
echo $view->render();
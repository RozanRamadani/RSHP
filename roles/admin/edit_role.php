<?php
session_start();
require_once __DIR__ . '/../../databases/koneksi.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: /views/auth/login.php");
    exit();
}

if (!isset($_GET['iduser'])) {
    header("Location: datamaster_role_user.php");
    exit();
}

$iduser = $_GET['iduser'];
$db = new Database();

// Ambil data user berdasarkan iduser
$userResult = $db->select("SELECT * FROM user WHERE iduser = ?", [$iduser], 'i');
if (empty($userResult)) {
    header("Location: datamaster_role_user.php");
    exit();
}
$user = $userResult[0];

// Ambil semua role yang tersedia
$roles = $db->select("SELECT * FROM role ORDER BY nama_role");

// Ambil role pengguna saat ini
$userRoles = $db->select("SELECT ru.*, r.nama_role FROM role_user ru JOIN role r ON ru.idrole = r.idrole WHERE ru.iduser = ?", [$iduser], 'i');

$msg = '';

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_roles'])) {
        $selectedRoles = $_POST['roles'] ?? [];
        $roleStatuses = $_POST['role_status'] ?? [];

        try {
            // Mulai transaksi
            $db->getConnection()->begin_transaction();

            // Hapus semua role yang ada untuk user ini
            $db->execute("DELETE FROM role_user WHERE iduser = ?", [$iduser], 'i');

            // Tambahkan role, yang dipilih beserta statusnya
            foreach ($selectedRoles as $roleId) {
                $status = isset($roleStatuses[$roleId]) ? 1 : 0;
                $db->execute("INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, ?)", [$iduser, $roleId, $status], 'iii');
            }

            // Commit transaksi
            $db->getConnection()->commit();
            $msg = '<div class="msg-success">Role berhasil diperbarui!</div>';

            // Refresh data role pengguna
            $userRoles = $db->select("SELECT ru.*, r.nama_role FROM role_user ru JOIN role r ON ru.idrole = r.idrole WHERE ru.iduser = ?", [$iduser], 'i');
        } catch (Exception $e) {
            $db->getConnection()->rollback();
            $msg = '<div class="msg-error">Gagal memperbarui role: ' . $e->getMessage() . '</div>';
        }
    }
}

// Buat array untuk memudahkan pengecekan role yang dimiliki user
$currentRoleIds = [];
$currentRoleStatuses = [];
foreach ($userRoles as $userRole) {
    $currentRoleIds[] = $userRole['idrole'];
    $currentRoleStatuses[$userRole['idrole']] = $userRole['status'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Role User</title>
    <link rel="stylesheet" href="../../assets/css/edit_role.css">
</head>

<body>
    <?php include("../../views/partials/menu.php"); ?>
    <div class="edit-role-container">
        <h2>Edit Role User</h2>
        <div class="user-info">
            <h3>User: <?= htmlspecialchars($user['nama']) ?></h3>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <?= $msg ?>

        <form method="POST">
            <div class="roles-section">
                <h4>Pilih Role untuk User:</h4>
                <div class="roles-grid">
                    <?php foreach ($roles as $role): ?>
                        <div class="role-item">
                            <div class="role-checkbox">
                                <input type="checkbox"
                                    id="role_<?= $role['idrole'] ?>"
                                    name="roles[]"
                                    value="<?= $role['idrole'] ?>"
                                    <?= in_array($role['idrole'], $currentRoleIds) ? 'checked' : '' ?>>
                                <label for="role_<?= $role['idrole'] ?>">
                                    <?= htmlspecialchars($role['nama_role']) ?>
                                </label>
                            </div>
                            <div class="role-status">
                                <input type="checkbox"
                                    id="status_<?= $role['idrole'] ?>"
                                    name="role_status[<?= $role['idrole'] ?>]"
                                    value="1"
                                    <?= isset($currentRoleStatuses[$role['idrole']]) && $currentRoleStatuses[$role['idrole']] == 1 ? 'checked' : '' ?>>
                                <label for="status_<?= $role['idrole'] ?>">Aktif</label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-actions">
                <a href="datamaster_role_user.php" class="back-link">Kembali</a>
                <button type="submit" name="update_roles" class="update-btn">Update Role</button>
            </div>
        </form>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>

</html>
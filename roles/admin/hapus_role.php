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

// Get user information
$userResult = $db->select("SELECT * FROM user WHERE iduser = ?", [$iduser], 'i');
if (empty($userResult)) {
    header("Location: datamaster_role_user.php");
    exit();
}
$user = $userResult[0];

// Get current user roles
$userRoles = $db->select("SELECT ru.*, r.nama_role FROM role_user ru JOIN role r ON ru.idrole = r.idrole WHERE ru.iduser = ? ORDER BY r.nama_role", [$iduser], 'i');

if (empty($userRoles)) {
    header("Location: datamaster_role_user.php");
    exit();
}

$msg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_roles'])) {
        $rolesToDelete = $_POST['roles_to_delete'] ?? [];

        if (empty($rolesToDelete)) {
            $msg = '<div class="msg-error">Pilih minimal satu role untuk dihapus!</div>';
        } else {
            try {
                // Begin transaction
                $db->getConnection()->begin_transaction();

                // Delete selected roles
                foreach ($rolesToDelete as $roleUserId) {
                    $db->execute("DELETE FROM role_user WHERE idrole_user = ? AND iduser = ?", [$roleUserId, $iduser], 'ii');
                }

                // Commit transaction
                $db->getConnection()->commit();
                $msg = '<div class="msg-success">Role berhasil dihapus!</div>';

                // Refresh user roles data
                $userRoles = $db->select("SELECT ru.*, r.nama_role FROM role_user ru JOIN role r ON ru.idrole = r.idrole WHERE ru.iduser = ? ORDER BY r.nama_role", [$iduser], 'i');

                // If no roles left, redirect back
                if (empty($userRoles)) {
                    header("refresh:2;url=datamaster_role_user.php");
                    $msg .= '<div class="msg-info">Tidak ada role tersisa. Akan dialihkan ke halaman utama...</div>';
                }
            } catch (Exception $e) {
                $db->getConnection()->rollback();
                $msg = '<div class="msg-error">Gagal menghapus role: ' . $e->getMessage() . '</div>';
            }
        }
    }

    if (isset($_POST['delete_all_roles'])) {
        try {
            // Begin transaction
            $db->getConnection()->begin_transaction();

            // Delete all roles for this user
            $db->execute("DELETE FROM role_user WHERE iduser = ?", [$iduser], 'i');

            // Commit transaction
            $db->getConnection()->commit();
            $msg = '<div class="msg-success">Semua role berhasil dihapus!</div>';

            // Redirect after 2 seconds
            header("refresh:2;url=datamaster_role_user.php");
            $msg .= '<div class="msg-info">Akan dialihkan ke halaman utama...</div>';
            $userRoles = []; // Clear roles array

        } catch (Exception $e) {
            $db->getConnection()->rollback();
            $msg = '<div class="msg-error">Gagal menghapus semua role: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hapus Role User</title>
    <link rel="stylesheet" href="../../assets/css/hapus_role.css">
</head>

<body>
    <?php include("../../views/partials/menu.php"); ?>
    <div class="hapus-role-container">
        <h2>Hapus Role User</h2>
        <div class="user-info">
            <h3>User: <?= htmlspecialchars($user['nama']) ?></h3>
            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <?= $msg ?>

        <?php if (!empty($userRoles)): ?>
            <div class="danger-warning">
                <div class="warning-icon">⚠️</div>
                <div class="warning-text">
                    <strong>Peringatan!</strong><br>
                    Penghapusan role bersifat permanen dan tidak dapat dibatalkan.
                    Pastikan Anda yakin sebelum melanjutkan.
                </div>
            </div>

            <form method="POST" onsubmit="return confirmDelete()">
                <div class="roles-section">
                    <h4>Pilih Role yang akan dihapus:</h4>
                    <div class="roles-list">
                        <?php foreach ($userRoles as $userRole): ?>
                            <div class="role-item">
                                <div class="role-checkbox">
                                    <input type="checkbox"
                                        id="role_<?= $userRole['idrole_user'] ?>"
                                        name="roles_to_delete[]"
                                        value="<?= $userRole['idrole_user'] ?>">
                                    <label for="role_<?= $userRole['idrole_user'] ?>">
                                        <span class="role-name"><?= htmlspecialchars($userRole['nama_role']) ?></span>
                                        <span class="role-status <?= $userRole['status'] == 1 ? 'active' : 'inactive' ?>">
                                            (<?= $userRole['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?>)
                                        </span>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="select-all-section">
                        <label class="select-all">
                            <input type="checkbox" id="select-all"> Pilih Semua
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="datamaster_role_user.php" class="back-link">Kembali</a>
                    <button type="submit" name="delete_roles" class="delete-btn">Hapus Role Terpilih</button>
                    <button type="submit" name="delete_all_roles" class="delete-all-btn"
                        onclick="return confirmDeleteAll()">Hapus Semua Role</button>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Pilih semua checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="roles_to_delete[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Konfirmasi sebelum menghapus role terpilih
        function confirmDelete() {
            const checkedBoxes = document.querySelectorAll('input[name="roles_to_delete[]"]:checked');
            if (checkedBoxes.length === 0) {
                alert('Pilih minimal satu role untuk dihapus!');
                return false;
            }
            return confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} role yang dipilih? Tindakan ini tidak dapat dibatalkan.`);
        }

        // Konfirmasi sebelum menghapus semua role
        function confirmDeleteAll() {
            return confirm('Apakah Anda yakin ingin menghapus SEMUA role untuk user ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus seluruh akses user.');
        }

        // Update pilih semua status berdasarkan checkbox individu (nb: indeterminate = tanda strip bukan centang)
        document.querySelectorAll('input[name="roles_to_delete[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('input[name="roles_to_delete[]"]');
                const checkedCheckboxes = document.querySelectorAll('input[name="roles_to_delete[]"]:checked');
                const selectAllCheckbox = document.getElementById('select-all');

                if (checkedCheckboxes.length === allCheckboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (checkedCheckboxes.length > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            });
        });
    </script>

    <?php include('../../views/partials/footer.php'); ?>
</body>

</html>
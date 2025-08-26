<?php
include('koneksi.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Query join user, role_user, role
// Mengambil data user beserta role dan statusnya dengan join ke tabel role_user dan role.
$query = "SELECT u.iduser, u.nama, r.nama_role, ru.status FROM user as u
    LEFT JOIN role_user as ru ON u.iduser = ru.iduser
    LEFT JOIN role as r ON ru.idrole = r.idrole
    ORDER BY u.iduser";
//Jalankan query ke database lalu simpan ke variabel
$result = $conn->query($query);

// Build array: [iduser] => [iduser, nama, roles => [ [nama_role, status], ... ] ]
//manampung array kosong
$users = array();
//Perulangan setiap query
while ($row = $result->fetch_assoc()) {
    //simpan ke iduser
    $iduser = $row['iduser'];
    // Jika user dengan iduser ini belum ada di array $users, tambahkan user baru ke array.
    if (!array_key_exists($iduser, $users)) {
        $users[$iduser] = [
            'iduser' => $iduser,
            'nama' => $row['nama'],
            'roles' => []
        ];
    }
    //Jika nama_role tidak null, tambahkan ke array roles
    if ($row['nama_role'] !== null) {
        $users[$iduser]['roles'][] = [
            'nama_role' => $row['nama_role'],
            'status' => $row['status']
        ];
    }
}
?>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Role User</title>
    <link rel="stylesheet" href="aset/tugas1.css">
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .role-table-container {
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

        th,
        td {
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

        .role-badge {
            display: inline-block;
            padding: 4px 14px 4px 14px;
            border-radius: 6px;
            font-size: 0.98em;
            font-weight: 600;
            margin-bottom: 4px;
            margin-right: 6px;
            border: 2px solid;
            letter-spacing: 0.5px;
        }

        .role-badge.active {
            background: #e8fbe8;
            color: #219a3a;
            border-color: #43c463;
        }

        .role-badge.inactive {
            background: #fff0f0;
            color: #d32f2f;
            border-color: #f44336;
        }

        .aksi-link {
            color: #2587a3;
            text-decoration: none;
            font-weight: 500;
        }

        .aksi-link:hover {
            text-decoration: underline;
        }

        .aksi-link {
            text-decoration: none;
            font-weight: 500;
            padding: 6px 16px;
            border-radius: 5px;
            background: #36a2c2;
            color: #fff;
            border: none;
            transition: background 0.18s, color 0.18s;
            display: inline-block;
        }

        .aksi-link:hover {
            background: #2587a3;
            color: #fff;
            text-decoration: none;
        }

        .tambah-role-btn {
            background: #43c463 !important;
            color: #fff !important;
            border: none !important;
        }

        .tambah-role-btn:hover {
            background: #219a3a !important;
            color: #fff !important;
        }

        .back-link {
            display: inline-block;
            background: #fff;
            color: #2587a3;
            border: 1.5px solid #2587a3;
            border-radius: 5px;
            padding: 10px 22px;
            margin-top: 22px;
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
    <div class="role-table-container">
        <h2>Manajemen Role User</h2>
        <table>
            <tr>
                <th>ID User</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['iduser'] ?></td>
                    <td><?= htmlspecialchars($user['nama']) ?></td>
                    <td style="text-align:left">
                        <?php if (count($user['roles']) > 0): ?>
                            <?php foreach ($user['roles'] as $role): ?>
                                <span class="role-badge <?= $role['status'] == 1 ? 'active' : 'inactive' ?>">
                                    <?= htmlspecialchars($role['nama_role']) ?>
                                    (<?= $role['status'] == 1 ? 'Aktif' : 'Non-Aktif' ?>)
                                </span><br>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="role-badge inactive">Belum ada role</span>
                        <?php endif; ?>
                    </td>
                    <td><a class="aksi-link tambah-role-btn" href="tambah_role.php?iduser=<?= $user['iduser'] ?>">Tambah Role</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a class="back-link" href="data_master.php">&larr; Kembali ke Data Master</a>
    </div>
</body>
<?php include('footer.php'); ?>

</html>
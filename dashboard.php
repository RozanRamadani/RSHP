<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: ../login.php');
    exit;
}

// Query statistik sederhana
include_once('koneksi.php');
$jml_user = $conn->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];
$jml_role = $conn->query("SELECT COUNT(*) as total FROM role")->fetch_assoc()['total'];
$jml_role_user = $conn->query("SELECT COUNT(*) as total FROM role_user")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin RSHP</title>
    <link rel="stylesheet" href="aset/tugas1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f4f8fb; font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif; }
        .dashboard-container {
            max-width: 1100px;
            margin: 36px auto 0 auto;
            padding: 0 18px 32px 18px;
        }
        .dashboard-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 18px;
        }
        .dashboard-header img {
            width: 60px; height: 60px; border-radius: 10px; object-fit: cover; background: #fff; box-shadow: 0 2px 8px rgba(54,162,194,0.10);
        }
        .dashboard-header h1 {
            color: #2587a3; font-size: 2.1em; margin: 0; font-weight: 700;
        }
        .dashboard-header .admin-info {
            color: #555; font-size: 1.1em; margin-top: 2px;
        }
        .dashboard-cards {
            display: flex;
            gap: 24px;
            margin: 32px 0 24px 0;
            flex-wrap: wrap;
        }
        .card {
            flex: 1 1 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(54,162,194,0.10);
            padding: 28px 24px 22px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 200px;
            position: relative;
        }
        .card .icon {
            font-size: 2.2em;
            margin-bottom: 10px;
            color: #36a2c2;
        }
        .card-title {
            font-size: 1.1em;
            color: #888;
            margin-bottom: 6px;
        }
        .card-value {
            font-size: 2.1em;
            font-weight: bold;
            color: #2587a3;
        }
        .card-link {
            margin-top: 12px;
            font-size: 0.98em;
            color: #36a2c2;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .card-link:hover { color: #2587a3; text-decoration: underline; }
        .dashboard-welcome {
            background: #e6f6fa;
            border-radius: 10px;
            padding: 22px 28px;
            margin-bottom: 24px;
            color: #2587a3;
            font-size: 1.15em;
            box-shadow: 0 2px 8px rgba(54,162,194,0.07);
        }
        .dashboard-footer {
            text-align: center;
            color: #888;
            font-size: 0.98em;
            margin-top: 48px;
            padding: 18px 0 0 0;
        }
        @media (max-width: 900px) {
            .dashboard-cards { flex-direction: column; gap: 18px; }
        }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <img src="img/RSHP.png" alt="Logo RSHP">
            <div>
                <h1>Dashboard Admin RSHP</h1>
                <div class="admin-info">Halo, <b><?php echo htmlspecialchars($_SESSION['user']['nama']); ?></b> &mdash; Anda login sebagai <b>Administrator</b>.</div>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="card">
                <div class="icon">👤</div>
                <div class="card-title">Total User</div>
                <div class="card-value"><?php echo $jml_user; ?></div>
                <a class="card-link" href="data_user.php">Lihat Data User &rarr;</a>
            </div>
            <div class="card">
                <div class="icon">🛡️</div>
                <div class="card-title">Total Role</div>
                <div class="card-value"><?php echo $jml_role; ?></div>
                <a class="card-link" href="datamaster_role_user.php">Lihat Manajemen Role &rarr;</a>
            </div>
            <div class="card">
                <div class="icon">🔗</div>
                <div class="card-title">Total Relasi User-Role</div>
                <div class="card-value"><?php echo $jml_role_user; ?></div>
                <a class="card-link" href="datamaster_role_user.php">Lihat Relasi &rarr;</a>
            </div>
        </div>
        <div class="dashboard-welcome">
            Selamat datang di <b>Dashboard Admin RSHP</b>. Anda dapat mengelola data user, role, dan hak akses melalui menu di atas.<br>
            <span style="color:#888; font-size:0.98em;">Rumah Sakit Hewan Pendidikan Universitas Airlangga</span>
        </div>
        <!-- Bisa tambahkan info lain di sini, misal: pengumuman, statistik lain, dsb -->
    </div>
    <div class="dashboard-footer">
        &copy; <?php echo date('Y'); ?> RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga
    </div>
</body>
<?php include('footer.php'); ?>
</html>

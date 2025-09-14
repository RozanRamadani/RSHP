<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: /views/auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/data_master.css">
</head>

<body>
    <?php include('partials/menu.php'); ?>
    <div class="master-container">
        <h2>Data Master</h2>
        <div class="master-menu">
            <a class="master-card" href="/roles/admin/data_user.php"><span class="icon">👤</span> Data User</a>
            <a class="master-card" href="/roles/admin/datamaster_role_user.php"><span class="icon">🛡️</span> Manajemen Role</a>
            <a class="master-card" href="/roles/animal/RasHewanView.php"><span class="icon">🛡️</span> Ras Hewan</a>
            <a class="master-card" href="/roles/animal/JenisHewanView.php"><span class="icon">🛡️</span> Jenis Hewan</a>
        </div>
    </div>
</body>

</html>
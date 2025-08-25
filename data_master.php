<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master</title>
</head>
<body>
    <?php include("menu.php"); ?>
    <div style="max-width:800px;margin:32px auto;background:#fff;padding:32px 24px;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.10);">
        <h2>Data Master</h2>
        <ul style="list-style:none;padding:0;">
            <li style="margin-bottom:12px;"><a href="data_user.php" style="font-size:1.1em;">Data User</a></li>
            <li><a href="datamaster_role_user.php" style="font-size:1.1em;">Manajemen Role</a></li>
        </ul>
    </div>
</body>
</html>
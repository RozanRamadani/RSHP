<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="aset/tugas1.css">
</head>
<body>
    <?php include("menu.php"); ?>
    <h1>Halo, <?php echo $_SESSION['user']['nama']; ?></h1>
    <p>Anda login sebagai <b>Administrator</b>.</p>
</body>
</html>

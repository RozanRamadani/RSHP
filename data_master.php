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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f4f8fb;
            font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
        }
        .master-container {
            max-width: 520px;
            margin: 48px auto 0 auto;
            background: #fff;
            padding: 38px 32px 32px 32px;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(54,162,194,0.10);
        }
        h2 {
            color: #2587a3;
            text-align: center;
            margin-bottom: 32px;
            font-size: 2em;
            font-weight: 700;
        }
        .master-menu {
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding: 0;
            margin: 0;
        }
        .master-card {
            display: flex;
            align-items: center;
            gap: 18px;
            background: #e6f6fa;
            border: 2px solid #36a2c2;
            border-radius: 8px;
            padding: 18px 22px;
            font-size: 1.15em;
            font-weight: 600;
            color: #2587a3;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(54,162,194,0.07);
            transition: background 0.18s, border 0.18s, color 0.18s;
        }
        .master-card:hover {
            background: #36a2c2;
            color: #fff;
            border-color: #2587a3;
        }
        .master-card .icon {
            font-size: 1.7em;
            margin-right: 6px;
        }
        @media (max-width: 600px) {
            .master-container { padding: 18px 6px; }
            h2 { font-size: 1.3em; }
            .master-card { font-size: 1em; padding: 12px 8px; }
        }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="master-container">
        <h2>Data Master</h2>
        <div class="master-menu">
            <a class="master-card" href="data_user.php"><span class="icon">👤</span> Data User</a>
            <a class="master-card" href="datamaster_role_user.php"><span class="icon">🛡️</span> Manajemen Role</a>
        </div>
    </div>
</body>
</html>
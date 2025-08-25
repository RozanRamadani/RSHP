
<?php
// reset_password.php
include('koneksi.php');
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

// Ambil ID user dari parameter GET, jika ada ubah nilainya menjadi int dan simpan, jika tidak ada simpan 0
$iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;
$msg = '';
$new_password = '';
// Fungsi untuk generate password acak
function generateRandomPassword($length = 8) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789!@#$%';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

// Fungsi untuk menjalankan proses reset password
if ($iduser > 0) {
    // Panggil fungsi generateRandomPassword
    $new_password = generateRandomPassword(10);
    // Hash password baru
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password='$hash' WHERE iduser=$iduser";
    if ($conn->query($sql)) {
        $msg = 'Password berhasil direset!';
    } else {
        $msg = 'Gagal reset password!';
        $new_password = '';
    }
} else {
    header("Location: data_user.php");
    exit();
}
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="aset/tugas1.css">
    <style>
        body { background: #f4f8fb; font-family: 'Segoe UI', Arial, sans-serif; }
        .reset-container {
            background: #fff;
            max-width: 420px;
            margin: 40px auto 0 auto;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(54,162,194,0.10);
        }
        h2 { color: #2587a3; text-align: center; margin-bottom: 24px; }
        .msg { text-align: center; margin-bottom: 18px; color: #2587a3; font-weight: 500; }
        .newpass { text-align: center; color: #222; font-size: 1.1em; margin-bottom: 10px; }
        .back-link {
            display: inline-block;
            background: #fff;
            color: #2587a3;
            border: 1.5px solid #2587a3;
            border-radius: 5px;
            padding: 10px 22px;
            margin-top: 18px;
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
    <div class="reset-container">
        <h2>Reset Password</h2>
        <?php if($msg) echo '<div class="msg">'.$msg.'</div>'; ?>
        <?php if($new_password) echo '<div class="newpass">Password baru user: <b>'.$new_password.'</b><br><small>Catat password ini, password tidak akan ditampilkan lagi.</small></div>'; ?>
        <a class="back-link" href="data_user.php">&larr; Kembali ke Data User</a>
    </div>
</body>
</html>

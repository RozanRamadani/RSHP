<?php
// tambah_user.php
include('koneksi.php');
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}
$msg = '';
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Ambil password dan retype dari input
    $password = $_POST['password'];
    $retype = $_POST['retype'];
    // Cek apakah password dan retype sama
    if ($password !== $retype) {
        $msg = 'Password tidak sama!';
    } else {
        // Jika password sama, Gunakan Hash bawaan PHP
        $hash = password_hash($password, PASSWORD_DEFAULT);
        //Tambahkan ke TABLE user 
        $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')";
        if ($conn->query($sql)) {
            $msg = 'User baru berhasil ditambahkan!';
        } else {
            $msg = 'Gagal menambah user!';
        }
    }
}
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <style>
        body { background: #f4f8fb; font-family: 'Segoe UI', Arial, sans-serif; }
        .tambah-user-container {
            background: #fff;
            max-width: 420px;
            margin: 40px auto 0 auto;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(54,162,194,0.10);
        }
        h2 { color: #2587a3; text-align: center; margin-bottom: 24px; }
        label { font-weight: 500; color: #333; display: block; margin-bottom: 6px; margin-top: 14px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #b5d6e0;
            font-size: 1em;
            background: #f8fafc;
        }
        input:focus { outline: 2px solid #36a2c2; }
        button, .back-link {
            display: inline-block;
            background: #36a2c2;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 22px;
            margin-right: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }
        button:hover, .back-link:hover { background: #2587a3; color: #fff; }
        .msg { text-align: center; margin-bottom: 18px; color: #2587a3; font-weight: 500; }
    </style>
</head>
<body>
    <?php include("menu.php"); ?>
    <div class="tambah-user-container">
        <h2>Tambah User</h2>
        <?php if($msg) echo '<div class="msg">'.$msg.'</div>'; ?>
        <form method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="retype">Retype Password:</label>
            <input type="password" id="retype" name="retype" required>
            <button type="submit" name="tambah">Tambah</button>
            <a class="back-link" href="data_user.php">Kembali</a>
        </form>
    </div>
</body>
<?php include('footer.php'); ?>
</html>

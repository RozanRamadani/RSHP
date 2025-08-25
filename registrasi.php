<?php
include 'koneksi.php';
$msg = '';
if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    // Validasi
    if ($password !== $password2) {
        $msg = 'Password tidak sama!';
    } else {
        $cek = $conn->query("SELECT * FROM user WHERE email='$email'");
        if ($cek->num_rows > 0) {
            $msg = 'Email sudah terdaftar!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')";
            if ($conn->query($sql)) {
                $msg = 'Registrasi berhasil! Silakan login.';
            } else {
                $msg = 'Registrasi gagal!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        body { background: #f4f8fb; font-family: 'Segoe UI', Arial, sans-serif; min-height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; }
        .form-box { background: #fff; max-width: 370px; width: 100%; margin: 40px auto 0 auto; padding: 32px 28px 24px 28px; border-radius: 10px; box-shadow: 0 4px 16px rgba(54,162,194,0.10); }
        h2 { color: #2587a3; text-align: center; margin-bottom: 24px; }
        label { font-weight: 500; color: #333; display: block; margin-bottom: 6px; margin-top: 14px; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px 8px; margin-bottom: 10px; border-radius: 5px; border: 1px solid #b5d6e0; font-size: 1em; background: #f8fafc; }
        input:focus { outline: 2px solid #36a2c2; }
        button[type="submit"] { width: 100%; background: #36a2c2; color: #fff; font-weight: bold; border: none; border-radius: 5px; padding: 10px 0; font-size: 1em; cursor: pointer; margin-top: 12px; transition: background 0.2s; }
        button[type="submit"]:hover { background: #2587a3; }
        .msg { color: #e74c3c; text-align: center; margin: 10px 0 0 0; font-weight: 500; }
        .login-link { text-align: center; margin-top: 18px; color: #2587a3; }
        .login-link a { color: #2587a3; text-decoration: underline; }
        .login-link a:hover { color: #36a2c2; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Registrasi</h2>
        <form method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="password2">Ulangi Password:</label>
            <input type="password" id="password2" name="password2" required>
            <button type="submit" name="register">Registrasi</button>
        </form>
        <?php if($msg) echo '<div class="msg">'.$msg.'</div>'; ?>
        <div class="login-link">Sudah punya akun? <a href="login.php">Login</a></div>
    </div>
</body>
</html>

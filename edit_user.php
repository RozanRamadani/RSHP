<?php
// edit_user.php
include('koneksi.php');
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role_aktif'] != '1') {
    header("Location: login.php");
    exit();
}

// Ambil ID user dari parameter GET, jika ada ubah nilainya menjadi int dan simpan, jika
$iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;

$msg = '';
if ($iduser > 0) {
    if (isset($_POST['update'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $sql = "UPDATE user SET nama='$nama' WHERE iduser=$iduser";
        if ($conn->query($sql)) {
            $msg = 'Nama user berhasil diupdate!';
        } else {
            $msg = 'Gagal update nama user!';
        }
    }
    $result = $conn->query("SELECT * FROM user WHERE iduser=$iduser");
    $user = $result->fetch_assoc();
} else {
    header("Location: data_user.php");
    exit();
}
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="aset/tugas1.css">
    <style>
        body { background: #f4f8fb; font-family: 'Segoe UI', Arial, sans-serif; }
        .edit-user-container {
            background: #fff;
            max-width: 420px;
            margin: 40px auto 0 auto;
            padding: 32px 28px 24px 28px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(54,162,194,0.10);
        }
        h2 { color: #2587a3; text-align: center; margin-bottom: 24px; }
        label { font-weight: 500; color: #333; }
        input[type="text"] {
            width: 100%;
            padding: 10px 8px;
            margin-top: 6px;
            margin-bottom: 18px;
            border-radius: 5px;
            border: 1px solid #b5d6e0;
            font-size: 1em;
        }
        input[type="text"]:focus { outline: 2px solid #36a2c2; }
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
    <div class="edit-user-container">
        <h2>Edit User</h2>
        <?php if($msg) echo '<div class="msg">'.$msg.'</div>'; ?>
        <form method="post">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            <button type="submit" name="update">Update</button>
            <a class="back-link" href="data_user.php">Kembali</a>
        </form>
    </div>
</body>
<?php include('footer.php'); ?>
</html>

<?php
include 'koneksi.php';
session_start();
$msg = '';
if (isset($_POST['login'])) {
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = $_POST['password'];
    //Ambil data user dari table user
	$sql = "SELECT * FROM user WHERE email='$email'";
	$result = mysqli_query($conn, $sql);
    // Cek apakah user ditemukan
	if ($row = mysqli_fetch_assoc($result)) {
        // Cek password
		if (password_verify($password, $row['password'])) {
            //Ambil data role aktif
			$query = "SELECT * FROM role_user WHERE iduser = " . $row['iduser'] . " AND status = 1";
			$role_result = mysqli_query($conn, $query);
            // cek apakah user punya role aktif
			if ($role_row = mysqli_fetch_assoc($role_result)) {
				//cek apakah user admin
				if ($role_row['idrole'] == 1) {
					$_SESSION['user'] = array(
						'id' => $row['iduser'],
						'nama' => $row['nama'],
						'email' => $row['email'],
						'role_aktif' => $role_row['idrole'],
						'logged_in' => true
					);
					header('Location: dashboard.php');
					exit();
				}
				else if ($role_row['idrole'] == 2){
					$msg = 'Anda adalah dokter';
				}
				else if ($role_row['idrole'] == 3){
					$msg = 'Anda adalah perawat';
				}
				else if ($role_row['idrole'] == 4){
					$msg = 'Anda adalah Resepsionis';
				}
				else {
					$msg = 'Role tidak dikenali.';
				}
			} else {
				$msg = 'Role tidak ditemukan.';
			}
		} else {
			$msg = 'Password salah!';
		}
	} else {
		$msg = 'Email tidak ditemukan!';
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

	<style>
		body {
			background: #f4f8fb;
			font-family: 'Segoe UI', Arial, sans-serif;
			min-height: 100vh;
			margin: 0;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		.form-box {
			background: #fff;
			max-width: 370px;
			width: 100%;
			margin: 40px auto 0 auto;
			padding: 32px 28px 24px 28px;
			border-radius: 10px;
			box-shadow: 0 4px 16px rgba(54,162,194,0.10);
		}
		h2 {
			color: #2587a3;
			text-align: center;
			margin-bottom: 24px;
		}
		label {
			font-weight: 500;
			color: #333;
			display: block;
			margin-bottom: 6px;
			margin-top: 14px;
		}
		input[type="email"], input[type="password"] {
			width: 100%;
			padding: 10px 8px;
			margin-bottom: 10px;
			border-radius: 5px;
			border: 1px solid #b5d6e0;
			font-size: 1em;
			background: #f8fafc;
		}
		input[type="email"]:focus, input[type="password"]:focus {
			outline: 2px solid #36a2c2;
		}
		button[type="submit"] {
			width: 100%;
			background: #36a2c2;
			color: #fff;
			font-weight: bold;
			border: none;
			border-radius: 5px;
			padding: 10px 0;
			font-size: 1em;
			cursor: pointer;
			margin-top: 12px;
			transition: background 0.2s;
		}
		button[type="submit"]:hover {
			background: #2587a3;
		}
		.msg {
			color: #e74c3c;
			text-align: center;
			margin: 10px 0 0 0;
			font-weight: 500;
		}
		.register-link {
			text-align: center;
			margin-top: 18px;
			color: #2587a3;
		}
		.register-link a {
			color: #2587a3;
			text-decoration: underline;
		}
		.register-link a:hover {
			color: #36a2c2;
		}
	</style>
</head>

<body>

	<div class="form-box">
		<h2>Login</h2>
		<form method="post">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			<button type="submit" name="login">Login</button>
		</form>
		<?php if($msg) echo '<div class="msg">'.$msg.'</div>'; ?>
		<div class="register-link">Belum punya akun? <a href="registrasi.php">Registrasi</a></div>
	</div>

</body>

</html>
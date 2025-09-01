<style>
	body {
		background: linear-gradient(120deg, #2193b0 0%, #6dd5ed 100%);
		font-family: 'Montserrat', Arial, sans-serif;
		min-height: 100vh;
		margin: 0;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.login-panel {
		background: #fff;
		max-width: 400px;
		width: 100%;
		margin: 48px auto 0 auto;
		padding: 36px 32px 28px 32px;
		border-radius: 18px;
		box-shadow: 0 8px 32px rgba(33, 147, 176, 0.13);
		position: relative;
		overflow: hidden;
	}

	.login-panel::before {
		content: '';
		position: absolute;
		top: -60px;
		right: -60px;
		width: 120px;
		height: 120px;
		background: #2193b033;
		border-radius: 50%;
		z-index: 0;
	}

	.login-title {
		color: #2193b0;
		text-align: center;
		margin-bottom: 28px;
		font-size: 2em;
		font-weight: 700;
		letter-spacing: 1px;
	}

	.login-panel label {
		font-weight: 600;
		color: #235;
		display: block;
		margin-bottom: 7px;
		margin-top: 18px;
		letter-spacing: 0.5px;
	}

	.login-panel input[type="email"],
	.login-panel input[type="password"] {
		width: 100%;
		padding: 12px 10px;
		margin-bottom: 12px;
		border-radius: 7px;
		border: 1.5px solid #2193b0;
		font-size: 1em;
		background: #f0f8ff;
		transition: border 0.2s;
	}

	.login-panel input[type="email"]:focus,
	.login-panel input[type="password"]:focus {
		outline: none;
		border: 1.5px solid #176cae;
	}

	.login-panel button[type="submit"] {
		width: 100%;
		background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
		color: #fff;
		font-weight: bold;
		border: none;
		border-radius: 7px;
		padding: 12px 0;
		font-size: 1.1em;
		cursor: pointer;
		margin-top: 18px;
		box-shadow: 0 2px 8px rgba(33, 147, 176, 0.08);
		transition: background 0.2s;
	}

	.login-panel button[type="submit"]:hover {
		background: linear-gradient(90deg, #176cae 0%, #2193b0 100%);
	}

	.msg {
		color: #176cae;
		text-align: center;
		margin: 12px 0 0 0;
		font-weight: 600;
		background: #e3f2fd;
		border: 1px solid #90caf9;
		border-radius: 6px;
		padding: 10px 0;
	}

	.register-link {
		text-align: center;
		margin-top: 22px;
		color: #2193b0;
		font-size: 0.98em;
	}

	.register-link a {
		color: #176cae;
		text-decoration: underline;
		font-weight: 600;
	}

	.register-link a:hover {
		color: #6dd5ed;
	}

	.footer-sticky {
		position: fixed;
		left: 0;
		bottom: 0;
		width: 100%;
		background: transparent;
		z-index: 10;
		margin: 0;
		padding: 12px 0 8px 0;
		text-align: center;
		color: #ffffffff;
		font-size: 0.98em;
		box-shadow: none;
	}
</style>

<?php
session_start();
require_once 'koneksi.php';
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Class AuthController
class AuthController
{
	private $database;
	private $error = '';

	// Inisialisasi Database OOP sebelum logic
	public function __construct()
	{
		try {
			$this->database = new Database(); // Panggil koneksi database
		} catch (Exception $e) {
			die('<div class="msg">Error: ' . $e->getMessage() . '</div>'); // Tangani error
		}
	}

	// Method Validasi input
	private function validateInput($username, $password)
	{
		if (empty($username) || empty($password)) {
			$this->error = 'Email dan password harus diisi!';
			return false;
		}
		if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$this->error = 'Format email tidak valid!';
			return false;
		}
		return true;
	}

	// Method membersihkan input dari karakter berbahaya
	private function sanitizeInput($input)
	{
		return htmlspecialchars(strip_tags(trim($input)));
	}

	// Method untuk set session user setelah login
	private function setUserSession($userData)
	{
		$_SESSION['user'] = [
			'id' => $userData['iduser'],
			'nama' => $userData['nama'],
			'email' => $userData['email'],
			'role_aktif' => $userData['idrole'],
			'nama_role' => $userData['nama_role'],
			'logged_in' => true,
			'login_time' => time()
		];
	}

	// Method untuk proses login
	public function login($username, $password)
	{
		// Sanitasi input
		$username = $this->sanitizeInput($username);
		$password = $this->sanitizeInput($password);

		// Validasi input
		if (!$this->validateInput($username, $password)) {
			return false;
		}

		// Query untuk mengambil data user
		$query = "SELECT u.iduser, u.nama, u.email, u.password, ru.idrole, r.nama_role FROM user u LEFT JOIN role_user ru ON ru.iduser = u.iduser LEFT JOIN role r ON r.idrole = ru.idrole_user WHERE u.email = ? AND ru.status = '1' LIMIT 1";

		// Eksekusi query
		try {
			// Ambil data user
			$result = $this->database->select($query, [$username], 's');
			// Cek apakah user ditemukan
			if ($result && count($result) > 0) {
				$row = $result[0];
				// Verifikasi password
				if (password_verify($password, $row['password'])) {
					// Set session user
					$this->setUserSession($row);
					return true;
				} else {
					$this->error = 'Password salah!';
				}
			// Jika akun tidak aktif
			} else {
				$this->error = 'Email tidak terdaftar atau akun tidak aktif!';
			}
		// Tangani kesalahan saat eksekusi query
		} catch (Exception $e) {
			$this->error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
		}
		return false;
	}

	// Method untuk mendapatkan pesan error
	public function getError()
	{
		return $this->error;
	}

	// Method untuk redirect ke halaman lain
	public function redirect($url)
	{
		if (!headers_sent()) {
			header("Location: $url");
			exit();
		}
	}

	// Method untuk memeriksa apakah pengguna sudah login
	public function isLoggedIn()
	{
		return isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true;
	}

	// Method untuk logout
	public function logout()
	{
		session_destroy();
		$this->redirect('login.php');
	}

	// Destruktor - method hapus objek otomatis
	public function __destruct()
	{
		if ($this->database) {
			$this->database->closeConnection();
		}
	}
}

// Kelas untuk tampilan login
class LoginView
{
	private $error;

	// Konstruktor error message
	public function __construct($error = '')
	{
		$this->error = $error;
	}

	// Method untuk merender form login
	public function renderLoginForm()
	{

		// Menggunakan output buffering untuk menangkap HTML
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Login RSHP</title>
		</head>

		<body>
			<div class="login-panel">
				<div style="text-align:center; margin-bottom:6px;">
					<img src="img/RSHP.png" alt="RSHP Logo" style="height:64px; width:auto; margin-bottom:2px;">
				</div>
				<div class="login-title">Login RSHP</div>
				<?php if (!empty($this->error)): ?>
					<div class="msg"><?php echo htmlspecialchars($this->error); ?></div>
				<?php endif; ?>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<label for="username">Email</label>
					<input type="email" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" placeholder="Email Anda" required autofocus>
					<label for="password">Password</label>
					<input type="password" id="password" name="password" placeholder="Password Anda" required>
					<button type="submit">Login</button>
				</form>
				<div class="register-link">Belum punya akun? <a href="registrasi.php">Daftar di sini</a></div>
			</div>
			<footer class="footer-sticky">
				&copy; <?php echo date('Y'); ?> RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga
			</footer>
		</body>

		</html>
<?php
		return ob_get_clean();
	}
}

// ====================  logika utama ====================
try {
	$authController = new AuthController();
	if ($authController->isLoggedIn()) {
		$authController->redirect('dashboard.php');
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$username = $_POST['username'] ?? '';
		$password = $_POST['password'] ?? '';
		if ($authController->login($username, $password)) {
			$authController->redirect('dashboard.php');
		}
	}
	$loginView = new LoginView($authController->getError());
	echo $loginView->renderLoginForm();
} catch (Exception $e) {
	die('<div class="alert alert-danger">System Error: ' . htmlspecialchars($e->getMessage()) . '</div>');
}

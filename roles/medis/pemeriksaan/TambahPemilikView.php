<?php
session_start();
require_once __DIR__ . '/../../../controllers/PemilikController.php';
require_once __DIR__ . '/../../../models/User.php';

class TambahPemilikView
{
	public function render()
	{
		ob_start();
?>
		<!DOCTYPE html>
		<html lang="id">

		<head>
			<meta charset="UTF-8">
			<title>Registrasi Pemilik</title>
			<link rel="stylesheet" href="../../../assets/css/tambah_pemilik.css?v=<?php echo time(); ?>">
		</head>

		<body>
			<?php include('../../../views/partials/menu.php'); ?>
			<div class="tambah-pemilik_container">
				<h2>Registrasi Pemilik</h2>
				<?php
				if (isset($_SESSION['flash_msg'])) {
					$msg = $_SESSION['flash_msg'];
					unset($_SESSION['flash_msg']);
					echo '<div class="msg">' . htmlspecialchars($msg) . '</div>';
				}
				if (isset($_POST['tambah'])) {
					require_once __DIR__ . '/../../../models/User.php';

					$user_option = $_POST['user_option'] ?? 'existing';
					$no_wa = trim($_POST['no_wa']);
					$alamat = trim($_POST['alamat']);

					// Validasi input dasar
					if (empty($no_wa) || empty($alamat)) {
						echo '<div class="msg" style="color:#d32f2f;">No. WhatsApp dan alamat harus diisi!</div>';
						goto skip_processing;
					}

					$controller = new PemilikController();

					if ($user_option === 'existing') {
						// Gunakan user yang sudah ada
						$iduser = intval($_POST['iduser'] ?? 0);
						if ($iduser <= 0) {
							echo '<div class="msg" style="color:#d32f2f;">Silakan pilih user!</div>';
							goto skip_processing;
						}

						$result = $controller->store($iduser, $no_wa, $alamat);
						if ($result === true) {
							echo '<div class="msg" style="color:#258a5a;">Berhasil menambah pemilik!</div>';
						} else {
							echo '<div class="msg" style="color:#d32f2f;">Gagal menambah pemilik!</div>';
						}
					} else {
						// Buat user baru sekaligus pemilik
						$new_nama = trim($_POST['new_nama'] ?? '');
						$new_email = trim($_POST['new_email'] ?? '');
						$new_password = trim($_POST['new_password'] ?? '');

						// Validasi input user baru
						if (empty($new_nama) || empty($new_email) || empty($new_password)) {
							echo '<div class="msg" style="color:#d32f2f;">Semua field user baru harus diisi!</div>';
							goto skip_processing;
						}

						if (strlen($new_password) < 6) {
							echo '<div class="msg" style="color:#d32f2f;">Password minimal 6 karakter!</div>';
							goto skip_processing;
						}

						if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
							echo '<div class="msg" style="color:#d32f2f;">Format email tidak valid!</div>';
							goto skip_processing;
						}

						// Gunakan method storeWithNewUser yang sudah handle transaction
						$result = $controller->storeWithNewUser($new_nama, $new_email, $new_password, $no_wa, $alamat);

						if ($result[0]) {
							echo '<div class="msg" style="color:#258a5a;">' . htmlspecialchars($result[1]) . '</div>';
						} else {
							echo '<div class="msg" style="color:#d32f2f;">' . htmlspecialchars($result[1]) . '</div>';
						}
					}

					skip_processing:
				}
				?>
				<?php
				// Ambil user yang BELUM menjadi pemilik (belum ada di tabel pemilik)
				$db = new Database();
				$sql = "SELECT u.iduser, u.nama, u.email FROM user u
			LEFT JOIN pemilik p ON u.iduser = p.iduser
			WHERE p.iduser IS NULL";
				$users = $db->select($sql);
				$selectedIdUser = isset($_GET['iduser']) ? $_GET['iduser'] : '';
				?>
				<form method="post">
					<!-- Toggle antara user existing atau registrasi baru -->
					<div class="user-option-toggle">
						<label class="toggle-option">
							<input type="radio" name="user_option" value="existing" checked onchange="toggleUserOption()">
							<span>Pilih User Existing</span>
						</label>
						<label class="toggle-option">
							<input type="radio" name="user_option" value="new" onchange="toggleUserOption()">
							<span>Registrasi User Baru</span>
						</label>
					</div>

					<!-- Seleksi User yang sudah ada -->
					<div id="existing-user-section">
						<label for="iduser">Pilih User:</label>
						<select id="iduser" name="iduser">
							<option value="">-- Pilih User --</option>
							<?php foreach ($users as $user): ?>
								<option value="<?= htmlspecialchars($user['iduser']) ?>" <?= ($selectedIdUser == $user['iduser']) ? 'selected' : '' ?>>
									<?= htmlspecialchars($user['nama']) ?> (<?= htmlspecialchars($user['email']) ?>)
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<!-- New User Registration -->
					<div id="new-user-section" style="display: none;">
						<div class="new-user-fields">
							<label for="new_nama">Nama Lengkap:</label>
							<input type="text" id="new_nama" name="new_nama" placeholder="Masukkan nama lengkap">

							<label for="new_email">Email:</label>
							<input type="email" id="new_email" name="new_email" placeholder="contoh@email.com">

							<label for="new_password">Password:</label>
							<input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter">

							<div class="auto-role-info">
								<small>✓ User akan otomatis mendapat role pemilik (ID: 5)</small>
							</div>
						</div>
					</div>

					<!-- Informasi Pemilik -->
					<div class="pemilik-info">
						<h3>Informasi Pemilik</h3>
						<label for="no_wa">No. WhatsApp:</label>
						<input type="text" id="no_wa" name="no_wa" placeholder="08xxxxxxxxxx" required>

						<label for="alamat">Alamat Lengkap:</label>
						<textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap..." required></textarea>
					</div>

					<div class="form-actions">
						<a href="PemilikView.php" class="back-link">Kembali</a>
						<button type="submit" name="tambah">Tambah Pemilik</button>
					</div>
				</form>

				<script>
					// JavaScript untuk toggle antara existing user dan new user
					function toggleUserOption() {
						// opsi user yang dipilih
						const userOption = document.querySelector('input[name="user_option"]:checked').value;
						// section untuk user existing
						const existingSection = document.getElementById('existing-user-section');
						// section untuk user baru
						const newSection = document.getElementById('new-user-section');
						// Memilih user yang ada
						const iduserSelect = document.getElementById('iduser');
						// Field input untuk user baru
						const newUserFields = document.querySelectorAll('#new-user-section input');

						// Hapus Kelas yang ada
						existingSection.classList.remove('visible', 'hidden');
						newSection.classList.remove('visible', 'hidden');

						if (userOption === 'existing') {
							// Tampilkan bagian user existing dengan animasi
							existingSection.classList.add('visible');
							newSection.classList.add('hidden');
							iduserSelect.required = true;
							newUserFields.forEach(field => field.required = false);

							// Bersihkan form user baru saat beralih
							clearNewUserForm();
						} else {
							// Tampilkan bagian user baru dengan animasi
							existingSection.classList.add('hidden');
							newSection.classList.add('visible');
							iduserSelect.required = false;
							iduserSelect.value = '';
							newUserFields.forEach(field => field.required = true);

							// Fokus pada input pertama di bagian user baru
							setTimeout(() => {
								const firstInput = newSection.querySelector('input[type="text"]');
								if (firstInput) firstInput.focus();
							}, 300);
						}
					}

					// Fungsi untuk membersihkan form user baru
					function clearNewUserForm() {
						const newUserInputs = document.querySelectorAll('#new-user-section input');
						newUserInputs.forEach(input => {
							input.value = '';
							input.classList.remove('error');
						});

						// Bersihkan pesan error
						const errorMessages = document.querySelectorAll('#new-user-section .error-message');
						errorMessages.forEach(msg => msg.remove());
					}

					// Fungsi validasi form user baru
					function validateNewUserForm() {
						const nama = document.getElementById('new_nama').value.trim();
						const email = document.getElementById('new_email').value.trim();
						const password = document.getElementById('new_password').value;

						let isValid = true;

						// Bersihkan pesan error sebelumnya
						clearErrorMessages();

						// Validasi nama
						if (nama.length < 2) {
							showError('new_nama', 'Nama harus minimal 2 karakter');
							isValid = false;
						}

						// Validasi email
						const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
						if (!emailRegex.test(email)) {
							showError('new_email', 'Format email tidak valid');
							isValid = false;
						}

						// Validasi password
						if (password.length < 6) {
							showError('new_password', 'Password harus minimal 6 karakter');
							isValid = false;
						}

						return isValid;
					}

					// Fungsi untuk menampilkan pesan error di bawah input
					function showError(inputId, message) {
						const input = document.getElementById(inputId);
						input.classList.add('error');

						const errorDiv = document.createElement('div');
						errorDiv.className = 'error-message';
						errorDiv.textContent = message;

						input.parentNode.appendChild(errorDiv);
					}

					// Fungsi untuk menghapus semua pesan error
					function clearErrorMessages() {
						const errorMessages = document.querySelectorAll('.error-message');
						errorMessages.forEach(msg => msg.remove());

						const errorInputs = document.querySelectorAll('.error');
						errorInputs.forEach(input => input.classList.remove('error'));
					}

					// Inisialisasi form saat halaman dimuat
					document.addEventListener('DOMContentLoaded', function() {
						// Tetapkan pilihan default ke user existing
						const existingRadio = document.querySelector('input[name="user_option"][value="existing"]');
						if (existingRadio) {
							existingRadio.checked = true;
							toggleUserOption();
						}

						// Tambahkan validasi form saat submit
						const form = document.querySelector('form');
						if (form) {
							form.addEventListener('submit', function(e) {
								const userOption = document.querySelector('input[name="user_option"]:checked').value;

								if (userOption === 'new') {
									if (!validateNewUserForm()) {
										e.preventDefault();
										return false;
									}
								}

								// Tambahkan status loading
								form.classList.add('form-loading');
							});
						}
					});
				</script>
			</div>
			<?php include('../../../views/partials/footer.php'); ?>
		</body>

		</html>
<?php
		return ob_get_clean();
	}
}

$view = new TambahPemilikView();
echo $view->render();

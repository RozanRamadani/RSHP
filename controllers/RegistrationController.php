<?php
require_once __DIR__ . '/../models/User.php';

class RegistrationController {
    private $error = '';
    private $success = '';

    // Validasi input registrasi
    private function validateInput($nama, $email, $password, $password2) {
        if (empty($nama) || empty($email) || empty($password) || empty($password2)) {
            $this->error = 'Semua field harus diisi!';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Format email tidak valid!';
            return false;
        }

        if (strlen($password) < 6) {
            $this->error = 'Password minimal 6 karakter!';
            return false;
        }

        if ($password !== $password2) {
            $this->error = 'Password tidak sama!';
            return false;
        }

        return true;
    }

    // Sanitasi input
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Proses registrasi
    public function register($nama, $email, $password, $password2, $jadi_peserta = false) {
        // Sanitasi input
        $nama = $this->sanitizeInput($nama);
        $email = $this->sanitizeInput($email);

        // Validasi input
        if (!$this->validateInput($nama, $email, $password, $password2)) {
            return false;
        }

        try {
            // Cek apakah email sudah terdaftar
            if (User::emailExists($email)) {
                $this->error = 'Email sudah terdaftar!';
                return false;
            }

            // Buat user baru
            $userCreated = User::createUser($nama, $email, $password);
            
            if ($userCreated > 0) {
                // Jika user memilih jadi peserta, assign role pemilik
                if ($jadi_peserta) {
                    $newUser = User::getByEmail($email);
                    if ($newUser) {
                        $roleAssigned = User::assignRole($newUser['iduser'], 5); // Role 5 = Pemilik
                        if ($roleAssigned > 0) {
                            $this->success = 'Registrasi berhasil! Anda terdaftar sebagai peserta (pemilik pet). Silakan login.';
                        } else {
                            $this->success = 'Registrasi berhasil, namun gagal mengatur role peserta. Silakan hubungi admin.';
                        }
                    } else {
                        $this->success = 'Registrasi berhasil, namun gagal mengatur role peserta. Silakan hubungi admin.';
                    }
                } else {
                    $this->success = 'Registrasi berhasil! Silakan login.';
                }
                return true;
            } else {
                $this->error = 'Registrasi gagal! Silakan coba lagi.';
                return false;
            }
        } catch (Exception $e) {
            $this->error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
            return false;
        }
    }

    // Get error message
    public function getError() {
        return $this->error;
    }

    // Get success message
    public function getSuccess() {
        return $this->success;
    }

    // Get message (error atau success)
    public function getMessage() {
        return !empty($this->error) ? $this->error : $this->success;
    }
}
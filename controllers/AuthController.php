<?php
require_once __DIR__ . '/../models/Auth.php';

class AuthController {
    private $authModel;
    private $error = '';

    public function __construct() {
        $this->authModel = new Auth();
    }

    // Validasi input
    private function validateInput($email, $password) {
        if (empty($email) || empty($password)) {
            $this->error = 'Email dan password harus diisi!';
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = 'Format email tidak valid!';
            return false;
        }
        return true;
    }

    // Sanitasi input
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Set session user
    private function setUserSession($userData) {
        $_SESSION['user'] = [
            'id' => $userData['iduser'],
            'nama' => $userData['nama'],
            'email' => $userData['email'],
            'role_aktif' => $userData['idrole'],
            'nama_role' => $userData['nama_role'],
            'logged_in' => true,
            'login_time' => time()
        ];
        $_SESSION['idrole'] = $userData['idrole'];
    }

    // Proses login
    public function login($email, $password) {
        // Sanitasi input
        $email = $this->sanitizeInput($email);
        $password = $this->sanitizeInput($password);

        // Validasi input
        if (!$this->validateInput($email, $password)) {
            return false;
        }

        try {
            // Autentikasi user
            $user = $this->authModel->authenticate($email, $password);
            
            if ($user) {
                $this->setUserSession($user);
                return true;
            } else {
                $this->error = 'Email atau password salah!';
                return false;
            }
        } catch (Exception $e) {
            $this->error = 'Terjadi kesalahan sistem: ' . $e->getMessage();
            return false;
        }
    }

    // Cek apakah user sudah login
    public function isLoggedIn() {
        return isset($_SESSION['user']['logged_in']) && $_SESSION['user']['logged_in'] === true;
    }

    // Logout user
    public function logout() {
        session_destroy();
        $this->redirect('/views/auth/login.php');
    }

    // Get error message
    public function getError() {
        return $this->error;
    }

    // Redirect ke URL
    public function redirect($url) {
        if (!headers_sent()) {
            header("Location: $url");
            exit();
        }
    }

    // Get redirect URL berdasarkan role
    public function getRedirectUrlByRole($role) {
        $roleUrls = [
            1 => '/roles/admin/dashboard.php',
            2 => '/roles/medis/dashboard_dokter.php', 
            3 => '/roles/medis/dashboard_perawat.php',
            4 => '/roles/resepsionis/dashboard_resepsionis.php',
            5 => '/roles/pemilik/dashboard_pemilik.php'
        ];

        return $roleUrls[$role] ?? '/roles/admin/dashboard.php';
    }
}
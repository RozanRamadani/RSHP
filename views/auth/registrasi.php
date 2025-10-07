<?php
/**
 * Registration Page - Entry Point
 * Mengikuti standar MVC Pattern
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load required files
require_once __DIR__ . '/../../controllers/RegistrationController.php';
require_once __DIR__ . '/RegistrationView.php';

try {
    // Initialize controller
    $registrationController = new RegistrationController();
    
    // Initialize form data untuk maintain input values
    $formData = [];
    $message = '';

    // Handle POST request (form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        // Ambil data dari form
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $jadi_peserta = isset($_POST['jadi_peserta']);

        // Simpan form data untuk maintain values jika error
        $formData = [
            'nama' => $nama,
            'email' => $email,
            'jadi_peserta' => $jadi_peserta
        ];

        // Proses registrasi
        if ($registrationController->register($nama, $email, $password, $password2, $jadi_peserta)) {
            // Registrasi berhasil - clear form data
            $formData = [];
        }
        
        // Ambil pesan (error atau success)
        $message = $registrationController->getMessage();
    }

    // Render registration form
    $registrationView = new RegistrationView($message, $formData);
    echo $registrationView->render();

} catch (Exception $e) {
    die('<div class="alert alert-danger">System Error: ' . htmlspecialchars($e->getMessage()) . '</div>');
}

<?php
/**
 * Login Page - Entry Point
 * Mengikuti standar MVC Pattern
 */

session_start();

// Load required files
require_once __DIR__ . '/../../controllers/AuthController.php';
require_once __DIR__ . '/LoginView.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Initialize controller
    $authController = new AuthController();

    // Check if user already logged in
    if ($authController->isLoggedIn()) {
        $role = $_SESSION['user']['role_aktif'] ?? null;
        $authController->redirect($authController->getRedirectUrlByRole($role));
    }

    // Handle POST request (login form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($authController->login($email, $password)) {
            // Login successful - redirect to appropriate dashboard
            $role = $_SESSION['user']['role_aktif'] ?? null;
            $authController->redirect($authController->getRedirectUrlByRole($role));
        }
    }

    // Render login form
    $username = $_POST['username'] ?? '';
    $loginView = new LoginView($authController->getError(), $username);
    echo $loginView->render();

} catch (Exception $e) {
    die('<div class="alert alert-danger">System Error: ' . htmlspecialchars($e->getMessage()) . '</div>');
}
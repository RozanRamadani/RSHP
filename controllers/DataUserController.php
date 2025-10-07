<?php
require_once __DIR__ . '/../models/User.php';
class DataUserController
{
    public $users;

    // Konstruktor - method inisialisasi objek
    public function __construct()
    {
        // Ambil semua user
        $this->users = User::getAllUsers();
    }
}

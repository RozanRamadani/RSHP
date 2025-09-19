<?php
require_once __DIR__ . '/../models/User.php';
class DataUserController
{
    public $users;
    public function __construct()
    {
        $this->users = User::getAllUsers();
    }
}

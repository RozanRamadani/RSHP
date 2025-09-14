<?php
class DataUserController
{
    private $db;
    public $users;
    public function __construct()
    {
        $this->db = new Database();
        $this->users = $this->db->select("SELECT * FROM user");
    }
}

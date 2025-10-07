<?php
require_once __DIR__ . '/../databases/koneksi.php';

class Auth
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Validasi user login
    public function authenticate($email, $password)
    {
        $query = "SELECT u.iduser, u.nama, u.email, u.password, ru.idrole, r.nama_role 
                  FROM user u 
                  LEFT JOIN role_user ru ON ru.iduser = u.iduser 
                  LEFT JOIN role r ON r.idrole = ru.idrole 
                  WHERE u.email = ? AND ru.status = '1' 
                  LIMIT 1";

        $result = $this->db->select($query, [$email], 's');

        if ($result && count($result) > 0) {
            $user = $result[0];
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // Cek apakah email ada di database
    public function emailExists($email)
    {
        $query = "SELECT iduser FROM user WHERE email = ?";
        $result = $this->db->select($query, [$email], 's');
        return $result && count($result) > 0;
    }

    // Cek apakah user memiliki role aktif
    public function hasActiveRole($iduser)
    {
        $query = "SELECT idrole FROM role_user WHERE iduser = ? AND status = '1'";
        $result = $this->db->select($query, [$iduser], 'i');
        return $result && count($result) > 0;
    }

    // Debug method - cek user exist tanpa role check
    public function debugGetUser($email) {
        $query = "SELECT u.iduser, u.nama, u.email, u.password FROM user u WHERE u.email = ?";
        $result = $this->db->select($query, [$email], 's');
        return $result;
    }

    // Debug method - cek role user
    public function debugGetUserRoles($iduser) {
        $query = "SELECT ru.*, r.nama_role FROM role_user ru LEFT JOIN role r ON r.idrole = ru.idrole WHERE ru.iduser = ?";
        $result = $this->db->select($query, [$iduser], 'i');
        return $result;
    }
}

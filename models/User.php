<?php
require_once __DIR__ . '/helper/Respon.php';
require_once __DIR__ . '/../databases/koneksi.php';


class User
{
    protected $iduser;
    protected $nama;
    protected $email;
    protected $password;

    public function set_password($password)
    {
        $this->password = $password;
    }

    public function set_data_user(int $iduser = 0, string $nama = '', string $email = '')
    {
        $this->iduser = $iduser;
        $this->nama = $nama;
        $this->email = $email;
    }

    public function email_exists($email): bool
    {
        $db = new Database();
        $sql = "SELECT iduser FROM user WHERE email = ?";
        $result = $db->select($sql, [$email], 's');
        return $result && count($result) > 0;
    }

    public function create(): bool|string
    {
        if ($this->email_exists($this->email)) {
            return "Email sudah terdaftar!";
        }
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $db = new Database();
        $sql = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
        $result = $db->execute($sql, [$this->nama, $this->email, $password], 'sss');
        return $result;
    }

    public function get_user_by_id(): Respon
    {
        $db = new Database();
        $sql = "SELECT * FROM user WHERE iduser = ?";
        $result = $db->select($sql, [$this->iduser], 'i');
        if ($result && count($result) > 0) {
            $user_data = $result[0];
            $this->set_data_user($user_data['iduser'], $user_data['nama'], $user_data['email']);
            return new Respon(true, "User found", $user_data);
        } else {
            return new Respon(false, "User not found", []);
        }
    }

    // Ambil semua user
    public static function getAllUsers()
    {
        $db = new Database();
        $sql = "SELECT iduser, nama, email FROM user";
        return $db->select($sql);
    }

    public static function getAllDokter()
    {
        $db = new Database();
        $sql = "SELECT u.iduser, u.nama FROM user u
                JOIN role_user ru ON u.iduser = ru.iduser
                WHERE ru.idrole = 2 AND ru.status = 1";
        return $db->select($sql);
    }
}

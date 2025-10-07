<?php
require_once __DIR__ . '/helper/Respon.php';
require_once __DIR__ . '/../databases/koneksi.php';


class User
{
    protected $iduser;
    protected $nama;
    protected $email;
    protected $password;

    // Setters password
    public function set_password($password)
    {
        $this->password = $password;
    }

    // Set data user
    public function set_data_user(int $iduser = 0, string $nama = '', string $email = '')
    {
        $this->iduser = $iduser;
        $this->nama = $nama;
        $this->email = $email;
    }

    // Cek apakah email sudah terdaftar
    public function email_exists($email): bool
    {
        $db = new Database();
        $sql = "SELECT iduser FROM user WHERE email = ?";
        $result = $db->select($sql, [$email], 's');
        return $result && count($result) > 0;
    }

    // Create user baru
    public function create(): bool|string
    {
        if ($this->email_exists($this->email)) {
            return "Email sudah terdaftar!";
        }
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $db = new Database();
        $sql = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
        $result = $db->insertAndGetId($sql, [$this->nama, $this->email, $password], 'sss');
        return $result > 0 ? true : "Gagal membuat user";
    }

    // Ambil user berdasarkan iduser
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

    // Ambil semua dokter
    public static function getAllDokter()
    {
        $db = new Database();
        $sql = "SELECT u.iduser, u.nama FROM user u
                JOIN role_user ru ON u.iduser = ru.iduser
                WHERE ru.idrole = 2 AND ru.status = 1";
        return $db->select($sql);
    }

    // Method untuk registrasi
    public static function emailExists($email) {
        $db = new Database();
        $query = "SELECT iduser FROM user WHERE email = ?";
        $result = $db->select($query, [$email], 's');
        return $result && count($result) > 0;
    }

	// Buat user baru dan return ID
	public static function createUser($nama, $email, $password) {
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$db = new Database();
		$query = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
		return $db->insertAndGetId($query, [$nama, $email, $hashedPassword], 'sss');
	}    // Ambil user berdasarkan email
    public static function getByEmail($email) {
        $db = new Database();
        $query = "SELECT iduser, nama, email FROM user WHERE email = ?";
        $result = $db->select($query, [$email], 's');
        return $result && count($result) > 0 ? $result[0] : null;
    }

    // Assign role ke user
    public static function assignRole($iduser, $idrole, $status = 1) {
        $db = new Database();
        $query = "INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, ?)";
        $result = $db->execute($query, [$iduser, $idrole, $status], 'iii');
        return $result > 0;
    }
}

<?php
class TambahUserController
{
    private $db;
    public $msg = '';
    public function __construct()
    {
        $this->db = new Database();
        if (isset($_POST['tambah'])) {
            $nama = htmlspecialchars(strip_tags(trim($_POST['nama'])));
            $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
            $password = $_POST['password'];
            $retype = $_POST['retype'];
            if ($password !== $retype) {
                $this->msg = 'Password tidak sama!';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user (nama, email, password) VALUES (?, ?, ?)";
                try {
                    $affected = $this->db->execute($sql, [$nama, $email, $hash], 'sss');
                    if ($affected > 0) {
                        $this->msg = 'User baru berhasil ditambahkan!';
                    } else {
                        $this->msg = 'Gagal menambah user!';
                    }
                } catch (Exception $e) {
                    $this->msg = 'Gagal menambah user!';
                }
            }
        }
    }
}
?>

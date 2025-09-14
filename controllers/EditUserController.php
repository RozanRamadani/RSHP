<?php
    class EditUserController {
    private $db;
    public $user;
    public $msg = '';
    private $iduser;
    public function __construct() {
        $this->db = new Database();
        $this->iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($this->iduser > 0) {
            if (isset($_POST['update'])) {
                $nama = htmlspecialchars(strip_tags(trim($_POST['nama'])));
                $sql = "UPDATE user SET nama=? WHERE iduser=?";
                try {
                    $affected = $this->db->execute($sql, [$nama, $this->iduser], 'si');
                    if ($affected > 0) {
                        $this->msg = 'Nama user berhasil diupdate!';
                    } else {
                        $this->msg = 'Gagal update nama user!';
                    }
                } catch (Exception $e) {
                    $this->msg = 'Gagal update nama user!';
                }
            }
            $result = $this->db->select("SELECT * FROM user WHERE iduser=?", [$this->iduser], 'i');
            $this->user = $result ? $result[0] : null;
        } else {
            header("Location: /views/admin/data_user.php");
            exit();
        }
    }
}

?>
<?php
class TambahRoleController
{
    private $db;
    public $msg = '';
    public $iduser;
    public $nama_user = '';
    public $roles = [];
    public function __construct()
    {
        $this->db = new Database();
        $this->iduser = isset($_GET['iduser']) ? intval($_GET['iduser']) : 0;
        if ($this->iduser > 0) {
            $res_nama = $this->db->select("SELECT nama FROM user WHERE iduser=?", [$this->iduser], 'i');
            if ($res_nama && count($res_nama) > 0) {
                $this->nama_user = $res_nama[0]['nama'];
            }
        }
        $this->roles = $this->db->select("SELECT MIN(idrole) as idrole, nama_role FROM role GROUP BY nama_role");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->iduser > 0) {
            $idrole = intval($_POST['idrole']);
            $status = intval($_POST['status']);
            $cek = $this->db->select("SELECT * FROM role_user WHERE iduser=? AND idrole=?", [$this->iduser, $idrole], 'ii');
            if ($cek && count($cek) > 0) {
                $this->msg = 'Role sudah ada untuk user ini!';
            } else {
                $sql = "INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, ?)";
                try {
                    $affected = $this->db->execute($sql, [$this->iduser, $idrole, $status], 'iii');
                    if ($affected > 0) {
                        $this->msg = 'Role berhasil ditambahkan!';
                    } else {
                        $this->msg = 'Gagal menambahkan role!';
                    }
                } catch (Exception $e) {
                    $this->msg = 'Gagal menambahkan role!';
                }
            }
        }
    }
}

?>

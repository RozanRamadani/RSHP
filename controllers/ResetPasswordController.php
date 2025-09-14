<?php
class ResetPasswordController
{
    private $db;
    public $msg = '';
    public $iduser;
    public function __construct()
    {
        $this->db = new Database();
        $this->iduser = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($this->iduser > 0) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $new_password = $_POST['new_password'] ?? '';
                $retype = $_POST['retype_password'] ?? '';
                if (empty($new_password) || empty($retype)) {
                    $this->msg = 'Password baru dan konfirmasi harus diisi!';
                } elseif ($new_password !== $retype) {
                    $this->msg = 'Password baru dan konfirmasi tidak sama!';
                } else {
                    $hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE user SET password=? WHERE iduser=?";
                    try {
                        $affected = $this->db->execute($sql, [$hash, $this->iduser], 'si');
                        if ($affected > 0) {
                            $this->msg = 'Password berhasil direset!';
                        } else {
                            $this->msg = 'Gagal reset password!';
                        }
                    } catch (Exception $e) {
                        $this->msg = 'Gagal reset password!';
                    }
                }
            }
        } else {
            header("Location: /views/admin/data_user.php");
            exit();
        }
    }
}

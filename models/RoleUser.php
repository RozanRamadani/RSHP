<?php
require_once __DIR__ . '/../databases/koneksi.php';

class RoleUser {
    // Ambil semua user yang punya role tertentu (misal: Pemilik)
    public static function getUsersByRole($nama_role = 'Pemilik') {
        $db = new Database();
        $sql = "SELECT u.iduser, u.nama, u.email FROM user u 
                JOIN role_user ru ON u.iduser = ru.iduser 
                JOIN role r ON ru.idrole = r.idrole 
                WHERE r.nama_role = ? AND ru.status = 1";
        return $db->select($sql, [$nama_role], 's');
    }
}

<?php
require_once __DIR__ . '/../databases/koneksi.php';

class RoleUser
{

    // Ambil semua role dokter besera nama usernya
    public static function getDokterList()
    {
        $db = new Database();
        $sql = "SELECT ru.idrole_user, u.nama FROM role_user ru
            JOIN user u ON ru.iduser = u.iduser
            WHERE ru.idrole = 2 AND ru.status = 1";
        return $db->select($sql);
    }

    // Ambil semua user yang punya role tertentu
    // Defaultnya adalah 'Pemilik'
    public static function getUsersByRole($nama_role = 'Pemilik')
    {
        $db = new Database();
        $sql = "SELECT u.iduser, u.nama, u.email FROM user u 
            JOIN role_user ru ON u.iduser = ru.iduser 
            JOIN role r ON ru.idrole = r.idrole 
            WHERE r.nama_role = ? AND ru.status = 1";
        return $db->select($sql, [$nama_role], 's');
    }
}

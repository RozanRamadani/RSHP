<?php
require_once __DIR__ . '/../databases/koneksi.php';

class Role {
    // Ambil idrole berdasarkan nama_role
    public static function getIdByName($nama_role) {
        $db = new Database();
        $sql = "SELECT idrole FROM role WHERE nama_role = ? LIMIT 1";
        $result = $db->select($sql, [$nama_role], 's');
        return $result && count($result) > 0 ? $result[0]['idrole'] : null;
    }
}

<?php
require_once __DIR__ . '/../databases/koneksi.php';

class TemuDokter {

    public static function getNoUrutHariIni() {
        $db = new Database();
        $sql = "SELECT COUNT(*) as total FROM temu_dokter WHERE DATE(waktu_daftar) = CURDATE()";
        $result = $db->select($sql);
        return $result ? $result[0]['total'] : 0;
    }


    public static function insert($idpet, $idrole_user, $no_urut) {
        $db = new Database();
        $sql = "INSERT INTO temu_dokter (idpet, idrole_user, no_urut, status) VALUES (?, ?, ?, ?)";
        return $db->execute($sql, [$idpet, $idrole_user, $no_urut, 'M'], 'iiii');
    }

    public static function getAntrianHariIni() {
        $db = new Database();
        $sql = "SELECT * FROM temu_dokter WHERE DATE(waktu_daftar) = CURDATE() ORDER BY no_urut ASC";
        return $db->select($sql);
    }
}

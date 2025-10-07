<?php
require_once __DIR__ . '/../databases/koneksi.php';

class TemuDokter {

    // Ambil jumlah no_urut hari ini
    public static function getNoUrutHariIni() {
        $db = new Database();
        $sql = "SELECT COUNT(*) as total FROM temu_dokter WHERE DATE(waktu_daftar) = CURDATE()";
        $result = $db->select($sql);
        return $result ? $result[0]['total'] : 0;
    }

    // Menambah data temu dokter
    public static function insert($idpet, $idrole_user, $no_urut) {
        $db = new Database();
        $sql = "INSERT INTO temu_dokter (idpet, idrole_user, no_urut, status) VALUES (?, ?, ?, ?)";
        return $db->execute($sql, [$idpet, $idrole_user, $no_urut, 'M'], 'iiii');
    }

    // Ambil antrian hari ini
    public static function getAntrianHariIni() {
        $db = new Database();
        $sql = "SELECT * FROM temu_dokter WHERE DATE(waktu_daftar) = CURDATE() ORDER BY no_urut ASC";
        return $db->select($sql);
    }

    // Ambil semua idreservasi_dokter untuk dropdown
    public static function getAllReservasiDokter() {
        $db = new Database();
        $sql = "SELECT td.idreservasi_dokter, p.nama AS nama_pet
        FROM temu_dokter td
        LEFT JOIN pet p ON td.idpet = p.idpet
        ORDER BY td.idreservasi_dokter DESC";
        return $db->select($sql);
    }

    // Ambil reservasi berdasarkan id pemilik
    public function getByPemilik($idpemilik) {
        $db = new Database();
        $sql = "SELECT td.*, p.nama as nama_pet, u.nama as nama_dokter 
                FROM temu_dokter td 
                LEFT JOIN pet p ON td.idpet = p.idpet 
                LEFT JOIN role_user ru ON td.idrole_user = ru.idrole_user
                LEFT JOIN user u ON ru.iduser = u.iduser
                WHERE p.idpemilik = ? 
                ORDER BY td.waktu_daftar DESC";
        return $db->select($sql, [$idpemilik], 'i');
    }

    // Ambil satu reservasi berdasarkan id
    public function getById($idreservasi_dokter) {
        $db = new Database();
        $sql = "SELECT td.*, p.nama as nama_pet, u.nama as nama_dokter 
                FROM temu_dokter td 
                LEFT JOIN pet p ON td.idpet = p.idpet 
                LEFT JOIN role_user ru ON td.idrole_user = ru.idrole_user
                LEFT JOIN user u ON ru.iduser = u.iduser
                WHERE td.idreservasi_dokter = ?";
        $result = $db->select($sql, [$idreservasi_dokter], 'i');
        return $result ? $result[0] : null;
    }
}

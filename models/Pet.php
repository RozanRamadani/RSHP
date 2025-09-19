<?php
require_once __DIR__ . '/../databases/koneksi.php';

class Pet {
    public static function getAll() {
        $db = new Database();
        $sql = "SELECT * FROM pet";
        return $db->select($sql);
    }

    public static function create($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan) {
        $db = new Database();
        $sql = "INSERT INTO pet (nama, tanggal_lahir, warna_tanda, jenis_kelamin, idpemilik, idras_hewan) VALUES (?, ?, ?, ?, ?, ?)";
        return $db->execute($sql, [$nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan], 'ssssii');
    }

        public static function getById($idpet) {
            $db = new Database();
            $sql = "SELECT * FROM pet WHERE idpet = ?";
            $result = $db->select($sql, [$idpet], 'i');
            return $result ? $result[0] : null;
        }

        public static function update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan) {
            $db = new Database();
            $sql = "UPDATE pet SET nama = ?, tanggal_lahir = ?, warna_tanda = ?, jenis_kelamin = ?, idpemilik = ?, idras_hewan = ? WHERE idpet = ?";
            return $db->execute($sql, [$nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan, $idpet], 'ssssiii');
        }

        public static function delete($idpet) {
            $db = new Database();
            $sql = "DELETE FROM pet WHERE idpet = ?";
            return $db->execute($sql, [$idpet], 'i');
        }

    
}

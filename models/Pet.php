<?php
require_once __DIR__ . '/../databases/koneksi.php';

class Pet
{

    // Ambil semua data hewan peliharaan
    public static function getAll()
    {
        $db = new Database();
        $sql = "SELECT * FROM pet";
        return $db->select($sql);
    }

    // Tambah data hewan peliharaan
    public static function create($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        $db = new Database();
        $sql = "INSERT INTO pet (nama, tanggal_lahir, warna_tanda, jenis_kelamin, idpemilik, idras_hewan) VALUES (?, ?, ?, ?, ?, ?)";
        return $db->execute($sql, [$nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan], 'ssssii');
    }

    // Ambil data hewan peliharaan berdasarkan ID
    public static function getById($idpet)
    {
        $db = new Database();
        $sql = "SELECT * FROM pet WHERE idpet = ?";
        $result = $db->select($sql, [$idpet], 'i');
        return $result ? $result[0] : null;
    }

    // Update data hewan peliharaan
    public static function update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        $db = new Database();
        $sql = "UPDATE pet SET nama = ?, tanggal_lahir = ?, warna_tanda = ?, jenis_kelamin = ?, idpemilik = ?, idras_hewan = ? WHERE idpet = ?";
        return $db->execute($sql, [$nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan, $idpet], 'ssssiii');
    }

    // Hapus data hewan peliharaan
    public static function delete($idpet)
    {
        $db = new Database();
        $sql = "DELETE FROM pet WHERE idpet = ?";
        return $db->execute($sql, [$idpet], 'i');
    }

    // Ambil pet berdasarkan id pemilik
    public function getByPemilik($idpemilik)
    {
        $db = new Database();
        $sql = "SELECT p.*, rh.nama_ras, jh.nama_jenis_hewan FROM pet p 
                LEFT JOIN ras_hewan rh ON p.idras_hewan = rh.idras_hewan 
                LEFT JOIN jenis_hewan jh ON rh.idjenis_hewan = jh.idjenis_hewan 
                WHERE p.idpemilik = ?";
        return $db->select($sql, [$idpemilik], 'i');
    }
}

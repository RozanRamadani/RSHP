<?php
require_once __DIR__ . '/../databases/koneksi.php';

class KategoriKlinis {

    // Mengambil semua data kategori klinis
    public static function getAll() {
        $db = new Database();
        $sql = "SELECT * FROM kategori_klinis";
        return $db->select($sql);
    }

    // Menambah data kategori klinis
    public static function insert($nama_kategori_klinis) {
        $db = new Database();
        $sql = "INSERT INTO kategori_klinis (nama_kategori_klinis) VALUES (?)";
        return $db->execute($sql, [$nama_kategori_klinis], 's');
    }

    // Update data kategori klinis
    public static function update($idkategori_klinis, $nama_kategori_klinis) {
        $db = new Database();
        $sql = "UPDATE kategori_klinis SET nama_kategori_klinis = ? WHERE idkategori_klinis = ?";
        return $db->execute($sql, [$nama_kategori_klinis, $idkategori_klinis], 'si');
    }

    // Hapus data kategori klinis
    public static function delete($idkategori_klinis) {
        $db = new Database();
        $sql = "DELETE FROM kategori_klinis WHERE idkategori_klinis = ?";
        return $db->execute($sql, [$idkategori_klinis], 'i');
    }

    // Ambil data kategori klinis berdasarkan ID
    public static function getById($idkategori_klinis) {
        $db = new Database();
        $sql = "SELECT * FROM kategori_klinis WHERE idkategori_klinis = ?";
        $result = $db->select($sql, [$idkategori_klinis], 'i');
        return $result ? $result[0] : null;
    }
}

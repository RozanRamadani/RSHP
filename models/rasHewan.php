<?php
require_once __DIR__ . '/helper/Respon.php';
class rasHewan {
    private $db;

    // Konstruktor untuk inisialisasi koneksi database
    public function __construct() {
        // Pastikan class Database sudah ada dan di-require
        $this->db = new Database();
    }

    // Ambil semua ras hewan (bisa difilter per jenis)
    public function get_all($idjenis_hewan = null) {
        if ($idjenis_hewan) {
            $sql = "SELECT * FROM ras_hewan WHERE idjenis_hewan = ?";
            return $this->db->select($sql, [$idjenis_hewan], 'i');
        } else {
            $sql = "SELECT * FROM ras_hewan";
            return $this->db->select($sql);
        }
    }

    // Tambah ras hewan
    public function insert_db($nama_ras, $idjenis_hewan) {
        $sql = "INSERT INTO ras_hewan (nama_ras, idjenis_hewan) VALUES (?, ?)";
        $result = $this->db->execute($sql, [$nama_ras, $idjenis_hewan], 'si');
        if ($result) {
            return new Respon(true, "Berhasil menambah ras hewan");
        } else {
            return new Respon(false, "Gagal menambah ras hewan");
        }
    }

    // Update ras hewan
    public function update_db($idras_hewan, $nama_ras, $idjenis_hewan) {
        $sql = "UPDATE ras_hewan SET nama_ras=?, idjenis_hewan=? WHERE idras_hewan=?";
        $result = $this->db->execute($sql, [$nama_ras, $idjenis_hewan, $idras_hewan], 'sii');
        if ($result) {
            return new Respon(true, "Berhasil update ras hewan");
        } else {
            return new Respon(false, "Gagal update ras hewan");
        }
    }

    // Hapus ras hewan
    public function delete_db($idras_hewan) {
        $sql = "DELETE FROM ras_hewan WHERE idras_hewan=?";
        $result = $this->db->execute($sql, [$idras_hewan], 'i');
        if ($result) {
            return new Respon(true, "Berhasil hapus ras hewan");
        } else {
            return new Respon(false, "Gagal hapus ras hewan");
        }
    }

    // Ambil satu ras hewan
    public function get_by_id($idras_hewan) {
        $sql = "SELECT * FROM ras_hewan WHERE idras_hewan=?";
        $result = $this->db->select($sql, [$idras_hewan], 'i');
        return $result ? $result[0] : null;
    }
}
<?php
require_once __DIR__ . '/../databases/koneksi.php';

class DetailRekamMedis {
    // Ambil satu detail rekam medis
    public function getById($iddetail_rekam_medis) {
        $db = new Database();
        $sql = "SELECT * FROM detail_rekam_medis WHERE iddetail_rekam_medis = ?";
        $result = $db->select($sql, [$iddetail_rekam_medis], 'i');
        return $result ? $result[0] : null;
    }
    // Ambil semua detail rekam medis untuk satu rekam medis
    public function getAllByRekamMedis($idrekam_medis) {
        $db = new Database();
        $sql = "SELECT * FROM detail_rekam_medis WHERE idrekam_medis = ?";
        return $db->select($sql, [$idrekam_medis], 'i');
    }

    // Tambah detail rekam medis
    public function insert($idrekam_medis, $idkode_tindakan_terapi, $detail) {
        $db = new Database();
        $sql = "INSERT INTO detail_rekam_medis (idrekam_medis, idkode_tindakan_terapi, detail) VALUES (?, ?, ?)";
        return $db->execute($sql, [$idrekam_medis, $idkode_tindakan_terapi, $detail], 'iis');
    }

    // Update detail rekam medis
    public function update($iddetail_rekam_medis, $idkode_tindakan_terapi, $detail) {
        $db = new Database();
        $sql = "UPDATE detail_rekam_medis SET idkode_tindakan_terapi = ?, detail = ? WHERE iddetail_rekam_medis = ?";
        return $db->execute($sql, [$idkode_tindakan_terapi, $detail, $iddetail_rekam_medis], 'isi');
    }

    // Hapus detail rekam medis
    public function delete($iddetail_rekam_medis) {
        $db = new Database();
        $sql = "DELETE FROM detail_rekam_medis WHERE iddetail_rekam_medis = ?";
        return $db->execute($sql, [$iddetail_rekam_medis], 'i');
    }
}
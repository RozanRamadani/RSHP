<?php
require_once __DIR__ . '/../models/Pemilik.php';

class PemilikController {
    private $model;
    public $pemilikList = [];

    public function __construct() {
        $this->model = new Pemilik();
        $this->loadAll();
    }

    // Ambil semua data pemilik
    public function loadAll() {
        $db = new Database();
        $sql = "SELECT p.idpemilik, u.nama, u.email, p.no_wa, p.alamat FROM pemilik p JOIN user u ON p.iduser = u.iduser";
        $result = $db->select($sql);
        $this->pemilikList = $result ? $result : [];
    }

    // Tambah pemilik
    public function store($iduser, $no_wa, $alamat) {
        $this->model->set_data_user($iduser);
        $this->model->set_no_wa($no_wa);
        $this->model->set_alamat($alamat);
        return $this->model->create();
    }

    // Ambil satu pemilik
    public function show($id_pemilik) {
        $db = new Database();
        $sql = "SELECT * FROM pemilik WHERE idpemilik = ?";
        $result = $db->select($sql, [$id_pemilik], 'i');
        return ($result && count($result) > 0) ? $result[0] : null;
    }

    // Update pemilik
    public function update($idpemilik, $no_wa, $alamat) {
        $db = new Database();
        $sql = "UPDATE pemilik SET no_wa = ?, alamat = ? WHERE idpemilik = ?";
        $db->execute($sql, [$no_wa, $alamat, $idpemilik], 'ssi');
        // Return updated data
        return $this->show($idpemilik);
    }

    // Delete pemilik (with pet check)
    public function delete($idpemilik) {
        $db = new Database();
        $sqlCheckPet = "SELECT COUNT(*) as jml FROM pet WHERE idpemilik = ?";
        $petRes = $db->select($sqlCheckPet, [$idpemilik], 'i');
        $jmlPet = ($petRes && isset($petRes[0]['jml'])) ? intval($petRes[0]['jml']) : 0;
        if ($jmlPet > 0) {
            return [false, 'Tidak bisa menghapus pemilik karena masih memiliki datapet.'];
        }
        $sqlDelete = "DELETE FROM pemilik WHERE idpemilik = ?";
        $deleteRes = $db->execute($sqlDelete, [$idpemilik], 'i');
        if ($deleteRes) {
            return [true, 'Data pemilik berhasil dihapus.'];
        } else {
            return [false, 'Gagal menghapus data pemilik.'];
        }
    }
}

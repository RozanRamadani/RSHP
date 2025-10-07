<?php
require_once __DIR__ . '/../models/DetailRekamMedis.php';

class DetailRekamMedisController {
    private $model;

    public function __construct() {
        $this->model = new DetailRekamMedis();
    }

    // Ambil semua detail rekam medis untuk satu rekam medis
    public function index($idrekam_medis) {
        return $this->model->getAllByRekamMedis($idrekam_medis);
    }

    // Ambil satu detail rekam medis
    public function show($iddetail_rekam_medis) {
        return $this->model->getById($iddetail_rekam_medis);
    }

    // Tambah detail rekam medis
    public function store($idrekam_medis, $idkode_tindakan_terapi, $detail) {
        return $this->model->insert($idrekam_medis, $idkode_tindakan_terapi, $detail);
    }

    // Update detail rekam medis
    public function update($iddetail_rekam_medis, $idkode_tindakan_terapi, $detail) {
        return $this->model->update($iddetail_rekam_medis, $idkode_tindakan_terapi, $detail);
    }

    // Hapus detail rekam medis
    public function destroy($iddetail_rekam_medis) {
        return $this->model->delete($iddetail_rekam_medis);
    }
}
?>
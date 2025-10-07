<?php
require_once __DIR__ . '/../models/RekamMedis.php';
require_once __DIR__ . '/../models/DetailRekamMedis.php';

class RekamMedisPemilikController {
    private $rekamMedisModel;
    private $detailModel;

    public function __construct() {
        $this->rekamMedisModel = new RekamMedis();
        $this->detailModel = new DetailRekamMedis();
    }

    // Ambil semua rekam medis berdasarkan id pemilik
    public function getRekamMedisByPemilik($idpemilik) {
        return $this->rekamMedisModel->getByPemilik($idpemilik);
    }

    // Ambil detail rekam medis
    public function getDetailRekamMedis($idrekam_medis) {
        return $this->detailModel->getAllByRekamMedis($idrekam_medis);
    }

    // Ambil satu rekam medis berdasarkan id
    public function show($idrekam_medis) {
        return $this->rekamMedisModel->getById($idrekam_medis);
    }
}
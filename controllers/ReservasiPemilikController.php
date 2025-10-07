<?php
require_once __DIR__ . '/../models/TemuDokter.php';

class ReservasiPemilikController {
    private $model;

    public function __construct() {
        $this->model = new TemuDokter();
    }

    // Ambil semua reservasi berdasarkan id pemilik
    public function getReservasiByPemilik($idpemilik) {
        return $this->model->getByPemilik($idpemilik);
    }

    // Ambil satu reservasi berdasarkan id
    public function show($idreservasi_dokter) {
        return $this->model->getById($idreservasi_dokter);
    }
}
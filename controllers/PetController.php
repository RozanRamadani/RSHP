<?php
require_once __DIR__ . '/../models/Pet.php';

class PetController {
    private $model;
    public $petList = [];
    public function __construct() {
        $this->model = new Pet();
        $this->petList = $this->model->getAll();
    }

    public function store($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan) {
        return Pet::create($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
    }

        public function getById($idpet) {
            return Pet::getById($idpet);
        }

        public function update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan) {
            return Pet::update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
        }

        public function delete($idpet) {
            return Pet::delete($idpet);
        }
}

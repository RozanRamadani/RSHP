<?php
require_once __DIR__ . '/../models/Pet.php';

class PetPemilikController {
    private $model;

    public function __construct() {
        $this->model = new Pet();
    }

    // Ambil semua pet berdasarkan id pemilik
    public function getPetByPemilik($idpemilik) {
        return $this->model->getByPemilik($idpemilik);
    }

    // Ambil satu pet berdasarkan id
    public function show($idpet) {
        return $this->model->getById($idpet);
    }
}
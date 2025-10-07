<?php
require_once __DIR__ . '/../models/Pet.php';

class PetController
{
    private $model;
    public $petList = [];

    // Konstruktor - method inisialisasi objek
    public function __construct()
    {
        $this->model = new Pet();
        $this->petList = $this->model->getAll();
    }

    // Method untuk operasi tambah data hewan peliharaan
    public function store($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        return Pet::create($nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
    }

    // Method untuk mengambil data hewan peliharaan berdasarkan ID
    public function getById($idpet)
    {
        return Pet::getById($idpet);
    }

    // Method untuk operasi ubah data hewan peliharaan
    public function update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan)
    {
        return Pet::update($idpet, $nama, $tanggal_lahir, $warna_tanda, $jenis_kelamin, $idpemilik, $idras_hewan);
    }

    // Method untuk operasi hapus data hewan peliharaan
    public function delete($idpet)
    {
        return Pet::delete($idpet);
    }
}

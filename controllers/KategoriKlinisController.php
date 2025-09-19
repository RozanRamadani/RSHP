<?php
require_once __DIR__ . '/../models/KategoriKlinis.php';

class KategoriKlinisController {
    public $kategoriKlinisList = [];
    public function __construct() {
        $this->kategoriKlinisList = KategoriKlinis::getAll();
    }
        public function createKategoriKlinis($nama_kategori_klinis) {
            return KategoriKlinis::insert($nama_kategori_klinis);
        }

        public function updateKategoriKlinis($idkategori_klinis, $nama_kategori_klinis) {
            return KategoriKlinis::update($idkategori_klinis, $nama_kategori_klinis);
        }

        public function deleteKategoriKlinis($idkategori_klinis) {
            return KategoriKlinis::delete($idkategori_klinis);
        }

        public function getKategoriKlinisById($idkategori_klinis) {
            return KategoriKlinis::getById($idkategori_klinis);
        }
}

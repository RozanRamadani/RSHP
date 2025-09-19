<?php
require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {
	public $kategoriList = [];
	public function __construct() {
		$this->kategoriList = Kategori::getAll();
	}

	public function createKategori($nama_kategori) {
		return Kategori::insert($nama_kategori);
	}

	public function updateKategori($idkategori, $nama_kategori) {
		return Kategori::update($idkategori, $nama_kategori);
	}

	public function deleteKategori($idkategori) {
		return Kategori::delete($idkategori);
	}

	public function getKategoriById($idkategori) {
		return Kategori::getById($idkategori);
	}
}

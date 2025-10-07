<?php
require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {

	// Menyimpan daftar kategori
	public $kategoriList = [];

	// Konstruktor - method inisialisasi objek
	public function __construct() {
		
		// Ambil semua kategori
		$this->kategoriList = Kategori::getAll();
	}

	// Method untuk operasi tambah data kategori
	public function createKategori($nama_kategori) {
		return Kategori::insert($nama_kategori);
	}

	// Method untuk operasi ubah data kategori
	public function updateKategori($idkategori, $nama_kategori) {
		return Kategori::update($idkategori, $nama_kategori);
	}

	// Method untuk operasi hapus data kategori
	public function deleteKategori($idkategori) {
		return Kategori::delete($idkategori);
	}

	// Method untuk mengambil data kategori berdasarkan ID
	public function getKategoriById($idkategori) {
		return Kategori::getById($idkategori);
	}
}

<?php
require_once __DIR__ . '/../models/KodeTindakanTerapi.php';

class KodeTindakanTerapiController
{

	// Menyimpan daftar kode tindakan terapi
	public $tindakanList = [];

	// Konstruktor - method inisialisasi objek
	public function __construct()
	{
		$this->tindakanList = KodeTindakanTerapi::getAll();
	}

	// Method untuk operasi tambah data kode tindakan terapi
	public function createKodeTindakanTerapi($kode, $deskripsi, $idkategori, $idkategori_klinis)
	{
		return KodeTindakanTerapi::insert($kode, $deskripsi, $idkategori, $idkategori_klinis);
	}

	// Method untuk operasi ubah data kode tindakan terapi
	public function updateKodeTindakanTerapi($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis)
	{
		return KodeTindakanTerapi::update($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis);
	}

	// Method untuk operasi hapus data kode tindakan terapi
	public function deleteKodeTindakanTerapi($idkode_tindakan_terapi)
	{
		return KodeTindakanTerapi::delete($idkode_tindakan_terapi);
	}

	// Method untuk mengambil data kode tindakan terapi berdasarkan ID
	public function getKodeTindakanTerapiById($idkode_tindakan_terapi)
	{
		return KodeTindakanTerapi::getById($idkode_tindakan_terapi);
	}
}

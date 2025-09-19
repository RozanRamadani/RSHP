<?php
require_once __DIR__ . '/../models/KodeTindakanTerapi.php';

class KodeTindakanTerapiController {
	public $tindakanList = [];
	public function __construct() {
		$this->tindakanList = KodeTindakanTerapi::getAll();
	}
		public function createKodeTindakanTerapi($kode, $deskripsi, $idkategori, $idkategori_klinis) {
			return KodeTindakanTerapi::insert($kode, $deskripsi, $idkategori, $idkategori_klinis);
		}

		public function updateKodeTindakanTerapi($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis) {
			return KodeTindakanTerapi::update($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis);
		}

		public function deleteKodeTindakanTerapi($idkode_tindakan_terapi) {
			return KodeTindakanTerapi::delete($idkode_tindakan_terapi);
		}

		public function getKodeTindakanTerapiById($idkode_tindakan_terapi) {
			return KodeTindakanTerapi::getById($idkode_tindakan_terapi);
		}
}

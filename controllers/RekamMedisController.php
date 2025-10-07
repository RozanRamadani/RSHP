<?php
require_once __DIR__ . '/../models/RekamMedis.php';

class RekamMedisController {
	private $model;

	public function __construct() {
		$this->model = new RekamMedis();
	}

	// Ambil semua rekam medis
	public function index() {
		return $this->model->getAll();
	}

	// Ambil satu rekam medis
	public function show($idrekam_medis) {
		return $this->model->getById($idrekam_medis);
	}

	// Tambah rekam medis
	public function store($created_at, $anamesis, $temuan_klinis, $diagnosa, $idreservasi_dokter, $dokter_pemeriksa) {
		return $this->model->insert($created_at, $anamesis, $temuan_klinis, $diagnosa, $idreservasi_dokter, $dokter_pemeriksa);
	}

	// Update rekam medis
	public function update($idrekam_medis, $anamesis, $temuan_klinis, $diagnosa) {
		return $this->model->update($idrekam_medis, $anamesis, $temuan_klinis, $diagnosa);
	}

	// Hapus rekam medis
	public function destroy($idrekam_medis) {
		return $this->model->delete($idrekam_medis);
	}
}

<?php
require_once __DIR__ . '/../databases/koneksi.php';

class RekamMedis {
	// Ambil semua rekam medis
	public function getAll() {
		$db = new Database();
		$sql = "SELECT rm.*, COALESCE(p.nama, 'Pet Tidak Diketahui') as nama_pet, u.nama as nama_dokter 
				FROM rekam_medis rm 
				LEFT JOIN temu_dokter td ON rm.idreservasi_dokter = td.idreservasi_dokter 
				LEFT JOIN pet p ON td.idpet = p.idpet 
				LEFT JOIN role_user ru ON rm.dokter_pemeriksa = ru.idrole_user
				LEFT JOIN user u ON ru.iduser = u.iduser
				ORDER BY rm.created_at DESC";
		return $db->select($sql);
	}

	// Ambil satu rekam medis
	public function getById($idrekam_medis) {
		$db = new Database();
		$sql = "SELECT rm.*, u.nama as nama_dokter 
				FROM rekam_medis rm 
				LEFT JOIN role_user ru ON rm.dokter_pemeriksa = ru.idrole_user
				LEFT JOIN user u ON ru.iduser = u.iduser
				WHERE rm.idrekam_medis = ?";
		return $db->select($sql, [$idrekam_medis], 'i');
	}

	// Tambah rekam medis
	public function insert($created_at, $anamesis, $temuan_klinis, $diagnosa, $idreservasi_dokter, $dokter_pemeriksa) {
		$db = new Database();
		$sql = "INSERT INTO rekam_medis (created_at, anamesis, temuan_klinis, diagnosa, idreservasi_dokter, dokter_pemeriksa) VALUES (?, ?, ?, ?, ?, ?)";
		return $db->execute($sql, [$created_at, $anamesis, $temuan_klinis, $diagnosa, $idreservasi_dokter, $dokter_pemeriksa], 'ssssii');
	}

	// Update rekam medis
	public function update($idrekam_medis, $anamesis, $temuan_klinis, $diagnosa) {
		$db = new Database();
		$sql = "UPDATE rekam_medis SET anamesis = ?, temuan_klinis = ?, diagnosa = ? WHERE idrekam_medis = ?";
		return $db->execute($sql, [$anamesis, $temuan_klinis, $diagnosa, $idrekam_medis], 'sssi');
	}

	// Hapus rekam medis
	public function delete($idrekam_medis) {
		$db = new Database();
		$sql = "DELETE FROM rekam_medis WHERE idrekam_medis = ?";
		try {
			return $db->execute($sql, [$idrekam_medis], 'i');
		} catch (mysqli_sql_exception $e) {
			if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
				return 'DETAIL_EXIST';
			}
			return false;
		}
	}

	// Ambil rekam medis berdasarkan id pemilik
	public function getByPemilik($idpemilik) {
		$db = new Database();
		$sql = "SELECT rm.*, td.idpet, p.nama as nama_pet, u.nama as nama_dokter 
				FROM rekam_medis rm 
				LEFT JOIN temu_dokter td ON rm.idreservasi_dokter = td.idreservasi_dokter 
				LEFT JOIN pet p ON td.idpet = p.idpet 
				LEFT JOIN role_user ru ON rm.dokter_pemeriksa = ru.idrole_user
				LEFT JOIN user u ON ru.iduser = u.iduser
				WHERE p.idpemilik = ? 
				ORDER BY rm.created_at DESC";
		return $db->select($sql, [$idpemilik], 'i');
	}
}

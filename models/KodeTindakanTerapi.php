<?php
require_once __DIR__ . '/../databases/koneksi.php';

class KodeTindakanTerapi {
	public static function getAll() {
		$db = new Database();
		$sql = "SELECT * FROM kode_tindakan_terapi";
		return $db->select($sql);
	}

	public static function insert($kode, $deskripsi, $idkategori, $idkategori_klinis) {
		$db = new Database();
		$sql = "INSERT INTO kode_tindakan_terapi (kode, deskripsi_tindakan_terapi, idkategori, idkategori_klinis) VALUES (?, ?, ?, ?)";
		return $db->execute($sql, [$kode, $deskripsi, $idkategori, $idkategori_klinis], 'ssii');
	}

	public static function update($idkode_tindakan_terapi, $kode, $deskripsi, $idkategori, $idkategori_klinis) {
		$db = new Database();
		$sql = "UPDATE kode_tindakan_terapi SET kode = ?, deskripsi_tindakan_terapi = ?, idkategori = ?, idkategori_klinis = ? WHERE idkode_tindakan_terapi = ?";
		return $db->execute($sql, [$kode, $deskripsi, $idkategori, $idkategori_klinis, $idkode_tindakan_terapi], 'ssiii');
	}

	public static function delete($idkode_tindakan_terapi) {
		$db = new Database();
		$sql = "DELETE FROM kode_tindakan_terapi WHERE idkode_tindakan_terapi = ?";
		return $db->execute($sql, [$idkode_tindakan_terapi], 'i');
	}

	public static function getById($idkode_tindakan_terapi) {
		$db = new Database();
		$sql = "SELECT * FROM kode_tindakan_terapi WHERE idkode_tindakan_terapi = ?";
		$result = $db->select($sql, [$idkode_tindakan_terapi], 'i');
		return $result ? $result[0] : null;
	}
}

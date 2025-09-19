<?php
require_once __DIR__ . '/../databases/koneksi.php';

class Kategori
{
	public static function getAll()
	{
		$db = new Database();
		$sql = "SELECT * FROM kategori";
		return $db->select($sql);
	}
	public static function insert($nama_kategori)
	{
		$db = new Database();
		$sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
		return $db->execute($sql, [$nama_kategori], 's');
	}

	public static function update($idkategori, $nama_kategori)
	{
		$db = new Database();
		$sql = "UPDATE kategori SET nama_kategori = ? WHERE idkategori = ?";
		return $db->execute($sql, [$nama_kategori, $idkategori], 'si');
	}

	public static function delete($idkategori)
	{
		$db = new Database();
		$sql = "DELETE FROM kategori WHERE idkategori = ?";
		return $db->execute($sql, [$idkategori], 'i');
	}

	public static function getById($idkategori)
	{
		$db = new Database();
		$sql = "SELECT * FROM kategori WHERE idkategori = ?";
		$result = $db->select($sql, [$idkategori], 'i');
		return $result ? $result[0] : null;
	}
}

<?php
require_once __DIR__ . '/../models/KategoriKlinis.php';

class KategoriKlinisController
{
    // Menyimpan daftar kategori klinis
    public $kategoriKlinisList = [];

    // Konstruktor - method inisialisasi objek
    public function __construct()
    {
        $this->kategoriKlinisList = KategoriKlinis::getAll();
    }

    // Method untuk operasi tambah data kategori klinis
    public function createKategoriKlinis($nama_kategori_klinis)
    {
        return KategoriKlinis::insert($nama_kategori_klinis);
    }

    // Method untuk operasi ubah data kategori klinis
    public function updateKategoriKlinis($idkategori_klinis, $nama_kategori_klinis)
    {
        return KategoriKlinis::update($idkategori_klinis, $nama_kategori_klinis);
    }

    // Method untuk operasi hapus data kategori klinis
    public function deleteKategoriKlinis($idkategori_klinis)
    {
        return KategoriKlinis::delete($idkategori_klinis);
    }

    // Method untuk mengambil data kategori klinis berdasarkan ID
    public function getKategoriKlinisById($idkategori_klinis)
    {
        return KategoriKlinis::getById($idkategori_klinis);
    }
}

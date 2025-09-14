<?php
require_once __DIR__ . '/../models/rasHewan.php';
require_once __DIR__ . '/../models/jenisHewan.php';

class RasHewanController
{
    private $rasModel;
    private $jenisModel;

    // Konstruktor untuk inisialisasi model
    public function __construct()
    {
        $this->rasModel = new rasHewan();
        $this->jenisModel = new Jenis_hewan();
    }


    // Ambil semua data ras hewan, dikelompokkan per jenis
    public function index()
    {
        $jenisList = $this->jenisModel->helper_fetch_all_with_ras_from_db();
        return $jenisList;
    }

    // Ambil semua jenis hewan (untuk form tambah ras)
    public function getJenisList()
    {
        return $this->jenisModel->helper_fetch_all_jenis_hewan_from_db();
    }

    // Tambah ras hewan
    public function store($nama_ras, $idjenis_hewan)
    {
        return $this->rasModel->insert_db($nama_ras, $idjenis_hewan);
    }

    // Update ras hewan
    public function update($idras_hewan, $nama_ras, $idjenis_hewan)
    {
        return $this->rasModel->update_db($idras_hewan, $nama_ras, $idjenis_hewan);
    }

    // Hapus ras hewan
    public function destroy($idras_hewan)
    {
        return $this->rasModel->delete_db($idras_hewan);
    }

    // Ambil satu ras hewan
    public function show($idras_hewan)
    {
        return $this->rasModel->get_by_id($idras_hewan);
    }
}

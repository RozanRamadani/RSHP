<?php
require_once __DIR__ . '/../models/jenisHewan.php';
require_once __DIR__ . '/../models/helper/Respon.php';

require_once __DIR__ . '/../models/rasHewan.php';
class JenisHewanController {
    private $model;
    private $rasModel;

    // Konstruktor untuk inisialisasi model
    public function __construct() {
        $this->model = new Jenis_hewan();
        $this->rasModel = new rasHewan();
    }

    // Ambil semua data jenis hewan
    public function index() {
        return $this->model->helper_fetch_all_jenis_hewan_from_db();
    }

    // Tambah jenis hewan
    public function store($nama) {
        $res = $this->model->insert_db($nama);
        return $res;
    }

    // Update jenis hewan
    public function update($id, $nama) {
        $res = $this->model->update_db($id, $nama);
        return $res;
    }

    // Hapus jenis hewan, dicek dulu apakah ada ras terkait
    public function destroy($id) {
        $rasTerkait = $this->rasModel->get_all($id);
        if ($rasTerkait && count($rasTerkait) > 0) {
            return new Respon(false, "Tidak bisa menghapus jenis hewan karena masih ada ras terkait.");
        }
        $res = $this->model->delete_db($id);
        return $res;
    }

    // Ambil satu jenis hewan
    public function show($id) {
        return $this->model->get_by_id($id);
    }
}
<?php
require_once __DIR__ . '/../models/Pemilik.php';

class PemilikController {
    private $model;
    public $pemilikList = [];

    // Konstruktor - method inisialisasi objek
    public function __construct() {
        $this->model = new Pemilik();
        $this->loadAll();
    }

    // Ambil semua data pemilik
    public function loadAll() {
        $db = new Database();
        $sql = "SELECT p.idpemilik, u.nama, u.email, p.no_wa, p.alamat FROM pemilik p JOIN user u ON p.iduser = u.iduser";
        $result = $db->select($sql);
        $this->pemilikList = $result ? $result : [];
    }

    // Tambah pemilik
    public function store($iduser, $no_wa, $alamat) {
        $this->model->set_data_user($iduser);
        $this->model->set_no_wa($no_wa);
        $this->model->set_alamat($alamat);
        return $this->model->create();
    }

    // Tambah pemilik dengan registrasi user baru
    public function storeWithNewUser($nama, $email, $password, $no_wa, $alamat) {
        require_once __DIR__ . '/../models/User.php';
        
        $db = new Database();
        $conn = $db->getConnection();
        $conn->begin_transaction();
        
        try {
            // 1. Check if email already exists
            if (User::emailExists($email)) {
                throw new Exception('Email sudah terdaftar!');
            }
            
            // 2. Create new user
            $iduser = User::createUser($nama, $email, $password);
            
            if (!$iduser || $iduser <= 0) {
                throw new Exception('Gagal membuat user baru!');
            }
            
            // 3. Assign role pemilik (ID: 5)
            if (!User::assignRole($iduser, 5)) {
                throw new Exception('Gagal memberikan role pemilik!');
            }
            
            // 4. Create pemilik
            $this->model->set_data_user($iduser);
            $this->model->set_no_wa($no_wa);
            $this->model->set_alamat($alamat);
            $pemilikResult = $this->model->create();
            
            if (!$pemilikResult) {
                throw new Exception('Gagal membuat data pemilik!');
            }
            
            $conn->commit();
            return [true, 'User dan pemilik berhasil dibuat!'];
            
        } catch (Exception $e) {
            $conn->rollback();
            return [false, $e->getMessage()];
        }
    }

    // Ambil satu pemilik
    public function show($id_pemilik) {
        $db = new Database();
        $sql = "SELECT * FROM pemilik WHERE idpemilik = ?";
        $result = $db->select($sql, [$id_pemilik], 'i');
        return ($result && count($result) > 0) ? $result[0] : null;
    }

    // Update pemilik
    public function update($idpemilik, $no_wa, $alamat) {
        $db = new Database();
        $sql = "UPDATE pemilik SET no_wa = ?, alamat = ? WHERE idpemilik = ?";
        $db->execute($sql, [$no_wa, $alamat, $idpemilik], 'ssi');
        // Return updated data
        return $this->show($idpemilik);
    }

    // Delete pemilik (with pet check)
    public function delete($idpemilik) {
        $db = new Database();
        $sqlCheckPet = "SELECT COUNT(*) as jml FROM pet WHERE idpemilik = ?";
        $petRes = $db->select($sqlCheckPet, [$idpemilik], 'i');
        $jmlPet = ($petRes && isset($petRes[0]['jml'])) ? intval($petRes[0]['jml']) : 0;
        if ($jmlPet > 0) {
            return [false, 'Tidak bisa menghapus pemilik karena masih memiliki datapet.'];
        }
        $sqlDelete = "DELETE FROM pemilik WHERE idpemilik = ?";
        $deleteRes = $db->execute($sqlDelete, [$idpemilik], 'i');
        if ($deleteRes) {
            return [true, 'Data pemilik berhasil dihapus.'];
        } else {
            return [false, 'Gagal menghapus data pemilik.'];
        }
    }
}

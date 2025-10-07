<?php
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Role.php';


class Pemilik extends User {
    protected $id_pemilik;

    // setter untuk id_pemilik
    public function set_id_pemilik($id_pemilik) {
        $this->id_pemilik = $id_pemilik;
    }

    // override set_data_user agar bisa set id_pemilik
    public function set_data_user(int $iduser = 0, string $nama = '', string $email = '') {
        parent::set_data_user($iduser, $nama, $email);
        $this->id_pemilik = $iduser; // asumsikan id_pemilik sama dengan iduser
    }

    // atribut tambahan untuk pemilik
    public $no_wa;
    public $alamat;

    // setter untuk no_wa
    public function set_no_wa($no_wa) {
        $this->no_wa = $no_wa;
    }

    // setter untuk alamat
    public function set_alamat($alamat) {
        $this->alamat = $alamat;
    }

    // override create: insert ke tabel pemilik dan assign role 'Pemilik' ke user
    public function create(): bool|string {
        $db = new Database();
        // 1. Insert ke tabel pemilik
        $sqlPemilik = "INSERT INTO pemilik (iduser, no_wa, alamat) VALUES (?, ?, ?)";
        $stmtPemilik = $db->getConnection()->prepare($sqlPemilik);
        $stmtPemilik->bind_param('iss', $this->iduser, $this->no_wa, $this->alamat);
        $resultPemilik = $stmtPemilik->execute();
        $stmtPemilik->close();
        if (!$resultPemilik) {
            return "Gagal insert pemilik: " . $db->getConnection()->error;
        }
        // 2. Tambahkan role 'Pemilik' ke user jika belum ada
        $idrole = Role::getIdByName('Pemilik');
        if ($idrole) {
            $sqlCheck = "SELECT COUNT(*) as cnt FROM role_user WHERE iduser = ? AND idrole = ?";
            $cek = $db->select($sqlCheck, [$this->iduser, $idrole], 'ii');
            if ($cek && $cek[0]['cnt'] == 0) {
                // Insert role_user
                $sqlRoleUser = "INSERT INTO role_user (iduser, idrole, status) VALUES (?, ?, 1)";
                $db->execute($sqlRoleUser, [$this->iduser, $idrole], 'ii');
            }
        }
        return true;
    }

    // override get_user_by_id: cari berdasarkan id_pemilik
    public function get_user_by_id(): Respon {
        $db = new Database();
        $sql = "SELECT * FROM user WHERE iduser = ?";
        $result = $db->select($sql, [$this->id_pemilik], 'i');
        if ($result && count($result) > 0) {
            $user_data = $result[0];
            $this->set_data_user($user_data['iduser'], $user_data['nama'], $user_data['email']);
            return new Respon(true, "User found", $user_data);
        } else {
            return new Respon(false, "User not found", []);
        }
    }

    // Ambil data pemilik berdasarkan iduser
    public static function getByUserId($iduser) {
        $db = new Database();
        $sql = "SELECT * FROM pemilik WHERE iduser = ?";
        $result = $db->select($sql, [$iduser], 'i');
        return $result ? $result[0] : null;
    }
}

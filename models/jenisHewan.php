<?php
require_once __DIR__ . '/../databases/koneksi.php';
class Jenis_hewan
{
    private $db;

    // Konstruktor untuk inisialisasi koneksi database
    public function __construct()
    {
        // Pastikan class Database sudah ada dan di-require
        $this->db = new Database();
    }

    // Ambil semua jenis hewan
    public function helper_fetch_all_jenis_hewan_from_db()
    {
        $sql = "SELECT * FROM jenis_hewan ORDER BY nama_jenis_hewan";
        return $this->db->select($sql);
    }

    // Ambil semua jenis hewan + ras hewan (digabung)
    public function helper_fetch_all_with_ras_from_db()
    {
        $sql = "SELECT jh.*, rh.idras_hewan, rh.nama_ras
            FROM jenis_hewan jh
            LEFT JOIN ras_hewan rh ON jh.idjenis_hewan = rh.idjenis_hewan
            ORDER BY jh.idjenis_hewan, rh.nama_ras";
        $result = $this->db->select($sql);

        // Gabungkan hasil menjadi array: [jenis][ras[]]
        $data = [];
        foreach ($result as $row) {
            $idjenis = $row['idjenis_hewan'];
            if (!isset($data[$idjenis])) {
                $data[$idjenis] = [
                    'idjenis_hewan' => $row['idjenis_hewan'],
                    'nama_jenis_hewan' => $row['nama_jenis_hewan'],
                    'ras' => []
                ];
            }
            if ($row['idras_hewan']) {
                $data[$idjenis]['ras'][] = [
                    'idras_hewan' => $row['idras_hewan'],
                    'nama_ras' => $row['nama_ras']
                ];
            }
        }
        return array_values($data);
    }

    // Tambah jenis hewan
    public function insert_db($nama)
    {
        $sql = "INSERT INTO jenis_hewan (nama_jenis_hewan) VALUES (?)";
        $result = $this->db->execute($sql, [$nama], 's');
        if ($result) {
            return new Respon(true, "Berhasil menambah jenis hewan");
        } else {
            return new Respon(false, "Gagal menambah jenis hewan");
        }
    }

    // Update jenis hewan
    public function update_db($id, $nama)
    {
        $sql = "UPDATE jenis_hewan SET nama_jenis_hewan=? WHERE idjenis_hewan=?";
        $result = $this->db->execute($sql, [$nama, $id], 'si');
        if ($result) {
            return new Respon(true, "Berhasil update jenis hewan");
        } else {
            return new Respon(false, "Gagal update jenis hewan");
        }
    }

    // Hapus jenis hewan
    public function delete_db($id)
    {
        $sql = "DELETE FROM jenis_hewan WHERE idjenis_hewan=?";
        $result = $this->db->execute($sql, [$id], 'i');
        if ($result) {
            return new Respon(true, "Berhasil hapus jenis hewan");
        } else {
            return new Respon(false, "Gagal hapus jenis hewan");
        }
    }

    // Ambil satu jenis hewan (dipakai untuk update & delete)
    public function get_by_id($id)
    {
        $sql = "SELECT * FROM jenis_hewan WHERE idjenis_hewan=?";
        $result = $this->db->select($sql, [$id], 'i');
        return $result ? $result[0] : null;
    }
}

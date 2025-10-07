<?php
class DashboardController
{
    private $db;
    public $jml_user;
    public $jml_role;
    public $jml_role_user;

    // Konstruktor - method inisialisasi objek
    public function __construct()
    {
        // Inisialisasi objek Database
        $this->db = new Database();

        // Ambil jumlah data dari tabel user, role, dan role_user
        $this->jml_user = $this->db->select("SELECT COUNT(*) as total FROM user")[0]['total'];

        // Ambil jumlah data dari tabel role dan role_user
        $this->jml_role = $this->db->select("SELECT COUNT(*) as total FROM role")[0]['total'];

        // Ambil jumlah data dari tabel role_user
        $this->jml_role_user = $this->db->select("SELECT COUNT(*) as total FROM role_user")[0]['total'];
    }
}
?>
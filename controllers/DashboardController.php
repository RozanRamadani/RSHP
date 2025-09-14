<?php
class DashboardController
{
    private $db;
    public $jml_user;
    public $jml_role;
    public $jml_role_user;
    public function __construct()
    {
        $this->db = new Database();
        $this->jml_user = $this->db->select("SELECT COUNT(*) as total FROM user")[0]['total'];
        $this->jml_role = $this->db->select("SELECT COUNT(*) as total FROM role")[0]['total'];
        $this->jml_role_user = $this->db->select("SELECT COUNT(*) as total FROM role_user")[0]['total'];
    }
}
?>
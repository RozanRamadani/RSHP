<?php
class RoleUserController
{
    private $db;
    public $users = [];
    public function __construct()
    {
        $this->db = new Database();
        $result = $this->db->select("SELECT u.iduser, u.nama, r.nama_role, ru.status FROM user as u LEFT JOIN role_user as ru ON u.iduser = ru.iduser LEFT JOIN role as r ON ru.idrole = r.idrole ORDER BY u.iduser");
        foreach ($result as $row) {
            $id = $row['iduser'];
            if (!isset($this->users[$id])) {
                $this->users[$id] = [
                    'iduser' => $id,
                    'nama' => $row['nama'],
                    'roles' => []
                ];
            }
            if ($row['nama_role']) {
                $this->users[$id]['roles'][] = [
                    'nama_role' => $row['nama_role'],
                    'status' => $row['status']
                ];
            }
        }
    }
}

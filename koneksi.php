<?php
class Database {
	// Properti private 
	private $host;  // Hostname/alamat server database
	private $user;  // Username untuk login ke database
	private $pass;  // Password untuk login ke database
	private $db;    // Nama database yang akan digunakan
	private $conn;  // Object koneksi mysqli

	// Konstruktor - method yang otomatis dijalankan saat object dibuat
	public function __construct(
		$host = 'localhost', 
		$user = 'root',
		$pass = '',
		$db   = 'kuliah_wf_2025'
	) {
		// Menyimpan parameter ke properti object
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db   = $db;

		// memanggil method connect untuk membuat koneksi
		$this->connect();
	}

	// Method private untuk membuat koneksi ke database
	private function connect() {
       
		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->conn->connect_error) {
			throw new Exception('Koneksi gagal: ' . $this->conn->connect_error);
		}
	}


	// Method public untuk mendapatkan object koneksi database
	public function getConnection() {
		return $this->conn; 
	}

	// Method SELECT dengan prepared statement
	public function select($query, $params = [], $types = '') {
		$stmt = $this->conn->prepare($query);
		// Mengikat parameter jika ada
		if ($params && $types) {
			$stmt->bind_param($types, ...$params);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
		$stmt->close();
		return $data;
	}

	// Method eksekusi query (INSERT/UPDATE/DELETE) dengan prepared statement
	public function execute($query, $params = [], $types = '') {
		$stmt = $this->conn->prepare($query);
		if ($params && $types) {
			$stmt->bind_param($types, ...$params);
		}
		$stmt->execute();
		$affected = $stmt->affected_rows;
		$stmt->close();
		return $affected;
	}

	// Method public untuk menutup koneksi database
	public function closeConnection() {
      
		if ($this->conn) {
			$this->conn->close();    
			$this->conn = null;     
		}
	}

	// Destruktor - method hapus objek otomatis
	public function __destruct() {
		$this->closeConnection();  
	}
}
?>

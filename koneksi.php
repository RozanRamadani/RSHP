<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'kuliah_wf_2025';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
	die('Koneksi gagal: ' . mysqli_connect_error());
}
?>

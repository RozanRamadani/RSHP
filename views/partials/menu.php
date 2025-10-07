<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['user']['role_aktif'] ?? null;
// Cek apakah file ini dipanggil dari subfolder (ada 'roles' di path)
$base = (strpos($_SERVER['SCRIPT_NAME'], '/roles/') !== false) ? '../../../' : '../';
?>
<nav style="background:#36a2c2;padding:0;box-shadow:0 2px 4px rgba(0,0,0,0.04);">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/menu.css">
    <div class="navbar-rshp">
        <div style="display:flex; align-items:center; gap:18px;">
            <img src="<?php echo $base; ?>assets/img/uner.png" alt="Logo UNER" class="navbar-logo" />
            <ul style="margin:0; padding:0;">
                <?php if ($role == 1): // ADMIN 
                ?>
                    <li>
                        <a href="/roles/admin/dashboard.php">Dashboard</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">Data Master &#9662;</a>
                        <div class="dropdown-content">
                            <a href="/roles/admin/data_user.php">Data User</a>
                            <a href="/roles/admin/datamaster_role_user.php">Manajemen Role</a>
                            <a href="/roles/animal/JenisHewanView.php">Jenis Hewan</a>
                            <a href="/roles/animal/RasHewanView.php">Ras Hewan</a>
                            <a href="/roles/medis/pemeriksaan/PemilikView.php">Data Pemilik</a>
                            <a href="/roles/medis/pemeriksaan/PetView.php">Data Pet</a>
                            <a href="/roles/medis/kategori/KategoriView.php">Data Kategori</a>
                            <a href="/roles/medis/kategori/KategoriKlinisView.php">Data Kategori Klinis</a>
                            <a href="/roles/medis/kategori/KodeTindakanTerapiView.php">Data Kode Tindakan Terapi</a>
                        </div>
                    </li>
                <?php elseif ($role == 2): // DOKTER 
                ?>
                    <li>
                        <a href="/roles/medis/dashboard_dokter.php">Dashboard</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">Data Pasien & Medis &#9662;</a>
                        <div class="dropdown-content">
                            <a href="/roles/animal/JenisHewanView.php">Jenis Hewan</a>
                            <a href="/roles/animal/RasHewanView.php">Ras Hewan</a>
                            <a href="/roles/medis/Rekam_Medis/RekamMedisView.php">Rekam Medis</a>
                        </div>
                    </li>
                <?php elseif ($role == 3): // PERAWAT 
                ?>
                    <li>
                        <a href="/roles/medis/dashboard_perawat.php">Dashboard</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">Data Pasien & Medis &#9662;</a>
                        <div class="dropdown-content">
                            <a href="/roles/animal/JenisHewanView.php">Jenis Hewan</a>
                            <a href="/roles/animal/RasHewanView.php">Ras Hewan</a>
                            <a href="/roles/medis/Rekam_Medis/RekamMedisView.php">Rekam Medis</a>
                        </div>
                    </li>
                <?php elseif ($role == 5): // PEMILIK 
                ?>
                    <li>
                        <a href="/roles/pemilik/dashboard_pemilik.php">Dashboard</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">My Pet & Medis &#9662;</a>
                        <div class="dropdown-content">
                            <a href="/roles/pemilik/PetPemilikView.php">Daftar Pet Saya</a>
                            <a href="/roles/pemilik/ReservasiPemilikView.php">Daftar Reservasi</a>
                            <a href="/roles/pemilik/RekamMedisPemilikView.php">Rekam Medis Pet</a>
                        </div>
                    </li>
                    <nav class="navbar">
                        <ul>
                            <li><a href="../../views/interface/home.php">Home</a></li>
                            <li><a href="../../views/interface/struktur.php">Struktur Organisasi</a></li>
                            <li><a href="../../views/interface/layanan.php">Layanan Umum</a></li>
                            <li><a href="../../views/interface/visi.php">Visi Misi dan Tujuan</a></li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </ul>
        </div>
        <ul>
            <li>
                <a href="/views/auth/logout.php" class="logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<?php
// Halaman Home Resepsionis
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Home Resepsionis</title>
    <link rel="stylesheet" href="../../assets/css/dashboard_resepsionis.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include('../../views/partials/menu.php'); ?>
    <div class="dashboard-topbar">
        <div class="topbar-left">
            <span class="topbar-title">Dashboard Resepsionis</span>
        </div>
    </div>
    <div class="dashboard-main">
        <?php
        require_once __DIR__ . '/../../models/RoleUser.php';
        require_once __DIR__ . '/../../models/Pet.php';
        require_once __DIR__ . '/../../models/TemuDokter.php';
        $totalPemilik = count(RoleUser::getUsersByRole('Pemilik'));
        $totalPet = count(Pet::getAll());
        $totalTemuDokter = TemuDokter::getNoUrutHariIni();
        ?>
        <div class="dashboard-overview">
            <div class="overview-card">
                <div class="overview-icon" style="background:#1976d2;">&#128100;</div>
                <div class="overview-label">Total Pemilik</div>
                <div class="overview-value"><?= $totalPemilik ?></div>
            </div>
            <div class="overview-card">
                <div class="overview-icon" style="background:#1976d2;">&#128054;</div>
                <div class="overview-label">Total Pet</div>
                <div class="overview-value"><?= $totalPet ?></div>
            </div>
            <div class="overview-card">
                <div class="overview-icon" style="background:#1976d2;">&#128106;</div>
                <div class="overview-label">Temu Dokter Hari Ini</div>
                <div class="overview-value"><?= $totalTemuDokter ?></div>
            </div>
        </div>
        <div class="dashboard-menu">
            <a href="/roles/medis/pemeriksaan/TambahPemilikView.php" class="menu-btn">Registrasi Pemilik</a>
            <a href="/roles/medis/pemeriksaan/TambahPet.php" class="menu-btn">Registrasi Pet</a>
            <a href="/roles/resepsionis/TemuDokterView.php" class="menu-btn">Temu Dokter</a>
        </div>
        <?php
        require_once __DIR__ . '/../../controllers/TemuDokterController.php';
        require_once __DIR__ . '/../../models/Pet.php';
    require_once __DIR__ . '/../../models/RoleUser.php';
    $temuController = new TemuDokterController();
    $antrian = $temuController->getAntrianHariIni();
    $dokterList = RoleUser::getDokterList();
        ?>
        <div class="dashboard-card">
            <h3 class="antrian-title">Antrian Temu Dokter Hari Ini</h3>
            <table class="antrian-table">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>Pet</th>
                        <th>Dokter</th>
                        <th>Waktu Daftar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($antrian as $row): ?>
                        <?php 
                            $pet = Pet::getById($row['idpet']);
                            $petNama = $pet ? $pet['nama'] : $row['idpet'];
                            $dokterNama = $row['idrole_user'];
                            foreach ($dokterList as $dokter) {
                                if ($dokter['idrole_user'] == $row['idrole_user']) {
                                    $dokterNama = $dokter['nama'];
                                    break;
                                }
                            }
                        ?>
                        <tr>
                            <td><?= $row['no_urut'] ?></td>
                            <td><?= htmlspecialchars($petNama) ?></td>
                            <td><?= htmlspecialchars($dokterNama) ?></td>
                            <td><?= $row['waktu_daftar'] ?></td>
                            <td><?php 
                                $status = $row['status'];
                                if ($status == '0' || $status == 0) echo 'Menunggu';
                                elseif ($status == '1' || $status == 1) echo 'Selesai';
                                elseif ($status == 'M') echo 'Menunggu';
                                else echo $status;
                            ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="dashboard-contact">
            <b>Kontak:</b> rshp@unair.ac.id | (031) 1234567
        </div>
    </div>
    <?php include('../../views/partials/footer.php'); ?>
</body>

</html>
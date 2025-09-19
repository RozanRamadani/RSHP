<?php
require_once __DIR__ . '/../models/TemuDokter.php';

class TemuDokterController {
    public function daftarTemuDokter($idpet, $idrole_user) {
        $no_urut = TemuDokter::getNoUrutHariIni() + 1;
        return TemuDokter::insert($idpet, $idrole_user, $no_urut);
    }

    public function getAntrianHariIni() {
        return TemuDokter::getAntrianHariIni();
    }
}

<?php
require_once __DIR__ . '/../models/TemuDokter.php';

class TemuDokterController
{
    // Ambil semua idreservasi_dokter untuk dropdown
    public function getAllReservasiDokter() {
        return TemuDokter::getAllReservasiDokter();
    }

    // Menyimpan daftar antrian temu dokter
    public function daftarTemuDokter($idpet, $idrole_user)
    {
        $no_urut = TemuDokter::getNoUrutHariIni() + 1;
        return TemuDokter::insert($idpet, $idrole_user, $no_urut);
    }

    // Method untuk mengambil antrian temu dokter hari ini
    public function getAntrianHariIni()
    {
        return TemuDokter::getAntrianHariIni();
    }
}

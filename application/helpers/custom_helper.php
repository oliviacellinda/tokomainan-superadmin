<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( ! function_exists('url_admin') ) {
    function url_admin() {
        return 'http://localhost/tokomainan-superadmin/';
    }
}

if( ! function_exists('umur_stok_barang') ) {
    function umur_stok_barang($string_tanggal) {
        $today = new DateTime(date('Y-m-d'));
        $tanggal = new DateTime($string_tanggal);
        
        $selisih = date_diff($today, $tanggal);
        return $selisih->days;
        // days adalah properti dari objek DateInterval
        // fungsi date_diff di atas menghasilkan objek DateInterval
    }
}

if( ! function_exists('ubah_format_tanggal') ) {
    function ubah_format_tanggal($tanggal_database) {
        $y = substr($tanggal_database,0,4); //tahun
        $m = substr($tanggal_database,5,2);	//bulan
        $d = substr($tanggal_database,8,2);	//tanggal
        $h = substr($tanggal_database,11,2); //jam
        $i = substr($tanggal_database,14,2); //menit
        // $s = substr($tanggal_database,17,2); //detik
        switch($m) {
            case "01" : $m = "Januari"; break;
            case "02" : $m = "Februari"; break;
            case "03" : $m = "Maret"; break;
            case "04" : $m = "April"; break;
            case "05" : $m = "Mei"; break;
            case "06" : $m = "Juni"; break;
            case "07" : $m = "Juli"; break;
            case "08" : $m = "Agustus"; break;
            case "09" : $m = "September"; break;
            case "10" : $m = "Oktober"; break;
            case "11" : $m = "November"; break;
            case "12" : $m = "Desember"; break;
        }
        return $d.' '.$m.' '.$y.', '.$h.':'.$i;
    }
}
?>
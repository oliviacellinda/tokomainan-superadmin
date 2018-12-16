<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_laporan_penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function laporan_penjualan() {
        if($this->session->username == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_laporan_penjualan');
    }

    public function daftar_penjualan() {
        $id_toko = $this->input->post('id_toko');
        $bulan_tahun = $this->input->post('bulan_tahun');

        $this->load->model('m_laporan_penjualan');

        if($id_toko == 'semua' && $bulan_tahun == '') {
            $data = $this->m_laporan_penjualan->lihat_seluruh_laporan();
            
            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $date = $data[$j]['tgl_invoice'];
                    $y = substr($date,0,4); //tahun
                    $m = substr($date,5,2);	//bulan
                    $d = substr($date,8,2);	//tanggal
                    $h = substr($date,11,2); //jam
                    $i = substr($date,14,2); //menit
                    // $s = substr($date,17,2); //detik
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
                    $data[$j]['tgl_invoice'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF data default (semua toko dan tidak ada bulan)
        
        elseif($id_toko == 'semua' && $bulan_tahun != '') {
            $this->load->model('m_laporan_penjualan');

            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,5,4);

            $data = $this->m_laporan_penjualan->filter_laporan_1($bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $date = $data[$j]['tgl_invoice'];
                    $y = substr($date,0,4); //tahun
                    $m = substr($date,5,2);	//bulan
                    $d = substr($date,8,2);	//tanggal
                    $h = substr($date,11,2); //jam
                    $i = substr($date,14,2); //menit
                    // $s = substr($date,17,2); //detik
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
                    $data[$j]['tgl_invoice'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter hanya berdasarkan bulan tahun

        elseif($id_toko != 'semua' && $bulan_tahun == '') {
            $this->load->model('m_laporan_penjualan');

            $data = $this->m_laporan_penjualan->filter_laporan_2($id_toko);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $date = $data[$j]['tgl_invoice'];
                    $y = substr($date,0,4); //tahun
                    $m = substr($date,5,2);	//bulan
                    $d = substr($date,8,2);	//tanggal
                    $h = substr($date,11,2); //jam
                    $i = substr($date,14,2); //menit
                    // $s = substr($date,17,2); //detik
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
                    $data[$j]['tgl_invoice'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter hanya berdasarkan toko 

        else {
            $this->load->model('m_laporan_penjualan');

            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,5,4);

            $data = $this->m_laporan_penjualan->filter_laporan_3($id_toko, $bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $date = $data[$j]['tgl_invoice'];
                    $y = substr($date,0,4); //tahun
                    $m = substr($date,5,2);	//bulan
                    $d = substr($date,8,2);	//tanggal
                    $h = substr($date,11,2); //jam
                    $i = substr($date,14,2); //menit
                    // $s = substr($date,17,2); //detik
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
                    $data[$j]['tgl_invoice'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter toko dan bulan tahun
    }

    public function detail_penjualan() {
        $id_invoice = $this->input->post('id_invoice');

        $this->load->model('m_laporan_penjualan');

        $data['laporan_penjualan'] = $this->m_laporan_penjualan->laporan_penjualan_per_id($id_invoice);
        $data['detail_penjualan'] = $this->m_laporan_penjualan->detail_penjualan($id_invoice);

        if($data['laporan_penjualan'] != '' && $data['detail_penjualan'] != '') {
            $date = $data['laporan_penjualan']['tgl_invoice'];
            $y = substr($date,0,4); //tahun
            $m = substr($date,5,2);	//bulan
            $d = substr($date,8,2);	//tanggal
            $h = substr($date,11,2); //jam
            $i = substr($date,14,2); //menit
            // $s = substr($date,17,2); //detik
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
            $data['laporan_penjualan']['tgl_invoice'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
            echo json_encode($data);
        }
        else echo json_encode($data);
    }
}
?>
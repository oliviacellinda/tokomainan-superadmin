<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_stok_barang extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function data_barang_masuk() {
        if($this->session->id_toko == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_data_barang_masuk');
    }

    public function daftar_stok_barang() {
        $this->load->model('m_manajemen_stok_barang');

        $data = $this->m_manajemen_stok_barang->daftar_stok_barang($this->session->id_toko);

        if($data != '') {
            for($i=0; $i<count($data); $i++) {
                $today = new DateTime(date('Y-m-d'));
                $date = new DateTime($data[$i]['tgl_modifikasi_data']);
                $data[$i]['umur_barang'] = date_diff($today, $date)->days;
                // days adalah properti dari objek DateInterval
                // fungsi date_diff di atas menghasilkan objek DateInterval
            }
            echo json_encode($data);
        }
        else echo json_encode('no data');
    }

    public function input_barang_masuk() {
        $id_barang = $this->input->post('id_barang');
        $id_toko = $this->session->id_toko;
        $jml_barang_masuk = $this->input->post('jml_barang_masuk');

        $this->load->model('m_manajemen_stok_barang');

        $jml_barang_sblm = $this->m_manajemen_stok_barang->ambil_jumlah($id_barang, $id_toko);
        $jml_barang_skrg = $jml_barang_sblm['stok_barang'] + $jml_barang_masuk;
        $tgl = date('Y-m-d'); // Tanggal saat data diubah

        $this->m_manajemen_stok_barang->update_jumlah_masuk($id_barang, $id_toko, $jml_barang_skrg, $tgl);
    }

    public function data_barang_keluar() {
        if($this->session->id_toko == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_data_barang_keluar');
    }

    public function laporan_barang_keluar() {
        $this->load->model('m_manajemen_stok_barang');

        $data = $this->m_manajemen_stok_barang->laporan_barang_keluar($this->session->id_toko);

        if($data != '') {
            for($j=0; $j<count($data); $j++) {
                $date = $data[$j]['waktu_keluar'];
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
                $data[$j]['waktu_keluar'] = $d.' '.$m.' '.$y.', '.$h.':'.$i; 
            }
            echo json_encode($data);
        }
        else echo json_encode('no data');
    }

    public function input_barang_keluar() {
        $id_barang = $this->input->post('id_barang');
        $id_toko = $this->session->id_toko;
        $jml_barang_keluar = $this->input->post('jml_barang_keluar');
        $keterangan_barang_keluar = $this->input->post('keterangan_barang_keluar');

        $this->load->model('m_manajemen_stok_barang');

        $jml_barang_sblm = $this->m_manajemen_stok_barang->ambil_jumlah($id_barang, $id_toko);

        // Cek apakah jumlah stok barang saat ini lebih besar dari jumlah barang yang akan dikeluarkan
        if($jml_barang_sblm['stok_barang'] > $jml_barang_keluar) {
            $jml_barang_skrg = $jml_barang_sblm['stok_barang'] - $jml_barang_keluar;
            $tgl = date('Y-m-d H:i:s');

            $this->m_manajemen_stok_barang->update_jumlah_keluar($id_barang, $id_toko, $jml_barang_skrg);
            $this->m_manajemen_stok_barang->lapor_barang_keluar($id_barang, $id_toko, $tgl, $jml_barang_keluar, $keterangan_barang_keluar);

            echo json_encode('success');
        }
        else {
            echo json_encode('fail');
        }
    }
}
?>
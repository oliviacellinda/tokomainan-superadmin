<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_laporan_penjualan_dibatalkan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('custom_helper');
        $this->load->model('m_laporan_penjualan_dibatalkan');
    }

    public function laporan_penjualan_dibatalkan() {
        if($this->session->username == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_laporan_penjualan_dibatalkan');
    }

    public function daftar_penjualan_dibatalkan() {
        $id_toko = $this->input->post('id_toko');
        $bulan_tahun = $this->input->post('bulan_tahun');

        if($id_toko == 'semua' && $bulan_tahun == '') {
            $data = $this->m_laporan_penjualan_dibatalkan->lihat_seluruh_laporan();
            
            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']);
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF data default (semua toko dan tidak ada bulan)
        
        elseif($id_toko == 'semua' && $bulan_tahun != '') {
            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,5,4);

            $data = $this->m_laporan_penjualan_dibatalkan->filter_laporan_1($bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']); 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter hanya berdasarkan bulan tahun

        elseif($id_toko != 'semua' && $bulan_tahun == '') {
            $data = $this->m_laporan_penjualan_dibatalkan->filter_laporan_2($id_toko);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']); 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter hanya berdasarkan toko 

        else {
            $bulan = substr($bulan_tahun,0,2);
            $tahun = substr($bulan_tahun,5,4);

            $data = $this->m_laporan_penjualan_dibatalkan->filter_laporan_3($id_toko, $bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']); 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter toko dan bulan tahun
    }

    public function detail_penjualan_dibatalkan() {
        $id_invoice = $this->input->post('id_invoice');

        $data['laporan_penjualan'] = $this->m_laporan_penjualan_dibatalkan->laporan_penjualan_per_id($id_invoice);
        $data['detail_penjualan'] = $this->m_laporan_penjualan_dibatalkan->detail_penjualan($id_invoice);

        if($data['laporan_penjualan'] != '' && $data['detail_penjualan'] != '') {
            $data['laporan_penjualan']['tgl_invoice'] = ubah_format_tanggal($data['laporan_penjualan']['tgl_invoice']);
            echo json_encode($data);
        }
        else echo json_encode($data);
    }
}
?>
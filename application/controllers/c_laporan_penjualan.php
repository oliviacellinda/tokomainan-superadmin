<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_laporan_penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('custom_helper');
        $this->load->model('m_laporan_penjualan');
    }

    public function laporan_penjualan() {
        if($this->session->username == '') {
            header('Location: login');
            die();
        }
        else {
            $data['toko'] = $this->m_laporan_penjualan->daftar_toko();

            $this->load->view('v_laporan_penjualan', $data);
        }
    }

    public function daftar_penjualan() {
        $id_toko = $this->input->post('id_toko');
        $bulan_tahun = $this->input->post('bulan_tahun');

        if($id_toko == 'semua' && $bulan_tahun == '') {
            $data = $this->m_laporan_penjualan->lihat_seluruh_laporan();
            
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

            $data = $this->m_laporan_penjualan->filter_laporan_1($bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']); 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter hanya berdasarkan bulan tahun

        elseif($id_toko != 'semua' && $bulan_tahun == '') {
            $data = $this->m_laporan_penjualan->filter_laporan_2($id_toko);

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

            $data = $this->m_laporan_penjualan->filter_laporan_3($id_toko, $bulan, $tahun);

            if($data != '') {
                for($j=0; $j<count($data); $j++) {
                    $data[$j]['tgl_invoice'] = ubah_format_tanggal($data[$j]['tgl_invoice']); 
                }
                echo json_encode($data);
            } // End IF data tidak kosong
            else echo json_encode('no data');
        } // End IF filter toko dan bulan tahun
    }

    public function detail_penjualan() {
        $id_invoice = $this->input->post('id_invoice');

        $data['laporan_penjualan'] = $this->m_laporan_penjualan->laporan_penjualan_per_id($id_invoice);
        $data['detail_penjualan'] = $this->m_laporan_penjualan->detail_penjualan($id_invoice);

        // Untuk keperluan cetak nota
        $id_toko = $this->m_laporan_penjualan->cari_toko($data['laporan_penjualan']['id_kasir']);
        $nama_toko = $this->m_laporan_penjualan->nama_toko($id_toko['id_toko']);
        $data['nama_toko'] = $nama_toko['nama_toko'];

        if($data['laporan_penjualan'] != '' && $data['detail_penjualan'] != '') {
            $data['laporan_penjualan']['tgl_invoice_database'] = $data['laporan_penjualan']['tgl_invoice'];
            $data['laporan_penjualan']['tgl_invoice'] = ubah_format_tanggal($data['laporan_penjualan']['tgl_invoice']);
            echo json_encode($data);
        }
        else echo json_encode($data);
    }

    public function batalkan_nota() {
        $id_invoice = $this->input->post('id_invoice');

        $laporan_penjualan = $this->m_laporan_penjualan->laporan_penjualan_per_id($id_invoice);
        $detail_penjualan = $this->m_laporan_penjualan->detail_penjualan($id_invoice);
        $id_toko = $this->m_laporan_penjualan->cari_toko($laporan_penjualan['id_kasir']);
        $id_toko = $id_toko['id_toko'];

        for($i=0; $i<count($detail_penjualan); $i++) {
            $status_stok[] = $this->m_laporan_penjualan->perbarui_stok_barang($detail_penjualan[$i]['id_barang'], $id_toko, $detail_penjualan[$i]['jumlah_barang']);
        }

        if( !in_array(0, $status_stok) ) {
            $status_nota = $this->m_laporan_penjualan->batalkan_nota($id_invoice);

            if($status_nota == 1) echo json_encode('success');
            else echo json_encode('fail');
        }
        else echo json_encode('fail');
    }
}
?>
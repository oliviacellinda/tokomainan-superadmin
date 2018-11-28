<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_laporan_penjualan extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function lihat_seluruh_laporan() {
        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan');
        $this->db->from('laporan_penjualan');
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function filter_laporan_1($bulan, $tahun) {
        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan');
        $this->db->from('laporan_penjualan');
        $this->db->where('MONTH(tgl_invoice) = '.$bulan);
        $this->db->where('YEAR(tgl_invoice) = '.$tahun);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function filter_laporan_2($id_toko) {
        $this->db->select('id_kasir');
        $this->db->from('kasir');
        $this->db->where('id_toko', $id_toko);
        $where = $this->db->get_compiled_select();

        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan');
        $this->db->from('laporan_penjualan');
        $this->db->where('id_kasir IN ('.$where.')');
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function filter_laporan_3($id_toko, $bulan, $tahun) {
        $this->db->select('id_kasir');
        $this->db->from('kasir');
        $this->db->where('id_toko', $id_toko);
        $where = $this->db->get_compiled_select();

        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan');
        $this->db->from('laporan_penjualan');
        $this->db->where('id_kasir IN ('.$where.')');
        $this->db->where('MONTH(tgl_invoice) = '.$bulan);
        $this->db->where('YEAR(tgl_invoice) = '.$tahun);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function laporan_penjualan_per_id($id_invoice) {
        $this->db->select('laporan_penjualan.*, pelanggan.nama_pelanggan');
        $this->db->from('laporan_penjualan');
        $this->db->join('pelanggan', 'laporan_penjualan.id_pelanggan = pelanggan.id_pelanggan');
        $this->db->where('laporan_penjualan.id_invoice', $id_invoice);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function detail_penjualan($id_invoice) {
        $this->db->select('detail_penjualan.*, barang.nama_barang');
        $this->db->from('detail_penjualan');
        $this->db->join('barang', 'detail_penjualan.id_barang = barang.id_barang');
        $this->db->where('detail_penjualan.id_invoice', $id_invoice);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
}
?>
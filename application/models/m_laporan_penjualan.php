<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_laporan_penjualan extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function daftar_toko() {
        $query = $this->db->get('toko');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    
    public function lihat_seluruh_laporan() {
        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan, nama_pelanggan');
        $this->db->from('laporan_penjualan');
        $this->db->where('status_void', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function filter_laporan_1($bulan, $tahun) {
        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan, nama_pelanggan');
        $this->db->from('laporan_penjualan');
        $this->db->where('MONTH(tgl_invoice) = '.$bulan);
        $this->db->where('YEAR(tgl_invoice) = '.$tahun);
        $this->db->where('status_void', 0);
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

        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan, nama_pelanggan');
        $this->db->from('laporan_penjualan');
        $this->db->where('id_kasir IN ('.$where.')');
        $this->db->where('status_void', 0);
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

        $this->db->select('id_invoice, tgl_invoice, id_kasir, total_penjualan, nama_pelanggan');
        $this->db->from('laporan_penjualan');
        $this->db->where('id_kasir IN ('.$where.')');
        $this->db->where('MONTH(tgl_invoice) = '.$bulan);
        $this->db->where('YEAR(tgl_invoice) = '.$tahun);
        $this->db->where('status_void', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function laporan_penjualan_per_id($id_invoice) {
        $this->db->where('id_invoice', $id_invoice);
        $query = $this->db->get('laporan_penjualan');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function detail_penjualan($id_invoice) {
        $this->db->where('detail_penjualan.id_invoice', $id_invoice);
        $query = $this->db->get('detail_penjualan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function cari_toko($id_kasir) {
        $this->db->select('id_toko');
        $this->db->where('id_kasir', $id_kasir);
        $query = $this->db->get('kasir');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function nama_toko($id_toko) {
        $this->db->select('nama_toko');
        $this->db->where('id_toko', $id_toko);
        $query = $this->db->get('toko');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    // Berbeda dengan perbarui stok barang dalam sinkronisasi, fungsi ini untuk menambahkan kembali stok
    public function perbarui_stok_barang($id_barang, $id_toko, $jumlah) {
        $query = 'UPDATE stok_barang SET stok_barang = stok_barang + ' . $jumlah;
        $query .= ' WHERE id_barang = "' . $id_barang . '" AND id_toko = "' . $id_toko . '"';
        $this->db->query($query);

        if($this->db->affected_rows() > 0) return 1;
        else return 0;
    }

    public function batalkan_nota($id_invoice) {
        $this->db->set('status_void', 1);
        $this->db->where('id_invoice', $id_invoice);
        $this->db->update('laporan_penjualan');

        if($this->db->affected_rows() > 0) return 1;
        else return 0;
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_manajemen_stok_barang extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function daftar_stok_barang($id_toko) {
        $this->db->select('stok_barang.id_barang, barang.nama_barang, barang.jumlah_dlm_koli, stok_barang.id_toko, toko.nama_toko, stok_barang.stok_barang, stok_barang.tgl_modifikasi_data');
        $this->db->from('stok_barang');
        $this->db->join('barang', 'stok_barang.id_barang = barang.id_barang');
        $this->db->join('toko', 'stok_barang.id_toko = toko.id_toko');
        $this->db->where('stok_barang.id_toko', $id_toko);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function ambil_jumlah($id_barang, $id_toko) {
        $this->db->select('stok_barang');
        $this->db->from('stok_barang');
        $this->db->where('id_barang', $id_barang);
        $this->db->where('id_toko', $id_toko);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function update_jumlah_masuk($id_barang, $id_toko, $jumlah, $tgl) {
        $this->db->set('stok_barang', $jumlah);
        $this->db->set('tgl_modifikasi_data', $tgl);
        $this->db->where('id_barang', $id_barang);
        $this->db->where('id_toko', $id_toko);
        $this->db->update('stok_barang');
    }

    public function laporan_barang_keluar($id_toko) {
        $this->db->select('laporan_barang_keluar.*, barang.nama_barang, toko.nama_toko');
        $this->db->from('laporan_barang_keluar');
        $this->db->join('barang', 'laporan_barang_keluar.id_barang = barang.id_barang');
        $this->db->join('toko', 'laporan_barang_keluar.id_toko = toko.id_toko');
        $this->db->where('laporan_barang_keluar.id_toko', $id_toko);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function update_jumlah_keluar($id_barang, $id_toko, $jumlah) {
        $this->db->set('stok_barang', $jumlah);
        $this->db->where('id_barang', $id_barang);
        $this->db->where('id_toko', $id_toko);
        $this->db->update('stok_barang');
    }

    public function lapor_barang_keluar($id_barang, $id_toko, $tgl, $jumlah, $keterangan) {
        $input = array(
            'id_barang'     => $id_barang,
            'id_toko'       => $id_toko,
            'waktu_keluar'  => $tgl,
            'jumlah_keluar' => $jumlah,
            'keterangan'    => $keterangan
        );
        $this->db->insert('laporan_barang_keluar', $input);
    }

    public function auto_insert_stok_barang_baru($id_barang, $id_toko, $today) {
        $input = array(
            'id_barang'             => $id_barang,
            'id_toko'               => $id_toko,
            'stok_barang'           => 0,
            'tgl_modifikasi_data'   => $today
        );
        $this->db->insert('stok_barang', $input);
    }
}
?>
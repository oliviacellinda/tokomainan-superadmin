<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_m_stok extends CI_Model {

    public function __construct() {

    }

    public function cek_toko($id_kasir) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->select('id_toko');
        $dbkasir->where('id_kasir', $id_kasir);
        $query = $dbkasir->get('kasir');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function lihat_stok($id_toko) {
        // $dbkasir = $this->load->database('dbkasir', TRUE);

        // $dbkasir->select('stok_barang.*, barang.nama_barang');
        // $dbkasir->from('stok_barang');
        // $dbkasir->join('barang', 'stok_barang.id_barang = barang.id_barang');
        // $dbkasir->where('id_toko', $id_toko);
        // $query = $dbkasir->get();

        $this->load->database();

        $this->db->select('stok_barang.*, barang.nama_barang');
        $this->db->from('stok_barang');
        $this->db->join('barang', 'stok_barang.id_barang = barang.id_barang');
        $this->db->where('id_toko', $id_toko);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    } 
}
?>
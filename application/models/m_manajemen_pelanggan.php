<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_manajemen_pelanggan extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }

    public function lihat_pelanggan() {
        $query = $this->db->get('pelanggan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function tambah_pelanggan($input) {
        $this->db->insert('pelanggan', $input);
    }

    public function edit_pelanggan($id_pelanggan, $nama_kolom, $nilai_baru, $today) {
        $this->db->set($nama_kolom, $nilai_baru);
        $this->db->set('tgl_modifikasi_data', $today);
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->update('pelanggan');
    }

    public function hapus_pelanggan($id_pelanggan) {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->delete('pelanggan');
    }

    public function daftar_pelanggan_dihapus($id_pelanggan) {
        $this->db->insert('daftar_pelanggan_dihapus', $id_pelanggan);
    }
}
?>
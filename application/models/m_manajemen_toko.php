<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_manajemen_toko extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function lihat_toko() {
        $query = $this->db->get('toko');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function cek_id_toko($id_toko) {
        $this->db->select('id_toko');
        $this->db->where('id_toko', $id_toko);
        $query = $this->db->get('toko');

        if($query->num_rows() > 0) return 0;
        else return 1;
    }

    public function tambah_toko($input) {
        $this->db->insert('toko', $input);
    }

    public function edit_toko($id_toko, $nama_kolom, $nilai_baru) {
        $this->db->set($nama_kolom, $nilai_baru);
        $this->db->where('id_toko', $id_toko);
        $this->db->update('toko');
    }

    public function hapus_toko($id_toko) {
        $this->db->where('id_toko', $id_toko);
        $this->db->delete('toko');
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class toko_m_login extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function login($id_toko, $password_toko) {
        $this->db->where('id_toko', $id_toko);
        $this->db->where('password_toko', $password_toko);
        $query = $this->db->get('toko');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_m_login extends CI_Model {

    public function __construct() {

    }

    public function login($id_kasir, $password_kasir) {
        $dbkasir = $this->load->database('dbkasir', TRUE);
        $dbkasir->where('id_kasir', $id_kasir);
        $dbkasir->where('password_kasir', $password_kasir);
        $query = $dbkasir->get('kasir');

        if($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
}
?>
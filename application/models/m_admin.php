<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_admin extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function login($username, $password) {
        $this->db->where('username_admin', $username);
        $this->db->where('password_admin', $password);
        $query = $this->db->get('admin');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
}
?>
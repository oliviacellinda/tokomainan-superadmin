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
            return $query->row_array();
        }
    }

    public function periksa_password($passwordLama) {
        $this->db->where('username_admin', $this->session->username);
        $this->db->where('password_admin', $passwordLama);
        $query = $this->db->get('admin');

        if($query->num_rows() > 0) return true;
        else return false;
    }

    public function ganti_password($passwordBaru) {
        $this->db->set('password_admin', $passwordBaru);
        $this->db->where('username_admin', $this->session->username);
        $this->db->update('admin');
    }
}
?>
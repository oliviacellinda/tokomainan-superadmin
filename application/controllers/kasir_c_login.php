<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_c_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if($this->session->id_kasir != '') {
            header('Location: penjualan');
            die();
        }
        else $this->load->view('kasir_v_login');
    }

    public function proses_login() {
        $id_kasir = $this->input->post('username');
        $password_kasir = $this->input->post('password');

        $this->load->model('kasir_m_login');

        $data = $this->kasir_m_login->login($id_kasir, $password_kasir);
        if($data == '') echo json_encode('no match');
        else {
            $this->session->set_userdata('id_kasir', $id_kasir);
            echo json_encode('found a match');
        }
    }

    public function proses_logout() {
        $this->session->sess_destroy();
        header('Location: login');
        die();
    }
}
?>
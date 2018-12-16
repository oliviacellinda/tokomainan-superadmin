<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class toko_c_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if($this->session->id_toko != '') {
            header('Location: data-barang-masuk');
            die();
        }
        else $this->load->view('toko_v_login');
    }

    public function proses_login() {
        $id_toko = $this->input->post('username');
        $password_toko = $this->input->post('password');

        $this->load->model('toko_m_login');

        $data = $this->toko_m_login->login($id_toko, $password_toko);
        if($data == '') echo json_encode('no match');
        else {
            $this->session->set_userdata('id_toko', $id_toko);
            $this->session->set_userdata('nama_toko', $data['nama_toko']);
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
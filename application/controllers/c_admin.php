<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        if($this->session->username != '') {
			header('Location: manajemen-toko');
			die();
		}
		else $this->load->view('v_login');
    }

    public function proses_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->load->model('m_admin');

        $data = $this->m_admin->login($username, $password);
        if($data == '') echo json_encode('no match');
        else {
            $this->session->set_userdata('username', $username);
            echo json_encode('found a match');
        }
    }

    public function proses_logout() {
        $this->session->sess_destroy();
        header('Location: login');
        die();
    }

    public function ganti_password() {
        if($this->session->username == '') {
			header('Location: login');
			die();
		}
		else $this->load->view('v_ganti_password');
    }

    public function proses_ganti_password() {
        $passwordLama = $this->input->post('passwordLama');
        $passwordBaru = $this->input->post('passwordBaru');

        $this->load->model('m_admin');

        $statusPassLama = $this->m_admin->periksa_password($passwordLama);

        if($statusPassLama) {
            $this->m_admin->ganti_password($passwordBaru);
            echo json_encode('success');
        }
        else echo json_encode('fail');
    }
}
?>
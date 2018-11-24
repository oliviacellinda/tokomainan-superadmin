<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_toko extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function manajemen_toko() {
        if($this->session->username == '') {
			header('Location: login');
			die();
		}
		else $this->load->view('v_manajemen_toko');
    }

    public function lihat_toko() {
        $this->load->model('m_manajemen_toko');

        $data = $this->m_manajemen_toko->lihat_toko();
        if($data == '') echo json_encode('no data');
        else echo json_encode($data);
    }

    public function tambah_toko() {
        $input = array(
            'id_toko'      => $this->input->post('id_toko'),
            'nama_toko'    => $this->input->post('nama_toko'),
            'alamat_toko'  => $this->input->post('alamat_toko')
        );

        $this->load->model('m_manajemen_toko');

        $this->m_manajemen_toko->tambah_toko($input);
    }

    public function edit_toko() {
        $id_toko = $this->input->post('id_toko');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');

        $this->load->model('m_manajemen_toko');

        $this->m_manajemen_toko->edit_toko($id_toko, $nama_kolom, $nilai_baru);
    }

    public function hapus_toko() {
        $id_toko = $this->input->post('id_toko');

        $this->load->model('m_manajemen_toko');

        $this->m_manajemen_toko->hapus_toko($id_toko);
    }
}
?>
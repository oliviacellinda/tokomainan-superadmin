<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_kasir extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function manajemen_kasir() {
        if($this->session->username == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_manajemen_kasir');
    }

    public function lihat_kasir() {
        $this->load->model('m_manajemen_kasir');
        $this->load->model('m_manajemen_toko');

        $data['kasir'] = $this->m_manajemen_kasir->lihat_kasir();
        $data['toko'] = $this->m_manajemen_toko->lihat_toko();
        if($data['kasir'] == '') $data['kasir'] = 'no data';
        if($data['toko'] == '') $data['toko'] = 'no data';
        echo json_encode($data);
    }

    public function tambah_kasir() {
        $input = array(
            'id_kasir'       => $this->input->post('id_kasir'),
            'password_kasir' => $this->input->post('password_kasir'),
            'id_toko'        => $this->input->post('id_toko'),
            'tgl_modifikasi_data' => date('Y-m-d H:i:s')
        );

        $this->load->model('m_manajemen_kasir');

        $this->m_manajemen_kasir->tambah_kasir($input);
    }

    public function edit_kasir() {
        $id_kasir = $this->input->post('id_kasir');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');
        $tgl_modifikasi_data = date('Y-m-d H:i:s');

        $this->load->model('m_manajemen_kasir');

        $this->m_manajemen_kasir->edit_kasir($id_kasir, $nama_kolom, $nilai_baru, $tgl_modifikasi_data);
    }

    public function hapus_kasir() {
        $id_kasir = $this->input->post('id_kasir');

        $this->load->model('m_manajemen_kasir');

        $this->m_manajemen_kasir->hapus_kasir($id_kasir);
        $this->m_manajemen_kasir->daftar_kasir_dihapus(array('id_kasir' => $id_kasir));
    }
}
?>
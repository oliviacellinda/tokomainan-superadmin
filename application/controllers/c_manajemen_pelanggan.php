<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function manajemen_pelanggan() {
        if($this->session->username == '') {
			header('Location: login');
			die();
		}
		else $this->load->view('v_manajemen_pelanggan');
    }

    public function lihat_pelanggan() {
        $this->load->model('m_manajemen_pelanggan');

        $data = $this->m_manajemen_pelanggan->lihat_pelanggan();
        if($data == '') echo json_encode('no data');
        else echo json_encode($data);
    }

    public function tambah_pelanggan() {
        $id_pelanggan = 'admin' . strtolower( substr($this->input->post('nama_pelanggan'),0,3) ) . date('dmyHi');

        $input = array(
            'id_pelanggan'          => $id_pelanggan,
            'nama_pelanggan'        => $this->input->post('nama_pelanggan'),
            'alamat_pelanggan'      => $this->input->post('alamat_pelanggan'),
            'ekspedisi'             => $this->input->post('ekspedisi'),
            'telepon_pelanggan'     => $this->input->post('telepon_pelanggan'),
            'maks_utang'            => $this->input->post('maks_utang'),
            'level'                 => $this->input->post('level'),
            'tgl_modifikasi_data'   => date('Y-m-d H:i:s')
        );

        $this->load->model('m_manajemen_pelanggan');

        $this->m_manajemen_pelanggan->tambah_pelanggan($input);
    }

    public function edit_pelanggan() {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');
        $today = date('Y-m-d H:i:s');

        $this->load->model('m_manajemen_pelanggan');

        $this->m_manajemen_pelanggan->edit_pelanggan($id_pelanggan, $nama_kolom, $nilai_baru, $today);
    }

    public function hapus_pelanggan() {
        $id_pelanggan = $this->input->post('id_pelanggan');

        $this->load->model('m_manajemen_pelanggan');

        $this->m_manajemen_pelanggan->hapus_pelanggan($id_pelanggan);
        $this->m_manajemen_pelanggan->daftar_pelanggan_dihapus(array('id_pelanggan' => $id_pelanggan));
    }
}
?>
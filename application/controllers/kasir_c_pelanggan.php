<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_c_pelanggan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function pelanggan() {
        if($this->session->id_kasir == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('kasir_v_pelanggan');
    }

    public function lihat_pelanggan() {
        $this->load->model('kasir_m_pelanggan');

        $data = $this->kasir_m_pelanggan->lihat_pelanggan();
        if($data != '') echo json_encode($data);
        else echo json_encode('no data');
    }

    public function tambah_pelanggan() {
        $id_pelanggan = $this->session->id_kasir . strtolower( substr($this->input->post('nama_pelanggan'),0,3) ) . date('dmyHi');

        $input = array(
            'id_pelanggan'          => $id_pelanggan,
            'nama_pelanggan'        => $this->input->post('nama_pelanggan'),
            'alamat_pelanggan'      => $this->input->post('alamat_pelanggan'),
            'telepon_pelanggan'     => $this->input->post('telepon_pelanggan'),
            'maks_utang'            => 0,
            'level'                 => 4,
            'tgl_modifikasi_data'   => date('Y-m-d H:i:s')
        );

        $this->load->model('kasir_m_pelanggan');

        $this->kasir_m_pelanggan->tambah_pelanggan($input);
    }
    
    public function edit_pelanggan() {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');

        $this->load->model('kasir_m_pelanggan');

        $this->kasir_m_pelanggan->edit_pelanggan($id_pelanggan, $nama_kolom, $nilai_baru);
    }
}
?>
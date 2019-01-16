<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_toko extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('m_manajemen_toko');
    }

    public function manajemen_toko() {
        if($this->session->username == '') {
			header('Location: login');
			die();
		}
		else $this->load->view('v_manajemen_toko');
    }

    public function lihat_toko() {
        $data = $this->m_manajemen_toko->lihat_toko();
        if($data == '') echo json_encode('no data');
        else echo json_encode($data);
    }

    public function tambah_toko() {
        $input = array(
            'id_toko'      => $this->input->post('id_toko'),
            'password_toko'=> $this->input->post('password_toko'),
            'nama_toko'    => $this->input->post('nama_toko'),
            'alamat_toko'  => $this->input->post('alamat_toko')
        );

        // Cek apakah ID Toko yang akan ditambahkan ada dalam database. TRUE jika tidak ada dalam database
        if( $this->m_manajemen_toko->cek_id_toko($input['id_toko']) ) {
            $this->m_manajemen_toko->tambah_toko($input);

            // Auto insert toko baru ke tabel stok barang
            $this->load->model('m_manajemen_barang');
            $this->load->model('m_manajemen_stok_barang');

            $id_toko = $this->input->post('id_toko');
            $daftar_barang = $this->m_manajemen_barang->lihat_barang();

            if($daftar_barang != '') {
                $today = date('Y-m-d');
                for($i=0; $i<count($daftar_barang); $i++) {
                    $this->m_manajemen_stok_barang->auto_insert_stok_barang_baru($daftar_barang[$i]['id_barang'], $id_toko, $today);
                }
            }

            echo json_encode('success');
        }
        else {
            echo json_encode('ID used');
        }
    }

    public function edit_toko() {
        $id_toko = $this->input->post('id_toko');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');

        if($nama_kolom == 'id_toko') {
            // Cek apakah ID Toko baru ada dalam database. TRUE jika tidak ada dalam database
            if( $this->m_manajemen_toko->cek_id_toko($nilai_baru) ) {
                $this->m_manajemen_toko->edit_toko($id_toko, $nama_kolom, $nilai_baru);

                echo json_encode('success');
            }
            else {
                echo json_encode('ID used');
            }
        }
        else {
            $this->m_manajemen_toko->edit_toko($id_toko, $nama_kolom, $nilai_baru);

            echo json_encode('success');
        }
    }

    public function hapus_toko() {
        $id_toko = $this->input->post('id_toko');

        $this->m_manajemen_toko->hapus_toko($id_toko);
    }
}
?>
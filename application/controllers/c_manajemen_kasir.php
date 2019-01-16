<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_kasir extends CI_Controller {
    
    public function __construct() {
        parent::__construct();

        $this->load->model('m_manajemen_kasir');
    }

    public function manajemen_kasir() {
        if($this->session->username == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('v_manajemen_kasir');
    }

    public function lihat_kasir() {
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

        // Cek apakah ID Kasir dari data yang akan ditambahkan ada dalam database. TRUE jika tidak ada dalam database.
        if( $this->m_manajemen_kasir->cek_id_kasir($input['id_kasir']) ) {
            $this->m_manajemen_kasir->tambah_kasir($input);

            // Cek apakah ID Kasir ada dalam daftar kasir yang pernah dihapus sebelumnya. TRUE jika ada dalam daftar.
            if( $this->m_manajemen_kasir->cek_id_kasir_dihapus($input['id_kasir']) ) {
                $this->m_manajemen_kasir->hapus_dari_daftar_kasir_dihapus($input['id_kasir']);
            }

            echo json_encode('success');
        }
        else {
            echo json_encode('ID used');
        }
    }

    public function edit_kasir() {
        $id_kasir = $this->input->post('id_kasir');
        $nama_kolom = $this->input->post('nama_kolom');
        $nilai_baru = $this->input->post('nilai_baru');
        $tgl_modifikasi_data = date('Y-m-d H:i:s');

        if($nama_kolom == 'id_kasir') {
            // Cek apakah ID Kasir baru ada dalam database. TRUE jika tidak ada dalam database.
            if( $this->m_manajemen_kasir->cek_id_kasir($nilai_baru) ) {
                $this->m_manajemen_kasir->edit_kasir($id_kasir, $nama_kolom, $nilai_baru, $tgl_modifikasi_data);

                // Cek apakah ID Kasir ada dalam daftar kasir yang pernah dihapus sebelumnya. TRUE jika ada dalam daftar.
                if( $this->m_manajemen_kasir->cek_id_kasir_dihapus($nilai_baru) ) {
                    $this->m_manajemen_kasir->hapus_dari_daftar_kasir_dihapus($nilai_baru);
                }

                echo json_encode('success');
            }
            else {
                echo json_encode('ID used');
            }
        }
        else {
            $this->m_manajemen_kasir->edit_kasir($id_kasir, $nama_kolom, $nilai_baru, $tgl_modifikasi_data);

            echo json_encode('success');
        }
    }

    public function hapus_kasir() {
        $id_kasir = $this->input->post('id_kasir');

        $this->m_manajemen_kasir->hapus_kasir($id_kasir);
        $this->m_manajemen_kasir->daftar_kasir_dihapus(array('id_kasir' => $id_kasir));
    }
}
?>
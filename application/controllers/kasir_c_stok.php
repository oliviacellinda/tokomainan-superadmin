<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_c_stok extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function stok() {
        if($this->session->id_kasir == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('kasir_v_stok');
    }

    public function lihat_stok() {
        $this->load->model('kasir_m_stok');

        // Ambil data hanya di toko tempat kasir berada
        $id_toko = $this->kasir_m_stok->cek_toko($this->session->id_kasir);
        $data = $this->kasir_m_stok->lihat_stok($id_toko['id_toko']);

        if($data != '') {
            for($i=0; $i<count($data); $i++) {
                $today = new DateTime(date('Y-m-d'));
                $date = new DateTime($data[$i]['tgl_modifikasi_data']);
                $data[$i]['umur_barang'] = (date_diff($today, $date))->days;
                // days adalah properti dari objek DateInterval
                // fungsi date_diff di atas menghasilkan objek DateInterval
            }
            echo json_encode($data);
        } // End if data tidak kosong
        else echo json_encode('no data');
    }
}
?>
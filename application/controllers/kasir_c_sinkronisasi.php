<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_c_sinkronisasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function sinkronisasi_data() {
        if($this->session->id_kasir == '') {
            header('Location: login');
            die();
        }
        else $this->load->view('kasir_v_sinkronisasi');
    }

    public function sinkronisasi_pelanggan() {
        $this->load->helper('file');
        $tgl_modifikasi_skrg = read_file('tgl_modifikasi_data_pelanggan_lokal.txt');

        $this->load->model('kasir_m_sinkronisasi');

        $data_baru = $this->kasir_m_sinkronisasi->ambil_data_baru_pelanggan($tgl_modifikasi_skrg);
        if($data_baru != '') {
            for($i=0; $i<count($data_baru); $i++) {
                $baris = array(
                    'id_pelanggan'      => $data_baru[$i]['id_pelanggan'],
                    'nama_pelanggan'    => $data_baru[$i]['nama_pelanggan'],
                    'alamat_pelanggan'  => $data_baru[$i]['alamat_pelanggan'],
                    'telepon_pelanggan' => $data_baru[$i]['telepon_pelanggan'],
                    'maks_utang'        => $data_baru[$i]['maks_utang'],
                    'level'             => $data_baru[$i]['level']
                );
                $this->kasir_m_sinkronisasi->perbarui_data_pelanggan_lokal($baris);
            }
            write_file('tgl_modifikasi_data_pelanggan_lokal.txt', date('Y-m-d H:i:s'));
        }

        /* Proses data dihapus -------------------------------------------------- */
        $data_dihapus = $this->kasir_m_sinkronisasi->daftar_pelanggan_dihapus();
        $data_skrg = $this->kasir_m_sinkronisasi->daftar_pelanggan_lokal();

        if($data_dihapus != '') {
            for($i=0; $i<count($data_dihapus); $i++) $a[] = $data_dihapus[$i]['id_pelanggan'];
            for($i=0; $i<count($data_skrg); $i++) $b[] = $data_skrg[$i]['id_pelanggan'];

            $data_akan_dihapus = array_intersect($a, $b);
            foreach($data_akan_dihapus as $key=>$value) {
                $this->kasir_m_sinkronisasi->hapus_pelanggan_lokal($data_akan_dihapus[$key]);
            }
        }

        echo json_encode('done');
    }

    public function sinkronisasi_barang() {
        $this->load->helper('file');
        $tgl_modifikasi_skrg = read_file('tgl_modifikasi_data_barang_lokal.txt');

        $this->load->model('kasir_m_sinkronisasi');

        $data_baru = $this->kasir_m_sinkronisasi->ambil_data_baru_barang($tgl_modifikasi_skrg);
        if($data_baru != '') {
            for($i=0; $i<count($data_baru); $i++) {
                $baris = array(
                    'id_barang'         => $data_baru[$i]['id_barang'],
                    'nama_barang'       => $data_baru[$i]['nama_barang'],
                    'jumlah_dlm_koli'   => $data_baru[$i]['jumlah_dlm_koli'],
                    'kategori'          => $data_baru[$i]['kategori'],
                    'fungsi'            => $data_baru[$i]['fungsi'],
                    'harga_jual_1'      => $data_baru[$i]['harga_jual_1'],
                    'harga_jual_2'      => $data_baru[$i]['harga_jual_2'],
                    'harga_jual_3'      => $data_baru[$i]['harga_jual_3'],
                    'harga_jual_4'      => $data_baru[$i]['harga_jual_4']
                );
                $this->kasir_m_sinkronisasi->perbarui_data_barang_lokal($baris);
            }
            write_file('tgl_modifikasi_data_barang_lokal.txt', date('Y-m-d H:i:s'));
        }

        /* Proses data dihapus -------------------------------------------------- */
        $data_dihapus = $this->kasir_m_sinkronisasi->daftar_barang_dihapus();
        $data_skrg = $this->kasir_m_sinkronisasi->daftar_barang_lokal();

        if($data_dihapus != '') {
            for($i=0; $i<count($data_dihapus); $i++) $a[] = $data_dihapus[$i]['id_barang'];
            for($i=0; $i<count($data_skrg); $i++) $b[] = $data_skrg[$i]['id_barang'];

            $data_akan_dihapus = array_intersect($a, $b);
            foreach($data_akan_dihapus as $key=>$value) {
                $this->kasir_m_sinkronisasi->hapus_barang_lokal($data_akan_dihapus[$key]);
            }
        }
        
        echo json_encode('done');
    }

    public function sinkronisasi_penjualan() {
        $this->load->model('kasir_m_sinkronisasi');

        $data_penjualan_blm_upload = $this->kasir_m_sinkronisasi->data_penjualan_blm_upload();
        
        if($data_penjualan_blm_upload != '') {
            for($i=0; $i<count($data_penjualan_blm_upload); $i++) {
                $detail_penjualan_blm_upload[$i] = $this->kasir_m_sinkronisasi->detail_penjualan_blm_upload($data_penjualan_blm_upload[$i]['id_invoice']);

                $this->kasir_m_sinkronisasi->tambah_data_penjualan_pusat($data_penjualan_blm_upload[$i]);

                for($j=0; $j<count($detail_penjualan_blm_upload[$i]); $j++) {
                    $this->kasir_m_sinkronisasi->tambah_detail_penjualan_pusat($detail_penjualan_blm_upload[$i][$j]);
                }

                $this->kasir_m_sinkronisasi->perbarui_data_penjualan_lokal($data_penjualan_blm_upload[$i]['id_invoice']);
            }
        }

        echo json_encode('done');
    }
}
?>
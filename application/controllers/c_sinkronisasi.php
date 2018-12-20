<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_sinkronisasi extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('m_sinkronisasi');
    }

    public function ambil_pelanggan_baru() {
        $tgl_modifikasi_lokal = $this->input->post('tgl_modifikasi_lokal');

        $pelanggan_baru = $this->m_sinkronisasi->ambil_pelanggan_baru($tgl_modifikasi_lokal);

        if($pelanggan_baru == '') echo json_encode('no data');
        else echo json_encode($pelanggan_baru);
    }

    public function daftar_pelanggan_dihapus() {
        $daftar_pelanggan_dihapus = $this->m_sinkronisasi->daftar_pelanggan_dihapus();

        if($daftar_pelanggan_dihapus == '') echo json_encode('no data');
        else echo json_encode($daftar_pelanggan_dihapus);
    }

    public function tambah_pelanggan() {
        $data = array(
            'id_pelanggan'        => $this->input->post('id_pelanggan'),
            'nama_pelanggan'      => $this->input->post('nama_pelanggan'),
            'alamat_pelanggan'    => $this->input->post('alamat_pelanggan'),
            'telepon_pelanggan'   => $this->input->post('telepon_pelanggan'),
            'maks_utang'          => $this->input->post('maks_utang'),
            'level'               => $this->input->post('level'),
            'tgl_modifikasi_data' => $this->input->post('tgl_modifikasi_data')
        );

        $status = $this->m_sinkronisasi->tambah_pelanggan($data);

        if($status == 1) echo 1;
        else echo 0;
    }

    public function ambil_barang_baru() {
        $tgl_modifikasi_lokal = $this->input->post('tgl_modifikasi_lokal');

        $barang_baru = $this->m_sinkronisasi->ambil_barang_baru($tgl_modifikasi_lokal);

        if($barang_baru == '') echo json_encode('no data');
        else echo json_encode($barang_baru);
    }

    public function daftar_barang_dihapus() {
        $daftar_barang_dihapus = $this->m_sinkronisasi->daftar_barang_dihapus();

        if($daftar_barang_dihapus == '') echo json_encode('no data');
        else echo json_encode($daftar_barang_dihapus);
    }

    public function tambah_laporan_penjualan() {
        $laporan_penjualan = json_decode($this->input->post('laporan_penjualan'), true);
        $detail_penjualan = json_decode($this->input->post('detail_penjualan'), true);
        $id_toko = json_decode($this->input->post('id_toko'), true);

        $status = array();
        $status_laporan = array();
        $status_detail = array();
        $status_stok = array();

        for($i=0; $i<count($laporan_penjualan); $i++) {
            $status_laporan[$i] = $this->m_sinkronisasi->tambah_laporan_penjualan($laporan_penjualan[$i]);

            if($status_laporan[$i] == 1) {
                for($j=0; $j<count($detail_penjualan[$i]); $j++) {
                    $status_detail[$i][$j] = $this->m_sinkronisasi->tambah_detail_penjualan($detail_penjualan[$i][$j]);
                }

                if( !(in_array(0, $status_detail[$i])) ) {
                    for($j=0; $j<count($detail_penjualan[$i]); $j++) {
                        $status_stok[$i][$j] = $this->m_sinkronisasi->perbarui_stok_barang($detail_penjualan[$i][$j]['id_barang'], $id_toko[$i]['id_toko'], $detail_penjualan[$i][$j]['jumlah_barang']);

                        /* Catatan:
                        | Masih ada kekurangan untuk proses update stok.
                        | Misalkan ada 5 baris data barang yang akan diperbarui jumlah stoknya. Saat iterasi ke 3, terjadi masalah pada proses update.
                        | Status laporan penjualan dalam database kasir tidak akan berubah karena ditemukan error dalam $status_stok.
                        | Saat laporan penjualan diupload ulang, data barang 1 dan barang 2 yang sebelumnya sudah diupdate akan melalui proses update lagi.
                        | Belum ada penyelesaian untuk kasus ini.
                        */
                    }
                }
            }
        }

        $status[0] = $status_laporan;
        $status[1] = $status_detail;
        $status[2] = $status_stok;

        echo json_encode($status);
    }

    public function lihat_stok_barang() {
        $id_toko = $this->input->post('id_toko');

        $daftar_stok_barang = $this->m_sinkronisasi->lihat_stok_barang($id_toko);

        if($daftar_stok_barang == '') echo json_encode('no data');
        else echo json_encode($daftar_stok_barang);
    }

    public function ambil_kasir_baru() {
        $tgl_modifikasi_lokal = $this->input->post('tgl_modifikasi_lokal');

        $kasir_baru = $this->m_sinkronisasi->ambil_kasir_baru($tgl_modifikasi_lokal);

        if($kasir_baru == '') echo json_encode('no data');
        else echo json_encode($kasir_baru);
    }

    public function daftar_kasir_dihapus() {
        $daftar_kasir_dihapus = $this->m_sinkronisasi->daftar_kasir_dihapus();

        if($daftar_kasir_dihapus == '') echo json_encode('no data');
        else echo json_encode($daftar_kasir_dihapus);
    }
}
?>
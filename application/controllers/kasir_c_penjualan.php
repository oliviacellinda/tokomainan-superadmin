<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_c_penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function penjualan() {
        if($this->session->id_kasir == '') {
            header('Location: login');
            die();
        }
        else {
            $this->load->model('kasir_m_penjualan');

            $data['daftar_barang'] = $this->kasir_m_penjualan->lihat_barang();
            
            $this->load->view('kasir_v_penjualan', $data);
        }
    }

    public function nomor_invoice() {
        $this->load->model('kasir_m_penjualan');

        $data = $this->kasir_m_penjualan->nomor_invoice($this->session->id_kasir);
        $data = $data + 1; // Untuk no urut inovice saat ini
        echo json_encode($data);
    }

    public function cari_pelanggan() {
        $keyword = $this->input->post('term');

        $this->load->model('kasir_m_penjualan');
        
        $data = $this->kasir_m_penjualan->cari_pelanggan($keyword);

        if($data != '') {
			// Ubah data sesuai dengan format autocomplete jquery-ui
			for($i=0; $i<count($data); $i++) {
				$response[$i]['label'] = $data[$i]['nama_pelanggan'];
                $response[$i]['value'] = $data[$i]['nama_pelanggan'];
                $response[$i]['id']    = $data[$i]['id_pelanggan'];
                $response[$i]['level'] = $data[$i]['level'];
			}
			echo json_encode($response);
        }
        else {
            // Jika tidak ada data, tampilkan tulisan tambah pelanggan untuk memunculkan form pelanggan
            $response[0]['label'] = 'Pelanggan belum terdaftar';
            $response[0]['value'] = 'Pelanggan belum terdaftar';
            echo json_encode($response);
        }
    }

    public function penjualan_tambah_pelanggan() {
        $id_pelanggan = $this->session->id_kasir . strtolower( substr($this->input->post('nama_pelanggan'),0,3) ) . date('dmyHi');

        $input = array(
            'id_pelanggan'      => $id_pelanggan,
            'nama_pelanggan'    => $this->input->post('nama_pelanggan'),
            'alamat_pelanggan'  => $this->input->post('alamat_pelanggan'),
            'telepon_pelanggan' => $this->input->post('telepon_pelanggan'),
            'maks_utang'        => 0,
            'level'             => 4,
            'status_upload'     => 0
        );

        $this->load->model('kasir_m_pelanggan');

        $this->kasir_m_pelanggan->tambah_pelanggan($input);

        echo json_encode($id_pelanggan);
    }

    public function simpan_nota_lokal() {
        $input_laporan_penjualan = array(
            'id_invoice'              => $this->input->post('nomorInvoice'),
            'tgl_invoice'             => $this->input->post('today'),
            'id_kasir'                => $this->session->id_kasir,
            'sub_total_penjualan'     => $this->input->post('subTotal'),
            'diskon_penjualan'        => $this->input->post('diskonTotal'),
            'status_diskon_penjualan' => $this->input->post('statusDiskonTotal'),
            'total_penjualan'         => $this->input->post('totalPenjualan'),
            'id_pelanggan'            => $this->input->post('idPelanggan'),
            'nama_pelanggan'          => $this->input->post('namaPelanggan'),
            'keterangan'              => $this->input->post('keterangan'),
            'status_upload'           => 0
        );        
        $detail_penjualan = json_decode($this->input->post('isiNotaString'), true); // true untuk mengubah object menjadi associative array
 
        $this->load->model('kasir_m_penjualan');

        $this->kasir_m_penjualan->tambah_laporan_penjualan($input_laporan_penjualan);
        for($i=0; $i<count($detail_penjualan); $i++) {
            $baris = array(
                'id_invoice'            => $this->input->post('nomorInvoice'),
                'id_barang'             => $detail_penjualan[$i]['idBarang'],
                'nama_barang'           => $detail_penjualan[$i]['namaBarang'],
                'jumlah_barang'         => $detail_penjualan[$i]['jumlah'],
                'harga_barang'          => $detail_penjualan[$i]['harga'],
                'diskon_barang'         => $detail_penjualan[$i]['diskon'],
                'status_diskon_barang'  => $detail_penjualan[$i]['statusDiskon'],
                'total_harga_barang'    => $detail_penjualan[$i]['totalHarga']
            );
            $this->kasir_m_penjualan->tambah_detail_penjualan($baris);
        }
    }
    
    public function simpan_nota_pusat() {
        $this->load->model('kasir_m_stok');
        $id_toko = $this->kasir_m_stok->cek_toko($this->session->id_kasir);
        $id_toko = $id_toko['id_toko'];

        $input_laporan_penjualan = array(
            'id_invoice'              => $this->input->post('nomorInvoice'),
            'tgl_invoice'             => $this->input->post('today'),
            'id_kasir'                => $this->session->id_kasir,
            'sub_total_penjualan'     => $this->input->post('subTotal'),
            'diskon_penjualan'        => $this->input->post('diskonTotal'),
            'status_diskon_penjualan' => $this->input->post('statusDiskonTotal'),
            'total_penjualan'         => $this->input->post('totalPenjualan'),
            'id_pelanggan'            => $this->input->post('idPelanggan'),
            'nama_pelanggan'          => $this->input->post('namaPelanggan'),
            'keterangan'              => $this->input->post('keterangan')
        );        
        $detail_penjualan = json_decode($this->input->post('isiNotaString'), true); // true untuk mengubah object menjadi associative array
 
        $this->load->model('kasir_m_penjualan');

        $this->kasir_m_penjualan->tambah_laporan_penjualan_pusat($input_laporan_penjualan);
        for($i=0; $i<count($detail_penjualan); $i++) {
            $baris = array(
                'id_invoice'            => $this->input->post('nomorInvoice'),
                'id_barang'             => $detail_penjualan[$i]['idBarang'],
                'nama_barang'           => $detail_penjualan[$i]['namaBarang'],
                'jumlah_barang'         => $detail_penjualan[$i]['jumlah'],
                'harga_barang'          => $detail_penjualan[$i]['harga'],
                'diskon_barang'         => $detail_penjualan[$i]['diskon'],
                'status_diskon_barang'  => $detail_penjualan[$i]['statusDiskon'],
                'total_harga_barang'    => $detail_penjualan[$i]['totalHarga']
            );
            $this->kasir_m_penjualan->tambah_detail_penjualan_pusat($baris);
            $this->kasir_m_penjualan->perbarui_stok_barang($detail_penjualan[$i]['idBarang'], $id_toko, $detail_penjualan[$i]['jumlah']);
        }
        $this->kasir_m_penjualan->perbarui_status_penjualan_lokal($this->input->post('nomorInvoice'));
    }
}
?>
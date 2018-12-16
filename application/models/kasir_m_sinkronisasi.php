<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasir_m_sinkronisasi extends CI_Model {

    public function __construct() {

    }

    /* Sinkronisasi Data Pelanggan ---------------------------------------------------------------------------------------------------- */

    public function ambil_data_baru_pelanggan($tgl_modifikasi_skrg) {
        $this->load->database();

        $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, telepon_pelanggan, maks_utang, level');
        $this->db->where('tgl_modifikasi_data >', $tgl_modifikasi_skrg);
        $query = $this->db->get('pelanggan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function perbarui_data_pelanggan_lokal($data) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $query = 'INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, alamat_pelanggan, telepon_pelanggan, maks_utang, level) ';
        $query .= 'VALUES ("'.$data['id_pelanggan'].'","'.$data['nama_pelanggan'].'","'.$data['alamat_pelanggan'].'","'.$data['telepon_pelanggan'].'",'.$data['maks_utang'].',"'.$data['level'].'") ';
        $query .= 'ON DUPLICATE KEY UPDATE nama_pelanggan="'.$data['nama_pelanggan'].'", alamat_pelanggan="'.$data['alamat_pelanggan'].'", telepon_pelanggan="'.$data['telepon_pelanggan'].'", maks_utang='.$data['maks_utang'].', level="'.$data['level'].'"';
        $dbkasir->query($query);
    }

    public function daftar_pelanggan_dihapus() {
        $this->load->database();

        $query = $this->db->get('daftar_pelanggan_dihapus');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function daftar_pelanggan_lokal() {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->select('id_pelanggan');
        $query = $dbkasir->get('pelanggan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function hapus_pelanggan_lokal($id_pelanggan) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->where('id_pelanggan', $id_pelanggan);
        $dbkasir->delete('pelanggan');
    }
    /* End Sinkronisasi Data Pelanggan ---------------------------------------------------------------------------------------------------- */


    /* Sinkronisasi Data Barang ---------------------------------------------------------------------------------------------------- */
    
    public function ambil_data_baru_barang($tgl_modifikasi_skrg) {
        $this->load->database();

        $this->db->select('id_barang, nama_barang, jumlah_dlm_koli, kategori, fungsi, harga_jual_1, harga_jual_2, harga_jual_3, harga_jual_4');
        $this->db->where('tgl_modifikasi_data >', $tgl_modifikasi_skrg);
        $query = $this->db->get('barang');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function perbarui_data_barang_lokal($data) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $query = 'INSERT INTO barang (id_barang, nama_barang, jumlah_dlm_koli, kategori, fungsi, harga_jual_1, harga_jual_2, harga_jual_3, harga_jual_4) ';
        $query .= 'VALUES ("'.$data['id_barang'].'", "'.$data['nama_barang'].'", '.$data['jumlah_dlm_koli'].', "'.$data['kategori'].'", "'.$data['fungsi'].'", '.$data['harga_jual_1'].', '.$data['harga_jual_2'].', '.$data['harga_jual_3'].', '.$data['harga_jual_4'].') ';
        $query .= 'ON DUPLICATE KEY UPDATE id_barang="'.$data['id_barang'].'", nama_barang="'.$data['nama_barang'].'", jumlah_dlm_koli='.$data['jumlah_dlm_koli'].', kategori="'.$data['kategori'].'", fungsi="'.$data['fungsi'].'", harga_jual_1='.$data['harga_jual_1'].', harga_jual_2='.$data['harga_jual_2'].', harga_jual_3='.$data['harga_jual_3'].', harga_jual_4='.$data['harga_jual_4'];
        $dbkasir->query($query);
    }

    public function daftar_barang_dihapus() {
        $this->load->database();

        $query = $this->db->get('daftar_barang_dihapus');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function daftar_barang_lokal() {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->select('id_barang');
        $query = $dbkasir->get('barang');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function hapus_barang_lokal($id_barang) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->where('id_barang', $id_barang);
        $dbkasir->delete('barang');
    }
    /* End Sinkronisasi Data Barang ---------------------------------------------------------------------------------------------------- */


    /* Sinkronisasi Data Penjualan ---------------------------------------------------------------------------------------------------- */

    public function data_penjualan_blm_upload() {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->select('id_invoice, tgl_invoice, id_kasir, sub_total_penjualan, diskon_penjualan, status_diskon_penjualan, total_penjualan, id_pelanggan, nama_pelanggan, keterangan');
        $dbkasir->where('status_upload', 0);
        $query = $dbkasir->get('laporan_penjualan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function detail_penjualan_blm_upload($id_invoice) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->where('id_invoice', $id_invoice);
        $query = $dbkasir->get('detail_penjualan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function tambah_data_penjualan_pusat($data) {
        $this->load->database();

        $this->db->insert('laporan_penjualan', $data);
    }

    public function tambah_detail_penjualan_pusat($data) {
        $this->load->database();

        $this->db->insert('detail_penjualan', $data);
    }

    public function perbarui_stok_barang($id_barang, $id_toko, $jumlah) {
        $this->load->database();

        $query = 'UPDATE stok_barang SET stok_barang = stok_barang - ' . $jumlah;
        $query .= ' WHERE id_barang = "' . $id_barang . '" AND id_toko = "' . $id_toko . '"';
        $this->db->query($query); 
    }

    public function perbarui_data_penjualan_lokal($id_invoice) {
        $dbkasir = $this->load->database('dbkasir', TRUE);

        $dbkasir->set('status_upload', 1);
        $dbkasir->where('id_invoice', $id_invoice);
        $dbkasir->update('laporan_penjualan');
    }
    /* End Sinkronisasi Data Penjualan ---------------------------------------------------------------------------------------------------- */
}
?>
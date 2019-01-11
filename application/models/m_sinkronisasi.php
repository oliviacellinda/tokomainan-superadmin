<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_sinkronisasi extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function ambil_pelanggan_baru($tgl_modifikasi_lokal) {
        $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, telepon_pelanggan, maks_utang, level, ekspedisi');
        $this->db->where('tgl_modifikasi_data >', $tgl_modifikasi_lokal);
        $query = $this->db->get('pelanggan');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function daftar_pelanggan_dihapus() {
        $query = $this->db->get('daftar_pelanggan_dihapus');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function tambah_pelanggan($data) {
        $this->db->insert('pelanggan', $data);

        if($this->db->affected_rows() >= 0) return 1;
        else return 0;
    } 

    public function ambil_barang_baru($tgl_modifikasi_lokal) {
        $this->db->select('id_barang, nama_barang, jumlah_dlm_koli, kategori, fungsi, harga_jual_1, harga_jual_2, harga_jual_3, harga_jual_4');
        $this->db->where('tgl_modifikasi_data >', $tgl_modifikasi_lokal);
        $query = $this->db->get('barang');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function daftar_barang_dihapus() {
        $query = $this->db->get('daftar_barang_dihapus');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function tambah_laporan_penjualan($data) {
        // $this->db->insert('laporan_penjualan', $data);
        $query = 'INSERT INTO laporan_penjualan (id_invoice, tgl_invoice, id_kasir, sub_total_penjualan, diskon_penjualan, status_diskon_penjualan, total_penjualan, id_pelanggan, nama_pelanggan, alamat_pelanggan, telepon_pelanggan, keterangan) ';
        $query .= 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ';
        $query .= 'ON DUPLICATE KEY UPDATE ';
        $query .= 'id_invoice=VALUES(id_invoice), ';
        $query .= 'tgl_invoice=VALUES(tgl_invoice), ';
        $query .= 'id_kasir=VALUES(id_kasir), ';
        $query .= 'sub_total_penjualan=VALUES(sub_total_penjualan), ';
        $query .= 'diskon_penjualan=VALUES(diskon_penjualan), ';
        $query .= 'status_diskon_penjualan=VALUES(status_diskon_penjualan), ';
        $query .= 'total_penjualan=VALUES(total_penjualan), ';
        $query .= 'id_pelanggan=VALUES(id_pelanggan), ';
        $query .= 'nama_pelanggan=VALUES(nama_pelanggan), ';
        $query .= 'alamat_pelanggan=VALUES(alamat_pelanggan), ';
        $query .= 'telepon_pelanggan=VALUES(telepon_pelanggan), ';
        $query .= 'keterangan=VALUES(keterangan)';

        $this->db->query($query, $data);

        if($this->db->affected_rows() >= 0) return 1;
        else return 0;
    }

    public function tambah_detail_penjualan($data) {
        // $this->db->insert('detail_penjualan', $data);
        $query = 'INSERT INTO detail_penjualan (id_invoice, id_barang, nama_barang, jumlah_dlm_koli, kategori, jumlah_barang, harga_barang, diskon_barang, status_diskon_barang, total_harga_barang) ';
        $query .= 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ';
        $query .= 'ON DUPLICATE KEY UPDATE ';
        $query .= 'id_invoice=VALUES(id_invoice), ';
        $query .= 'id_barang=VALUES(id_barang), ';
        $query .= 'nama_barang=VALUES(nama_barang), ';
        $query .= 'jumlah_dlm_koli=VALUES(jumlah_dlm_koli), ';
        $query .= 'kategori=VALUES(kategori), ';
        $query .= 'jumlah_barang=VALUES(jumlah_barang), ';
        $query .= 'harga_barang=VALUES(harga_barang), ';
        $query .= 'diskon_barang=VALUES(diskon_barang), ';
        $query .= 'status_diskon_barang=VALUES(status_diskon_barang), ';
        $query .= 'total_harga_barang=VALUES(total_harga_barang)';

        $this->db->query($query, $data);

        if($this->db->affected_rows() >= 0) return 1;
        else return 0;        
    }

    public function perbarui_stok_barang($id_barang, $id_toko, $jumlah) {
        $query = 'UPDATE stok_barang SET stok_barang = stok_barang - ' . $jumlah;
        $query .= ' WHERE id_barang = "' . $id_barang . '" AND id_toko = "' . $id_toko . '"';
        $this->db->query($query);

        if($this->db->affected_rows() > 0) return 1;
        else return 0;
    }

    public function lihat_stok_barang($id_toko) {
        $this->db->select('stok_barang.*, barang.nama_barang, barang.jumlah_dlm_koli, barang.harga_jual_4');
        $this->db->from('stok_barang');
        $this->db->join('barang', 'stok_barang.id_barang = barang.id_barang');
        $this->db->where('id_toko', $id_toko);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function ambil_kasir_baru($tgl_modifikasi_lokal) {
        $this->db->select('kasir.id_kasir, kasir.password_kasir, kasir.id_toko, toko.nama_toko');
        $this->db->from('kasir');
        $this->db->join('toko', 'kasir.id_toko = toko.id_toko');
        $this->db->where('kasir.tgl_modifikasi_data >', $tgl_modifikasi_lokal);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function daftar_kasir_dihapus() {
        $query = $this->db->get('daftar_kasir_dihapus');

        if($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
}
?>
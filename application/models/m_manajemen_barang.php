<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_manajemen_barang extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function lihat_barang() {
		$query = $this->db->get('barang');

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	public function cek_id_barang($id_barang) {
		$this->db->select('id_barang');
		$this->db->where('id_barang', $id_barang);
		$query = $this->db->get('barang');

		if($query->num_rows() > 0) return 0;
		else return 1;
	}

	public function cek_id_barang_dihapus($id_barang) {
		$this->db->select('id_barang');
		$this->db->where('id_barang', $id_barang);
		$query = $this->db->get('daftar_barang_dihapus');

		if($query->num_rows() > 0) return 1;
		else return 0;
	}

	public function hapus_dari_daftar_barang_dihapus($id_barang) {
		$this->db->where('id_barang', $id_barang);
		$this->db->delete('daftar_barang_dihapus');
	}

	public function tambah_data($input) {
		$this->db->insert('barang', $input);
	}

	public function edit_barang($id_barang, $nama_kolom, $nilai_baru, $today) {
		$this->db->set($nama_kolom, $nilai_baru);
		$this->db->set('tgl_modifikasi_data', $today);
		$this->db->where('id_barang', $id_barang);
		$this->db->update('barang');
	}

	public function hapus_barang($id_barang) {
		$this->db->where('id_barang', $id_barang);
		$this->db->delete('barang');
	}

	public function daftar_barang_dihapus($id_barang) {
		$this->db->insert('daftar_barang_dihapus', $id_barang);
	}
	
	public function daftar_kategori($keyword) {
		$this->db->select('kategori');
		$this->db->from('barang');
		$this->db->like('kategori', $keyword);
		$this->db->group_by('kategori');
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	public function daftar_fungsi($keyword) {
		$this->db->select('fungsi');
		$this->db->from('barang');
		$this->db->like('fungsi', $keyword);
		$this->db->group_by('fungsi');
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
	}
}
?>
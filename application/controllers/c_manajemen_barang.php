<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_barang extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function manajemen_barang() {
		$this->load->view('v_manajemen_barang');
	}

	public function lihat_barang() {
		$this->load->model('m_manajemen_barang');

		echo json_encode($this->m_manajemen_barang->lihat_barang());
	}

	public function tambah_barang() {
		$input = array(
			'id_barang' => $this->input->post('id_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'jumlah_dlm_koli' => $this->input->post('jumlah_dlm_koli'),
			'kategori' => $this->input->post('kategori'),
			'fungsi' => $this->input->post('fungsi'),
			'harga_jual_1' => $this->input->post('harga_jual_1'),
			'harga_jual_2' => $this->input->post('harga_jual_2'),
			'harga_jual_3' => $this->input->post('harga_jual_3'),
			'harga_jual_4' => $this->input->post('harga_jual_4'),
		);
		
		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->tambah_data($input);
	}

	public function edit_barang() {
		$id_barang = $this->input->post('id_barang');
		$nama_kolom = $this->input->post('nama_kolom');
		$nilai_baru = $this->input->post('nilai_baru');

		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->edit_data($id_barang, $nama_kolom, $nilai_baru);
	}

	public function hapus_barang() {
		$id_barang = $this->input->post('id_barang');

		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->hapus_barang($id_barang);
	}
}

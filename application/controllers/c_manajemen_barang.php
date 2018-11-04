<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_barang extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function lihat_daftar_barang() {
		$this->load->model('m_manajemen_barang');

		$data['barang'] = $this->m_manajemen_barang->ambil_data_barang();
		
		$this->load->view('v_manajemen_barang',$data);
	}

	public function tambah_barang() {
		$input = array(
			'id_barang' => $this->input->post('id_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'harga_beli' => $this->input->post('harga_beli'),
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
		print_r($this->m_manajemen_barang->ambil_data_barang());
	}

	public function hapus_barang() {
		$id_barang = $this->input->post('id_barang');

		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->hapus_barang($id_barang);
		echo json_encode($this->m_manajemen_barang->ambil_data_barang());
	}
}

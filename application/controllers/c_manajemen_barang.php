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

	public function hapus_barang() {
		$id_barang = $this->input->post('id_barang');
		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->hapus_barang($id_barang);
	}
}

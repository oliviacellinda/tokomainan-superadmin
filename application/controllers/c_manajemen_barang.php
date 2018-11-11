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

	public function upload_gambar_barang() {
		// Tentukan syarat gambar yang diupload
		$config['upload_path']		= './assets/uploads/';
		$config['allowed_types']	= 'jpg|png';
		$config['file_ext_tolower']	= true; // Paksa ekstensi gambar menjadi lowercase
		$config['overwrite']		= true; // Overwrite file jika ada file dengan nama yg sama
		$config['max_size']			= '1024';
		$config['max_width']		= '1920';
		$config['max_height']		= '1080';
		$config['remove_spaces']	= false; // Jika TRUE, spasi dlm nama gambar diubah menjadi _
		$this->load->library('upload', $config);

		$response = array();
		$flag = array();

		$jml_gambar = count($_FILES['fileGambar']['name']);

		// Untuk menggunakan library upload CI, data file gambar harus disimpan dulu ke 'userfile'
		$file = $_FILES;
		for($i=0; $i<$jml_gambar; $i++) {
			$_FILES['userfile'] = [
				'name'		=> $file['fileGambar']['name'][$i],
				'type'		=> $file['fileGambar']['type'][$i],
				'tmp_name'	=> $file['fileGambar']['tmp_name'][$i],
				'error'		=> $file['fileGambar']['error'][$i],
				'size'		=> $file['fileGambar']['size'][$i]
			];

			$response[] = $_FILES['userfile'];

			if( !$this->upload->do_upload('userfile') ) {
				$error = $this->upload->display_errors();
				$arrayError = explode("<p>", $error);
				$countError = count($arrayError);
				$showError = substr($arrayError[$countError-1], 0, -4);
				$flag[] = $file['fileGambar']['name'][$i] . " => " . $showError;
			}
		}

		echo json_encode($flag);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_manajemen_barang extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function manajemen_barang() {
		if($this->session->username == '') {
			header('Location: login');
			die();
		}
		else $this->load->view('v_manajemen_barang');
	}

	public function lihat_barang() {
		$this->load->model('m_manajemen_barang');

		$data = $this->m_manajemen_barang->lihat_barang();
		if($data == '') echo json_encode('no data');
		else echo json_encode($data);
	}

	public function tambah_barang() {
		$input = array(
			'id_barang' 			=> $this->input->post('id_barang'),
			'nama_barang' 			=> $this->input->post('nama_barang'),
			'jumlah_dlm_koli' 		=> $this->input->post('jumlah_dlm_koli'),
			'kategori' 				=> $this->input->post('kategori'),
			'fungsi' 				=> $this->input->post('fungsi'),
			'harga_jual_1' 			=> $this->input->post('harga_jual_1'),
			'harga_jual_2'	 		=> $this->input->post('harga_jual_2'),
			'harga_jual_3' 			=> $this->input->post('harga_jual_3'),
			'harga_jual_4' 			=> $this->input->post('harga_jual_4'),
			'tgl_modifikasi_data'	=> date('Y-m-d H:i:s')
		);
		
		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->tambah_data($input);

		// Auto insert barang baru ke tabel stok barang
		$this->load->model('m_manajemen_toko');
		$this->load->model('m_manajemen_stok_barang');

		$id_barang = $this->input->post('id_barang');
		$daftar_toko = $this->m_manajemen_toko->lihat_toko();

		if($daftar_toko != '') {
			$today = date('Y-m-d');
			for($i=0; $i<count($daftar_toko); $i++) {
				$this->m_manajemen_stok_barang->auto_insert_stok_barang_baru($id_barang, $daftar_toko[$i]['id_toko'], $today);
			}
		}
	}

	public function edit_barang() {
		$id_barang = $this->input->post('id_barang');
		$nama_kolom = $this->input->post('nama_kolom');
		$nilai_baru = $this->input->post('nilai_baru');
		$today = date('Y-m-d H:i:s');

		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->edit_barang($id_barang, $nama_kolom, $nilai_baru, $today);
	}

	public function hapus_barang() {
		$id_barang = $this->input->post('id_barang');

		$this->load->model('m_manajemen_barang');

		$this->m_manajemen_barang->hapus_barang($id_barang);
        $this->m_manajemen_barang->daftar_barang_dihapus(array('id_barang' => $id_barang));
	}

	public function upload_gambar_barang() {
		$this->load->library('image_lib');

		// Tentukan syarat gambar yang diupload
		$config['upload_path']		= './assets/uploads/';
		$config['allowed_types']	= 'jpg|png';
		$config['file_ext_tolower']	= true; // Paksa ekstensi gambar menjadi lowercase
		$config['overwrite']		= true; // Overwrite file jika ada file dengan nama yg sama
		$config['remove_spaces']	= false; // Jika TRUE, spasi dlm nama gambar diubah menjadi _
		$this->load->library('upload', $config);

		// Variabel untuk menyimpan pesan error
		$pesan = array();

		$jml_gambar = count($_FILES['fileGambar']['name']);

		$file = $_FILES;
		for($i=0; $i<$jml_gambar; $i++) {

			// Untuk menggunakan library upload CI, data file gambar harus disimpan dulu ke 'userfile'
			$_FILES['userfile'] = [
				'name'		=> $file['fileGambar']['name'][$i],
				'type'		=> $file['fileGambar']['type'][$i],
				'tmp_name'	=> $file['fileGambar']['tmp_name'][$i],
				'error'		=> $file['fileGambar']['error'][$i],
				'size'		=> $file['fileGambar']['size'][$i]
			];

			// Simpan pesan error jika gambar tidak berhasil diupload
			if( ! $this->upload->do_upload('userfile') ) {
				// Fungsi display_errors() berikut menampilkan seluruh pesan error dari seluruh gambar
				// Untuk membedakan kepemilikan pesan error, pisahkan pesan error tsb
				// Pesan error berupa string dgn format <p>{pesan1}</p><p>{pesan2}</p><p>{pesan3}</p> dst
				// Pesan error untuk gambar yang diupload pada iterasi saat ini berada di posisi akhir
				// Karena itu, ambil pesan error paling akhir dengan cara berikut
				$error = $this->upload->display_errors();
				$array_error = explode("<p>", $error); // Pisahkan string menjadi array dgn indikator <p>
				$count_error = count($array_error);
				$show_error = substr($array_error[$count_error-1], 0, -4); // Hilangkan </p> di akhir string
				$pesan[] = $file['fileGambar']['name'][$i] . " -> " . $show_error;
			}
			// Jika berhasil upload gambar, resize gambar tsb
			else {
				$info = $this->upload->data();

				$config['image_library']	= 'gd2';
				$config['source_image']		= './assets/uploads/' . $file['fileGambar']['name'][$i];
				$config['maintain_ratio']	= true;
				$config['width']			= 500;
				$config['height']			= 500;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
			}
		}

		echo json_encode($pesan);
	}

	public function daftar_kategori() {
		$keyword = $this->input->post('term');

		$this->load->model('m_manajemen_barang');

		$data = $this->m_manajemen_barang->daftar_kategori($keyword);

		if($data != '') {
			// Ubah data sesuai dengan format autocomplete jquery-ui
			for($i=0; $i<count($data); $i++) {
				$response[$i]['label'] = $data[$i]['kategori'];
				$response[$i]['value'] = $data[$i]['kategori'];
			}
			echo json_encode($response);
		}
	}

	public function daftar_fungsi() {
		$keyword = $this->input->post('term');

		$this->load->model('m_manajemen_barang');

		$data = $this->m_manajemen_barang->daftar_fungsi($keyword);

		if($data != '') {
			// Ubah data sesuai dengan format autocomplete jquery-ui
			for($i=0; $i<count($data); $i++) {
				$response[$i]['label'] = $data[$i]['fungsi'];
				$response[$i]['value'] = $data[$i]['fungsi'];
			}
			echo json_encode($response);
		}
	}
}

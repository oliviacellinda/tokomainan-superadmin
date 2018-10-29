<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class manajemen_barang extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function lihat_daftar_barang()
	{
		$this->load->view('manajemen_barang');
	}
}

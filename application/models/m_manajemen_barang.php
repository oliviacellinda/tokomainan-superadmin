<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_manajemen_barang extends CI_Model
{

    public function __construct() {
		$this->load->database();
	}

	public function ambil_data_barang() {
		$query = $this->db->get('barang');

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
	}

	public function hapus_barang($id_barang) {
		$this->db->where('id_barang', $id_barang);
		$this->db->delete('barang');
	}
    
}
?>
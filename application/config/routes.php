<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'c_admin/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
| -------------------------------------------------------------------------
| ROUTE UNTUK SUPERADMIN
| -------------------------------------------------------------------------
*/
$route['login']                 = 'c_admin/login';
$route['proses-login']          = 'c_admin/proses_login';
$route['logout']                = 'c_admin/proses_logout';
$route['ganti-password']        = 'c_admin/ganti_password';
$route['proses-ganti-password'] = 'c_admin/proses_ganti_password';

$route['manajemen-toko']        = 'c_manajemen_toko/manajemen_toko';
$route['lihat-toko']            = 'c_manajemen_toko/lihat_toko';
$route['tambah-toko']           = 'c_manajemen_toko/tambah_toko';
$route['edit-toko']             = 'c_manajemen_toko/edit_toko';
$route['hapus-toko']            = 'c_manajemen_toko/hapus_toko';

$route['manajemen-kasir']       = 'c_manajemen_kasir/manajemen_kasir';
$route['lihat-kasir']           = 'c_manajemen_kasir/lihat_kasir';
$route['tambah-kasir']          = 'c_manajemen_kasir/tambah_kasir';
$route['edit-kasir']            = 'c_manajemen_kasir/edit_kasir';
$route['hapus-kasir']           = 'c_manajemen_kasir/hapus_kasir';

$route['manajemen-barang']      = 'c_manajemen_barang/manajemen_barang';
$route['lihat-barang']          = 'c_manajemen_barang/lihat_barang';
$route['tambah-barang']         = 'c_manajemen_barang/tambah_barang';
$route['edit-barang']           = 'c_manajemen_barang/edit_barang';
$route['hapus-barang']          = 'c_manajemen_barang/hapus_barang';
$route['upload-gambar-barang']  = 'c_manajemen_barang/upload_gambar_barang';
$route['daftar-kategori']       = 'c_manajemen_barang/daftar_kategori';
$route['daftar-fungsi']         = 'c_manajemen_barang/daftar_fungsi';

$route['manajemen-pelanggan']   = 'c_manajemen_pelanggan/manajemen_pelanggan';
$route['lihat-pelanggan']       = 'c_manajemen_pelanggan/lihat_pelanggan';
$route['tambah-pelanggan']      = 'c_manajemen_pelanggan/tambah_pelanggan';
$route['edit-pelanggan']        = 'c_manajemen_pelanggan/edit_pelanggan';
$route['hapus-pelanggan']       = 'c_manajemen_pelanggan/hapus_pelanggan';

$route['laporan-penjualan']     = 'c_laporan_penjualan/laporan_penjualan';
$route['daftar-penjualan']      = 'c_laporan_penjualan/daftar_penjualan';
$route['detail-penjualan']      = 'c_laporan_penjualan/detail_penjualan';
$route['batalkan-nota']         = 'c_laporan_penjualan/batalkan_nota';

$route['laporan-penjualan-dibatalkan']  = 'c_laporan_penjualan_dibatalkan/laporan_penjualan_dibatalkan';
$route['daftar-penjualan-dibatalkan']   = 'c_laporan_penjualan_dibatalkan/daftar_penjualan_dibatalkan';
$route['detail-penjualan-dibatalkan']   = 'c_laporan_penjualan_dibatalkan/detail_penjualan_dibatalkan';

// Route untuk aliran data pelanggan dengan kasir
$route['ambil-pelanggan-baru']      = 'c_sinkronisasi/ambil_pelanggan_baru';
$route['daftar-pelanggan-dihapus']  = 'c_sinkronisasi/daftar_pelanggan_dihapus';
$route['kasir-tambah-pelanggan']    = 'c_sinkronisasi/tambah_pelanggan';

// Route untuk aliran data barang dengan kasir/toko
$route['ambil-barang-baru']         = 'c_sinkronisasi/ambil_barang_baru';
$route['daftar-barang-dihapus']     = 'c_sinkronisasi/daftar_barang_dihapus';

// Route untuk aliran data laporan penjualan dan detail penjualan dengan kasir
$route['tambah-laporan-penjualan']  = 'c_sinkronisasi/tambah_laporan_penjualan';

// Route untuk aliran data stok barang dengan kasir/toko
$route['lihat-stok-barang']         = 'c_sinkronisasi/lihat_stok_barang';

// Route untuk aliran data kasir dengan kasir
$route['ambil-kasir-baru']          = 'c_sinkronisasi/ambil_kasir_baru';
$route['daftar-kasir-dihapus']      = 'c_sinkronisasi/daftar_kasir_dihapus';


/*
| -------------------------------------------------------------------------
| ROUTE UNTUK ADMIN TOKO
| -------------------------------------------------------------------------
*/
$route['toko/login']                 = 'toko_c_login/login';
$route['toko/proses-login']          = 'toko_c_login/proses_login';
$route['toko/logout']                = 'toko_c_login/proses_logout'; 

$route['toko/data-barang-masuk']     = 'c_manajemen_stok_barang/data_barang_masuk';
$route['toko/daftar-stok-barang']    = 'c_manajemen_stok_barang/daftar_stok_barang';
$route['toko/input-barang-masuk']    = 'c_manajemen_stok_barang/input_barang_masuk';
$route['toko/data-barang-keluar']    = 'c_manajemen_stok_barang/data_barang_keluar';
$route['toko/laporan-barang-keluar'] = 'c_manajemen_stok_barang/laporan_barang_keluar';
$route['toko/input-barang-keluar']   = 'c_manajemen_stok_barang/input_barang_keluar';

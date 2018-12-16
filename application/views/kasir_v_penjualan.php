<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Penjualan</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-themes-1.12.1/themes/base/jquery-ui.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.min.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
		.table > tbody > tr > td {
			vertical-align: middle;
		}

		@media print {
			@page {
				margin: 0mm !important;
                size: 148mm 210mm !important; 
				font-size: 10px;
            }
		}
	</style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <!-- Header -->
        <?php include('application/views/kasir_v_navbar_top.php');?>

		<div class="content-wrapper">
			<div class="container">
				<section class="content-header">
					<h1>Nota : <span id="nomorInvoice"></span></h1>
				</section> <!-- End content-header -->

				<section class="content">
					<!-- Lokasi pesan pemberitahuan akan ditampilkan -->
					<div id="pesanPemberitahuan"></div>

                    <!-- Cari Pelanggan -->
                    <div class="box">
                        <div class="box-body">
							<div class="row">
								<div class="col-xs-3"><label>Nama Pelanggan</label></div>
								<div class="col-xs-3 col-sm-offset-1"><label>Keterangan</label></div>
							</div> <!-- End row -->

							<div class="row">
								<!-- ID Pelanggan -->
								<input type="hidden" name="id_pelanggan">
								<!-- Level Pelanggan -->
								<input type="hidden" name="level">
								<!-- Nama Pelanggan -->
								<div class="col-xs-3">
									<div class="form-group">
										<input type="text" class="form-control" name="cari_pelanggan" placeholder="Nama Pelanggan" autocomplete="off">
									</div>
								</div>
								<div class="col-xs-1">
									<button id="btnTambahPelanggan" class="btn btn-success" data-toggle="modal" data-target="#modalFormPelanggan">
										<i class="fa fa-plus"></i>
									</button>
								</div>
								<!-- Keterangan -->
								<div class="col-xs-3">
									<div class="form-group">
										<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" autocomplete="off">
									</div>
								</div>
								<div class="col-xs-5">
									<button id="btnLihatData" class="btn btn-primary pull-right" disabled data-toggle="modal" data-target="#modalDataBarang">
										<i class="fa fa-list-ul"></i> Lihat Data
									</button>
								</div>
							</div> <!-- End row -->
                        </div> <!-- End box-body -->
                    </div> <!-- End box -->

					<!-- Tabel -->
					<div class="box">
						<div class="box-body">
							<table id="tabelPenjualan" class="table table-bordered table-striped">
								<!-- Header Tabel -->
								<thead>
								<tr>
									<th>No</th>
									<th width="162.6px">ID Barang</th>
									<th width="162.6px">Nama Barang</th>
									<th width="80px">Jumlah (pcs)</th>
									<th width="80px">Harga (pcs)</th>
									<th width="80px">Diskon</th>
									<th width="80px">Total Harga</th>
									<th>Gambar</th>
									<th>Hapus</th>
								</tr>
								</thead>

								<!-- Isi tabel -->
								<tbody>
									<!-- Isi tabel dimuat melalui fungsi refreshTabel di bawah -->
								</tbody>
							</table>

							<div class="row">
								<div class="col-sm-4 col-sm-offset-8">
									<div class="col-xs-6 text-right"><p><strong>Sub Total :</strong></p></div>
									<div class="col-xs-6"><p>Rp. <span id="labelSubTotal"></span></p></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4 col-sm-offset-8">
									<form class="form-horizontal" autocomplete="off">
										<div class="form-group">
											<label class="col-xs-6 control-label"><strong>Diskon :</strong></label>
											<div class="col-xs-6"><input type="text" class="form-control" name="diskonTotal" placeholder="Diskon Total" value="0" autocomplete="off"></div>
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4 col-sm-offset-8">
									<div class="col-xs-6 text-right"><p><strong>Total :</strong></p></div>
									<div class="col-xs-6"><p>Rp. <span id="labelTotalPenjualan"></span></p></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4 col-sm-offset-8">
									<button id="btnCetakNota" class="btn btn-primary pull-right"><i class="fa fa-print"></i> Cetak Nota</button>
								</div>
							</div>

						</div> <!-- End box-body -->

						<!-- Disable terlebih dahulu tabel penjualan -->
						<div id="disableTabelPenjualan" class="overlay"></div>
					</div> <!-- End box -->
				</section> <!-- End content -->
			</div> <!-- End container -->
		</div> <!-- End content-wrapper -->
    </div> <!-- End wrapper -->

	<!-- Modal Form Pelanggan -->
	<div class="modal" id="modalFormPelanggan" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Judul Modal -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                </div> <!-- End modal-header -->

                <!-- Isi Modal -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <form id="formTambahPelanggan" autocomplete="off">
								<div class="row">
									<div class="col-xs-4"><label>Nama</label></div>
									<div class="col-xs-4"><label>Alamat</label></div>
									<div class="col-xs-4"><label>Telepon</label></div>
								</div>
								<div class="row">
									<div class="col-xs-4">
										<div class="form-group">
											<input type="text" class="form-control" name="nama_pelanggan" placeholder="Nama" autocomplete="off" required>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="form-group">
											<input type="text" class="form-control" name="alamat_pelanggan" placeholder="Alamat" autocomplete="off" required>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="form-group">
											<input type="text" class="form-control" name="telepon_pelanggan" placeholder="Telepon" autocomplete="off" required>
										</div>
									</div>
								</div>
								<div id="loadingPelanggan" class="row"></div>
							</form>
                        </div> <!-- End col-xs-12 -->
                    </div> <!-- End row -->
                </div> <!-- End modal-body -->

                <!-- Kaki Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div> <!-- End modal-footer -->
            </div> <!-- End modal-content -->
        </div> <!-- End modal-dialog -->
    </div> <!-- End modal -->

	<!-- Modal Data Barang -->
    <div class="modal" id="modalDataBarang" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Judul Modal -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Daftar Barang</h4>
                </div> <!-- End modal-header -->

                <!-- Isi Modal -->
                <div class="modal-body">
					<div id="loadingBarang" class="row"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="tabelBarang" class="table table-bordered table-striped" style="width:100%">
								<thead>
								<tr>
									<th>Pilih</th>
									<th>ID Barang</th>
									<th>Nama Barang</th>
									<th>Jumlah dlm koli</th>
									<th>Kategori</th>
									<th>Fungsi</th>
								</tr>
								</thead>
                                <tbody><!-- Isi tabel melalui ajax di bawah --></tbody>
                            </table>
                        </div> <!-- End col-xs-12 -->
                    </div> <!-- End row -->
                </div> <!-- End modal-body -->

                <!-- Kaki Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div> <!-- End modal-footer -->
            </div> <!-- End modal-content -->
        </div> <!-- End modal-dialog -->
    </div> <!-- End modal -->
    
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/jquery-ui-1.12.1/jquery-ui.min.js');?>"></script>
	<script src="<?php echo base_url('assets/printThis-master/printThis.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>

	<script>
	// Deklarasi variabel global
	var isiNota = new Array();
	var daftarBarang = JSON.parse('<?php echo json_encode($daftar_barang);?>');
	var idBarangBaru, jumlahBaru, diskonBaru;

	// Ambil nilai baru dari input
	function ambilNilaiBaru(input) {
		idBarangBaru = $(input).parent().parent().find('input[name="id_barang"]').val();
		jumlahBaru = $(input).parent().parent().find('input[name="jumlah"]').val();
		diskonBaru = $(input).parent().parent().find('input[name="diskon"]').val();
	}

	$(document).ready(function() {
		// Tandai menu Penjualan8 sebagai menu aktif pada header
		$('#penjualan').addClass('active');
		// Fokus pada input pelanggan
		$('input[name="cari_pelanggan"]').focus();

		var tabelBarang = $('#tabelBarang').DataTable();

		var tabelPenjualan = $('#tabelPenjualan').DataTable({
			'scrollX'		: true,
			'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
			'columnDefs'	: [
				{ 'orderable' : false, 'targets' : [ 7, 8] }
			],
			'paging'		: false,
			'searching'		: false
		});

		$('input[name="cari_pelanggan"]').autocomplete({
			source		: function(request, response) {
				$.ajax({
					type	: 'post',
					url		: 'cari-pelanggan',
					dataType: 'json',
					data	: { term : request.term },
					success : function(data) {
						response(data);
					}
				});
			},
			// focus	: function(event, ui) {
			// 	event.preventDefault();
			// 	$(this).val(ui.item.label);
			// },
			select	: function(event, ui) {
				if(ui.item.value === 'Pelanggan belum terdaftar') {
					event.preventDefault();
					$('input[name="cari_pelanggan"]').val('');
				}
				else { 
					$('input[name="id_pelanggan"]').val(ui.item.id);
					$('input[name="level"]').val(ui.item.level);
					$('#btnLihatData').removeAttr('disabled');
					$('#disableTabelPenjualan').removeClass('overlay');
				}
			}
		});

		nomorInvoiceBaru();
		refreshTabelBarang();
		refreshTabelPenjualan();

		// Fungsi untuk menentukan ID Invoice baru
		function nomorInvoiceBaru() {
			var today = new Date();
			var d = ( today.getDate() >= 10 ) ? today.getDate() : ( '0' + today.getDate() ); // getDate mengembalikan nilai antara 1-31
			var m = ( (today.getMonth() + 1) >= 10 ) ? today.getMonth() + 1 : ( '0' + (today.getMonth() + 1) ); // getMonth mengembalikan nilai antara 0-11
			var y = today.getFullYear();

			$.ajax({
				url		: 'nomor-invoice',
				dataType: 'json',
				success : function(data) {
					// Tentukan nomor invoice dgn format [id kasir]-[Ymd hari ini]-[no urut]
					$('#nomorInvoice').text('<?php echo $this->session->id_kasir;?>' + '-' + y + m + d + '-' + data);
				}
			});
		} // End fungsi nomorInvoiceBaru

		// Fungsi untuk memperbarui modal data barang
		function refreshTabelBarang() {
			// Hapus isi data tabel
			$('#tabelBarang tbody').remove();
			
			// Buat variabel baru yang berisi HTML untuk isi data
			var isi = '<tbody>';
			if(daftarBarang.length > 0) {
				for(var i=0; i<daftarBarang.length; i++) {
					isi += '<tr>';
					isi += '<td><button id="btnPilihBarang" class="btn btn-xs btn-success">Pilih</button></td>';
					isi += '<td>'+daftarBarang[i].id_barang+'</td>';
					isi += '<td>'+daftarBarang[i].nama_barang+'</td>';
					isi += '<td>'+daftarBarang[i].jumlah_dlm_koli+'</td>';
					isi += '<td>'+daftarBarang[i].kategori+'</td>';
					isi += '<td>'+daftarBarang[i].fungsi+'</td>';
					isi += '</tr>';
				}
			}
			isi += '</tbody>';

			// Tambahkan data baru ke dalam tabel
			$('#tabelBarang').append(isi);

			// Reinitialize DataTable
			tabelBarang.clear().destroy();
			tabelBarang = $('#tabelBarang').DataTable({
				'scrollX'		: true,
				'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
				'columnDefs'	: [
					{ 'orderable' : false, 'targets' : 0 }
				],
				'order'			: [[ 1, 'asc' ]]
			});
		} // End fungsi refreshTabelBarang

		// Fungsi untuk memperbarui tabel penjualan
		function refreshTabelPenjualan() {
			// Hapus isi data tabel
			$('#tabelPenjualan tbody').remove();

			// Buat variabel baru yang berisi HTML untuk isi data
			var isi = '<tbody>';
			// Baris input manual
			isi += '<tr id="barisInput">';
			isi += '<td></td>';
			isi += '<td><input type="text" class="form-control" placeholder="ID Barang" name="id_barang" autocomplete="off"></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '<td></td>';
			isi += '</tr>';
			if(isiNota.length != 0) {
				for(var i=0; i<isiNota.length; i++) {
					isi += '<tr>';
					isi += '<td>'+(i+1)+'</td>';
					isi += '<td><input type="text" class="form-control" placeholder="ID Barang" name="id_barang" value="'+isiNota[i].idBarang+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
					isi += '<td>'+isiNota[i].namaBarang+'</td>';
					isi += '<td><input type="text" class="form-control" style="width:100px;" placeholder="Jumlah (pcs)" name="jumlah" value="'+isiNota[i].jumlah+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
					isi += '<td>'+isiNota[i].harga+'</td>';
					isi += '<td><input type="text" class="form-control" style="width:100px;" placeholder="Diskon" name="diskon" value="'+isiNota[i].diskon+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
					isi += '<td>'+isiNota[i].totalHarga+'</td>';
					isi += '<td><button id="btnGambar" class="btn btn-xs btn-info" data-id="'+isiNota[i].idBarang+'">Gambar</button></td>';
					isi += '<td><button id="btnHapus" class="btn btn-xs btn-danger" data-id="'+isiNota[i].idBarang+'"><i class="fa fa-times"></i></button></td>';
					isi += '</tr>';
				}
			}
			isi += '</tbody>';

			// Tambahkan ke tabel
			$('#tabelPenjualan').append(isi);

			// Reinitialize DataTable
			tabelPenjualan.clear().destroy();
			tabelPenjualan = $('#tabelPenjualan').DataTable({
				'scrollX'		: true,
				'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
				'columnDefs'	: [
					{ 'orderable' : false, 'targets' : [ 7, 8] }
				],
				'paging'		: false,
				'searching'		: false
			});
		} // End fungsi refreshTabelPenjualan

		// Fungsi untuk menampilkan pesan loading selama proses berlangsung
		function pesanLoading() {
			var loading = '<div class="overlay">';
			loading += '<i class="fa fa-refresh fa-spin"></i>';
			loading += '</div>';
			$('div[class="box"]').append(loading);
		} // End fungsi pesanLoading

		// Fungsi untuk menyesuaikan tombol Pilih dalam modal daftar barang
		function adjustTombolPilih() {
			if(isiNota.length != 0) {
				// Hapus isi data tabel
				$('#tabelBarang tbody').remove();
				
				// Buat variabel baru yang berisi HTML untuk isi data
				var isi = '<tbody>';
				if(daftarBarang.length > 0) {
					for(var i=0; i<daftarBarang.length; i++) {
						isi += '<tr>';

						// Cek apakah ID Barang pada iterasi saat ini sdh ada dalam nota
						var cek = isiNota.find(arr => arr.idBarang === daftarBarang[i].id_barang);
						if(cek != null) isi += '<td><button id="btnPilihBarang" class="btn btn-xs btn-success" disabled>Pilih</button></td>';
						else isi += '<td><button id="btnPilihBarang" class="btn btn-xs btn-success">Pilih</button></td>';

						isi += '<td>'+daftarBarang[i].id_barang+'</td>';
						isi += '<td>'+daftarBarang[i].nama_barang+'</td>';
						isi += '<td>'+daftarBarang[i].jumlah_dlm_koli+'</td>';
						isi += '<td>'+daftarBarang[i].kategori+'</td>';
						isi += '<td>'+daftarBarang[i].fungsi+'</td>';
						isi += '</tr>';
					}
				}
				isi += '</tbody>';

				// Tambahkan data baru ke dalam tabel
				$('#tabelBarang').append(isi);

				// Reinitialize DataTable
				tabelBarang.clear().destroy();
				tabelBarang = $('#tabelBarang').DataTable({
					'scrollX'		: true,
					'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
					'columnDefs'	: [
						{ 'orderable' : false, 'targets' : 0 }
					],
					'order'			: [[ 1, 'asc' ]]
				});
			}
		} // End fungsi adjustTombolPilih

		// Fungsi untuk menghitung total penjualan
		function totalPenjualan() {
			var subTotal = 0;
			var diskonTotal = $('input[name="diskonTotal"]').val();
			var totalPenjualan = 0;

			for(var i=0; i<isiNota.length; i++) {
				subTotal = subTotal + parseInt(isiNota[i].totalHarga);
			}

			if( diskonTotal.indexOf('%') == -1 ) {
				totalPenjualan = subTotal - parseInt(diskonTotal);
			}
			else {
				totalPenjualan = subTotal * (100 - parseInt(diskonTotal)) / 100;
			}

			$('#labelSubTotal').text(subTotal);
			$('#labelTotalPenjualan').text(totalPenjualan);

		} // End fungsi totalPenjualan

		// Fungsi untuk menyimpan nota dalam database kasir
		function simpanNotaLokal(today, subTotal, diskonTotal, statusDiskonTotal, totalPenjualan, nomorInvoice, idPelanggan, namaPelanggan, keterangan, isiNotaString) {
			$.ajax({
				type	: 'post',
				url		: 'simpan-nota-lokal',
				data	: {
					today				: today,
					subTotal			: subTotal,
					diskonTotal 		: diskonTotal,
					statusDiskonTotal	: statusDiskonTotal,
					totalPenjualan		: totalPenjualan,
					nomorInvoice		: nomorInvoice,
					idPelanggan			: idPelanggan,
					namaPelanggan		: namaPelanggan,
					keterangan			: keterangan,
					isiNotaString		: isiNotaString
				},
				success	: function(data) {
					// Jika berhasil simpan dalam database kasir, cetak nota dan simpan ke database pusat
					// Cetak nota
					// ??

					// Simpan ke database pusat
					simpanNotaPusat(today, subTotal, diskonTotal, statusDiskonTotal, totalPenjualan, nomorInvoice, idPelanggan, namaPelanggan, keterangan, isiNotaString);
				},
				error	: function(response) {
					console.log(response.responseText);
					// Tampilkan pesan pemberitahuan, dan lakukan tindakan sesuai pilihan kasir
					var pesan = confirm('Data gagal disimpan dalam database! Tetap cetak nota?');
					if(pesan == true) {
						// Cetak nota
						// ??

						// Simpan data ke database pusat
						simpanNotaPusat(today, subTotal, diskonTotal, statusDiskonTotal, totalPenjualan, nomorInvoice, idPelanggan, keterangan, isiNotaString);
					}
					else {

					}
				}
			})
		} // End fungsi simpanNotaLokal

		// Fungsi untuk menyimpan nota dalam database admin
		function simpanNotaPusat(today, subTotal, diskonTotal, statusDiskonTotal, totalPenjualan, nomorInvoice, idPelanggan, namaPelanggan, keterangan, isiNotaString) {
			$.ajax({
				type	: 'post',
				url		: 'simpan-nota-pusat',
				data	: {
					today				: today,
					subTotal			: subTotal,
					diskonTotal 		: diskonTotal,
					statusDiskonTotal	: statusDiskonTotal,
					totalPenjualan		: totalPenjualan,
					nomorInvoice		: nomorInvoice,
					idPelanggan			: idPelanggan,
					namaPelanggan		: namaPelanggan,
					keterangan			: keterangan,
					isiNotaString		: isiNotaString
				},
				success	: function(data) {
					console.log('yes');
					refreshHalaman();
				},
				error	: function(response) {
					console.log(response.responseText);
				}
			})
		} // End fungsi simpanNotaPusat

		// Fungsi untuk mencetak nota
		function cetakNota() {
			var print = '<div class="box">';
			print += '<div class="box-body" id="cetakNota">';
			print += '<table class="table table-bordered" width="100%">';
			// Baris judul tabel
			print += '<thead>';
			print += '<tr>';
			print += '<th>No</th>';
			print += '<th>Jumlah Barang</th>';
			print += '<th>Nama Barang</th>';
			print += '<th>Kode Barang</th>';
			print += '<th>Harga Satuan</th>';
			print += '<th>Diskon</th>';
			print += '<th>Total</th>';
			print += '<th>Dus ke-</th>';
			print += '</tr>';
			print += '</thead>';
			// Isi tabel
			print += '<tbody>';
			for(var i=0; i<isiNota.length; i++) {
				print += '<tr>';
				print += '<td>' + (i+1) + '</td>';
				print += '<td>' + isiNota[i].jumlah + '</td>';
				print += '<td>' + isiNota[i].namaBarang + '</td>';
				print += '<td>' + isiNota[i].idBarang + '</td>';
				print += '<td>Rp. ' + isiNota[i].harga + '</td>';
				if(isiNota[i].statusDiskon == 'p') print += '<td>' + isiNota[i].diskon + '%</td>';
				else print += '<td>Rp. ' + isiNota[i].diskon + '</td>';
				print += '<td>Rp. ' + isiNota[i].totalHarga + '</td>';
				print += '<td></td>';
				print += '</tr>';
			}
			print += '</tbody>';
			print += '</table>';
			print += '</div>';
			print += '</div>';

			$('body .content').append(print);

			$('#cetakNota').printThis({
				importCSS : true,
				importStyle : true,
			});
		} // End fungsi cetakNota

		// Fungsi untuk refresh halaman
		function refreshHalaman() {
			isiNota = new Array();
			refreshTabelPenjualan();
			refreshTabelBarang();
			nomorInvoiceBaru();
			$('input[name="cari_pelanggan"]').val('');
			$('input[name="cari_pelanggan"]').focus();
			$('input[name="id_pelanggan"]').val('');
			$('input[name="level_pelanggan"]').val('');
			$('input[name="keterangan"]').val('');
			$('#btnLihatData').prop('disabled', 'remove');
			$('#disableTabelPenjualan').addClass('overlay');
		} // End fungsi refreshHalaman

		// Event handler untuk menambah pelanggan
		$('#modalFormPelanggan').on('shown.bs.modal', function() {
			$('input[name="nama_pelanggan"]').focus();
		});
		$('#modalFormPelanggan').on('keypress', 'input[name="nama_pelanggan"]', function(event) {
			if(event.keyCode === 13) $('input[name="alamat_pelanggan"]').focus();
		});
		$('#modalFormPelanggan').on('keypress', 'input[name="alamat_pelanggan"]', function(event) {
			if(event.keyCode === 13) $('input[name="telepon_pelanggan"]').focus();
		});
		$('#modalFormPelanggan').on('keypress', 'input[name="telepon_pelanggan"]', function(event) {
			if(event.keyCode === 13) {
				// Progress bar selama proses tambah pelanggan
				var loading = '<div class="progress">';
				loading += '<div class="progress-bar progress-bar-success progress-bar-striped active progress-xs" style="width:100%"></div>';
				loading += '</div>';
				$('#loadingPelanggan').append(loading);

				// Disable semua input dalam form
				$('input[name="nama_pelanggan"]').prop('disabled', 'remove');
				$('input[name="alamat_pelanggan"]').prop('disabled', 'remove');
				$('input[name="telepon_pelanggan"]').prop('disabled', 'remove');

				// Ambil data
				var nama_pelanggan = $('input[name="nama_pelanggan"]').val();
				var alamat_pelanggan = $('input[name="alamat_pelanggan"]').val();
				var telepon_pelanggan = $('input[name="telepon_pelanggan"]').val();

				$.ajax({
					type	: 'post',
					url		: 'penjualan-tambah-pelanggan',
					dataType: 'json',
					data	: {
						nama_pelanggan		: nama_pelanggan,
						alamat_pelanggan	: alamat_pelanggan,
						telepon_pelanggan	: telepon_pelanggan
					},
					success	: function(data) {
						// Reset value input
						$('input[name="nama_pelanggan"]').val('');
						$('input[name="alamat_pelanggan"]').val('');
						$('input[name="telepon_pelanggan"]').val('');
						
						// Hilangkan disable pada input
						$('input[name="nama_pelanggan"]').removeAttr('disabled');
						$('input[name="alamat_pelanggan"]').removeAttr('disabled');
						$('input[name="telepon_pelanggan"]').removeAttr('disabled');

						// Hilangkan progress bar
						$('.progress').remove();

						// Tutup modal
						$('#modalFormPelanggan').modal('hide');

						// Tentukan nilai pada input cari pelanggan
						$('input[name="cari_pelanggan"]').val(nama_pelanggan);
						$('input[name="id_pelanggan"]').val(data);

						// Hilangkan disable pada button Lihat Data
						$('#btnLihatData').removeAttr('disabled');

						// Hilangkan disable pada tabel penjualan
						$('#disableTabelPenjualan').removeClass('overlay');
					}
				});
			}
		}); // End event handler menambah pelanggan

		// Ketika modal ditampilkan, sesuaikan button Pilih dengan isi nota
		$('#modalDataBarang').on('show.bs.modal', function() {
			if(isiNota.length != 0) {
				adjustTombolPilih();
			}
		}); // End event handler saat modal daftar barang ditampilkan

		// Setelah modal selesai ditampilkan, atur kembali lebar kolom tabel barang
		$('#modalDataBarang').on('shown.bs.modal', function() {
			// Atur kembali lebar kolom tabel saat modal muncul
			tabelBarang.columns.adjust();
		}); // End event handler saat modal daftar barang selesai ditampilkan

		// Event handler button Pilih dalam modal daftar barang
		$('#tabelBarang').on('click', '#btnPilihBarang', function() {
			// Level pelanggan
			var level = $('input[name="level"]').val();
			// Seluruh data yang berada di baris yang sama dengan tombol Pilih yang diklik
			var data = tabelBarang.row($(this).parents('tr')).data();
			var pilihan = {
				idBarang	: data[1],
				namaBarang	: data[2],
				jumlah		: 0,
				harga		: 0,
				diskon		: 0,
				statusDiskon: '',
				totalHarga	: 0
			};

			// Cek harga
			var temp = daftarBarang.find(arr => arr.id_barang === data[1]);
			switch(level) {
				case '1' : pilihan.harga = temp.harga_jual_1; break;
				case '2' : pilihan.harga = temp.harga_jual_2; break;
				case '3' : pilihan.harga = temp.harga_jual_3; break;
				case '4' : pilihan.harga = temp.harga_jual_4; break;
			}

			isiNota.push(pilihan);

			// Disable button Pilih pada baris data yang telah dipilih
			$(this).prop('disabled', 'remove');

			totalPenjualan();
		}); // End event klik button Pilih pada modal daftar barang

		// Event handler saat selesai memilih barang dan menutup modal
		$('#modalDataBarang').on('hidden.bs.modal', function() {
			pesanLoading();
			refreshTabelPenjualan();
			$('.overlay').remove();
		}); // End event handler saat modal daftar barang ditutup

		// Event handler tombol Enter di input ID Barang, untuk menambah daftar nota sesuai dengan ID Barang yang dimasukkan
		$('#tabelPenjualan').on('keypress', '#barisInput input[name="id_barang"]', function(event) {
			if(event.keyCode === 13) {
				pesanLoading();

				var id_barang = $('#barisInput input[name="id_barang"]').val();

				// Cek apakah barang sudah ada di daftar nota, tambahkan ke nota jika belum ada
				var cek = isiNota.find(arr => arr.idBarang === id_barang);
				if(cek == null) {
					// Cek apakah kode barang ada dalam daftar barang, tambahkan ke nota jika kode barang terdaftar
					var temp = daftarBarang.find(arr => arr.id_barang === id_barang);
					if(temp != null) {
						var input = {
							idBarang	: temp.id_barang,
							namaBarang	: temp.nama_barang,
							jumlah		: 0,
							harga		: 0,
							diskon		: 0,
							statusDiskon: '',
							totalHarga	: 0
						};
						var level = $('input[name="level"]').val();
						switch(level) {
							case '1' : input.harga = temp.harga_jual_1; break;
							case '2' : input.harga = temp.harga_jual_2; break;
							case '3' : input.harga = temp.harga_jual_3; break;
							case '4' : input.harga = temp.harga_jual_4; break;
						}
						isiNota.push(input);

						refreshTabelPenjualan();
					} // End if hasil pencarian tidak undefined
				} // End if barang belum ada di nota

				$('.overlay').remove();
			}
		}); // End event handler tekan tombol Enter di input ID Barang pada baris 
		
		// Event handler edit data dalam tabel penjualan (trigger dgn tombol Enter)
		$('#tabelPenjualan').on('keypress', 'td', function(event) {
			if(event.keyCode === 13) {
				// Cek apakah tombol ditekan pada barisan input data baru
				if( tabelPenjualan.row($(this).parents('tr')).id() != 'barisInput' ) {
					var baris = tabelPenjualan.cell(this).index().row;
					var dataBaris = tabelPenjualan.row($(this).parents('tr')).data();

					// Cek input yang dikenai event tombol Enter
					var cell = tabelPenjualan.cell(this).data();
					if( cell.indexOf('name="id_barang"') != -1 ) {
						var idBarang = idBarangBaru;

						// Cek apakah ID Barang baru sudah ada dalam nota
						var cekNota = isiNota.find(arr => arr.idBarang === idBarang);
						if(cekNota != null) {
							// Jika ada, kembalikan ID Barang ke nilai semula
							var idBarangSemula = cell.split('value="').pop();
							idBarangSemula = idBarangSemula.replace('" onkeypress="ambilNilaiBaru(this)">', '');
							$(this).find('input[name="id_barang"]').val(idBarangSemula);
						}
						else {
							// Cek apakah ID Barang baru ada dalam daftar barang
							var cekDaftar = daftarBarang.find(arr => arr.id_barang === idBarang);
							if(cekDaftar == null) {
								// Jika tidak ada, kembalikan ID Barang ke nilai semula
								var idBarangSemula = cell.split('value="').pop();
								idBarangSemula = idBarangSemula.replace('" onkeypress="ambilNilaiBaru(this)">', '');
								$(this).find('input[name="id_barang"]').val(idBarangSemula);
							}
							else {
								// Jika ada, perbarui isiNota dan refresh tabel penjualan
								var level = $('input[name="level"]').val();
								isiNota[baris-1].idBarang = cekDaftar.id_barang;
								isiNota[baris-1].namaBarang = cekDaftar.nama_barang;
								isiNota[baris-1].jumlah = 0;
								isiNota[baris-1].diskon = 0;
								isiNota[baris-1].statusDiskon = '';
								isiNota[baris-1].totalHarga = 0;

								switch(level) {
									case '1' : isiNota[baris-1].harga = cekDaftar.harga_jual_1; break;
									case '2' : isiNota[baris-1].harga = cekDaftar.harga_jual_2; break;
									case '3' : isiNota[baris-1].harga = cekDaftar.harga_jual_3; break;
									case '4' : isiNota[baris-1].harga = cekDaftar.harga_jual_4; break;
								}

								refreshTabelPenjualan();
							}
						}
					}
					else if( cell.indexOf('name="jumlah"') != -1 || cell.indexOf('name="diskon"') != -1 ) {
						var jumlah = jumlahBaru;
						var diskon = diskonBaru;
						var harga = tabelPenjualan.cell(baris, 4).data();
						var totalHarga = 0;
						isiNota[baris-1].jumlah = jumlah;
						isiNota[baris-1].diskon = parseInt(diskon);

						// Cek jenis diskon (persentase atau nominal)
						if( diskon.indexOf('%') == -1 ) {
							totalHarga = ( parseInt(jumlah) * (parseInt(harga) - parseInt(diskon)) ).toString();
							isiNota[baris-1].statusDiskon = 'n';
							isiNota[baris-1].totalHarga = totalHarga;
						}
						else {
							totalHarga = ( (parseInt(jumlah) * parseInt(harga)) * (100 - parseInt(diskon)) / 100 ).toString();
							isiNota[baris-1].statusDiskon = 'p';
							isiNota[baris-1].totalHarga = totalHarga;
						}

						tabelPenjualan.cell(baris, 6).data(totalHarga);
					}

					totalPenjualan();

				} // End if bukan baris input
			} // End if tombol yang ditekan adalah Enter
		}); // End event handler edit data dalam tabel penjualan

		// Event handler tombol Hapus dalam tabel penjualan
		$('#tabelPenjualan').on('click', '#btnHapus', function() {
			var baris = tabelPenjualan.row($(this).parent()).index();
			// Hapus data dari isiNota, parameter 1 adalah posisi/indeks, parameter 2 adalah jumlah yg dihapus
			isiNota.splice(baris-1, 1);
			refreshTabelPenjualan();
			totalPenjualan();
		}); // End event handler tombol Hapus dalam tabel penjualan

		// Event handler untuk input diskon total
		$('input[name="diskonTotal"]').keypress(function(event) {
			if(event.keyCode === 13) {
				event.preventDefault();
				totalPenjualan();
			}
		}); // End event handler untuk input diskon total

		// Event handler tombol Cetak Nota
		$('#btnCetakNota').click(function() {
			// cetakNota();
			var today = new Date();
			var d = ( today.getDate() >= 10 ) ? today.getDate() : ( '0' + today.getDate() ); // getDate mengembalikan nilai antara 1-31
			var m = ( (today.getMonth() + 1) >= 10 ) ? today.getMonth() + 1 : ( '0' + (today.getMonth() + 1) ); // getMonth mengembalikan nilai antara 0-11
			var y = today.getFullYear();
			var h = ( today.getHours() >= 10 ) ? today.getHours() : ( '0' + today.getHours() ); // getHours mengembalikan nilai antara 0-23
			var i = ( today.getMinutes() >= 10 ) ? today.getMinutes() : ( '0' + today.getMinutes() ); // getMinutes mengembalikan nilai antara 0-59
			var s = ( today.getSeconds() >= 10 ) ? today.getSeconds() : ( '0' + today.getSeconds() ); // getSeconds mengembalikan nilai antara 0-59
			var today = y + '-' + m + '-' + d + ' ' + h + ':' + i + ':' + s;

			var subTotal = $('#labelSubTotal').text();
			var diskonTotal = $('input[name="diskonTotal"]').val();
			var statusDiskonTotal = ( diskonTotal.indexOf('%') != -1 ) ? 'p' : 'n';
			var totalPenjualan = $('#labelTotalPenjualan').text();
			var nomorInvoice = $('#nomorInvoice').text();
			var idPelanggan = $('input[name="id_pelanggan"]').val();
			var namaPelanggan = $('input[name="cari_pelanggan"]').val();
			var keterangan = $('input[name="keterangan"]').val();
			var isiNotaString = JSON.stringify(isiNota);

			simpanNotaLokal(today, subTotal, diskonTotal, statusDiskonTotal, totalPenjualan, nomorInvoice, idPelanggan, namaPelanggan, keterangan, isiNotaString);
		});
	});
	</script>
</body>
</html>
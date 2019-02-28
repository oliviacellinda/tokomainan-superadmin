<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen Barang</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/css/select2.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-themes-1.12.1/themes/base/jquery-ui.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.min.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue">
	<div class="wrapper">
		<!-- Main Header -->
		<?php include('application/views/v_navbar_top.php');?>

		<!-- Sidebar -->
		<?php include('application/views/v_navbar_left.php');?>

		<!-- Konten Halaman -->
		<div class="content-wrapper">

			<!-- Header -->
			<section class="content-header">
				<h1>Manajemen Barang</h1>
			</section>

			<!-- Konten Utama -->
			<section class="content container-fluid">
				<div class="row">
					<div class="col-xs-12">

						<!-- Lokasi pesan pemberitahuan akan ditampilkan -->
						<div id="pesanPemberitahuan"></div>

						<!-- Kotak berisi tabel data -->
						<div class="box">
							<!-- Button untuk upload gambar -->
							<div class="box-header">
								<form class="pull-right" enctype="multipart/form-data">
									<input id="inputGambar" type="file" name="fileGambar[]" multiple>
								</form>
							</div>

							<!-- Tabel -->
							<div class="box-body">
								<table id="tabelBarang" class="table table-bordered table-striped">

								<!-- Header Tabel -->
								<thead>
								<tr>
									<th width="162.6px">ID Barang</th>
									<th width="162.6px">Nama Barang</th>
									<th width="162.6px">Jumlah dalam Koli</th>
									<th width="162.6px">Kemasan</th>
									<th width="162.6px">Fungsi</th>
									<th width="162.6px">Harga Jual Level 1</th>
									<th width="162.6px">Harga Jual Level 2</th>
									<th width="162.6px">Harga Jual Level 3</th>
									<th width="162.6px">Harga Jual Level 4</th>
									<th>Hapus</th>
								</tr>
								</thead>

								<!-- Isi Tabel -->
								<tbody>
									<!-- Isi tabel dimuat melalui fungsi refreshTabel di bawah -->
								</tbody>

								</table>
							</div> <!-- End box-body -->
						</div> <!-- End box -->
					</div> <!-- End col-xs-12 -->
				</div> <!-- End row -->
			</section> <!-- End section for content -->
		</div> <!-- End content-wrapper -->
	</div> <!-- End wrapper -->

	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/js/select2.full.min.js');?>"></script>
	<script src="<?php echo base_url('assets/jquery-ui-1.12.1/jquery-ui.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>
	<script src="<?php echo base_url('assets/bootstrap-filestyle-1.2.3/src/bootstrap-filestyle.min.js');?>"></script>

	<script>
	var nilaiBaru = 0; 
	// Ambil nilai baru dari input
	function ambilNilaiBaru(input) {
		nilaiBaru = input.value;
	}

	$(document).ready(function() {
		// Tandai menu Manajemen Barang sebagai menu aktif pada sidebar
		$('#manajemenBarang').addClass('active');

		// Gunakan Filestyle untuk button upload gambar
		$('#inputGambar').filestyle({
			input		: false,
			buttonText	: 'Upload Gambar',
			buttonName	: 'btn-primary',
			iconName	: 'fa fa-upload',
			badge		: false
		});

		// Gunakan DataTable
		var tabel = $('#tabelBarang').DataTable({
			'scrollX'		: true,
			'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
			'columnDefs'	: [
				{ 'orderable' : false, 'targets' : 9 } // Pilih kolom yg tdk memiliki fitur pengurutan, dimulai dari indeks 0
			],
			'stateSave'		: true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
		});

		// Isi tabel
		refreshTabel();

		// Kumpulan event handler untuk baris input
		$('#tabelBarang').on('keypress', '#barisInput input[name="id_barang"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#id').addClass('has-error');
				}
				else {
					$('#barisInput input[name="nama_barang"]').focus();
				}
			}
			else {
				$('#id').removeClass('has-error');
			}
		});
		$('#tabelBarang').on('keypress', '#barisInput input[name="nama_barang"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#nama').addClass('has-error');
				}
				else {
					$('#barisInput input[name="jumlah_dlm_koli"]').focus();
				}
			}
			else {
				$('#nama').removeClass('has-error');
			}
		});
		$('#tabelBarang').on('keypress', '#barisInput input[name="jumlah_dlm_koli"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#jmlKoli').addClass('has-error');
				}
				else {
					$('#barisInput select[name="kemasan"]').focus();
				}
			}
			else {
				$('#jmlKoli').removeClass('has-error');
			}
		});
		$('#tabelBarang').on('keypress', '#barisInput input[name="harga_jual_1"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#harga1').addClass('has-error');
				}
				else {
					$('#barisInput input[name="harga_jual_2"]').focus();
				}
			}
			else {
				$('#harga1').removeClass('has-error');
			}
		});
		$('#tabelBarang').on('keypress', '#barisInput input[name="harga_jual_2"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#harga2').addClass('has-error');
				}
				else {
					$('#barisInput input[name="harga_jual_3"]').focus();
				}
			}
			else {
				$('#harga2').removeClass('has-error');
			}
		});
		$('#tabelBarang').on('keypress', '#barisInput input[name="harga_jual_3"]', function(event) {
			if(event.keyCode === 13) {
				if( $(this).val() == '' ) {
					$('#harga3').addClass('has-error');
				}
				else {
					$('#barisInput input[name="harga_jual_4"]').focus();
				}
			}
			else {
				$('#harga3').removeClass('has-error');
			}
		});
		// Saat menekan tombol Enter di Harga Jual Level 4, ambil seluruh nilai data baru dan simpan ke database
		$('#tabelBarang').on('keypress', '#barisInput input[name="harga_jual_4"]', function(event) {
			if(event.keyCode === 13) {
				// Kumpulkan data
				var id_barang = $('#barisInput input[name="id_barang"]').val();
				var nama_barang = $('#barisInput input[name="nama_barang"]').val();
				var jumlah_dlm_koli = $('#barisInput input[name="jumlah_dlm_koli"]').val();
				var kemasan = $('#barisInput select[name="kemasan"]').val();
				var fungsi = $('#barisInput select[name="fungsi"]').val();
				var harga_jual_1 = $('#barisInput input[name="harga_jual_1"]').val();
				var harga_jual_2 = $('#barisInput input[name="harga_jual_2"]').val();
				var harga_jual_3 = $('#barisInput input[name="harga_jual_3"]').val();
				var harga_jual_4 = $('#barisInput input[name="harga_jual_4"]').val();

				if(id_barang == '' || nama_barang == '' || jumlah_dlm_koli == '' || harga_jual_1 == '' || harga_jual_2 == '' || harga_jual_3 == '' || harga_jual_4 == '') {
					if(id_barang == '') $('#id').addClass('has-error');
					if(nama_barang == '') $('#nama').addClass('has-error');
					if(jumlah_dlm_koli == '') $('#jmlKoli').addClass('has-error');
					if(harga_jual_1 == '') $('#harga1').addClass('has-error');
					if(harga_jual_2 == '') $('#harga2').addClass('has-error');
					if(harga_jual_3 == '') $('#harga3').addClass('has-error');
					if(harga_jual_4 == '') $('#harga4').addClass('has-error');
				}
				else if(id_barang != '' && nama_barang != '' && jumlah_dlm_koli != '' && harga_jual_1 != '' && harga_jual_2 != '' && harga_jual_3 != '' && harga_jual_4 != '') {
					// Tampilkan pesan loading
					pesanLoading();
					
					$.ajax({
						type	: 'post',
						url		: 'tambah-barang',
						dataType: 'json',
						data	: {
							id_barang		: id_barang,
							nama_barang		: nama_barang,
							jumlah_dlm_koli	: jumlah_dlm_koli,
							kemasan			: kemasan,
							fungsi			: fungsi,
							harga_jual_1 	: harga_jual_1,
							harga_jual_2 	: harga_jual_2,
							harga_jual_3 	: harga_jual_3,
							harga_jual_4 	: harga_jual_4
						},
						success : function(data) {
							if(data == 'success') {
								// Perbarui isi tabel
								refreshTabel();

								// Tambahkan pesan pemberitahuan bahwa data berhasil ditambahkan
								pesanPemberitahuan('info', 'Data berhasil ditambahkan.');
							}
							else if(data == 'ID used') {
								// Tambahkan pesan pemberitahuan bahwa data gagal ditambahkan karena ID telah digunakan sebelumnya
								pesanPemberitahuan('warning', 'ID barang telah digunakan sebelumnya. Silakan memasukkan kembali data yang sesuai.');
							}
						},
						error	: function() {
							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('warning', 'Gagal menambahkan data. Silakan mencoba kembali.');
						},
						complete: function() {
							// Hapus pesan loading
							$('div.overlay').remove();
						}
					});
				}
			} // End if tombol yang ditekan adalah Enter
		}); // End event input data baru
		
		// Fungsi untuk menampilkan pesan loading selama proses berlangsung
		function pesanLoading() {
			var loading = '<div class="overlay">';
			loading += '<i class="fa fa-refresh fa-spin"></i>';
			loading += '</div>';
			$('div[class="box"]').append(loading);
		} // End fungsi pesanLoading()

		// Fungsi untuk menambahkan pesan pemberitahuan di atas tabel
		// Variabel jenis menampung nilai yang berisi informasi jenis alert yang diinginkan
		// Variabel pesan menampung string yang berisi pesan yang ingin disampaikan
		function pesanPemberitahuan(jenis, pesan) {
			// Hapus terlebih dahulu jika sudah ada pesan pemberitahuan sebelumnya
			$('.alert').remove();

			var alert = '<div class="alert alert-'+jenis+' alert-dismissible" role="alert">';
			alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
			alert += pesan;
			alert += '</div>';
			$('#pesanPemberitahuan').append(alert);
		} // End fungsi pesanPemberitahuan

		// Fungsi untuk memuat ulang data tabel
		function refreshTabel() {
			$.ajax({
				type	: 'post',
				url		: 'lihat-barang',
				dataType: 'json',
				success : function(data) {
					// console.log(data);
					// Hapus isi data tabel
					$('#tabelBarang tbody').remove();
					
					// Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';
					// Untuk baris input data barang baru
					isi += '<tr id="barisInput">';
					isi += '<td><div class="form-group" id="id" style="width:185px"><input type="text" class="form-control" placeholder="ID barang" name="id_barang" autocomplete="off"></div></td>';
					isi += '<td><div class="form-group" id="nama" style="width:185px"><input type="text" class="form-control" placeholder="Nama barang" name="nama_barang" autocomplete="off"></div></td>';
					isi += '<td><div class="form-group" id="jmlKoli" style="width:185px"><input type="text" class="form-control" placeholder="Jumlah dalam Koli" name="jumlah_dlm_koli" autocomplete="off"></div></td>';
					// kemasan
					isi += '<td><div class="form-group" id="kemasan" style="width:185px">';
					isi += '<select name="kemasan" style="width:100%">';
					isi += '<option></option>';
					isi += '<option value="Dus">Dus</option>';
					isi += '<option value="Set">Set</option>';
					isi += '<option value="Ktg">Ktg</option>';
					isi += '<option value="Jala">Jala</option>';
					isi += '<option value="Mika">Mika</option>';
					isi += '</select>';
					isi += '</div></td>';
					// end kemasan
					// fungsi
					isi += '<td><div class="form-group" id="fungsi" style="width:185px">';
					isi += '<select name="fungsi" style="width:100%">';
					isi += '<option></option>';
					isi += '<option value="B/O">B/O</option>';
					isi += '<option value="R/C">R/C</option>';
					isi += '<option value="W/U">W/U</option>';
					isi += '<option value="P/B">P/B</option>';
					isi += '<option value="F/C">F/C</option>';
					isi += '<option value="NBO">NBO</option>';
					isi += '</select>';
					isi += '</div></td>';
					// end fungsi
					isi += '<td><div class="form-group" id="harga1" style="width:185px"><input type="text" class="form-control" placeholder="Harga Jual Level 1" name="harga_jual_1" autocomplete="off"></div></td>';
					isi += '<td><div class="form-group" id="harga2" style="width:185px"><input type="text" class="form-control" placeholder="Harga Jual Level 2" name="harga_jual_2" autocomplete="off"></div></td>';
					isi += '<td><div class="form-group" id="harga3" style="width:185px"><input type="text" class="form-control" placeholder="Harga Jual Level 3" name="harga_jual_3" autocomplete="off"></div></td>';
					isi += '<td><div class="form-group" id="harga4" style="width:185px"><input type="text" class="form-control" placeholder="Harga Jual Level 4" name="harga_jual_4" autocomplete="off"></div></td>';
					isi += '<td></td>';
					isi += '</tr>';
					// Untuk daftar barang
					// Tuliskan data dalam <p hidden></p> agar fungsi search DataTable dapat digunakan
					if(data != 'no data') {
						for(var i=0; i<data.length; i++) {
							isi += '<tr>';
							isi += '<td><p hidden>'+data[i].id_barang+'</p><div class="form-group"><input type="text" class="form-control" name="id_barang" value="'+data[i].id_barang+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><p hidden>'+data[i].nama_barang+'</p><div class="form-group"><input type="text" class="form-control" name="nama_barang" value="'+data[i].nama_barang+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><p hidden>'+data[i].jumlah_dlm_koli+'</p><div class="form-group"><input type="text" class="form-control" name="jumlah_dlm_koli" value="'+data[i].jumlah_dlm_koli+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							// kemasan
							isi += '<td><div class="form-group" id="kemasan" style="width:100%">';
							isi += '<select name="kemasan" style="width:100%">';
							isi += '<option></option>';
							if(data[i].kemasan == 'Dus') isi += '<option selected value="Dus">Dus</option>'; else isi += '<option value="Dus">Dus</option>'
							if(data[i].kemasan == 'Set') isi += '<option selected value="Set">Set</option>'; else isi += '<option value="Set">Set</option>';
							if(data[i].kemasan == 'Ktg') isi += '<option selected value="Ktg">Ktg</option>'; else isi += '<option value="Ktg">Ktg</option>';
							if(data[i].kemasan == 'Jala') isi += '<option selected value="Jala">Jala</option>'; else isi += '<option value="Jala">Jala</option>';
							if(data[i].kemasan == 'Mika') isi += '<option selected value="Mika">Mika</option>'; else isi += '<option value="Mika">Mika</option>';
							isi += '</select>';
							isi += '</div></td>';
							// end kemasan
							// fungsi
							isi += '<td><div class="form-group" id="fungsi" style="width:100%">';
							isi += '<select name="fungsi" style="width:100%">';
							isi += '<option></option>';
							if(data[i].fungsi == 'B/O') isi += '<option selected value="B/O">B/O</option>'; else isi += '<option value="B/O">B/O</option>'
							if(data[i].fungsi == 'R/C') isi += '<option selected value="R/C">R/C</option>'; else isi += '<option value="R/C">R/C</option>';
							if(data[i].fungsi == 'W/U') isi += '<option selected value="W/U">W/U</option>'; else isi += '<option value="W/U">W/U</option>';
							if(data[i].fungsi == 'P/B') isi += '<option selected value="P/B">P/B</option>'; else isi += '<option value="P/B">P/B</option>';
							if(data[i].fungsi == 'F/C') isi += '<option selected value="F/C">F/C</option>'; else isi += '<option value="F/C">F/C</option>';
							if(data[i].fungsi == 'NBO') isi += '<option selected value="NBO">NBO</option>'; else isi += '<option value="NBO">NBO</option>';
							isi += '</select>';
							isi += '</div></td>';
							// end fungsi
							isi += '<td><p hidden>'+data[i].harga_jual_1+'</p><div class="form-group"><input type="text" class="form-control" name="harga_jual_1" value="'+data[i].harga_jual_1+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><p hidden>'+data[i].harga_jual_2+'</p><div class="form-group"><input type="text" class="form-control" name="harga_jual_2" value="'+data[i].harga_jual_2+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><p hidden>'+data[i].harga_jual_3+'</p><div class="form-group"><input type="text" class="form-control" name="harga_jual_3" value="'+data[i].harga_jual_3+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><p hidden>'+data[i].harga_jual_4+'</p><div class="form-group"><input type="text" class="form-control" name="harga_jual_4" value="'+data[i].harga_jual_4+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div></td>';
							isi += '<td><button id="btnHapus" class="btn btn-xs btn-danger" data-id="'+data[i].id_barang+'"><i class="fa fa-times"></i></button></td>';
							isi += '</tr>';
						}
					}
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelBarang').append(isi);

					// Reinitialize DataTable
					tabel.clear().destroy();
					tabel = $('#tabelBarang').DataTable({
						'scrollX'		: true,
						'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
						'columnDefs'	: [
							{ 'orderable' : false, 'targets' : 9 }
						],
						'stateSave'		: true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
					});

					// Initialize kemasan dan fungsi
					$('select[name="kemasan"]').select2({ 
						minimumResultsForSearch	: -1,
						placeholder				: 'Pilih kemasan'
					});
					$('select[name="fungsi"]').select2({ 
						minimumResultsForSearch	: -1,
						placeholder				: 'Pilih fungsi'
					});

					// Fokuskan pada sel ID Barang pada baris input data barang baru
					$('#barisInput input[name="id_barang"]').focus();
				}, // End success
				error	: function() {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				} // End error
			}); // End ajax		
		} // End fungsi refreshTabel()

		// Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		$('#tabelBarang').on('click', '#btnHapus', function() {
			// Ambil ID Barang dari baris data yang akan dihapus
			var id_barang = $(this).data('id');

			var konfirmasi = confirm('Apakah Anda yakin untuk menghapus data dengan ID : ' + id_barang + ' ?');
			if(konfirmasi == true) {
				// Tampilkan pesan loading
				pesanLoading();

				$.ajax({
					type	: 'post',
					url		: 'hapus-barang',
					data	: { id_barang : id_barang },
					success	: function() {
						// Perbarui isi tabel
						refreshTabel();

						// Tambahkan pesan pemberitahuan bahwa data telah dihapus
						pesanPemberitahuan('danger', 'Data berhasil dihapus.');
					},
					error	: function(response) {
						// Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Gagal menghapus data. Silakan mencoba kembali.');
					},
					complete: function() {
						// Hapus pesan loading
						$('div.overlay').remove();
					}
				}); // End ajax
			} // End konfirmasi akan hapus data
		}); // End event tombol Hapus

		// Event handler untuk edit data barang
		$('#tabelBarang').on('keypress', 'td', function (event) {
			// Cek apakah tombol yg ditekan adalah tombol Enter
			if(event.keyCode === 13) {
				// Cek apakah tombol ditekan pada barisan input data baru
				if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {

					var dataBaris = tabel.row($(this).parents('tr')).data();
					var dataSel = nilaiBaru; // nilaiBaru dari fungsi ambilNilaiBaru di atas
					var kolom = tabel.cell(this).index().column; // Dapatkan posisi kolom

					// Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
					var id_barang = dataBaris[0];
					id_barang = id_barang.split('value="').pop();
					id_barang = id_barang.replace('" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></div>', '');
					
					// Dapatkan nama kolom (field yang ingin diubah nilainya) dari variabel kolom
					var namaKolom;
					switch(kolom) {
						case 0 : namaKolom = 'id_barang'; break;
						case 1 : namaKolom = 'nama_barang'; break;
						case 2 : namaKolom = 'jumlah_dlm_koli'; break;
						case 3 : namaKolom = 'kemasan'; break;
						case 4 : namaKolom = 'fungsi' ; break;
						case 5 : namaKolom = 'harga_jual_1'; break;
						case 6 : namaKolom = 'harga_jual_2'; break;
						case 7 : namaKolom = 'harga_jual_3'; break;
						case 8 : namaKolom = 'harga_jual_4'; break;
					}

					// Status untuk mengecek apakah data yang diinputkan kosong
					var status = 1;

					// Cek apakah id / nama / jumlah dlm koli / harga kosong
					if(namaKolom == 'id_barang' || namaKolom == 'nama_barang' || namaKolom == 'jumlah_dlm_koli' || namaKolom == 'harga_jual_1' || namaKolom == 'harga_jual_2' || namaKolom == 'harga_jual_3' || namaKolom == 'harga_jual_4') {
						if(namaKolom == 'id_barang' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'nama_barang' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'jumlah_dlm_koli' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'harga_jual_1' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'harga_jual_2' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'harga_jual_3' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
						if(namaKolom == 'harga_jual_4' && $(this).find('input').val() == '') {
							$(this).find('div.form-group').addClass('has-error');
							status = 0;
						}
					}
					
					if(status != 0) {
						// Tampilkan pesan loading
						pesanLoading();

						$.ajax({
							type	: 'post',
							url		: 'edit-barang',
							dataType: 'json',
							data	: {
								id_barang : id_barang,
								nama_kolom: namaKolom,
								nilai_baru: dataSel
							},
							success : function(data) {
								if(data == 'success') {
									// Perbarui isi tabel
									refreshTabel();

									// Tampilkan pesan pemberitahuan
									pesanPemberitahuan('success', 'Data berhasil diperbarui');
								}
								else if(data == 'ID used') {
									// Tambahkan pesan pemberitahuan bahwa data gagal diedit karena ID telah digunakan sebelumnya
									pesanPemberitahuan('warning', 'ID barang telah digunakan sebelumnya. Silakan memasukkan kembali data yang sesuai.');
								}								
							},
							error	: function() {
								// Tampilkan pesan pemberitahuan
								pesanPemberitahuan('warning', 'Gagal mengedit data. Silakan mencoba kembali.');
							},
							complete: function() {
								// Hapus pesan loading
								$('div.overlay').remove();
							}
						}); // End ajax
					} // End status != 0
					
				} // End if pengecekan baris input
			} // End if pengecekan tombol Enter
			else {
				$(this).find('div.form-group').removeClass('has-error');
			}
		}); // End event handler untuk edit barang

		// Fungsi yang dijalankan setelah selesai memilih gambar
		$('#inputGambar').change(function() {
			pesanLoading();

			// Ambil data file gambar yang dipilih
			var inputGambar = $('#inputGambar')[0];
			var fileGambar = new FormData();
			$.each(inputGambar.files, function(k, file) {
				fileGambar.append('fileGambar[]', file);
			});
			
			$.ajax({
				type	: 'post',
				url		: 'upload-gambar-barang',
				data	: fileGambar,
				dataType: 'json',
				contentType	: false,
				processData	: false,
				success		: function(response) {
					// Tampilkan pesan error jika ada kesalahan dalam mengupload gambar
					pesanErrorGambar(response);

					// Hapus pesan loading
					$('div.overlay').remove();
				},
				error		: function(response) {
					console.log(response.responseText);
				}
			}) // End ajax
		}); // End fungsi upload gambar

		// Fungsi yang digunakan untuk menampilkan pesan error saat upload gambar
		function pesanErrorGambar(response) {
			if(response != '') {
				// Hapus terlebih dahulu jika sudah ada pesan pemberitahuan sebelumnya
				$('.alert').remove();

				var alert =  '<div class="alert alert-warning alert-dismissible" role="alert">';
				alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
				alert += '<h4><i class="icon fa fa-ban"></i> Error!</h4>';
				for(i=0; i<response.length; i++) {
					alert += '<p>' + response[i] + '</p>';
				}
				alert += '</div>';
				$('#pesanPemberitahuan').append(alert);
			}
		} // End fungsi pesanErrorGambar

		// Fungsi untuk edit kemasan
		$('#tabelBarang').on('change', 'select[name="kemasan"]', function() {
			// Cek apakah dalam baris input
			if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
				pesanLoading();

				var id_barang = $(this).closest('tr').find('input[name="id_barang"]').val();
				var kemasan_baru = $(this).val();

				// Gunakan ajax yang sama dengan edit data barang
				$.ajax({
					type	: 'post',
					url		: 'edit-barang',
					dataType: 'json',
					data	: {
						id_barang : id_barang,
						nama_kolom: 'kemasan',
						nilai_baru: kemasan_baru,
					},
					success : function(data) {
						if(data == 'success') {
							// Perbarui isi tabel
							refreshTabel();

							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('success', 'Data berhasil diperbarui');
						}
						else if(data == 'ID used') {
							// Tambahkan pesan pemberitahuan bahwa data gagal diedit karena ID telah digunakan sebelumnya
							pesanPemberitahuan('warning', 'ID barang telah digunakan sebelumnya. Silakan memasukkan kembali data yang sesuai.');
						}								
					},
					error	: function() {
						// Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Gagal mengedit data. Silakan mencoba kembali.');
					},
					complete: function() {
						// Hapus pesan loading
						$('div.overlay').remove();
					}
				}); // End ajax
			}
		}); // End fungsi untuk edit kemasan

		// Fungsi untuk edit fungsi
		$('#tabelBarang').on('change', 'select[name="fungsi"]', function() {
			// Cek apakah dalam baris input
			if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
				pesanLoading();

				var id_barang = $(this).closest('tr').find('input[name="id_barang"]').val();
				var fungsi_baru = $(this).val();

				// Gunakan ajax yang sama dengan edit data barang
				$.ajax({
					type	: 'post',
					url		: 'edit-barang',
					dataType: 'json',
					data	: {
						id_barang : id_barang,
						nama_kolom: 'fungsi',
						nilai_baru: fungsi_baru,
					},
					success : function(data) {
						if(data == 'success') {
							// Perbarui isi tabel
							refreshTabel();

							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('success', 'Data berhasil diperbarui');
						}
						else if(data == 'ID used') {
							// Tambahkan pesan pemberitahuan bahwa data gagal diedit karena ID telah digunakan sebelumnya
							pesanPemberitahuan('warning', 'ID barang telah digunakan sebelumnya. Silakan memasukkan kembali data yang sesuai.');
						}								
					},
					error	: function() {
						// Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Gagal mengedit data. Silakan mencoba kembali.');
					},
					complete: function() {
						// Hapus pesan loading
						$('div.overlay').remove();
					}
				}); // End ajax
			}
		}); // End fungsi untuk edit fungsi
		
	});
		
	</script>
</body>
</html>
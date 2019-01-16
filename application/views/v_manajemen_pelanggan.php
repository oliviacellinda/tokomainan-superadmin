<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen Pelanggan</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/css/select2.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.min.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
		.table > tbody > tr > td {
			vertical-align: middle;
		}
	</style>
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
				<h1>Manajemen Pelanggan</h1>
            </section>
            
            <!-- Konten Utama -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">

                        <!-- Lokasi pesan pemberitahuan akan ditampilkan -->
                        <div id="pesanPemberitahuan"></div>

                        <!-- Kotak berisi tabel data -->
                        <div class="box">
                            <!-- Tabel -->
                            <div class="box-body">
                                <table id="tabelPelanggan" class="table table-bordered table-striped">

                                    <!-- Header Tabel -->
                                    <thead>
                                    <tr>
                                        <th width="162.6px">ID Pelanggan</th>
                                        <th width="162.6px">Nama</th>
                                        <th width="162.6px">Alamat</th>
                                        <th width="162.6px">Ekspedisi</th>
                                        <th width="162.6px">Telepon</th>
                                        <th width="162.6px">Maksimal Utang</th>
                                        <th width="162.6px">Level</th>
                                        <th>Menu</th>
                                    </tr>
                                    </thead>

                                    <!-- Isi tabel -->
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
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>
    
    <script>
    var nilaiBaru = 0; 
	// Ambil nilai baru dari input
	function ambilNilaiBaru(input) {
		nilaiBaru = input.value;
	}

    $(document).ready(function() {
        // Tandai menu Manajemen Pelanggan sebagai menu aktif pada sidebar
		$('#manajemenPelanggan').addClass('active');

        // Gunakan DataTable
        var tabel = $('#tabelPelanggan').DataTable({
			'scrollX'		: true,
			'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
			'columnDefs'	: [
				{ 'orderable' : false, 'targets' : 6 } // Pilih kolom yg tdk memiliki fitur pengurutan, dimulai dari indeks 0
            ],
            'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
		});

        // Isi tabel
        refreshTabel();

        // Fungsi untuk memuat ulang data tabel
		function refreshTabel() {
			$.ajax({
				type	: 'post',
				url		: 'lihat-pelanggan',
				dataType: 'json',
				success : function(data) {
					// Hapus isi data tabel
					$('#tabelPelanggan tbody').remove();
					
					// Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';

					// Untuk baris input data pelanggan baru
					isi += '<tr id="barisInput">';
					isi += '<td></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Nama" name="nama_pelanggan" autocomplete="off"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Alamat" name="alamat_pelanggan" autocomplete="off"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Ekspedisi" name="ekspedisi" autocomplete="off"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Telepon" name="telepon_pelanggan" autocomplete="off"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Maksimal Utang" name="maks_utang" autocomplete="off"></td>';
					// Dropdown level
					isi += '<td>';
					isi += '<div class="form-group">';
					isi += '<select class="form-control select2" style="width:184.4px" name="level">';
					isi += '<option></option>';
					isi += '<option>1</option>';
					isi += '<option>2</option>';
					isi += '<option>3</option>';
					isi += '<option>4</option>';
					isi += '</select>';
					isi += '</div>';
					isi += '</td>';
					// End dropdown level
					isi += '<td></td>';
					isi += '</tr>';

					// Untuk daftar pelanggan
					// Tuliskan data dalam <p hidden></p> agar fungsi search DataTable dapat digunakan
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            isi += '<tr>';
                            isi += '<td>'+data[i].id_pelanggan+'</td>';
                            isi += '<td><p hidden>'+data[i].nama_pelanggan+'</p><input type="text" class="form-control" name="nama_pelanggan" value="'+data[i].nama_pelanggan+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
                            isi += '<td><p hidden>'+data[i].alamat_pelanggan+'</p><input type="text" class="form-control" name="alamat_pelanggan" value="'+data[i].alamat_pelanggan+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
                            isi += '<td><p hidden>'+data[i].ekspedisi+'</p><input type="text" class="form-control" name="ekspedisi" value="'+data[i].ekspedisi+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
                            isi += '<td><p hidden>'+data[i].telepon_pelanggan+'</p><input type="text" class="form-control" name="telepon_pelanggan" value="'+data[i].telepon_pelanggan+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
                            isi += '<td><p hidden>'+data[i].maks_utang+'</p><input type="text" class="form-control" name="maks_utang" value="'+data[i].maks_utang+'" onkeypress="ambilNilaiBaru(this)" autocomplete="off"></td>';
                            // Dropdown level
							isi += '<td>';
							isi += '<div class="form-group">';
							isi += '<select class="form-control select2" style="width:184.4px" name="level">';
							isi += '<option></option>';
							isi += (data[i].level == '1') ? '<option selected value="1">1</option>' : '<option value="1">1</option>';
							isi += (data[i].level == '2') ? '<option selected value="2">2</option>' : '<option value="2">2</option>';
							isi += (data[i].level == '3') ? '<option selected value="3">3</option>' : '<option value="3">3</option>';
							isi += (data[i].level == '4') ? '<option selected value="4">4</option>' : '<option value="4">4</option>';
							isi += '</select>';
							isi += '</div>';
							isi += '</td>';
							// End dropdown level
							isi += '<td><button id="btnHapus" class="btn btn-xs btn-danger" data-id="'+data[i].id_pelanggan+'"><i class="fa fa-times"></i></button></td>';
                            isi += '</tr>';
                        }
                    }
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelPelanggan').append(isi);

					// Reinitialize DataTable
					tabel.clear().destroy();
					tabel = $('#tabelPelanggan').DataTable({
						'scrollX'		: true,
						'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
						'columnDefs'	: [
							{ 'orderable' : false, 'targets' : 6 }
                        ],
                        'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
					});

					$('select').select2({
						placeholder 			: 'Pilih level pelanggan',
						minimumResultsForSearch : Infinity
					});

					// Fokuskan pada sel ID Pelanggan pada baris input data pelanggan baru
					$('#barisInput input[name="nama_pelanggan"]').focus();
				}, // End success
				error	: function() {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				} // End error
			}); // End ajax		
        } // End fungsi refreshTabel
        
        // Kumpulan event handler untuk baris input
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="nama_pelanggan"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="alamat_pelanggan"]').focus();
        });
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="alamat_pelanggan"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="ekspedisi"]').focus();
        });
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="ekspedisi"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="telepon_pelanggan"]').focus();
        });
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="telepon_pelanggan"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="maks_utang"]').focus();
        });
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="maks_utang"]', function(event) {
            if(event.keyCode === 13) $('#barisInput select').focus();
        });
        $('#tabelPelanggan').on('change', '#barisInput select', function() {
			// Tampilkan pesan loading
			pesanLoading();

			// Kumpulkan data
			var nama_pelanggan = $('#barisInput input[name="nama_pelanggan"]').val();
			var alamat_pelanggan = $('#barisInput input[name="alamat_pelanggan"]').val();
			var ekspedisi = $('#barisInput input[name="ekspedisi"]').val();
			var telepon_pelanggan = $('#barisInput input[name="telepon_pelanggan"]').val();
			var maks_utang = $('#barisInput input[name="maks_utang"]').val();
			var level = $('#barisInput select[name="level"]').val();

			$.ajax({
				type    : 'post',
				url     : 'tambah-pelanggan',
				data    : {
					nama_pelanggan      : nama_pelanggan,
					alamat_pelanggan    : alamat_pelanggan,
					ekspedisi			: ekspedisi,
					telepon_pelanggan   : telepon_pelanggan,
					maks_utang          : maks_utang,
					level               : level
				},
				success : function() {
					// Perbarui isi tabel
					refreshTabel();

					// Tambahkan pesan pemberitahuan bahwa data berhasil ditambahkan
					pesanPemberitahuan('info', 'Data berhasil ditambahkan.');
				},
				error   : function(response) {
					// console.log(response.responseText);
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Gagal menambahkan data. Silakan mencoba kembali.');
				},
				complete: function() {
					// Hapus pesan loading
					$('div.overlay').remove();
				}
			});
        }); // End event input data baru

        // Fungsi untuk menampilkan pesan loading selama proses berlangsung
		function pesanLoading() {
			var loading = '<div class="overlay">';
			loading += '<i class="fa fa-refresh fa-spin"></i>';
			loading += '</div>';
			$('div[class="box"]').append(loading);
		} // End fungsi pesanLoading

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

        // Event handler untuk edit pelanggan
        $('#tabelPelanggan').on('keypress', 'td', function(event) {
            // Cek apakah tombol yg ditekan adalah tombol Enter
			if(event.keyCode === 13) {
				// Cek apakah tombol ditekan pada barisan input data baru
				if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
					// Tampilkan pesan loading
					pesanLoading();

					var dataBaris = tabel.row($(this).parents('tr')).data();
					var dataSel = nilaiBaru; // nilaiBaru dari fungsi ambilNilaiBaru di atas
					var kolom = tabel.cell(this).index().column; // Dapatkan posisi kolom
					var id_pelanggan = dataBaris[0];
					
					// Dapatkan nama kolom (field yang ingin diubah nilainya) dari variabel kolom
					var namaKolom;
					switch(kolom) {
						case 1 : namaKolom = 'nama_pelanggan'; break;
						case 2 : namaKolom = 'alamat_pelanggan'; break;
						case 3 : namaKolom = 'ekspedisi'; break;
						case 4 : namaKolom = 'telepon_pelanggan'; break;
						case 5 : namaKolom = 'maks_utang' ; break;
					}
					
					$.ajax({
						type	: 'post',
						url		: 'edit-pelanggan',
						data	: {
							id_pelanggan : id_pelanggan,
							nama_kolom	 : namaKolom,
							nilai_baru   : dataSel
						},
						success : function() {
							// Perbarui isi tabel
							refreshTabel();

							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('success', 'Data berhasil diperbarui');
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
				} // End if pengecekan baris input
			} // End if pengecekan tombol Enter
        }); // End event handler untuk edit pelanggan

		// Event handler untuk dropdown level
		$('#tabelPelanggan').on('change', 'select', function() {
			// Cek apakah select yang digunakan adalah select pada baris input data baru
			if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
				// Tampilkan pesan loading
				pesanLoading();

				var level = $(this).val();
				var id_pelanggan = $(this).closest('tr').find('td:first').text();
				// Cari terlebih dahulu parent tr terdekat, dari tr cari td pertama yg berisi ID Pelanggan, ambil nilainya

				$.ajax({
					type	: 'post',
					url		: 'edit-pelanggan',
					data	: {
						id_pelanggan : id_pelanggan,
						nama_kolom	 : 'level',
						nilai_baru	 : level
					},
					success : function() {
						// Perbarui isi tabel
						refreshTabel();

						// Tampilkan pesan pemberitahuan
						pesanPemberitahuan('success', 'Data berhasil diperbarui');
					},
					error	: function() {
						// Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Gagal mengedit data. Silakan mencoba kembali.');
					},
					complete: function() {
						// Hapus pesan loading
						$('div.overlay').remove();
					}
				});
			} // End if pengecekan baris input
		}); // End event handler untuk dropdown level

        // Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		$('#tabelPelanggan').on('click', '#btnHapus', function() {
			// Ambil ID Pelanggan dari baris data yang akan dihapus
			var id_pelanggan = $(this).data('id');

			var konfirmasi = confirm('Apakah Anda yakin akan menghapus data dengan ID : ' + id_pelanggan + ' ?');
			if(konfirmasi == true) {
				// Tampilkan pesan loading
				pesanLoading();

				$.ajax({
					type	: 'post',
					url		: 'hapus-pelanggan',
					data	: { id_pelanggan : id_pelanggan },
					success	: function() {
						// Perbarui isi tabel
						refreshTabel();

						// Tambahkan pesan pemberitahuan bahwa data telah dihapus
						pesanPemberitahuan('danger', 'Data berhasil dihapus.');
					},
					error	: function(response) {
						// console.log(response.responseText);
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
    });
    </script>
</body>
</html>
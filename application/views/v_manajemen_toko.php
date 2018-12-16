<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen Toko</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
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
				<h1>Manajemen Toko</h1>
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
                                <table id="tabelToko" class="table table-bordered table-striped">

                                    <!-- Header Tabel -->
                                    <thead>
                                    <tr>
                                        <th width="162.6px">ID Toko</th>
										<th width="162.6px">Password</th>
                                        <th width="162.6px">Nama</th>
                                        <th width="162.6px">Alamat</th>
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
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>
    
    <script>
    var nilaiBaru = 0; 
	// Ambil nilai baru dari input
	function ambilNilaiBaru(input) {
		nilaiBaru = input.value;
	}

    $(document).ready(function() {
        // Tandai menu Manajemen Toko sebagai menu aktif pada sidebar
		$('#manajemenToko').addClass('active');

        // Gunakan DataTable
        var tabel = $('#tabelToko').DataTable({
            'scrollX'       : true,
            'bInfo'         : false, // Untuk menghilangkan tulisan keterangan di bawah tabel
            'columnDefs'    : [
                { 'orderable' : false, 'targets' : 3 } // Pilih kolom yg tdk memiliki fitur pengurutan, dimulai dari indeks 0
            ],
            'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
        });

        // Isi tabel
        refreshTabel();

        // Fungsi untuk memuat ulang data tabel
		function refreshTabel() {
			$.ajax({
				type	: 'post',
				url		: 'lihat-toko',
				dataType: 'json',
				success : function(data) {
					// Hapus isi data tabel
					$('#tabelToko tbody').remove();
					
					// Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';
					// Untuk baris input data toko baru
					isi += '<tr id="barisInput">';
					isi += '<td><input type="text" class="form-control" placeholder="ID Toko" name="id_toko"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Password" name="password_toko"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Nama" name="nama_toko"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Alamat" name="alamat_toko"></td>';
					isi += '<td></td>';
					isi += '</tr>';
					// Untuk daftar toko
					// Tuliskan data dalam <p hidden></p> agar fungsi search DataTable dapat digunakan
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            isi += '<tr>';
                            isi += '<td><p hidden>'+data[i].id_toko+'</p><input type="text" class="form-control" name="id_toko" value="'+data[i].id_toko+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            isi += '<td><p hidden>'+data[i].password_toko+'</p><input type="text" class="form-control" name="password_toko" value="'+data[i].password_toko+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            isi += '<td><p hidden>'+data[i].nama_toko+'</p><input type="text" class="form-control" name="nama_toko" value="'+data[i].nama_toko+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            isi += '<td><p hidden>'+data[i].alamat_toko+'</p><input type="text" class="form-control" name="alamat_toko" value="'+data[i].alamat_toko+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            isi += '<td><button id="btnHapus" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>';
                            isi += '</tr>';
                        }
                    }
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelToko').append(isi);

					// Reinitialize DataTable
					tabel.clear().destroy();
					tabel = $('#tabelToko').DataTable({
						'scrollX'		: true,
						'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
						'columnDefs'	: [
							{ 'orderable' : false, 'targets' : 4 }
                        ],
                        'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
					});

					// Fokuskan pada sel ID Toko pada baris input data toko baru
					$('#barisInput input[name="id_toko"]').focus();
				}, // End success
				error	: function() {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				} // End error
			}); // End ajax		
        } // End fungsi refreshTabel()

        // Kumpulan event handler untuk baris input
        $('#tabelToko').on('keypress', '#barisInput input[name="id_toko"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="password_toko"]').focus();
        });
        $('#tabelToko').on('keypress', '#barisInput input[name="password_toko"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="nama_toko"]').focus();
        });
        $('#tabelToko').on('keypress', '#barisInput input[name="nama_toko"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="alamat_toko"]').focus();
        });
        // Saat menekan tombol Enter di Level, ambil seluruh nilai data baru dan simpan ke dalam database
        $('#tabelToko').on('keypress', '#barisInput input[name="alamat_toko"]', function(event) {
            if(event.keyCode === 13) {
                // Tampilkan pesan loading
                pesanLoading();

                // Kumpulkan data
                var id_toko = $('#barisInput input[name="id_toko"]').val();
                var password_toko = $('#barisInput input[name="password_toko"]').val();
                var nama_toko = $('#barisInput input[name="nama_toko"]').val();
                var alamat_toko = $('#barisInput input[name="alamat_toko"]').val();

                $.ajax({
                    type    : 'post',
                    url     : 'tambah-toko',
                    data    : {
                        id_toko       : id_toko,
						password_toko : password_toko,
                        nama_toko     : nama_toko,
                        alamat_toko   : alamat_toko
                    },
                    success : function() {
                        // Perbarui isi tabel
                        refreshTabel();

                        // Tambahkan pesan pemberitahuan bahwa data berhasil ditambahkan
                        pesanPemberitahuan('info', 'Data berhasil ditambahkan.');

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    },
                    error   : function(response) {
                        // Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
                    }
                });
            }
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

        // Event handler untuk edit toko
        $('#tabelToko').on('keypress', 'td', function(event) {
            // Cek apakah tombol yg ditekan adalah tombol Enter
			if(event.keyCode === 13) {
				// Cek apakah tombol ditekan pada barisan input data baru
				if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
					// Tampilkan pesan loading
					pesanLoading();

					var dataBaris = tabel.row($(this).parents('tr')).data();
					var dataSel = nilaiBaru; // nilaiBaru dari fungsi ambilNilaiBaru di atas
					var kolom = tabel.cell(this).index().column; // Dapatkan posisi kolom

					// Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
					var id_toko = dataBaris[0];
					id_toko = id_toko.split('value="').pop();
					id_toko = id_toko.replace('" onkeypress="ambilNilaiBaru(this)">', '');
					
					// Dapatkan nama kolom (field yang ingin diubah nilainya) dari variabel kolom
					var namaKolom;
					switch(kolom) {
						case 0 : namaKolom = 'id_toko'; break;
						case 1 : namaKolom = 'password_toko'; break;
						case 2 : namaKolom = 'nama_toko'; break;
						case 3 : namaKolom = 'alamat_toko'; break;
					}
					
					$.ajax({
						type	: 'post',
						url		: 'edit-toko',
						data	: {
							id_toko : id_toko,
							nama_kolom: namaKolom,
							nilai_baru: dataSel
						},
						success : function() {
							// Perbarui isi tabel
							refreshTabel();

							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('success', 'Data berhasil diperbarui');

							// Hapus pesan loading
							$('div.overlay').remove();
						},
						error	: function() {
							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
						}
					}); // End ajax
				} // End if pengecekan baris input
			} // End if pengecekan tombol Enter
        }); // End event handler untuk edit toko

        // Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		$('#tabelToko').on('click', '#btnHapus', function() {
			// Tampilkan pesan loading
			pesanLoading();

			// Ambil seluruh data pada baris di mana tombol Hapus diklik
			var data = tabel.row($(this).parents('td')).data();

			// Ambil data id_toko dari data yang diambil sebelumnya
			var id_toko = data[0];
			// Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
			id_toko = id_toko.split('value="').pop();
			id_toko = id_toko.replace('" onkeypress="ambilNilaiBaru(this)">', '');

			$.ajax({
				type	: 'post',
				url		: 'hapus-toko',
				data	: { id_toko : id_toko },
				success	: function() {
					// Perbarui isi tabel
					refreshTabel();

					// Tambahkan pesan pemberitahuan bahwa data telah dihapus
					pesanPemberitahuan('danger', 'Data berhasil dihapus.');

					// Hapus pesan loading
					$('div.overlay').remove();
				},
				error	: function() {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				}
			}); // End ajax
		}); // End event tombol Hapus
    });
    </script>
</body>
</html>
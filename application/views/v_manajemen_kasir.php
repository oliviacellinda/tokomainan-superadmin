<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen POS</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/css/select2.min.css');?>">
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
				<h1>Manajemen POS</h1>
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
                                <table id="tabelKasir" class="table table-bordered table-striped">

                                    <!-- Header Tabel -->
                                    <thead>
                                    <tr>
                                        <th width="162.6px">ID Kasir</th>
                                        <th width="162.6px">Password Kasir</th>
                                        <th width="162.6px">Nama Toko</th>
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
        // Tandai menu Manajemen Kasir sebagai menu aktif pada sidebar
		$('#manajemenKasir').addClass('active');

        // Gunakan DataTable
        var tabel = $('#tabelKasir').DataTable({
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
				url		: 'lihat-kasir',
				dataType: 'json',
				success : function(data) {
					// Hapus isi data tabel
					$('#tabelKasir tbody').remove();
					
					// Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';
					// Untuk baris input data kasir baru
					isi += '<tr id="barisInput">';
					isi += '<td><input type="text" class="form-control" placeholder="ID Kasir" name="id_kasir"></td>';
					isi += '<td><input type="text" class="form-control" placeholder="Password" name="password_kasir"></td>';
					// Untuk dropdown toko
                    isi += '<td>';
                    isi += '<div class="form-group">';
                    isi += '<select class="form-control select2" name="id_toko">';
                    isi += '<option></option>';
                    if(data.toko != 'no data') {
                        for(var i=0; i<data.toko.length; i++) {
                            isi += '<option value="'+data.toko[i].id_toko+'">'+data.toko[i].nama_toko+'</option>';
                        }
                    }
                    isi += '</select>';
                    isi += '</div>';
                    isi += '</td>';
                    // End dropdown toko
					isi += '<td></td>';
					isi += '</tr>';
					// Untuk daftar kasir
					// Tuliskan data dalam <p hidden></p> agar fungsi search DataTable dapat digunakan
                    if(data.kasir != 'no data') {
                        for(var i=0; i<data.kasir.length; i++) {
                            isi += '<tr>';
                            isi += '<td><p hidden>'+data.kasir[i].id_kasir+'</p><input type="text" class="form-control" name="id_kasir" value="'+data.kasir[i].id_kasir+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            isi += '<td><p hidden>'+data.kasir[i].password_kasir+'</p><input type="text" class="form-control" name="password_kasir" value="'+data.kasir[i].password_kasir+'" onkeypress="ambilNilaiBaru(this)"></td>';
                            // Untuk dropdown toko
                            isi += '<td>';
                            isi += '<div class="form-group">';
                            isi += '<select class="form-control select2" name="id_toko">';
                            isi += '<option></option>';
                            if(data.toko != 'no data') {
                                for(var j=0; j<data.toko.length; j++) {
                                    // Cek apakah id_toko dari data kasir sama dengan id_toko dari daftar toko
                                    if(data.kasir[i].id_toko == data.toko[j].id_toko)
                                        isi += '<option selected value="'+data.toko[j].id_toko+'">'+data.toko[j].nama_toko+'</option>';
                                    else
                                        isi += '<option value="'+data.toko[j].id_toko+'">'+data.toko[j].nama_toko+'</option>';
                                }
                            }
                            isi += '</select>';
                            isi += '</div>';
                            isi += '</td>';
                            // End dropdown toko
                            isi += '<td><p hidden>'+data.kasir[i].nama_toko+'</p><button id="btnHapus" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button></td>';
                            isi += '</tr>';
                        }
                    }
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelKasir').append(isi);

					// Reinitialize DataTable
					tabel.clear().destroy();
					tabel = $('#tabelKasir').DataTable({
						'scrollX'		: true,
						'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
						'columnDefs'	: [
							{ 'orderable'  : false, 'targets' : 3 },
                            { 'searchable' : false, 'targets' : 2 }
                        ],
                        'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
					});

                    $('select').select2({placeholder : 'Pilih nama toko'});

					// Fokuskan pada sel ID Kasir pada baris input data kasir baru
					$('#barisInput input[name="id_kasir"]').focus();
				}, // End success
				error	: function(response) {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				} // End error
			}); // End ajax		
        } // End fungsi refreshTabel()

        $('#tabelKasir').on('keypress', '#barisInput input[name="id_kasir"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="password_kasir"]').focus();
        });
        $('#tabelKasir').on('keypress', '#barisInput input[name="password_kasir"]', function(event) {
            if(event.keyCode === 13) $('#barisInput select[name="id_toko"]').focus();
        });
        $('#tabelKasir').on('change', '#barisInput select[name="id_toko"]', function() {
            // Tampilkan pesan loading
            pesanLoading();

            // Kumpulkan data
            var id_kasir = $('#barisInput input[name="id_kasir"]').val();
            var password_kasir = $('#barisInput input[name="password_kasir"]').val();
            var id_toko = $('#barisInput select[name="id_toko"]').val();

            $.ajax({
                type    : 'post',
                url     : 'tambah-kasir',
                data    : {
                    id_kasir        : id_kasir,
                    password_kasir  : password_kasir,
                    id_toko         : id_toko
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
                    // console.log(response.responseText);
                    // Tampilkan pesan pemberitahuan
                    pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
                }
            });
        }); // End event input baru

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

        // Event handler untuk edit kasir (id_kasir dan password_kasir)
        $('#tabelKasir').on('keypress', 'td', function(event) {
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
					var id_kasir = dataBaris[0];
					id_kasir = id_kasir.split('value="').pop();
					id_kasir = id_kasir.replace('" onkeypress="ambilNilaiBaru(this)">', '');
					
					// Dapatkan nama kolom (field yang ingin diubah nilainya) dari variabel kolom
					var namaKolom;
					switch(kolom) {
						case 0 : namaKolom = 'id_kasir'; break;
						case 1 : namaKolom = 'password_kasir'; break;
					}
					
					$.ajax({
						type	: 'post',
						url		: 'edit-kasir',
						data	: {
							id_kasir    : id_kasir,
							nama_kolom  : namaKolom,
							nilai_baru  : dataSel
						},
						success : function() {
							// Perbarui isi tabel
							refreshTabel();

							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('success', 'Data berhasil diperbarui');

							// Hapus pesan loading
							$('div.overlay').remove();
						},
						error	: function(response) {
							// Tampilkan pesan pemberitahuan
							pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
						}
					}); // End ajax
				} // End if pengecekan baris input
			} // End if pengecekan tombol Enter
        }); // End event handler untuk edit kasir

        // Event handler untuk dropdown nama toko
        $('#tabelKasir').on('change', 'select', function() {
            if( tabel.row($(this).parents('tr')).id() != 'barisInput' ) {
                // Tampilkan pesan loading
                pesanLoading();

                // Ambil seluruh data pada baris dropdown yang diubah
                var data = tabel.row($(this).parents('td')).data();
                // Ambil data id_kasir dari data yang diambil sebelumnya
                var id_kasir = data[0];
                // Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
                id_kasir = id_kasir.split('value="').pop();
                id_kasir = id_kasir.replace('" onkeypress="ambilNilaiBaru(this)">', '');
                // Ambil data id_toko yang baru
                var id_toko = $(this).val();

                $.ajax({
                    type	: 'post',
                    url		: 'edit-kasir',
                    data	: {
                        id_kasir    : id_kasir,
                        nama_kolom  : 'id_toko',
                        nilai_baru  : id_toko
                    },
                    success : function() {
                        // Perbarui isi tabel
                        refreshTabel();

                        // Tampilkan pesan pemberitahuan
                        pesanPemberitahuan('success', 'Data berhasil diperbarui');

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    },
                    error	: function(response) {
                        // Tampilkan pesan pemberitahuan
                        pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
                    }
                })
            }
        });

        // Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		$('#tabelKasir').on('click', '#btnHapus', function() {
			// Tampilkan pesan loading
			pesanLoading();

			// Ambil seluruh data pada baris di mana tombol Hapus diklik
			var data = tabel.row($(this).parents('td')).data();

			// Ambil data id_kasir dari data yang diambil sebelumnya
			var id_kasir = data[0];
			// Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
			id_kasir = id_kasir.split('value="').pop();
			id_kasir = id_kasir.replace('" onkeypress="ambilNilaiBaru(this)">', '');

			$.ajax({
				type	: 'post',
				url		: 'hapus-kasir',
				data	: { id_kasir : id_kasir },
				success	: function() {
					// Perbarui isi tabel
					refreshTabel();

					// Tambahkan pesan pemberitahuan bahwa data telah dihapus
					pesanPemberitahuan('danger', 'Data berhasil dihapus.');

					// Hapus pesan loading
					$('div.overlay').remove();
				},
				error	: function(response) {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				}
			}); // End ajax
		}); // End event tombol Hapus
    });
    </script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Pelanggan</title>
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
	</style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <!-- Header -->
        <?php include('application/views/kasir_v_navbar_top.php');?>

		<div class="content-wrapper">
			<div class="container">
				<section class="content-header">
					<h1>Data Pelanggan</h1>
				</section> <!-- End content-header -->

				<section class="content">
					<!-- Lokasi pesan pemberitahuan akan ditampilkan -->
					<div id="pesanPemberitahuan"></div>

					<!-- Tabel -->
					<div class="box">
						<div class="box-body">
							<table id="tabelPelanggan" class="table table-bordered table-striped">
								<!-- Header Tabel -->
								<thead>
								<tr>
									<th width="162.6px">ID Pelanggan</th>
									<th width="162.6px">Nama</th>
									<th width="162.6px">Alamat</th>
									<th width="162.6px">Telepon</th>
								</tr>
								</thead>

								<!-- Isi tabel -->
								<tbody>
									<!-- Isi tabel dimuat melalui fungsi refreshTabel di bawah -->
								</tbody>
							</table>
						</div> <!-- End box-body -->
					</div> <!-- End box -->
				</section> <!-- End content -->
			</div> <!-- End container -->
		</div> <!-- End content-wrapper -->
    </div> <!-- End wrapper -->
    
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/jquery-ui-1.12.1/jquery-ui.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>

	<script>
	var nilaiBaru = 0; 
	// Ambil nilai baru dari input
	function ambilNilaiBaru(input) {
		nilaiBaru = input.value;
	}

	$(document).ready(function() {
		// Tandai menu Pelanggan sebagai menu aktif pada header
		$('#pelanggan').addClass('active');

		// Gunakan DataTable
        var tabel = $('#tabelPelanggan').DataTable({
			'scrollX'		: true,
			'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
            'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
		});

		// Isi tabel
		refreshTabel();

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
					isi += '<td><input type="text" class="form-control" placeholder="Telepon" name="telepon_pelanggan" autocomplete="off"></td>';
					isi += '</tr>';
					// Untuk daftar pelanggan
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            isi += '<tr>';
                            isi += '<td>'+data[i].id_pelanggan+'</td>';
                            isi += '<td>'+data[i].nama_pelanggan+'</td>';
                            isi += '<td>'+data[i].alamat_pelanggan+'</td>';
                            isi += '<td>'+data[i].telepon_pelanggan+'</td>';
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
                        'stateSave'     : true // Untuk menyimpan kondisi tabel (cth: pagination, ordering) agar dlm kondisi yg sama seperti sblm diupdate
					});

					// Fokuskan pada sel ID Pelanggan pada baris input data pelanggan baru
					$('#barisInput input[name="nama_pelanggan"]').focus();
				}, // End success
				error	: function(response) {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				}
			});// End ajax
		} // End fungsi refreshTabel

		// Kumpulan event handler untuk baris input
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="nama_pelanggan"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="alamat_pelanggan"]').focus();
        });
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="alamat_pelanggan"]', function(event) {
            if(event.keyCode === 13) $('#barisInput input[name="telepon_pelanggan"]').focus();
        });
        // Saat menekan tombol Enter di Level, ambil seluruh nilai data baru dan simpan ke dalam database
        $('#tabelPelanggan').on('keypress', '#barisInput input[name="telepon_pelanggan"]', function(event) {
            if(event.keyCode === 13) {
                // Tampilkan pesan loading
                pesanLoading();

                // Kumpulkan data
                var nama_pelanggan = $('#barisInput input[name="nama_pelanggan"]').val();
                var alamat_pelanggan = $('#barisInput input[name="alamat_pelanggan"]').val();
                var telepon_pelanggan = $('#barisInput input[name="telepon_pelanggan"]').val();

                $.ajax({
                    type    : 'post',
                    url     : 'tambah-pelanggan',
                    data    : {
                        nama_pelanggan      : nama_pelanggan,
                        alamat_pelanggan    : alamat_pelanggan,
                        telepon_pelanggan   : telepon_pelanggan,
                    },
                    success : function() {
						// Sinkronisasi data pelanggan
						sinkronisasiPelanggan();

                        // Perbarui isi tabel
                        refreshTabel();

                        // Tambahkan pesan pemberitahuan bahwa data berhasil ditambahkan
                        pesanPemberitahuan('info', 'Data berhasil ditambahkan.');

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    },
                    error   : function(response) {
                        // Tampilkan pesan pemberitahuan
						pesanPemberitahuan('warning', 'Gagal menambahkan data. Silakan mencoba kembali setelah beberapa saat.');
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

		// Fungsi untuk menyamakan data pelanggan di database kasir dan database admin, fungsi yg sama dgn fungsi di hlm sinkronisasi
		function sinkronisasiPelanggan() {
			$.ajax({
                url     : 'sinkronisasi-pelanggan',
                dataType: 'json',
                success : function(data) {
                    if(data == 'done') {
                        
                    }
                },
                error   : function(response) {
                    pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.')
                }
            });
		} // End fungsi sinkronisasiPelanggan

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

					// Karena data yang diperoleh berupa string <input type="text"... , data harus dibersihkan dulu
					var id_pelanggan = dataBaris[0];
					
					// Dapatkan nama kolom (field yang ingin diubah nilainya) dari variabel kolom
					var namaKolom;
					switch(kolom) {
						case 1 : namaKolom = 'nama_pelanggan'; break;
						case 2 : namaKolom = 'alamat_pelanggan'; break;
						case 3 : namaKolom = 'telepon_pelanggan'; break;
						case 4 : namaKolom = 'maks_utang' ; break;
						case 5 : namaKolom = 'level'; break;
					}
					
					$.ajax({
						type	: 'post',
						url		: 'edit-pelanggan',
						data	: {
							id_pelanggan : id_pelanggan,
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
        }); // End event handler untuk edit pelanggan
	});
	</script>
</body>
</html>
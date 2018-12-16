<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Stok</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/jquery-ui-themes-1.12.1/themes/base/jquery-ui.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.min.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <!-- Header -->
        <?php include('application/views/kasir_v_navbar_top.php');?>

		<div class="content-wrapper">
			<div class="container">
				<section class="content-header">
					<h1>Data Stok</h1>
				</section> <!-- End content-header -->

				<section class="content">
					<!-- Lokasi pesan pemberitahuan akan ditampilkan -->
					<div id="pesanPemberitahuan"></div>

					<!-- Tabel -->
					<div class="box">
						<div class="box-body">
							<table id="tabelStok" class="table table-bordered table-striped">
								<!-- Header Tabel -->
								<thead>
								<tr>
									<th width="162.6px">Nama Barang</th>
									<th width="162.6px">Stok</th>
									<th width="162.6px">Umur</th>
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
	$(document).ready(function() {
		// Tandai menu Pelanggan sebagai menu aktif pada header
		$('#stok').addClass('active');

		// Gunakan DataTable
        var tabel = $('#tabelStok').DataTable({
			'scrollX'		: true,
			'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
		});

		// Isi tabel
		pesanLoading();
		refreshTabel();
		$('.overlay').remove();

		function refreshTabel() {
			$.ajax({
				type	: 'post',
				url		: 'lihat-stok',
				dataType: 'json',
				success : function(data) {
					// Hapus isi data tabel
					$('#tabelStok tbody').remove();
					
					// Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            isi += '<tr>';
                            isi += '<td>'+data[i].nama_barang+'</td>';
                            isi += '<td>'+data[i].stok_barang+'</td>';
                            isi += '<td data-order="'+data[i].umur_barang+'">'+data[i].umur_barang+' hari</td>';
                            isi += '</tr>';
                        }
                    }
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelStok').append(isi);

					// Reinitialize DataTable
					tabel.clear().destroy();
					tabel = $('#tabelStok').DataTable({
						'scrollX'		: true,
						'bInfo'			: false, // Untuk menghilangkan tulisan keterangan di bawah tabel
					});
				}, // End success
				error	: function() {
					// Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
				}
			});// End ajax
		} // End fungsi refreshTabel

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
	});
	</script>
</body>
</html>
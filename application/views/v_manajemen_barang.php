<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen Barang</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css-custom.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">	
</head>

<body class="hold-transition skin-blue sidebar-mini">
	
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
						<div class="box-header">
							<button id="btnTambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
						</div>
						<div class="box-body">
							<table id="tabelBarang" class="table table-bordered table-striped">

								<!-- Header Tabel -->
								<thead>
								<tr>
									<th rowspan="2">ID Barang</th>
									<th rowspan="2">Nama Barang</th>
									<th rowspan="2">Harga Beli</th>
									<th rowspan="2">Jumlah dlm Koli</th>
									<th rowspan="2">Kategori</th>
									<th rowspan="2">Fungsi</th>
									<th colspan="4">Harga Jual</th>
									<th rowspan="2">Menu</th>
								</tr>
								<tr>
									<th>Level 1</th>
									<th>Level 2</th>
									<th>Level 3</th>
									<th>Level 4</th>
								</tr>
								</thead>

								<!-- Isi Tabel -->
								<tbody>
								<?php for($i=0; $i<count($barang); $i++) { ?> 
								<tr data-id="<?php echo $barang[$i]['id_barang'];?>">
									<td><?php echo $barang[$i]['id_barang'];?></td>
									<td><?php echo $barang[$i]['nama_barang'];?></td>
									<td><?php echo $barang[$i]['harga_beli'];?></td>
									<td><?php echo $barang[$i]['jumlah_dlm_koli'];?></td>
									<td><?php echo $barang[$i]['kategori'];?></td>
									<td><?php echo $barang[$i]['fungsi'];?></td>
									<td><?php echo $barang[$i]['harga_jual_1'];?></td>
									<td><?php echo $barang[$i]['harga_jual_2'];?></td>
									<td><?php echo $barang[$i]['harga_jual_3'];?></td>
									<td><?php echo $barang[$i]['harga_jual_4'];?></td>
									<td>
										<button onClick="eventHapus('<?php echo $barang[$i]['id_barang'];?>')" class="btn btn-xs btn-danger"><i class="fa fa-small fa-times"></i></button>
									</td>
								</tr>
								<?php } ?>
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</section>

	</div>
	
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.js');?>"></script>

	<script>
		// Tandai menu Manajemen Barang sebagai menu aktif pada sidebar
		$('#manajemenBarang').addClass('active');

		// Gunakan DataTable
		$('#tabelBarang').DataTable( {
			'scrollX'	: true
		});

		// Fungsi yang dijalankan ketika mengklik tombol Tambah Data
		// Jika diklik, baris baru untuk memasukkan data baru akan muncul di bagian bawah tabel
		$('#btnTambah').click(function() {

		});

		// var table = $('#tabelBarang').DataTable();
		// $('#tabelBarang tbody').on('click', 'tr', function () {
		// 	var data = table.row( this ).data();
		// 	alert( 'You clicked on '+data[0]+'\'s row' );
		// } );
		
		// Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		function eventHapus(id_barang) {
			// alert(id_barang);
			$.ajax({
				type	: 'post',
				url		: 'hapus-barang',
				data	: { id_barang : id_barang },
				success	: function(response) {
					// Hilangkan baris data yang dihapus
					$('tr[data-id="' + id_barang + '"]').fadeOut('fast', function() {
						$(this).remove();
					});

					// Tambahkan pesan pemberitahuan bahwa data telah dihapus
					var alert = '<div class="alert alert-danger alert-dismissible" role="alert">';
					alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alert += 'Data telah dihapus.';
					alert += '</div>';
					$('#pesanPemberitahuan').append(alert);
				}
			});
		}
		
	</script>
</body>
</html>
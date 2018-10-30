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
					<div class="box">
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
								<?php for($i=0; $i<count($barang); $i++) { ?> 
								<tr>
									<td id="idBarang"><?php echo $barang[$i]['id_barang'];?></td>
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
										<button id="btnHapus" class="btn btn-xs btn-danger"><i class="fa fa-small fa-times"></i></button>
									</td>
								</tr>
								<?php } ?>

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
		$(document).ready(function() {
			// Tandai menu Manajemen Barang sebagai menu aktif pada sidebar
			$('#manajemenBarang').addClass('active');
			
			// Event untuk tombol Hapus
			$('#btnHapus').click(function() {
				var idBarang = $(this).closest('tr')		// Cari baris yang sama dengan button Hapus yang diklik 
									  .find('#idBarang')	// Temukan elemen yang akan diambil nilainya
									  .text();
				alert(idBarang);
				$.ajax(
					{

					}
				);
			});
		});
	</script>
</body>
</html>
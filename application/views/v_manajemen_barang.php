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
									<th width="162.6px" rowspan="2">ID Barang</th>
									<th width="162.6px" rowspan="2">Nama Barang</th>
									<th width="162.6px" rowspan="2">Harga Beli</th>
									<th width="162.6px" rowspan="2">Jumlah dlm Koli</th>
									<th width="162.6px" rowspan="2">Kategori</th>
									<th width="162.6px" rowspan="2">Fungsi</th>
									<th colspan="4">Harga Jual</th>
									<th rowspan="2">Menu</th>
								</tr>
								<tr>
									<th width="162.6px">Level 1</th>
									<th width="162.6px">Level 2</th>
									<th width="162.6px">Level 3</th>
									<th width="162.6px">Level 4</th>
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
										<button onClick="eventHapus('<?php echo $barang[$i]['id_barang'];?>')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
									</td>
								</tr>
								<?php } ?>
								</tbody>

							</table>
						</div> <!-- End box-body -->
					</div> <!-- End box -->
				</div>
			</div>
		</section>

	</div>
	
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.js');?>"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.19/api/processing().js"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.js');?>"></script>

	<script>
	$(document).ready(function() {
		// Tandai menu Manajemen Barang sebagai menu aktif pada sidebar
		$('#manajemenBarang').addClass('active');

		// Gunakan DataTable
		var tabel = $('#tabelBarang').DataTable( {
			'scrollX'	: true
		});

		// Fungsi yang dijalankan ketika mengklik tombol Tambah Data
		// Jika diklik, baris baru untuk memasukkan data baru akan muncul di bagian bawah tabel
		$('#btnTambah').click(function() {
			// Cek terlebih dahulu apakah baris input sudah ada
			// Jika tidak ada, tambah baris baru
			// Jika ada, tidak ada aksi yang dilakukan
			if($('#barisBaru').length == 0) {
				tabel.row.add( [
				'<input type="text" class="form-control" placeholder="ID barang" name="id_barang">',
				'<input type="text" class="form-control" placeholder="Nama barang" name="nama_barang">',
				'<input type="text" class="form-control" placeholder="Harga beli" name="harga_beli">',
				'<input type="text" class="form-control" placeholder="Jumlah dalam koli" name="jumlah_dlm_koli">',
				'<input type="text" class="form-control" placeholder="Kategori" name="kategori">',
				'<input type="text" class="form-control" placeholder="Fungsi" name="fungsi">',
				'<input type="text" class="form-control" placeholder="Harga Jual 1" name="harga_jual_1">',
				'<input type="text" class="form-control" placeholder="Harga Jual 2" name="harga_jual_2">',
				'<input type="text" class="form-control" placeholder="Harga Jual 3" name="harga_jual_3">',
				'<input type="text" class="form-control" placeholder="Harga Jual 4" name="harga_jual_4">',
				'<button id="btnInputData" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i></button>'
				] ).node().id = 'barisBaru';
				tabel.draw(false);
			}
		});

		// Fungsi yang dijalankan ketika mengklik tombol Tambah (+)
		$('#tabelBarang').on('click', '#btnInputData', function() {
			// Tampilkan pesan loading
			var loading = '<div class="overlay">';
			loading += '<i class="fa fa-refresh fa-spin"></i>';
			loading += '</div>';
			$('div[class="box"]').append(loading);

			// Dapatkan seluruh nilai dari input data baru
			var id_barang = $('input[name="id_barang"]').val();
			var nama_barang = $('input[name="nama_barang"]').val();
			var harga_beli = $('input[name="harga_beli"]').val();
			var jumlah_dlm_koli = $('input[name="jumlah_dlm_koli"]').val();
			var kategori = $('input[name="kategori"]').val();
			var fungsi = $('input[name="fungsi"]').val();
			var harga_jual_1 = $('input[name="harga_jual_1"]').val();
			var harga_jual_2 = $('input[name="harga_jual_2"]').val();
			var harga_jual_3 = $('input[name="harga_jual_3"]').val();
			var harga_jual_4 = $('input[name="harga_jual_4"]').val();

			$.ajax({
				type	: 'post',
				url		: 'tambah-barang',
				cache	: false,
				async	: false,
				data	: {
					id_barang 		: id_barang,
					nama_barang		: nama_barang,
					harga_beli		: harga_beli,
					jumlah_dlm_koli	: jumlah_dlm_koli,
					kategori		: kategori,
					fungsi			: fungsi,
					harga_jual_1 	: harga_jual_1,
					harga_jual_2 	: harga_jual_2,
					harga_jual_3 	: harga_jual_3,
					harga_jual_4 	: harga_jual_4
				},
				success	: function() {
					// Tambahkan pesan pemberitahuan bahwa data telah ditambahkan ke database
					var alert = '<div class="alert alert-info alert-dismissible" role="alert">';
					alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					alert += 'Data baru berhasil disimpan.';
					alert += '</div>';
					$('#pesanPemberitahuan').append(alert);

					// Muat ulang data dalam tabel
					tabel.clear().draw();
					

					// Hapus pesan loading
					$('div.overlay').remove();
				}
			});
		});
	});
		

		// var table = $('#tabelBarang').DataTable();
		// $('#tabelBarang tbody').on('click', 'tr', function () {
		// 	var data = table.row( this ).data();
		// 	alert( 'You clicked on '+data[0]+'\'s row' );
		// } );
		
		// Fungsi yang dijalankan ketika mengklik tombol Hapus (silang)
		// function eventHapus(id_barang) {
		// 	// alert(id_barang);
		// 	$.ajax({
		// 		type	: 'post',
		// 		url		: 'hapus-barang',
		// 		cache	: 'false',
		// 		data	: { id_barang : id_barang },
		// 		success	: function(response) {
		// 			// Hilangkan baris data yang dihapus
		// 			$('tr[data-id="' + id_barang + '"]').fadeOut('fast', function() {
		// 				$(this).remove();
		// 			});

		// 			// Tambahkan pesan pemberitahuan bahwa data telah dihapus
		// 			var alert = '<div class="alert alert-danger alert-dismissible" role="alert">';
		// 			alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		// 			alert += 'Data telah dihapus.';
		// 			alert += '</div>';
		// 			$('#pesanPemberitahuan').append(alert);
		// 		}
		// 	});
		// }
		
	</script>
</body>
</html>
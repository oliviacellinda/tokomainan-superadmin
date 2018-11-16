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
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/AdminLTE.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/dist/css/skins/skin-blue.min.css');?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
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
                                        <th width="162.6px"></th>
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
    $(document).ready(function() {
        // Tandai menu Manajemen Pelanggan sebagai menu aktif pada sidebar
		$('#manajemenPelanggan').addClass('active');

        // Gunakan DataTable
        var tabel = $('#tabelPelanggan').DataTable({
            'scrollX'       : true,
            'bInfo'         : false, // Untuk menghilangkan tulisan keterangan di bawah tabel
            'columnDefs'    : [
                { 'orderable' : false, 'targets' : 7 } // Pilih kolom yg tdk memiliki fitur pengurutan, dimulai dari indeks 0
            ]
        });
    });
    </script>
</body>
</html>
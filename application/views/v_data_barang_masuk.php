<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Manajemen Stok Barang</title>
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
		<?php include('application/views/toko_v_navbar_top.php');?>

        <!-- Sidebar -->
        <?php include('application/views/toko_v_navbar_left.php');?>

        <!-- Konten Halaman -->
        <div class="content-wrapper">

            <!-- Header -->
			<section class="content-header">
				<h1>Manajemen Stok Barang</h1>
            </section>
            
            <!-- Konten Utama -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Lokasi pesan pemberitahuan akan ditampilkan -->
                        <div id="pesanPemberitahuan"></div>

                        <!-- Form data barang masuk -->
                        <div class="box box-info">
                            <!-- Judul box -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Data Barang Masuk</h3>
                            </div>
                            <!-- Isi box -->
                            <div class="box-body">
                                <form id="formBarangMasuk" autocomplete="off">
                                    <!-- Dropdown daftar barang -->
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <select class="form-control select2" name="id_barang" id="selectBarang">
                                                <!-- Isi option melalui ajax di bawah -->
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Input text jumlah barang masuk -->
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="jml_barang_masuk" placeholder="Jumlah Barang Masuk">
                                        </div>
                                    </div>
                                    
                                    <!-- Button submit -->
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div> <!-- End box-body -->
                        </div> <!-- End box -->
                    </div> <!-- End col-xs-6 -->
                </div> <!-- End row -->

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Laporan Stok Barang</h3>
                            </div>
                            <!-- Tabel -->
                            <div class="box-body">
                                <table id="tabelStok" class="table table-bordered table-striped">
                                    <!-- Header Tabel -->
                                    <thead>
                                    <tr>
                                        <th width="162.6px">Nama Barang</th>
                                        <th width="162.6px">Nama Toko</th>
                                        <th width="162.6px">Stok</th>
                                        <th width="162.6px">Umur Barang</th>
                                    </tr>
                                    </thead>
                                    <!-- Isi tabel -->
                                    <tbody>
                                        <!-- Isi tabel melalui ajax di bawah -->
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
    $(document).ready(function() {
        // Tandai Manajemen Stok Barang pada sidebar
        $('#manajemenStokBarang').addClass('active');
        $('#barangMasuk').addClass('active');

        $('#selectBarang').select2({placeholder:'Pilih nama barang'});
        $('#selectToko').select2({placeholder:'Pilih nama toko'});

        var tabel = $('#tabelStok').DataTable({
            'scrollX'   : true,
            'bInfo'     : false // Untuk menghilangkan tulisan keterangan di bawah tabel
        });

        daftarBarang();
        refreshTabel();

        // Fungsi untuk memuat daftar barang di dropdown daftar barang
        function daftarBarang() {
            $.ajax({
                type    : 'post',
                url     : '<?php echo base_url("lihat-barang");?>',
                dataType: 'json',
                success : function(data) {
                    // Hapus seluruh child (isi) select
                    $('#selectBarang').empty();

                    var option = '<option></option>';
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            option += '<option value="'+data[i].id_barang+'">'+data[i].nama_barang+'</option>'
                        }
                    }

                    // Tambahkan data ke select
                    $('#selectBarang').append(option);
                },
            });
        } // End fungsi daftarBarang

        // Fungsi untuk memuat ulang data tabel
        function refreshTabel() {
            $.ajax({
                type    : 'post',
                url     : 'daftar-stok-barang',
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
                            isi += '<td>'+data[i].nama_toko+'</td>';
                            isi += '<td>'+data[i].stok_barang+'</td>';
                            isi += '<td data-order="'+data[i].umur_barang+'" id="umurBarang">'+data[i].umur_barang+' hari</td>';
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
						'bInfo'			: false // Untuk menghilangkan tulisan keterangan di bawah tabel
					});
                    
                    // Beri label pada barang "tua"
                    labelUmur();
                },
                error   : function(response) {
                    // Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
                }
            });
        } // End fungsi refreshTabel

        // Fungsi untuk menandai kolom umur barang yg berumur lebih dari 30 hari
        function labelUmur() {
            $('td#umurBarang').each(function() {
                var day = $(this).html();
                day = parseInt(day);
                if(day > 30) {
                    $(this).css({'background-color':'#f44242', 'color':'#ffffff'});
                }
            });
        } // End fungsi labelUmur
        
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

        // Fungsi untuk event submit form
        $('#formBarangMasuk').submit(function(event) {
            pesanLoading();
            event.preventDefault();

            var data = $('#formBarangMasuk').serializeArray();
            
            // Reset form
            $('#selectBarang').val(null).trigger('change');
            $('#selectToko').val(null).trigger('change');
            $('input[name="jml_barang_masuk"]').val('');
            $('input[name="jml_barang_masuk"]').blur();

            $.ajax({
                type    : 'post',
                url     : 'input-barang-masuk',
                data    : data,
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
            }); // End ajax
        }); // End proses submit form
    });
    </script>
</body>
</html>
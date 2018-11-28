<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Ganti Password</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
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
				<h1>Ganti Password</h1>
            </section>
            
            <!-- Konten Utama -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Lokasi pesan pemberitahuan akan ditampilkan -->
                        <div id="pesanPemberitahuan"></div>

                        <!-- Kotak form ganti password -->
                        <div class="box">
                            <div class="box-body">
                                <form class="form-horizontal" autocomplete="off">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Password Lama</label>
                                        <div class="col-sm-3" id="passwordLama">
                                            <input type="password" class="form-control" name="passwordLama" placeholder="Password Lama" required>
                                        </div>
                                        <div id="pesanPassLama" class="col-sm-6"><span class="help-block" style="color:#a94442"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Password Baru</label>
                                        <div class="col-sm-3" id="passwordBaru">
                                            <input type="password" class="form-control" name="passwordBaru" placeholder="Password Baru" required>
                                        </div>
                                        <div id="pesanPassBaru" class="col-sm-6"><span class="help-block" style="color:#a94442"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Konfirmasi Password Baru</label>
                                        <div class="col-sm-3" id="konfirmasiPassword">
                                            <input type="password" class="form-control" name="konfirmasiPassword" placeholder="Konfirmasi Password Baru" required>
                                        </div>
                                        <div id="pesanKonfirmasiPass" class="col-sm-6"><span class="help-block" style="color:#a94442"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-3" style="padding-left:15px">
                                            <button id="btnSimpan" type="submit" class="btn btn-primary" style="width:100%">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- End box-body -->
                        </div> <!-- End box -->
                    </div> <!-- End col-xs-12 -->
                </div> <!-- End row -->
            </section> <!-- End section for content -->
        </div> <!-- End content-wrapper -->
    </div> <!-- End wrapper -->

    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>

    <script>
    $(document).ready(function() {
        $('input[name="passwordLama"]').focus();

        $('input[name="passwordLama"]').keypress(function(event) {
            // Hapus tanda error pada input saat mengetik
            // Digunakan setelah gagal mengubah password dan user mengetik ulang password
            $('#passwordLama').removeClass('has-error');
            // Hapus pesan yang ditampilkan sebelumnya
            $('#pesanPassLama span').html('');

            // Arahkan kursor ke input password baru setelah menekan Enter
            if(event.keyCode === 13) {
                event.preventDefault();
                $('input[name="passwordBaru"]').focus();
            }
        });

        $('input[name="passwordBaru"]').keypress(function(event) {
            // Hapus tanda error pada input saat mengetik
            // Digunakan setelah gagal mengubah password dan user mengetik ulang password
            $('#passwordBaru').removeClass('has-error');

            // Arahkan kursor ke input konfirmasi password setelah menekan Enter
            if(event.keyCode === 13) {
                event.preventDefault();
                $('input[name="konfirmasiPassword"]').focus();
            }
        });

        // Untuk memeriksa nilai yang diketikkan user
        // Event keypress dijalankan sebelum val() memperoleh nilai
        // Event keyup dijalankan setelah val() memperoleh nilai
        $('input[name="konfirmasiPassword"]').keyup(function(event) {
            if( $('input[name="konfirmasiPassword"]').val() != $('input[name="passwordBaru"]').val() ) {
                $('#pesanKonfirmasiPass span').html('Konfirmasi password tidak sama dengan password baru!');
                $('#konfirmasiPassword').addClass('has-error');
            }
            else {
                $('#pesanKonfirmasiPass span').html('');
                $('#konfirmasiPassword').removeClass('has-error');
            }
        });

        $('form').submit(function(event) {
            event.preventDefault();

            // Ubah tombol Simpan untuk menampilkan pesan loading pada user
            $('#btnSimpan').html('<i class="fa fa-refresh fa-spin"></i>');
            $('#btnSimpan').addClass('disabled');

            prosesGantiPassword();
        });

        function prosesGantiPassword() {
            var data = $('form').serializeArray();

            if( $('input[name="konfirmasiPassword"]').val() == $('input[name="passwordBaru"]').val() ) {
                $.ajax({
                    type    : 'post',
                    url     : 'proses-ganti-password',
                    dataType: 'json',
                    data    : data,
                    success : function(response) {
                        if(response == 'success') {
                            pesanPemberitahuan('success', 'Password Anda berhasil diubah.');
                            $('form').trigger('reset');
                            $('#btnSimpan').html('Sign In');
                            $('#btnSimpan').removeClass('disabled');
                            $('input[name="passwordLama"]').focus();
                        }
                        else if(response == 'fail') {
                            $('#pesanPassLama span').html('Password Anda salah.');
                            $('#passwordLama').addClass('has-error');
                            $('#btnSimpan').html('Sign In');
                            $('#btnSimpan').removeClass('disabled');
                            $('input[name="passwordLama"]').focus();
                        }
                    },
                    error   : function(response) {
                        console.log(response.responseText);
                    }
                });
            }
        }

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
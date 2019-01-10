<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Laporan Penjualan Dibatalkan</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/Buttons-1.5.4/css/buttons.bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/Buttons-1.5.4/css/buttons.dataTables.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/css/select2.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');?>">
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
				<h1>Laporan Penjualan Dibatalkan</h1>
            </section>
            
            <!-- Konten Utama -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Lokasi pesan pemberitahuan akan ditampilkan -->
                        <div id="pesanPemberitahuan"></div>

                        <div class="box box-success">
                            <!-- Judul box -->
                            <div class="box-header with-border">
                                <h3 class="box-title">Filter Data</h3>
                            </div>
                            <!-- Isi box -->
                            <div class="box-body">
                                <form id="formFilter" auto-complete="off">
                                    <div class="row">
                                        <div class="col-xs-3"><label>Nama Toko</label></div>
                                        <div class="col-xs-3"><label>Bulan</label></div>
                                    </div>
                                    <div class="row">
                                        <!-- Nama toko -->
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <select class="form-control select2" name="id_toko" id="selectToko">
                                                    <!-- Isi option melalui ajax di bawah -->
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Bulan -->
                                        <div class="col-xs-3">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control pull-right" name="bulan_tahun" id="filterBulan">
                                            </div>
                                        </div>

                                        <!-- Button submit -->
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- End box-body -->
                        </div> <!-- End box -->
                    </div> <!-- End col-xs-12 -->
                </div> <!-- End row-->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- Kotak berisi tabel data -->
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Data Laporan</h3>
                            </div>
                            <!-- Tabel -->
                            <div class="box-body">
                                <table id="tabelPenjualan" class="table table-bordered table-striped">
                                    <!-- Header Tabel -->
                                    <thead>
                                    <tr>
                                        <th width="162.6px">No. Invoice</th>
                                        <th width="162.6px">Tanggal Invoice</th>
                                        <th width="120px">Sumber Penjualan</th>
                                        <th width="120px">Total Penjualan</th>
                                        <th width="162.6px">Nama Pelanggan</th>
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

    <!-- Modal -->
    <div class="modal" id="modalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Judul Modal -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Detail Data Penjualan</h4>
                </div> <!-- End modal-header -->

                <!-- Isi Modal -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>Nomor Invoice : <span id="labelNota"></span></p>
                            <p>Tanggal Invoice : <span id="labelTanggal"></span></p>
                            <p>Nama Pelanggan : <span id="labelPelanggan"></span></p>
                        </div> <!-- End col-xs-12 -->
                        <div class="col-xs-12">
                            <table id="tabelDetail" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th width="162.6px">Kode Barang</th>
                                    <th width="162.6px">Nama Barang</th>
                                    <th width="162.6px">Jumlah (pcs)</th>
                                    <th width="162.6px">Harga (pcs)</th>
                                    <th width="162.6px">Diskon</th>
                                    <th width="162.6px">Total Harga</th>
                                </tr>
                                </thead>
                                <tbody><!-- Isi tabel melalui ajax di bawah --></tbody>
                            </table>
                        </div> <!-- End col-xs-12 -->
                        <div class="col-xs-4 col-xs-offset-8">
                            <div class="col-xs-5">
                                <p>Sub-Total :</p>
                                <p>Diskon :</p>
                                <p>Total :</p>
                            </div>
                            <div class="col-xs-7">
                                <p>Rp. <span id="labelSubTotal"></span></p>
                                <p><span id="labelDiskon"></span></p>
                                <p>Rp. <span id="labelTotal"></span></p>
                            </div>
                        </div> <!-- End col-xs-4 col-xs-offset-8 -->
                    </div> <!-- End row -->
                </div> <!-- End modal-body -->

                <!-- Kaki Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div> <!-- End modal-footer -->
            </div> <!-- End modal-content -->
        </div> <!-- End modal-dialog -->
    </div> <!-- End modal -->

    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/jquery/dist/jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net/js/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/Buttons-1.5.4/js/dataTables.buttons.min.js');?>"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/select2/dist/js/select2.full.min.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/bower_components/moment/min/moment-with-locales.min.js');?>"></script>
    <script src="<?php echo base_url('assets/datetime-moment.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>

    <script>
    // Deklarasi variabel global
    var nilaiToko = 'semua';
    var nilaiBulanTahun = '';

    $(document).ready(function() {
        // Tandai Laporan Penjualan pada sidebar
        $('#laporan').addClass('active');
        $('#laporanPenjualanDibatalkan').addClass('active');

        $('#selectToko').select2({placeholder:'Pilih nama toko'});

        $('#filterBulan').datepicker({
            format      : 'mm / yyyy',
            startView   : 'months',
            minViewMode : 'months'
        });
        
        // Gunakan moment.js untuk menampilkan tanggal, parameter 1 format tgl, parameter 2 lokalisasi data
        $.fn.dataTable.moment('D MMMM YYYY, HH.mm', 'id');
        var tabel = $('#tabelPenjualan').DataTable({
            'scrollX'       : true,
            'bInfo'         : false // Untuk menghilangkan tulisan keterangan di bawah tabel
        });

        daftarToko();
        refreshTabel();
        
        // var today = new Date();
        // var value = today.getMonth() + 1;
        // value += ' / ';
        // value += today.getFullYear();
        // $('#filterBulan').val(value);

        // Fungsi untuk memuat daftar toko di dropdown daftar toko
        function daftarToko() {
            $.ajax({
                type    : 'post',
                url     : 'lihat-toko',
                dataType: 'json',
                success : function(data) {
                    // Hapus seluruh child select
                    $('#selectToko').empty();

                    var option = '<option></option>';
                    option += '<option value="semua">Semua toko</option>';
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            option += '<option value="'+data[i].id_toko+'">'+data[i].nama_toko+'</option>'
                        }
                    }
                    
                    $('#selectToko').append(option).trigger('change');
                    $('#selectToko').val('semua').trigger('change');
                },
            });
        } // End fungsi daftarToko

        // Fungsi untuk memuat ulang data tabel
        function refreshTabel() {
            $.ajax({
                type    : 'post',
                url     : 'daftar-penjualan-dibatalkan',
                dataType: 'json',
                data    : {
                    id_toko   : nilaiToko,
                    bulan_tahun : nilaiBulanTahun
                },
                success : function(data) {
                    // console.log(data);
                    // Hapus isi data tabel
                    $('#tabelPenjualan tbody').remove();

                    // Buat variabel baru yang berisi HTML untuk isi data
					var isi = '<tbody>';
                    if(data != 'no data') {
                        for(var i=0; i<data.length; i++) {
                            isi += '<tr>';
                            isi += '<td>'+data[i].id_invoice+'</td>';
                            isi += '<td>'+data[i].tgl_invoice+'</td>';
                            isi += '<td>'+data[i].id_kasir+'</td>';
                            isi += '<td>'+data[i].total_penjualan+'</td>';
                            isi += '<td>'+data[i].nama_pelanggan+'</td>';
                            isi += '<td><button id="btnDetail" class="btn btn-xs btn-info" data-id="'+data[i].id_invoice+'" data-toggle="modal" data-target="#modalDetail">Detail</button></td>';
                            isi += '</tr>';
                        }
                    }
					isi += '</tbody>';

					// Tambahkan data baru ke dalam tabel
					$('#tabelPenjualan').append(isi);

                    // Reinitialize DataTable
                    tabel.clear().destroy();
                    // Gunakan moment.js untuk menampilkan tanggal, parameter 1 format tgl, parameter 2 lokalisasi data
                    $.fn.dataTable.moment('D MMMM YYYY, HH:mm', 'id');
					tabel = $('#tabelPenjualan').DataTable({
                        'scrollX'       : true,
                        'bInfo'         : false,
                        'dom'           : 'lBfrtips',
                        'buttons'       : [
                            {
                                'extend'        : 'excel',
                                'text'          : 'Simpan dalam Excel',
                                'className'     : 'btn btn-primary',
                                'exportOptions' : {
                                    'columns' : [ 0, 1, 2, 3, 4 ]
                                }
                            }
                        ],
					});
                },
                error   : function() {
                    // Tampilkan pesan pemberitahuan
					pesanPemberitahuan('warning', 'Terdapat kesalahan saat memuat data. Silakan mencoba kembali.');
                }
            });
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

        // Fungsi untuk event perubahan nilai pada dropdown toko
        $('#selectToko').on('select2:select', function(e) {
            nilaiToko = e.params.data.id;
        });

        // Fungsi untuk event submit form
        $('#formFilter').submit(function(event) {
            event.preventDefault();
            nilaiBulanTahun = $('input[name="bulan_tahun"]').val();
            pesanLoading();
            refreshTabel();
            $('div.overlay').remove();
        });

        // Fungsi untuk mengisi detail penjualan
        $('#tabelPenjualan').on('click', '#btnDetail', function() {
            pesanLoading();
            // Jangan munculkan modal sebelum data selesai diambil
            $('#modalDetail').modal(function(event) {
                event.preventDefault();
            });
            
            // Ambil nilai id_invoice dari atribut data-id pada button Detail
            var id_invoice = $(this).data('id');
            
            $.ajax({
                type    : 'post',
                url     : 'detail-penjualan-dibatalkan',
                dataType: 'json',
                data    : { id_invoice : id_invoice },
                success : function(data) {
                    if(data != 'no data') {
                        $('#labelNota').text(data.laporan_penjualan.id_invoice);
                        $('#labelTanggal').text(data.laporan_penjualan.tgl_invoice);
                        $('#labelPelanggan').text(data.laporan_penjualan.nama_pelanggan);
                        $('#labelSubTotal').text(data.laporan_penjualan.sub_total_penjualan);
                        $('#labelTotal').text(data.laporan_penjualan.total_penjualan);
                        if(data.laporan_penjualan.status_diskon_penjualan == 'p') $('#labelDiskon').text(data.laporan_penjualan.diskon_penjualan + '%');
                        else $('#labelDiskon').text('Rp. ' + data.laporan_penjualan.diskon_penjualan)

                        $('#tabelDetail tbody').empty();
                        var baris = '';
                        for(var i=0; i<data.detail_penjualan.length; i++) {
                            baris += '<tr>';
                            baris += '<td>'+(i+1)+'</td>';
                            baris += '<td>'+data.detail_penjualan[i].id_barang+'</td>';
                            baris += '<td>'+data.detail_penjualan[i].nama_barang+'</td>';
                            baris += '<td>'+data.detail_penjualan[i].jumlah_barang+'</td>';
                            baris += '<td>'+data.detail_penjualan[i].harga_barang+'</td>';
                            if(data.detail_penjualan[i].status_diskon_barang == 'p') baris += '<td>'+data.detail_penjualan[i].diskon_barang+'%</td>';
                            else baris += '<td>Rp. '+data.detail_penjualan[i].diskon_barang+'</td>';
                            baris += '<td>'+data.detail_penjualan[i].total_harga_barang+'</td>';
                            baris += '</tr>';
                        }
                        $('#tabelDetail tbody').append(baris);
                        
                        // Tampilkan modal setelah data selesai diatur tampilannya
                        $('#modalDetail').modal('show');

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    }
                },
                error   : function(response) {
                    // Do something
                    // console.log(response.responseText);
                }
            });
        }); // End fungsi untuk mengisi detail penjualan
        
    });
    </script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<title>Laporan Penjualan</title>
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
				<h1>Laporan Penjualan</h1>
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
                                        <!-- Nama toko -->
                                        <div class="col-xs-12 col-sm-5 col-md-4">
                                            <div class="form-group">
                                                <label>Nama Toko</label>
                                                <select class="form-control select2" name="id_toko" id="selectToko" style="width: 100%;">
                                                    <option value="semua">Semua toko</option>
                                                    <?php if($toko != '') : ?>
                                                        <?php for($i=0; $i<count($toko); $i++) : ?>
                                                            <option value="<?php echo $toko[$i]['id_toko'];?>"><?php echo $toko[$i]['nama_toko'];?></option>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Bulan -->
                                        <div class="col-xs-12 col-sm-5 col-md-4">
                                            <label>Bulan</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input autocomplete="off" type="text" class="form-control pull-right" name="bulan_tahun" id="filterBulan">
                                            </div>
                                        </div>

                                        <!-- Button submit -->
                                        <div class="col-xs-12 col-sm-2" style="padding-top: 25px;">
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
                                        <th>No. Invoice</th>
                                        <th>Tanggal Invoice</th>
                                        <th>Sumber Penjualan</th>
                                        <th>Total Penjualan</th>
                                        <th>Nama Pelanggan</th>
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
                                    <th width="162.6px">Kemasan</th>
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
	<script src="<?php echo base_url('assets/jsPDF-master/dist/jspdf.debug.js');?>"></script>
	<script src="<?php echo base_url('assets/jsPDF-AutoTable-master/dist/jspdf.plugin.autotable.js');?>"></script>
    <script src="<?php echo base_url('assets/AdminLTE-2.4.2/dist/js/adminlte.min.js');?>"></script>

    <script>
    // Deklarasi variabel global
    var nilaiToko = 'semua';
    var nilaiBulanTahun = '';

    $(document).ready(function() {
        // Tandai Laporan Penjualan pada sidebar
        $('#laporan').addClass('active');
        $('#laporanPenjualan').addClass('active');

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

        refreshTabel();

        // Fungsi untuk memuat ulang data tabel
        function refreshTabel() {
            pesanLoading();

            $.ajax({
                type    : 'post',
                url     : 'daftar-penjualan',
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
                            // Button menu
                            isi += '<td>';
                            isi += '<button id="btnDetail" class="btn btn-xs btn-info" data-id="'+data[i].id_invoice+'" data-toggle="modal" data-target="#modalDetail">Detail</button> ';
                            isi += '<button id="btnBatal" class="btn btn-xs btn-danger" data-id="'+data[i].id_invoice+'">Batalkan</button> ';
                            isi += '<button id="btnPrint" class="btn btn-xs btn-primary" data-id="'+data[i].id_invoice+'">Cetak</button></td>';
                            isi += '</td>';
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
                },
                complete: function() {
                    // Hapus pesan loading
                    $('div.overlay').remove();
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
            
            refreshTabel();
        });

        // Event handler untuk mengisi detail penjualan
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
                url     : 'detail-penjualan',
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
                            baris += '<td>'+data.detail_penjualan[i].kemasan+'</td>';
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
                    // console.log(response.responseText);
                    pesanPemberitahuan('warning', 'Gagal memperoleh data. Silakan mencoba kembali setelah beberapa saat.');

                    // Hapus pesan loading
                    $('div.overlay').remove();
                }
            });
        }); // End event handler untuk mengisi detail penjualan

        // Event handler untuk membatalkan nota
        $('#tabelPenjualan').on('click', '#btnBatal', function() {
            var id_invoice = $(this).data('id');

            // Munculkan peringatan sebelum batalkan nota
            var status = confirm('Anda akan membatalkan nota ' + id_invoice + '! Apakah Anda yakin?');
            if(status == true) {
                pesanLoading();

                $.ajax({
                    type    : 'POST',
                    url     : 'batalkan-nota',
                    dataType: 'json',
                    data    : { id_invoice : id_invoice },
                    success : function(data) {
                        if(data == 'fail') pesanPemberitahuan('warning', 'Gagal melakukan pembatalan nota.');
                        else if(data == 'success') pesanPemberitahuan('danger', 'Berhasil melakukan pembatalan nota.');
                    },
                    error   : function(response) {
                        // console.log(response.responseText);
                        pesanPemberitahuan('warning', 'Gagal melakukan pembatalan nota.');
                    },
                    complete: function() {
                        // Perbarui isi tabel
                        refreshTabel();

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    }
                });
            } // End if batalkan nota
        }); // End event handler untuk membatalkan nota

        // Event handler untuk mencetak nota
        $('#tabelPenjualan').on('click', '#btnPrint', function() {
            pesanLoading();
            
            // Ambil nilai id_invoice dari atribut data-id pada button Detail
            var id_invoice = $(this).data('id');
            var dataNota = new Array();
            
            $.ajax({
                type    : 'post',
                url     : 'detail-penjualan',
                dataType: 'json',
                data    : { id_invoice : id_invoice },
                success : function(data) {
                    if(data != 'no data') {
                        dataNota = data;

                        // Cetak nota
                        cetakNota(dataNota);

                        // Hapus pesan loading
                        $('div.overlay').remove();
                    }
                },
                error   : function(response) {
                    // console.log(response.responseText);
                    pesanPemberitahuan('warning', 'Gagal memperoleh data. Silakan mencoba kembali setelah beberapa saat.');

                    // Hapus pesan loading
                    $('div.overlay').remove();
                }
            });
        }); // End event handler untuk mencetak nota

        // Fungsi untuk mengambil dan menyusun data yang akan ditampilkan dalam nota, kemudian dicetak
		function cetakNota(dataNota) {
			var jumlahHlm = Math.ceil(dataNota.detail_penjualan.length / 10);
			var kolom = ['No', 'Jumlah', 'Nama Barang', 'Kode Barang', 'Kemasan', 'Harga Satuan', 'Diskon', 'Total', 'Dus ke-'];
			var data = new Array();
			var namaPelanggan = dataNota.laporan_penjualan.nama_pelanggan;
			var alamatPelanggan = dataNota.laporan_penjualan.alamat_pelanggan;
			var teleponPelanggan = dataNota.laporan_penjualan.telepon_pelanggan;
			var ekspedisi = dataNota.laporan_penjualan.ekspedisi;
			var nomorNota = dataNota.laporan_penjualan.id_invoice;
            var namaToko = dataNota.nama_toko;
			var pdf = new jsPDF('landscape', 'mm', 'a5');

            // Format ulang tanggal nota
            var tglNota = dataNota.laporan_penjualan.tgl_invoice_database;
            var d = tglNota.substring(8, 10);
            var m = tglNota.substring(5, 7);
            var y = tglNota.substring(0, 4);
            tglNota = d + '-' + m + '-' + y;

			for(var i=0; i<dataNota.detail_penjualan.length; i++) {
                var jumlah = dataNota.detail_penjualan[i].jumlah_barang + ' pcs';
                var nama = dataNota.detail_penjualan[i].nama_barang + ' (' + dataNota.detail_penjualan[i].jumlah_dlm_koli + ' pcs)';
                var kode = dataNota.detail_penjualan[i].id_barang;
                var kemasan = dataNota.detail_penjualan[i].kemasan;
                var harga = 'Rp. ' + dataNota.detail_penjualan[i].harga_barang;
                var diskon = '';
                var total = 'Rp. ' + dataNota.detail_penjualan[i].total_harga_barang;

                if(dataNota.detail_penjualan[i].status_diskon_barang == 'p') diskon = dataNota.detail_penjualan[i].diskon_barang + '%';
                else diskon = 'Rp. ' + dataNota.detail_penjualan[i].diskon_barang;

				var baris = [ i+1, jumlah, nama, kode, kemasan, harga, diskon, total, '' ];
				data.push(baris);
			}
			// console.log(data);

			for(var i=0; i<jumlahHlm; i++) {
				var dataPerHlm = new Array();
				
				if(i+1 == jumlahHlm) {
					var batas = data.length % 10;
					for(j=i*10; j<(i*10)+batas; j++) {
						dataPerHlm.push(data[j]);
					}
				}
				else {
					for(j=i*10; j<(i+1)*10; j++) {
						dataPerHlm.push(data[j]);
					}
				}
				// console.log(dataPerHlm);

				// Nama toko
				pdf.setFontSize(18);
				pdf.text(namaToko, 10, 10, 'left');

                // Nomor nota
				pdf.setFontSize(12);
				pdf.text('No. Nota: '+nomorNota, 10, 20, 'left');

				// Tanggal nota
				pdf.setFontSize(8);
				pdf.text('Tanggal', 140, 10, 'left');
				pdf.setFontSize(8);
				pdf.text(tglNota, 155, 10, 'left');

				// Nama pembeli
				pdf.setFontSize(8);
				pdf.text('Nama', 140, 15, 'left');
				pdf.setFontSize(8);
				pdf.text(namaPelanggan, 155, 15, 'left');

				// Alamat pembeli
				pdf.setFontSize(8);
				pdf.text('Alamat', 140, 20, 'left');
				pdf.setFontSize(8);
				pdf.text(alamatPelanggan, 155, 20, 'left');

				// Telepon pembeli
				pdf.setFontSize(8);
				pdf.text('Telepon', 140, 25, 'left');
				pdf.setFontSize(8);
				pdf.text(teleponPelanggan, 155, 25, 'left');

                // Ekspedisi
				pdf.setFontSize(8);
				pdf.text('Ekspedisi', 140, 30, 'left');
				pdf.setFontSize(8);
				pdf.text(ekspedisi, 155, 30, 'left');

				pdf.autoTable(kolom, dataPerHlm, {
					startX	: 10,
					startY	: 35,
					theme	: 'grid',
					styles	: {
						overflow:'linebreak',
						fontSize: 8
					}
				});

				pdf.setFontSize(8);
				pdf.text((i+1).toString(), 105, 140, 'left');

				if(i+1 != jumlahHlm) {
					var subTotal = 0;
					for(var a=0; a<dataPerHlm.length; a++) {
						harga = dataPerHlm[a][7];
						harga = harga.substring(4);
						harga = parseInt(harga);
						subTotal = subTotal + harga;
					}
					subTotal = subTotal.toString();

					pdf.setFontSize(10);
					pdf.setFontStyle('bold');
					pdf.text('Subtotal', 150, 135, 'left');
					pdf.setFontSize(10);
					pdf.setFontStyle('normal');
					pdf.text('Rp. '+subTotal, 190, 135, 'right');

					pdf.addPage('landscape', 'a5');
				}
				else {
					var subTotalPenjualan = dataNota.laporan_penjualan.sub_total_penjualan;
					var diskonTotal = '';
					if( dataNota.laporan_penjualan.status_diskon_penjualan == 'p' ) diskonTotal = dataNota.laporan_penjualan.diskon_penjualan + '%';
					else diskonTotal = 'Rp. ' + dataNota.laporan_penjualan.diskon_penjualan;
					var totalPenjualan = dataNota.laporan_penjualan.total_penjualan;
					
					// Sub total penjualan
					pdf.setFontSize(10);
					pdf.setFontStyle('bold');
					pdf.text('Subtotal', 150, 125, 'left');
					pdf.setFontSize(10);
					pdf.setFontStyle('normal');
					pdf.text('Rp. '+subTotalPenjualan, 190, 125, 'right');

					// Diskon total
					pdf.setFontSize(10);
					pdf.setFontStyle('bold');
					pdf.text('Diskon', 150, 130, 'left');
					pdf.setFontSize(10);
					pdf.setFontStyle('normal');
					pdf.text(diskonTotal, 190, 130, 'right');

					// Total penjualan
					pdf.setFontSize(10);
					pdf.setFontStyle('bold');
					pdf.text('Total', 150, 135, 'left');
					pdf.setFontSize(10);
					pdf.setFontStyle('normal');
					pdf.text('Rp. '+totalPenjualan, 190, 135, 'right');
				}
			}

			pdf.autoPrint();
			window.open(pdf.output('bloburl'), '_blank');
		} // End fungsi cetakNota
    });
    </script>
</body>
</html>
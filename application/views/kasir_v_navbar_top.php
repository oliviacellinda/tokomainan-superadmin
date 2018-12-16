<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Toko Mainan</a>
                <!-- Button yang akan dimunculkan sebagai tombol Menu pada layar kecil, misal HP -->
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Navbar Kiri -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li id="penjualan"><a href="<?php echo base_url('kasir/penjualan');?>"><i class="fa fa-shopping-basket" style="padding-right:5px"></i><span>Penjualan</span></a></li>
                    <li id="stok"><a href="<?php echo base_url('kasir/stok');?>"><i class="fa fa-cubes" style="padding-right:5px"></i><span>Stok</span></a></li>
                    <li id="pelanggan"><a href="<?php echo base_url('kasir/pelanggan');?>"><i class="fa fa-users" style="padding-right:5px"></i><span>Pelanggan</span></a></li>
                </ul>
            </div>

            <!-- Navbar Kanan -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li id="sinkronisasi"><a href="<?php echo base_url('kasir/sinkronisasi-data');?>"><i class="fa fa-refresh" style="padding-right:5px"></i><span>Sinkronisasi Data</span></a></li>
                    <li><a href="<?php echo base_url('kasir/logout');?>"><i class="fa fa-sign-out" style="padding-right:5px"></i><span>Logout</span></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
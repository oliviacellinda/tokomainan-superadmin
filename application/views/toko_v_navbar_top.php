<header class="main-header">

	<!-- Logo -->
	<a href="#" class="logo">
		<!-- Logo mini untuk sidebar mini, dengan ukuran logo 50x50 piksel -->
		<span class="logo-mini">TM</span>
		<!-- Logo ukuran normal untuk tampilan normal dan mobile device-->
		<span class="logo-lg">Toko Mainan</span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Navbar right menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- User account -->
				<li class="dropdown user user-menu">
					
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url('assets/image/user.png');?>" class="user-image" alt="Foto Pengguna">
						<span class="hidden-xs"><?php echo $this->session->nama_toko;?></span>
					</a>

					<!-- Dropdown menu -->
					<ul class="dropdown-menu">
						<!-- Menu header -->
						<li class="user-header">
							<img src="<?php echo base_url('assets/image/user.png');?>" class="img-circle" alt="Foto Pengguna">
							<p><?php echo $this->session->nama_toko;?></p>
						</li>
						<!-- Menu footer -->
						<li class="user-footer">
							<!-- <div class="pull-left">
								<a href="ganti-password" class="btn btn-default btn-flat">Ganti Password</a>
							</div> -->
							<div class="pull-right">
								<a href="logout" class="btn btn-default btn-flat">Keluar</a>
							</div>
						</li>
					</ul>

				</li>

			</ul>
		</div>

	</nav>
</header>
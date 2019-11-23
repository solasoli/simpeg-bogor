<?php
//session_start();

$is_tim = false; // tim opd flag
$is_administrator = false; //admin flag
if($_SESSION['user'] == NULL)
	{
		header('location:'.BASE_URL.'index.php');
	}

	$q = mysqli_query($mysqli,"SELECT * FROM pegawai WHERE nip_lama = '$_SESSION[user]' OR nip_baru = '$_SESSION[user]'");
	if($ata = $qu = $r = mysqli_fetch_array($q)){

		$user = $r[0] ;
	}

	$tim_opd = mysqli_query($mysqli,"select * from user_roles where role_id = 2");

	while($row = mysqli_fetch_array($tim_opd)){
			$tim[] = $row[0];
	}

	if(in_array($_SESSION['id_pegawai'],$tim)){

		$is_tim = TRUE;
	}

	$admin_bkpp = mysqli_query($mysqli,"select * from user_roles where role_id = 0");

	while($row = mysqli_fetch_array($admin_bkpp)){
			$tim_admin[] = $row[0];
	}

	if(in_array($_SESSION['id_pegawai'],$tim_admin)){

		$is_administrator = TRUE;	//ini
	}

	$qu=mysqli_query($mysqli,"select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru, unit_kerja.id_skpd
					from current_lokasi_kerja
					inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
					where id_pegawai=$ata[id_pegawai]");
	$unit = mysqli_fetch_array($qu);


?>

<div class="row-fluid">
	<div class="col-md-1 hidden-xs hidden-sm">
		<a href="<?php echo BASE_URL ?>index3.php" style="text-decoration:none" ?>
			<img src='<?php echo BASE_URL ?>images/logobgr.png' />
		</a>
	</div>
	<div class="col-md-11">
		<h2 class="simpeg-brand hidden-xs">
			SISTEM INFORMASI MANAJEMEN KEPEGAWAIAN
			<br>
			<small>PEMERINTAH KOTA BOGOR</small>
		</h2>
		<h2 class="simpeg-brand visible-xs">
			SIMPEG
			<br>
			<small>KOTA BOGOR</small>
		</h2>
	</div>
</div>
<div class="row-fluid">
	<div class="col-lg-12">
		<nav class="navbar  navbar-default " role="navigation">
		  <!--div class="navbar-inner"-->
		  <!--div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo BASE_URL ?>index3.php" style="color: orangered;"><span  class="glyphicon glyphicon-home"></span></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<!--li><a href="#">Link</a></li>
				<li><a href="#">Link</a></li-->
			   <!-- tim OPD Menu -->
			   <?php
					if($is_tim){
				?>
			   <li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Pengelola<b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=list2.php">
						<span class="glyphicon glyphicon-list"></span>
						Daftar Pegawai
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=ijinbelajar.php">
						<span class="glyphicon glyphicon-th"></span>
						Ijin Belajar
						</a>
					</li>

                    <li><a  href="<?php echo BASE_URL ?>index3.php?x=alur.php">
						<span class="glyphicon glyphicon-th"></span>
						Alur Ijin Belajar Online
						</a>
					</li>
                    <li><a  href="<?php echo BASE_URL ?>index3.php?x=tutorial.php">
						<span class="glyphicon glyphicon-th"></span>
						Tutorial Ijin Belajar Online
						</a>
					</li>

					<li><a  href="<?php echo BASE_URL ?>index3.php?x=list_by_subid.php">
						<span class="glyphicon glyphicon-th"></span>
						Hirarki Kepegawaian
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=list_pensiun.php">
						<span></span>
						Daftar Pensiun
						</a>
					</li>
					<li class="divider"></li>
					<li><a href="<?php echo BASE_URL ?>index3.php?x=list_tim_skpd.php"><span class="glyphicon glyphicon-list"></span>  Daftar Pengelola Kepegawaian</a></li>
				  </ul>
				</li>
				<?php } ?>
				<!-- end tim OPD menu -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
					 <ul class="dropdown-menu">
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=rekap_peg_opd.php">
						<span class=""></span>
						Rekap Pegawai per OPD
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=statistik.php">
						<span class=""></span>
						Statistik PNS
						</a>
					</li>
					<li class="divider"></li>
					<li><a  href="index3.php?x=duk.php">
						<span class=""></span>
						DUK
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=dukstruktural.php">
						<span class=""></span>
						DUK Struktural
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?x=dukfungsional.php">
						<span class=""></span>
						DUK Fungsional
						</a>
					</li>
					<li class="divider"></li>
					<li><a  href="index3.php?x=nominatif_pejabat.php" class="dropdown-toggle">
						<span class=""></span>
						Daftar Nominatif Pejabat
						</a>
					</li>
					<li><a  href="<?php echo BASE_URL ?>index3.php?p=kslist" class="dropdown-toggle">
						<span class=""></span>
						Daftar Kepala Sekolah
						</a>
					</li>
				  </ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Organigram<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo BASE_URL ?>organigram.php" target="_blank">Organigram</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=modul/organigram.php">Organigram <span class="badge">beta</span></a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#"class="dropdown-toggle" id="informasi" data-toggle="dropdown">Informasi<b class="caret"></b></a>
					<ul class="dropdown-menu">

                    <?php
					$qib=mysqli_query($mysqli,"select count(*) from ijin_belajar where id_pegawai=$_SESSION[id_pegawai] ");
					$ada=mysqli_fetch_array($qib);
					if($ada[0]>0)
					{
					?>

                    <li><a href="<?php echo BASE_URL ?>index3.php?x=statusib.php">Status Ijin Belajar</a></li>
                    <?php }                    ?>


						<li><a href="<?php echo BASE_URL ?>index3.php?x=kgb.php">Penjagaan KGB</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=dini.php">Pensiun</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=impassing.php">Peninjauan Masa Kerja</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=kartu.php">Karpeg, Karisu dan Taspen</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=belajar.php">Tugas/Ijin Belajar dan Pencantuman Gelar</a></li>
						<li><a href="<?php echo BASE_URL ?>index3.php?x=kuesioner.php">Kuesioner SIMPEG</a></li>
						<!--<li><a href="<?php echo BASE_URL ?>index3.php?x=cuti.php">Cuti Pegawai</a></li>-->
					</ul>
				</li>
				<li class="dropdown">
					<a href="#"class="dropdown-toggle" data-toggle="dropdown">Download <span class="badge">1</span><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo BASE_URL ?>index3.php?x=peraturan.php">Peraturan Kepegawaian</a></li>                    
						<li><a href="<?php echo BASE_URL ?>index3.php?p=download">Lain-lain <span class="badge">1</span></a></li>
					</ul>
				</li>
				<li>
					<a href="<?php echo BASE_URL ?>modul/skp/">Penilaian Prestasi</a>
				</li>
			  </ul>
			  <form class="navbar-form navbar-right " role="search" action="index3.php?x=search.php" method="post" name="searchform" id="searchform">
				<div class="form-group">
				 <input name="s" type="text" id="s"  size="15" class="form-control" placeholder="Cari Pegawai">
				</div>
				<!--button name="submit" type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span> Cari
				</button-->
			  </form>
			  <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php echo $ata['nama'] ?>
					<span class="glyphicon glyphicon-cog">
						<span/>
				  </a>

				  <ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $_SESSION[id_pegawai] ?>"><span class="glyphicon glyphicon-pencil"></span>  Edit Data </a></li>
					<li><a href="<?php echo BASE_URL ?>index3.php?x=ganti_password.php"><span class="glyphicon glyphicon-lock"></span>  Ubah Password</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo BASE_URL ?>logout.php?id=<?php echo $_SESSION['id_pegawai'] ?>"><span class="glyphicon glyphicon-log-out"></span>  Log out</a></li>
				  </ul>
				</li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  <!--/div><!-- /.container-fluid -->
		  <!--/div-->
		</nav>
	</div>
</div>

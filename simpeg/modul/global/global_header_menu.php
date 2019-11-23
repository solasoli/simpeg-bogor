 	<style>
	#msg-icon{width:45px; height: 36px;  margin:auto; cursor: pointer;}
	.counter{display: inline; color: #fff; font-size: 12px;  padding:0px 3px;
		float: right; margin-top: 7px; margin-right: 8px; font-weight: bold;}
	#notificationContainer {
		background-color: #fff;
		border: 1px solid #9a9a9a;
		overflow: visible;
		position: absolute;
		top: 45px;
		margin-left: 0px;
		width: 340px;
		z-index: 100;
		display: none;
	}
	#notificationContainer:before {
		content: '';
		display: block;
		position: absolute;
		width: 0;
		height: 0;
		color: transparent;
		border: 10px solid black;
		border-color: transparent transparent white;
		margin-top: -20px;
		margin-left: 15px;
	}
	#notificationTitle {
		z-index: 1000;
		font-weight: bold;
		color: black;
		padding: 8px;
		font-family: "Segoe UI Light", "Open Sans", sans-serif, sans;
		font-size: 13px;
		background-color: #ffffff;
		width: 333px;
		border-bottom: 1px solid #dddddd;
	}
	#notificationsBody {
		font-family: "Segoe UI Light", "Open Sans", sans-serif, sans;
		font-size: 12px;
		color: #000;
		padding: 10px 10px 10px 10px !important;
		max-height:300px;
		overflow:auto;
	}
	#divInformasiNotifikasi{
		padding-bottom: 20px;
	}
	#notificationFooter {
		background-color: #e9eaed;
		color: black;
		text-align: center;
		font-weight: bold;
		padding: 8px;
		font-size: 12px;
		border-top: 1px solid #dddddd;
	}

	/* dropdown */
	.dropdown-submenu {
    position:relative;
}
.dropdown-submenu>.dropdown-menu {
    top:0;
    left:100%;
    margin-top:-6px;
    margin-left:-1px;
    -webkit-border-radius:0 6px 6px 6px;
    -moz-border-radius:0 6px 6px 6px;
    border-radius:0 6px 6px 6px;
}
.dropdown-submenu:hover>.dropdown-menu {
    display:block;
}
.dropdown-submenu>a:after {
    display:block;
    content:" ";
    float:right;
    width:0;
    height:0;
    border-color:transparent;
    border-style:solid;
    border-width:5px 0 5px 5px;
    border-left-color:#cccccc;
    margin-top:5px;
    margin-right:-10px;
}
.dropdown-submenu:hover>a:after {
    border-left-color:#ffffff;
}
.dropdown-submenu.pull-left {
    float:none;
}
.dropdown-submenu.pull-left>.dropdown-menu {
    left:-100%;
    margin-left:10px;
    -webkit-border-radius:6px 0 6px 6px;
    -moz-border-radius:6px 0 6px 6px;
    border-radius:6px 0 6px 6px;
}
</style>

<?php

$is_tim = false; // tim opd flag
$is_administrator = false; //admin flag
/*
if($_SESSION['user'] == NULL && $_SESSION['id_pegawai'] == NULL)
{
	header('location:'.BASE_URL.'index.php');
}
*/
$q = mysqli_query($mysqli,"SELECT * FROM pegawai WHERE nip_lama = '$_SESSION[user]' OR nip_baru = '$_SESSION[user]'");
if($ata = $qu = $r = mysqli_fetch_array($q)){

	$user = $r[0] ;
}

$tim_opd = mysqli_query($mysqli,"select * from user_roles where role_id = 2");

while($row = mysqli_fetch_array($tim_opd)){
	$tim[] = $row[0];
}

$tim_proper = mysqli_query($mysqli,"select * from user_roles where role_id = 9");

$qmentor=mysqli_query($mysqli,"select * from proper where id_mentor=$_SESSION[id_pegawai]");
$mentor=mysqli_fetch_array($qmentor);
$proper = FALSE;
while($row2 = mysqli_fetch_array($tim_proper)){
	$proper[] = $row2[0];
}

if(is_array($proper) && in_array($_SESSION['id_pegawai'], $proper)){

	$is_proper = TRUE;
}


  if(isset($tim) && in_array($_SESSION['id_pegawai'],$tim)){

  	$is_tim = TRUE;
  }


$admin_bkpp = mysqli_query($mysqli,"select * from user_roles where role_id = 0");

while($row = mysqli_fetch_array($admin_bkpp)){
	$tim_admin[] = $row[0];
}

if(is_array(@$tim_admin) && in_array($_SESSION['id_pegawai'],@$tim_admin)){

	$is_administrator = TRUE;	//ini
}

$admin_absen = mysqli_query($mysqli,"select * from user_roles where role_id = 7");

while($row = mysqli_fetch_array($admin_absen)){
	@$tim_absen[] = $row[0];
}

if(in_array($_SESSION['id_pegawai'],@$tim_absen)){

	$is_admin_absen = TRUE;
}

$admin_bpkad = mysqli_query($mysqli,"select * from user_roles where role_id = 8");

while($row = mysqli_fetch_array($admin_bpkad)){
	$tim_bpkad[] = $row[0];
}

if(in_array($_SESSION['id_pegawai'],@$tim_bpkad)){

	$is_admin_bpkad = TRUE;
}

$qu=mysqli_query($mysqli,"select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru, unit_kerja.id_skpd
					from current_lokasi_kerja
					inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
					where id_pegawai=$ata[id_pegawai]");
$unit = mysqli_fetch_array($qu);

?>



<div class="row-fluid">
	<div class="col-md-1 hidden-xs hidden-sm hidden-print">
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
		<nav class="navbar  navbar-default " role="navigation" style="background-color: rgba(14,24,92,0.80)" >
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
								<li class="dropdown-submenu"><!--a  href="<?php echo BASE_URL ?>admin">	Admin</a-->
									<a tabindex="-1" href="#">Daftar Pegawai</span></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URL ?>index3.php?x=list2.php">Daftar PNS</a></li>
										<li><a href="<?php echo BASE_URL ?>index3.php?x=list2_plt.php">Daftar Pejabat Plt/Plh</a></li>
                    <li><a href="<?php echo BASE_URL ?>index3.php?x=list2_nonpns2.php">Daftar Pegawai NON PNS</a></li>
										<li>
											<a href="<?php echo BASE_URL ?>index3.php?x=listx.php">Daftar Pegawai NON AKTIF</a>
										</li>
										<li>
											<a href="<?php echo BASE_URL ?>index3.php?x=listnondik.php">Daftar Pegawai Blm Ada Data Diklat</a>
										</li>

                                        <li>
											<a href="<?php echo BASE_URL ?>index3.php?x=listnonskp.php">Daftar Pegawai Blm Mengisi SKP</a>
										</li>

                                         <li>
											<a href="<?php echo BASE_URL ?>index3.php?x=listanak.php">Daftar Anak Pegawai >21 Tahun</a>
										</li>

										<li>
											<a href="<?php echo BASE_URL ?>index3.php?x=list_keluarga_pegawai.php">Data Kekeluargaan Pegawai</a>
										</li>
										<?php if($_SESSION['profil']->id_pegawai == '11301'){ ?>
											<li>
												<a href="<?php echo BASE_URL ?>index3.php?x=listx2.php">Daftar Pegawai NON AKTIF2</a>
											</li>
										<?php } ?>
									</ul>
								</li>
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">Statistik</span></a>
									<ul class="dropdown-menu">
										<li><a href="<?php echo BASE_URL ?>index3.php?x=stkcuti.php">Statistik Cuti</a></li>
										<li><a href="<?php echo BASE_URL ?>index3.php?x=stkptk.php">Statistik PTK</a></li>
									</ul>
								</li>

								<!--li><a  href="<?php //echo BASE_URL ?>admin/index.php?page=duk2017">DUK 2017 </a-->
								</li>
								<li><a  href="<?php echo BASE_URL ?>index3.php?x=listos.php">

										Daftar Telp Pegawai
									</a>
								</li>

								<li><a  href="<?php echo BASE_URL ?>index3.php?x=listpen.php">

										Daftar Pendidikan Pegawai
									</a>
								</li>
								<!--<li><a  href="<?php //echo BASE_URL ?>index3.php?x=cuti_admin.php">

										Administrasi Cuti
									</a>
								</li>-->



								<?php if($unit['id_unit_kerja'] == 4216){?>
									<li><a  href="<?php echo BASE_URL ?>index3.php?x=ibe.php&y=l">

											Ijin Belajar
										</a>
									</li>
								<?php }else{ ?>

									<li><a  href="<?php echo BASE_URL ?>index3.php?x=ijinbelajar.php">

											Ijin Belajar
										</a>
									</li>
                                <?php } ?>
                                <li><a  href="<?php echo BASE_URL ?>index3.php?x=listabsensi.php">

										Input Absensi Harian
									</a>
								</li>

								<!--li><a  href="<?php echo BASE_URL ?>index3.php?x=alur.php">

										Alur Ijin Belajar Online
									</a>
								</li>
								<li><a  href="<?php echo BASE_URL ?>index3.php?x=tutorial.php">

										Tutorial Ijin Belajar Online
									</a>
								</li-->

								<!--li><a  href="<?php echo BASE_URL ?>index3.php?x=list_by_subid.php">

										Hirarki Kepegawaian
									</a>
								</li-->
								<li><a  href="<?php echo BASE_URL ?>index3.php?x=list_pensiun.php">

										Daftar Pensiun
									</a>
								</li>
								<li><a  href="<?php echo BASE_URL ?>index3.php?x=absensi.php">

										Absensi Kepegawaian
									</a>
								</li>
								<li><a  href="<?php echo BASE_URL ?>index3.php?x=verifikasi_berkas_list.php">

										Verifikasi Berkas Pegawai
									</a>
								</li>

                                <li><a  href="<?php echo BASE_URL ?>index3.php?x=request_diklat.php">
										Permohonan Kebutuhan Diklat
									</a>
								</li>
								<li><a  href="<?php //echo BASE_URL ?>index3.php?x=kenaikan_pangkat.php">
										Penjagaan Prediksi Kenaikan Pangkat
									</a>
								</li>
								<li class="divider"></li>
								<li><a href="<?php echo BASE_URL ?>index3.php?x=list_tim_skpd.php"><span class="glyphicon glyphicon-list"></span>  Daftar Pengelola Kepegawaian</a></li>

								<li><a href="<?php echo BASE_URL ?>index3.php?x=jfu_list.php"><span class="glyphicon glyphicon-leaf"></span>  Daftar Nama JFU</a></li>
							</ul>
						</li>
					<?php } ?>
					<!-- end tim OPD menu -->
					<?php if(@$is_admin_absen){ ?>
						<li class="dropdown">
							<a href="#"class="dropdown-toggle" data-toggle="dropdown">Absensi<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
								<a  href="<?php echo BASE_URL ?>index3.php?x=listabsensi.php">
									<span class="glyphicon glyphicon-th"></span>
									Input Absensi Harian
								</a>
								</li>
								<li>
									<a  href="<?php echo BASE_URL ?>index3.php?x=absensi.php">
										<span class="glyphicon glyphicon-th"></span>
										Rekapitulasi Waktu Kehadiran
									</a>
								</li>
							</ul>
						</li>
					<?php } ?>

					<?php if(@$is_admin_bpkad){ ?>
						<li class="dropdown">
							<a href="#"class="dropdown-toggle" data-toggle="dropdown">Keuangan<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a  href="<?php echo BASE_URL ?>index3.php?x=ptk_keu_mismatch.php&y=simpeg">
										<span class="glyphicon glyphicon-th"></span>
										Peninjauan Data Kepegawaian SIMPEG
									</a>
								</li>
								<li>
									<a  href="<?php echo BASE_URL ?>index3.php?x=ptk_keu_mismatch.php&y=simgaji">
										<span class="glyphicon glyphicon-th"></span>
										Peninjauan Data Kepegawaian SIMGAJI
									</a>
								</li>
								<li>
									<a  href="<?php echo BASE_URL ?>index3.php?x=ptk_histgaji_gapok.php">
										<span class="glyphicon glyphicon-th"></span>
										Mutasi Gaji Pokok
									</a>
								</li>
								<li>
									<a  href="<?php echo BASE_URL ?>index3.php?x=ptk_keu_usulan.php">
										<span class="glyphicon glyphicon-th"></span>
										Mutasi Tunjangan Jiwa (Keluarga)
									</a>
								</li>
								<!--<li>
									<a  href="<?php //echo BASE_URL ?>index3.php?x=ptk_histgaji_eselon.php">
										<span class="glyphicon glyphicon-th"></span>
										Mutasi Tunjangan Jabatan Struktural (Eselon)
									</a>
								</li>
								<li>
									<a  href="<?php //echo BASE_URL ?>index3.php?x=ptk_histgaji_fungsional.php">
										<span class="glyphicon glyphicon-th"></span>
										Mutasi Tunjangan Jabatan Fungsional
									</a>
								</li>-->
							</ul>
						</li>
					<?php } ?>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a  href="<?php echo BASE_URL ?>index3.php?x=rekap_peg_opd.php">
									<span class=""></span>
									Rekap Pegawai per Perangkat Daerah
								</a>
							</li>
							<li><a  href="<?php echo BASE_URL ?>index3.php?x=statistik.php">
									<span class=""></span>
									Statistik PNS
								</a>
							</li>
							<li><a  href="<?php echo BASE_URL ?>index3.php?x=statistiknonpns.php">
									<span class=""></span>
									Statistik NON PNS
								</a>
							</li>
							<!--li class="divider"></li>
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
							</li-->
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
							<li><a href="<?php echo BASE_URL ?>organigram2.php" target="_blank">Organigram</a></li>
													</ul>
					</li>
					<li class="dropdown">
						<a href="#"class="dropdown-toggle" id="informasi" data-toggle="dropdown">Informasi<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<!--li><a  href="<?php echo BASE_URL ?>index3.php?x=tutorial.php">
									<span class="glyphicon glyphicon-th"></span>
									Tutorial Ijin Belajar Online
								</a>
							</li-->
							<?php
							$qib=mysqli_query($mysqli,"select count(*) from ijin_belajar where id_pegawai=$_SESSION[id_pegawai] ");
							$ada=mysqli_fetch_array($qib);
							if($ada[0]>0)
							{
								?>

								<li><a href="<?php echo BASE_URL ?>index3.php?x=statusib.php">Status Ijin Belajar</a></li>
							<?php }                    ?>


							<li><a href="<?php echo BASE_URL ?>index3.php?x=kgb.php">Penjagaan Kenaikan Gaji Berkala (KGB)</a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=dini.php">Pensiun</a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=impassing.php">Peninjauan Masa Kerja</a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=kartu.php">Karpeg, Karis/Karsu dan Taspen</a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=belajar.php">Tugas/Ijin Belajar dan Pencantuman Gelar</a></li>

              <li><a href="javascript:void(0)" onclick="get_berkas_downloads('panduan_kp');">Panduan Pemberkasan KP</a></li>
              <li><a href="<?php echo BASE_URL ?>index3.php?x=listproper.php">Daftar Proyek Perubahan</a></li>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#"class="dropdown-toggle" data-toggle="dropdown">Layanan Online<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo BASE_URL ?>modul/skp">Penilaian Prestasi Kerja PNS</a></li>
							<!--<li class="divider"></li>
							<li><a href="<?php //echo BASE_URL ?>index3.php?x=pkp.php&idp=<?php //echo $_SESSION[id_pegawai]; ?>">Pengajuan Kenaikan Pangkat</a></li>
							<li class="divider"></li>
							<li><a href="<?php //echo BASE_URL ?>index3.php?x=cuti.php">Cuti</a></li>
						  <li><a href="<?php //echo BASE_URL ?>index3.php?x=alur.php">Alur Pengajuan Cuti</a></li>
						  <li><a href="<?php //echo BASE_URL ?>index3.php?x=form_alih_tugas.php">Alih Tugas</a></li> -->
							<!--<li><a href="<?php //echo BASE_URL ?>index3.php?x=form_alih_tugas.php">Perubahan Keluarga</a></li>-->
              <li><a href="<?php echo BASE_URL ?>index3.php?x=ptk.php">Perubahan Tunjangan Keluarga</a></li>
							<li><a href="<?php echo BASE_URL ?>index3.php?x=cuti_format_baru.php">Cuti Pegawai</a></li>
                            <li><a href="<?php echo BASE_URL ?>index3.php?x=form_pensiun.php">Pengajuan Pensiun Online (POL)</a></li>
              <li><a href="<?php echo BASE_URL ?>index3.php?x=absen_lapor.php">Lapor Absen</a></li>
              <!--li><a href="<?php //echo BASE_URL ?>modul/pak">Penilaian Angka Kredit JFT</a></li-->
                <?php if($_SESSION['id_pegawai'] == 11301 || 4314){ ?>
								<li><a href="<?php // echo BASE_URL ?>index3.php?x=sipohan.php">Sipohan Pinter</a></li>
							<?php } ?>
              <?php
							if($is_proper or $mentor[0]>0){
							  ?>
                <li><a href="<?php echo BASE_URL ?>modul/apresiasiproper">Apresiasi Proper</a></li>
                <?php
				        }
			         	?>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#"class="dropdown-toggle" data-toggle="dropdown">Download <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo BASE_URL ?>index3.php?x=peraturan.php">Peraturan Kepegawaian</a></li>
              <li><a href="<?php echo BASE_URL ?>index3.php?p=download">Dokumen Kepegawaian</a></li>
							<!--li><a href="<?php echo BASE_URL ?>downloads/~pranatakomputer" target="_blank">Sosialisasi Pranata Komputer</a></li-->
							<!--li><a href="<?php echo BASE_URL ?>index3.php?p=download">Lain-lain <span class="badge">1</span></a></li>
							<!--li><a target="_blank"  href="<?php // echo BASE_URL ?>/downloads/SimpegMobileAndroid.apk">Simpeg Mobile Android</a></li -->
							<!--li><a target="_blank"  href="<?php echo BASE_URL ?>/downloads/DynamicWebTWAIN11.0Trial.exe">TWAIN Driver scanner</a></li-->
						</ul>
					</li>
          <li class="dropdown">
						<a href="#"class="dropdown-toggle" data-toggle="dropdown">Kuesioner <b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li><a href="<?php echo BASE_URL ?>index3.php?x=kuesioner.php">Kuesioner Pelayanan SIMPEG</a></li>
            <li><a href="<?php echo BASE_URL ?>index3.php?x=spm.php">Kuesioner Pelayanan Kepegawaian</a></li>
          
             <li><a href="<?php echo BASE_URL ?>index3.php?x=spk.php#que1">Kuesioner Pengembangan Kompetensi</a></li>
             
           
							<!--li><a target="_blank"  href="<?php // echo BASE_URL ?>/downloads/SimpegMobileAndroid.apk">Simpeg Mobile Android</a></li -->
						</ul>
					</li>
					<!--li>
						<div>
						<a class="navbar-brand" href="#">
							<span id="msg-icon" class="glyphicon glyphicon-envelope">
								<div id="load_notif" class="counter" style="display:none">0</div>
								</span>
							</a>
							<div id="notificationContainer">
								<div id="notificationTitle">Notifikasi</div>
								<div id="notificationsBody"><div id="divInformasiNotifikasi"></div></div>
								<div id="notificationFooter"><span onclick="goto_notif_list();" style="cursor: pointer;">Lihat Semua</span></div>
							</div>
						</div>
					</li-->
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
							<li><a href="<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $_SESSION['id_pegawai']; ?>"><span class="glyphicon glyphicon-user"></span>  Edit Data Profil </a></li>
							<li class="divider"></li>

							<li><a href="#" onclick="login_kegiatan()"><span class="glyphicon glyphicon-pencil"></span>  Kegiatan</a></li>

							<li><a href="<?php echo BASE_URL ?>index3.php?x=ganti_password.php"><span class="glyphicon glyphicon-lock"></span>  Ubah Password</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo BASE_URL ?>logout.php?id=<?php echo $_SESSION['id_pegawai'] ?>"><span class="glyphicon glyphicon-log-out"></span>  Log out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
			<!--/div> /.container-fluid -->
			<!--/div-->
		</nav>
	</div>
</div>

<style>
	@keyframes notiny-animation-show-wtf {
		0% {
			opacity: 0;
			filter: blur(4px);
		}
		15% {
			opacity: 1;
		}
		50% {
		}
		90% {
			filter: blur(0px);
		}
		100% {
		}
	}
</style>
<script type="text/javascript">
	function login_kegiatan(){
		url = "<?php echo HTTP_HOST.'/digitaloffice/index.php/welcome/masuq' ?>"
		$.post(url,{
			userx:"<?php echo $_SESSION['nip_baru'] ?>",
			passx: "<?php echo $_SESSION['passx'] ?>",

		})
		.done(function(e){
			//alert(e);
			//window.open(url,'_blank');
			window.location.replace(url);
		});
	}

</script>

<script>
	$(document).ready(function()
	{
	$(document).click(function()
	{
		$("#notificationContainer").hide();
	});

	$("#notificationContainer").click(function()
	{
		return false
	});

	$(function() {
		var thetitle = $('title').text();
		var countNotif = parseInt($('.counter').text());
		var newcountNotif = 0; //++countNotif
		var hasil, jml = '';
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "class/cls_ajax_data.php?filter=load_notifikasi&idp=" + <?php echo $user;?>,
			success: function (results) {
				countNotif = parseInt($('.counter').text());
				$.each(results, function(k, v){
					hasil = v.hasil;
					jml = v.jumlah;
				});
			}
		}).done(function(){
			newcountNotif = parseInt(countNotif)+parseInt(jml);
			$('.counter').text(newcountNotif).show();
			$('title').text('(' + newcountNotif + ') ' + thetitle);
		});

		/*var auto_refresh = setInterval(
				function()
				{
					$.ajax({
						type: "GET",
						dataType: "json",
						url: "class/cls_ajax_data.php?filter=load_notifikasi&idp=" + <?php echo $user;?>,
						success: function (results) {
							countNotif = parseInt($('.counter').text());
							var hasil, jml = '';
							$.each(results, function(k, v){
								hasil = v.hasil;
								jml = v.jumlah;
							});
							if(parseInt(countNotif)!=parseInt(jml)){
								if((parseInt(jml) - parseInt(countNotif)) > 0){
									newcountNotif = parseInt(countNotif)+(parseInt(jml) - parseInt(countNotif));
									$.notiny({ text: "Ada pemberitahuan baru", position: 'right-top', theme: 'mytheme'});
								}else{
									newcountNotif = parseInt(countNotif)-(parseInt(countNotif)-parseInt(jml));
								}
							}
							$('.counter').text(newcountNotif).show();
							$('title').text('(' + newcountNotif + ') ' + thetitle);
						}
						}).done(function(){
					});
				}, 10000); */

		$('#msg-icon').click(function () {
			$('#msg-icon').removeClass('glyphicon glyphicon-envelope').addClass('glyphicon glyphicon-envelope');
			$('.counter').hide();
			$('title').text(thetitle);
			$("#notificationContainer").fadeToggle(300);
			$("#notification_count").fadeOut("slow");
			$("#divInformasiNotifikasi").html('Loading...');
			$.ajax({
				type: "GET",
				url: "notifikasi_msg.php?idp="+ <?php echo $user;?>,
				success: function (data) {
					$("#divInformasiNotifikasi").html(data);
				}
			}).done(function(){

			});
			return false;
		})
	});
	});

	function goto_notif_list(){
		var url = "/simpeg/index3.php?x=notifikasi_list_all.php";
		location.href = url;
	}
</script>
<script>
	/*$('.notif').click(function () {
		var countNotif = parseInt($('.counter').text());
		var newcountNotif = ++countNotif;
		$('.counter').text(newcountNotif).show();
		$('title').text('(' + newcountNotif + ') ' + thetitle);
	});*/
    function get_berkas_downloads(berkas){
        var nmberkas = '';
        if(berkas == 'panduan_kp'){
            nmberkas = 'PANDUAN PEMBERKASAN KENAIKAN PANGKAT.docx';
        }
        window.open('http://103.14.229.15/simpeg/downloads/' + nmberkas,'_blank');
    }
</script>
<!--<div class="notif">Insert Notif</div>-->
<script src="js/notify/notiny.js"></script>
<link rel="stylesheet" href="js/notify/notiny.css">

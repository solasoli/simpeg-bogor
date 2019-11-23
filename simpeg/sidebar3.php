
<div id="sidebar">
	<ul class="sidebar-nav">

			<?php

					if (file_exists("./foto/$_SESSION[id_pegawai].jpg"))
						echo "<img src='./foto/$_SESSION[id_pegawai].jpg?".time()."' width=100 hspace=10 id='photobox'/>";
					else if (file_exists("./foto/$_SESSION[id_pegawai].JPG"))
						echo "<img src='./foto/$_SESSION[id_pegawai].JPG?".time()."' width=100 hspace=10 id='photobox'/>";

				?>



			<li>

				<h2>Rekapitulasi Kepegawaian</h2>

					<ul class="sidebar-nav">
					<li><a href="index3.php?x=rekap.php"><div id="menu_bg">Rekap Pegawai</div></a></li>
					<li><a href="index3.php?x=rekapskpd.php"><div id="menu_bg">Rekap Pegawai Per Perangkat Daerah</div></a></li>
					<li><a href="index3.php?x=rekapfungsional.php"><div id="menu_bg">Rekap Pejabat Fungsional</div></a></li>
					<li><a href="index3.php?x=daftar_pejabat_fungsional_umum.php"><div id="menu_bg">Rekap Pelaksana</div></a></li>
					<li><a href="index3.php?x=statistik2.php"><div id="menu_bg">Statistik</div></a></li>
					<li><a href="index3.php?x=statistik.php"><div id="menu_bg">Statistik Perangkat Daerah</div></a></li>
					</ul>
					<hr />

			</li>

			<!--li>

				<h2>Informasi Kepegawaian</h2>

					<ul class="sidebar-nav">
					<li><a href="index3.php?x=dini.php"><div id="menu_bg">Pensiun</div></a></li>
                    <li><a href="index3.php?x=impassing.php"><div id="menu_bg">Persyaratan PMK</div></a></li>
					<li><a href="index3.php?x=kartu.php"><div id="menu_bg">Karpeg, Karisu dan Taspen</div></a></li>
					<li><a href="index3.php?x=belajar.php"><div id="menu_bg">Ijin Belajar, Tugas Belajar dan Pencantuman Gelar</div></a></li>
					<!--<li><a href="index3.php?x=box.php&od=<? //echo $_SESSION[id_pegawai] ?>" ><div id="menu_bg">Kelengkapan Berkas</div></a></li>>
					</ul>
					<hr />
			</li-->

			<!--<li>

				<h2>Download</h2>
				<ul class="sidebar-nav" >
					<li><a href="index3.php?x=peraturan.php"><div id="menu_bg">Peraturan Kepegawaian</div></a></li>
					<li><a href="./format/skum.doc" target="_blank"><div id="menu_bg">Format SKUM-PTK</div></a></li>

					<li><a href="./upload/Kamus_Jabatan_jfu.xls" target="_blank"><div id="menu_bg">Kamus JFU<span class="label label-important">New</span></div></a></li>

					<li><a href="./downloads/Form_A.pdf" target="_blank"><div id="menu_bg">FORM LHKPN A <span class="label label-important">New</span></div></a></li>
					<!--<li><a href="./downloads/mat_pro.zip" target="_blank"><div id="menu_bg">Materi Proyeksi<span class="label label-important">New</span></div></a></li>
					<li><a href="./downloads/k2.txt" target="_blank"><div id="menu_bg">Database Tenaga Honorer K2<span class="label label-important">New</span></div></a></li>
					<!--li><a href="./format/un_agus_2014.pdf" target="_blank" style=":'red'"><div id="menu_bg">Undangan TIM SIMPEG OPD AGS 2014 <span class="btn btn-danger">New</span></div></a>
					<li><a href="./downloads/alamat_kosong.xlsx" target="_blank"><div id="menu_bg">Alamat Kosong<span class="label label-important">New</span></div></a></li>
				</ul>
				<hr />
			</li></li-->


			<li>
				<h2>Menu</h2>
				<ul class="sidebar-nav">

					 <li><a href="index3.php"><div id="menu_bg">Beranda</div></a></li>

                    <!--<li><a href="index3.php?x=home2.php"><div id="menu_bg">Data Pribadi</div></a></li>-->
					<li><a href="index3.php?x=box.php&od=<? echo $_SESSION[id_pegawai] ?>" ><div id="menu_bg">Data Pegawai</div></a></li>
                    <!--<li><a href="index3.php?x=diklat.php"><div id="menu_bg">Pendidikan dan Pelatihan</div></a></li>

					<!--li><a href="index3.php?x=riwayat_kerja.php"><div id="menu_bg">Riwayat Pekerjaan</a></div></li-->
					<!--<li><a href="index3.php?x=riwayat_ker.php"><div id="menu_bg">Riwayat Kerja</a></div></li>-->

					<li><a href="index3.php?x=penghargaan.php"><div id="menu_bg">Penghargaan</div></a></li>

					<li><a href="index3.php?x=sertifikat.php"><div id="menu_bg">Sertifikat</div></a></li>
					<?php
						if($is_tim){
					?>


					<? }

else
//echo("<li><div id=menu_bg> <a href=index3.php?x=fox.php&od=$_SESSION[id_pegawai]>Berkas Digital </a></div>  </li>");
?>
 					<!--<li><a href="index3.php?x=cpns.php"><div id="menu_bg">Grafik Pemberkasan Digital</div></a></li>--->
					<!--<li><a href="index3.php?x=formkeluarga.php"><div id="menu_bg">Keluarga</div></a></li>-->

					<!--<li><a href="index3.php?x=cekkgb.php&id=<?

						$qid=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]'");

					$nod=mysqli_fetch_array($qid);
					echo($nod[0]); ?>"><div id="menu_bg">Kenaikan Gaji Berkala</div></a></li> -->
			<?

			include("konek.php");

			$qc=mysqli_query($mysqli,"select count(*) from pegawai where (nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]') and  (jabatan  like '%kasi%' or jabatan  like '%subag%' or jabatan  like '%subid%') ");

			//echo("select count(*) from pegawai where (nip_lama='$_SESSION[user]' or nip_baru='_SESSION[user]') and  (jabatan  like '%kasi%' or jabatan  like '%subag%' or jabatan  like '%subid%') ");

			$cek=mysqli_fetch_array($qc);


			?>



					<li><a href="index3.php?x=nominatif_pejabat.php"><div id="menu_bg">Nominatif Pejabat Struktural</div></a></li>
					<?

					include("konek.php");



					$k=mysqli_query($mysqli,"select unit_kerja.id_unit_kerja,pegawai.id_pegawai from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where pegawai.id_pegawai=$nod[0] order by id_riwayat desc");

					$ko=mysqli_fetch_array($k);

					?>
					<!-- <li><a href="stroke.php?u=<? echo($ko[0]);?>" target="_blank"><div id="menu_bg">Struktur Organisasi</div></a></li> -->
					<li><a href="organigram.php" target="_blank"><div id="menu_bg">Struktur Organisasi</div></a></li>

					<? if($_SESSION['user']=='197403171994032003' or $_SESSION['user']=='198205212006042020' )

					echo("<li><div id=menu_bg><a href=pegawai.php?us=$_SESSION[user] target=_blank>Mutasi Jabatan</a></div></li> ");

					elseif($_SESSION['user']=='195810241986032005' or $_SESSION['user']=='480099533')

					echo("<li><a href=index3.php?x=analisis.php&&\	us=$_SESSION[user] target=_blank>Analisis Pegawai</a></li> ");

					elseif($_SESSION['user']=='196306071985031018' or $_SESSION['user']=='480140284' or $_SESSION['user']=='260004957')

					//echo("<li><a href=adminkp.php?us=$_SESSION[user] target=_blank><div id=menu_bg>Pengajuan Kenaikan Pangkat</div></a></li> ");

					?>


				</ul>

			</li>


		</ul>
		</br>
		<p>
		<b>SIMPEG Kota Bogor</b> <br>
		simpeg.kotabogor@gmail.com <br>
		SMS 0857 7138 5222 <br>
		Copyright &copy <?php echo date('Y') ?> BKPP
		<p>
	</div>



	<!-- end #sidebar -->




<!-- end #page -->

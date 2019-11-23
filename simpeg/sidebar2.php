

</div>

<style type="text/css">

<!--

#Layer1 {

	position:absolute;

	left:300px;

	top:214px;

	width:250px;

	height:385px;

	z-index:1;

	background-color: #FFFFFF;

	visibility: hidden;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style>

<script type="text/JavaScript">

<!--

function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_showHideLayers() { //v6.0

  var i,p,v,obj,args=MM_showHideLayers.arguments;

  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];

    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }

    obj.visibility=v; }

}

//-->

</script>



	<div id="sidebar">
		<div>
		<iframe src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlqf6pvcc2bi4tnlatl31j7d4i30ir5sl99fbr1ujf9sghmp60lncl558tvob24vlhhvrrc0cb3cljh76bjlrgmi751284egng00n6havtojuldmj8sivggnqbjus143o1bauiiu150gikdvfg2jj9k4dn4s2fp8le55tpicb3gd1e3qpv4dmtbupfo6g&amp;w=200&amp;h=60" allowtransparency="true" width="200" frameborder="0" height="60"></iframe>
		</div>
		<?php 

			if (file_exists("./foto/$ata[0].jpg")) 
				echo("<img src=./foto/$ata[0].jpg width=100 hspace=10 id='photobox'/>");
			else if (file_exists("./foto/$ata[0].JPG")) 
				echo("<img src=./foto/$ata[0].JPG width=100 hspace=10 id='photobox'/>"); 

		?>


		<br/>

		<br/>

		<ul>

			<li id="search">

				<h2>Notifikasi</h2>

				<? include "notifikasi.php"; ?>

			</li>

			<li id="search">

				<h2>Pencarian</h2>

				<form action="index2.php?x=search.php" method="post" name="searchform" id="searchform">

					<div>

					<?

					$s=$_REQUEST['s'];

					

					

					?>

					  <input name="s" type="text" id="s" onkeyup="javascript:document.searchform.submit();" size="15" <? if($s!=NULL)  

					  echo("value=$s"); ?> style="border:#999999 solid 1px;height:27px; font-weight:bold" />

						<input name="submit" type="submit" value="" style="background-image:url(images/search-icon.png); background-repeat: no-repeat; border:#999999 1px solid; width: 40px; height: 27px; position: relative; left:-5px; top: 1px;" />

					</div>
					<div align="left" > <a href="index2.php?x=advance.php">Pencarian Spesifik </a></div>

			  </form>

			</li>

			<? if($_SESSION['user']=='198602222009021001')

			{?>

			<li>

				<h2>Internal</h2>

					<ul>

					<li><a href='daftar_pejabat.html' target=_blank><div id="menu_bg">Daftar Pejabat</div></a></li>
					<li><a href='index2.php?x=rekap.php' target=_blank><div id="menu_bg">Rekapitulasi</div></a></li>

					</ul>

					<hr />

			</li>

			<?php

			}

			?>
			
			<li>

				<h2>Pengumuman</h2>

					<ul>

					<li><a href="index2.php?x=beasiswa.php"><div id="menu_bg">Beasiswa</div></a></li>
					

					</ul>

					<hr />

			</li>
			
			<li>

				<h2>Administrasi</h2>

					<ul>

					<li><a href="index2.php?x=dini.php"><div id="menu_bg">Pensiun</div></a></li>
					<li><a href="./format/skum.doc" target="_blank"><div id="menu_bg">Format SKUM-PTK</div></a></li>
					<li><a href="./format/formsimpeg.doc" target="_blank"><div id="menu_bg">Form Isian SIMPEG</div></a></li>

					</ul>

					<hr />

			</li>
			<li>

				<h2>Menu</h2>

				<ul>

					</br>

					  <li><a href="index2.php"><div id="menu_bg">Beranda</div></a></li>

                    <li><a href="index2.php?x=home2.php"><div id="menu_bg">Data Pribadi</div></a></li>

                    <li><a href="index2.php?x=diklat.php"><div id="menu_bg">Pendidikan dan Pelatihan</div></a></li>

					<li><a href="index2.php?x=riwayat_kerja.php"><div id="menu_bg">Riwayat Pekerjaan</a></div></li>
					
					<li><a href="index2.php?x=penghargaan.php"><div id="menu_bg">Penghargaan</div></a></li>

					<li><a href="index2.php?x=sertifikat.php"><div id="menu_bg">Sertifikat</div></a></li>
					
					<li><a href="index2.php?x=sk.php"><div id="menu_bg">SK</div></a></li>

					<li><a href="index2.php?x=formkeluarga.php"><div id="menu_bg">Keluarga</div></a></li>

			<?

			include("konek.php");

			$qc=mysql_query("select count(*) from pegawai where (nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]') and  (jabatan  like '%kasi%' or jabatan  like '%subag%' or jabatan  like '%subid%') ");

			//echo("select count(*) from pegawai where (nip_lama='$_SESSION[user]' or nip_baru='_SESSION[user]') and  (jabatan  like '%kasi%' or jabatan  like '%subag%' or jabatan  like '%subid%') ");

			$cek=mysql_fetch_array($qc);

		/*	if($cek[0]>0)

			echo("<li><a href=index2.php?x=nilai.php>Penilaian Pegawai</a></li>");

			else

			echo("<li><a href=index2.php?x=nilai2.php>Absensi</a></li>");

			*/

			?>

					<li><a href="index2.php?x=statistik.php"><div id="menu_bg">Statistik</div></a></li>

					<?

					include("konek.php");

					$qid=mysql_query("select id_pegawai from pegawai where nip_lama='$_SESSION[user]' or nip_baru='$_SESSION[user]'"); 

					$nod=mysql_fetch_array($qid);

					$k=mysql_query("select unit_kerja.id_unit_kerja,pegawai.id_pegawai from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where pegawai.id_pegawai=$nod[0] order by id_riwayat desc");

					$ko=mysql_fetch_array($k);

					?>

					<li><a href="stroke.php?u=<? echo($ko[0]);?>" target="_blank"><div id="menu_bg">Struktur Organisasi</div></a></li>

					<? if($_SESSION['user']=='197403171994032003' or $_SESSION['user']=='480140284' )

					echo("<li><a href=pegawai.php?us=$_SESSION[user] target=_blank>Mutasi Jabatan</a></li> ");

					elseif($_SESSION['user']=='195810241986032005' or $_SESSION['user']=='480099533 ')

					echo("<li><a href=index2.php?x=analisis.php&&\	us=$_SESSION[user] target=_blank>Analisis Pegawai</a></li> ");

					?>

					

					<li><a href="index2.php?x=ganti_password.php"><div id="menu_bg">Ganti Password</div></a></li>

                    <li><a href="logout.php?id=<? echo($nod[0]); ?>"><div id="menu_bg">Keluar</div></a></li>

				</ul>

			</li>

		</ul>

	</div>

<iframe name="online" src="online.php?id=<? 

echo("$nod[0]");  ?>" frameborder="0" scrolling="auto" width="100%" /></iframe>
	<!-- end #sidebar -->


</div>

<!-- end #page -->
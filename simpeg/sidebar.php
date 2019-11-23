
<div class="panel panel-default">
	<div class="panel-heading "style="background-color: rgba(14,24,92,0.80)">
		<span class="left" >.: PROFIL</span>
		<a class="right">
		<span class="glyphicon glyphicon-pencil"></span>
		</a>
	</div>
  <div class="panel-body text-center" >

	<div>
		<?php

		if (file_exists("./foto/$_SESSION[id_pegawai].jpg"))
			echo "<img src='./foto/$_SESSION[id_pegawai].jpg?".time()."' width=100 hspace=10 id='photobox'/>";
		else if (file_exists("./foto/$_SESSION[id_pegawai].JPG"))
			echo "<img src='./foto/$_SESSION[id_pegawai].JPG?".time()."' width=100 hspace=10 id='photobox'/>";


	?>
	</div>

	<br>
	<table class="table table-unborder text-left">
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><div id="profilNama"><div class="loader">Loading...</div></div></td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>:</td>
			<td><div id="profilNip"><div>Loading...</div></div></td>
		</tr>
		<tr>
			<td>TTL</td>
			<td>:</td>
			<td><div id="profilTtl"><div >Loading...</div></div></td>
		</tr>
		<tr>
			<td>Pangkat/Gol</td>
			<td>:</td>
			<td><div id="profilPangkatGol"><div >Loading...</div></div></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td>
				<div id="profilJabatan"><div >Loading...</div></div>
				<?php //echo $_SESSION['profil']->jabatan ?>
                <?php echo(@$_SESSION['profil']->is_kepsek==1?' dan Kepala Sekolah':'')?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td>:</td>
			<td><div id="profilOpd"><div >Loading...</div></div></td>
		</tr>

        <?php

		if(@$_SESSION['profil']->jenjab=='Struktural')
		{
		$qpen=mysqli_query($mysqli,"select max from pendidikan_terakhir inner join pendidikan_puncak on pendidikan_terakhir.level_p=pendidikan_puncak.level_p where id_pegawai=$_SESSION[id_pegawai]");
		$pen=mysqli_fetch_array($qpen);



		$qmax=mysqli_query($mysqli,"select id_golongan from golongan where golongan like '$pen[0]'");
		$max=mysqli_fetch_array($qmax);




		$qnow=mysqli_query($mysqli,"select id_golongan from golongan where golongan like '".$_SESSION['profil']->golongan."'");
		$now=mysqli_fetch_array($qnow);

		if($_SESSION['profil']->id_j==NULL)
		{

		$qlast=mysqli_query($mysqli,"select id_kategori_sk,tmt from sk where  id_kategori_sk=5 and id_pegawai=$_SESSION[id_pegawai] order by tmt desc,id_kategori_sk limit 1");
		$last=mysqli_fetch_array($qlast);

		$thn=substr($last[1],0,4);
		$bln=substr($last[1],5,2);
		$tgl=substr($last[1],8,2);

		$taon=is_numeric($thn) ? $thn+4 : 0 ;





		$qlast=mysqli_query($mysqli,"select id_kategori_sk,tmt from sk where  id_kategori_sk=5 and id_pegawai=$_SESSION[id_pegawai] order by tmt desc,id_kategori_sk limit 1");
		$last=mysqli_fetch_array($qlast);
		$bln=substr($last[1],5,2);
		$eng=$now[0]+1;
		$qng=mysqli_query($mysqli,"select golongan from golongan where id_golongan=$eng");
		$ng=mysqli_fetch_array($qng);

        if($pen[0]==$_SESSION['profil']->golongan){
            $text = "Berds. data pendidikan terakhir, pangkat sudah mencapai batas maksimum";
        }else{
            $text="Kenaikan Pangkat Berikutnya ($ng[0]) : <br>$tgl-$bln-$taon";
        }




		}


		else
		{

		$qjab=mysqli_query($mysqli,"select gol_tertinggi from pangkat_eselon inner join jabatan on jabatan.eselon=pangkat_eselon.eselon where id_j=".$_SESSION['profil']->id_j);
		$jab=mysqli_fetch_array($qjab);


		if($jab[0]>$max[0])
		$max[0]=$jab[0];


			if($now[0]==$max[0])
		{
		$qlast=mysqli_query($mysqli,"select id_kategori_sk,tmt from sk where id_kategori_sk=9 and id_pegawai=$_SESSION[id_pegawai] order by tmt desc,id_kategori_sk limit 1");
		$last=mysqli_fetch_array($qlast);

		$thn=substr($last[1],0,4);
		$bln=substr($last[1],5,2);
		$tgl=substr($last[1],8,2);
		$taon=$thn+2;
		$text="Kenaikan Gaji Berkala Berikutnya : <br>$tgl-$bln-$taon";
		}
		else
		{

/*
		$qlast=mysqli_query($mysqli,"select id_kategori_sk,tmt from sk where ( id_kategori_sk=5 or id_kategori_sk=9 )and id_pegawai=$_SESSION[id_pegawai] order by tmt desc,id_kategori_sk limit 1");
		$last=mysqli_fetch_array($qlast);

		$thn=substr($last[1],0,4);
		$bln=substr($last[1],5,2);
		$tgl=substr($last[1],8,2);

		$taon=$thn+2;


		if($last[0]==5)
		{
		$text="Kenaikan Gaji Berkala Berikutnya : $tgl-$bln-$taon";
		$tanggal="$tgl-$bln-$taon";
		}
		else
		{
		*/

			$qlast=mysqli_query($mysqli,"select id_kategori_sk,tmt from sk where  id_kategori_sk=5 and id_pegawai=$_SESSION[id_pegawai] order by tmt desc,id_kategori_sk limit 1");

		$last=mysqli_fetch_array($qlast);

			$thn=substr($last[1],0,4);
		$bln=substr($last[1],5,2);
		$tgl=substr($last[1],8,2);
				$eng=$now[0]+1;
					$taon=$thn+4;
		$qng=mysqli_query($mysqli,"select golongan from golongan where id_golongan=$eng");
		$ng=mysqli_fetch_array($qng);

		$text="Kenaikan Pangkat Berikutnya ($ng[0]) : $tgl-$bln-$taon";

		//}
		}


		}
		}
		?>
        <tr>
        <td colspan="3">
        <?php
			echo @$text;
		?>
        </td>
        </tr>
		<tr>
			<td colspan="3">
				<script>
					$(document).ready(function()
					{

						$(function() {
							$.ajax({
								type: 'POST',
								url: '../simpeg2/index.php/kgb/json_nominatif',
								data: { idpegawai: <?php echo $_SESSION['id_pegawai'];?>,
									skpd: <?php echo $_SESSION['id_skpd'];?>,
									tahun: 0,
									bulan: 0,
									jenis: 'SIDEBAR'},
								dataType: 'json',
								success: function (data) {
									$("#txtKgbNext").html('');
									$.each(data, function(k, v){
										if(data[0].kelengkapan=='Data Tidak Lengkap'){
											status = "Berkas Tdk.Lengkap";
										}else{
											if(data[0].status_kenaikan == 'Kenaikan Pangkat'){
												status = 'Tidak KGB karena akan naik pangkat'
											}else{
												status = data[0].kgb_selanjutnya;
											}
										}
										//console.log(data);
									});
									$("#txtKgbNext").html(status);
								}
							});
						});


						$.post("../simpeg2/index.php/pegawai/json_profil", { idpegawai: <?php echo $_SESSION['id_pegawai'];?>}, function (data){

								p = JSON.parse(data);
								$("#profilNama").html(p.nama);
								$("#profilNip").html(p.nip);
								$("#profilTtl").html(p.ttl);
								$("#profilPangkatGol").html(p.pangkat+ " - "+p.golongan);
								$("#profilJabatan").html(p.jabatan);
								$("#profilOpd").html(p.opd);
						});

					});
				</script>
				Kenaikan Gaji Berkala (KGB) Berikutnya: <br> <div id="txtKgbNext"></div>
			</td>
		</tr>
	</table>
  </div>
</div>

<div id="sidebar">
	<ul class="sidebar-nav">

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






		</ul>
		</br>
		<p>
		<b>SIMPEG KOTA BOGOR</b> <br>
		simpeg.kotabogor@gmail.com <br>
		Copyright &copy <?php echo date('Y') ?> BKPSDA
		<p>
	</div>



	<!-- end #sidebar -->




<!-- end #page -->

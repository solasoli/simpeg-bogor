<?php 
	//redirect('cuti/view_surat_cuti');
	//setlocale(LC_TIME, 'ind
	//ssetlocale(LC_MONETARY, 'ind');

	date_default_timezone_set("Asia/Jakarta");
	ob_start();

?>
<html>
<body>
<div style="max-width:800px">
<br/>
<br/>
<table>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img height="100" src="<?php echo base_url()."images/logo_kota.jpg" ?>" />
		</td>
		<td>
			<strong>				
				<div style="margin-left:130px; margin-right:40px; margin-top:10px;">			
				BADAN KEPEGAWAIAN, PENDIDIKAN DAN PELATIHAN<br />
				</div>
				<div style="margin-left:200px; margin-right:40px; margin-top:10px;">
				PEMERINTAHAN KOTA BOGOR<br />
				</div>
				<div style="margin-left:100px; margin-right:40px; margin-top:10px;">	
				Jl. Ir. H. Juanda No. 10 Telp. (0251) 8358942 Fax. (0251) 8356170<br/>
				</div>
				<div style="margin-left:250px; margin-right:40px; margin-top:10px;">
				BOGOR - 16121<br/>
				</div>
			</strong>
		</td>
	</tr>
</table>

<div style="margin-left:50px; margin-right:50px;">
<table style="border-top:3px solid">
	<tr>
		<td width="100px"><div style="margin-left:400px;margin-right:300px">&nbsp;</div></td>
	</tr>
</table>
</div>

<div style="margin-left:550px; margin-right:600px;">
<?php foreach($tgl_skrng->result() as $now_db){
		$skrng = $now_db->now;
		}
		
	  $thn = substr($skrng,0,4);
	  $bulan = substr($skrng,5,2);
	  $hari = substr($skrng,8,2);
	  
	  $skrng = $hari . "-" . $bulan . "-" . $thn;
 ?>
Bogor, <?php echo $skrng; ?><br />
</div>
<br/>

<div style="margin-left:550px; margin-right:550px;">
	<u><b>SURAT IZIN CUTI</b><br/></u>
	Nomor : <br/>
</div>
<br/>

<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diberikan  untuk tahun  2015 kepada Pegawai Negeri Sipil :
</p>
<?php
	foreach($pegawai->result() as $pgw){
		$nama = $pgw->nama;
		$nip = $pgw->nip_baru;
		$pangkat = $pgw->pangkat_gol;
		$jabatan = $pgw->jabatan;
	}

	foreach($uk->result() as $uk_db){
		$unit_kerja = $uk_db->nama_baru;
	}

	foreach($cuti_cuti->result() as $cuti_db){
		$tmt_awal = $cuti_db->tmt_awal;
		$tmt_selesai = $cuti_db->tmt_selesai;
	}

	$tgl_awal = substr($tmt_awal,8,2);
	$bln_awal = substr($tmt_awal,5,2);
	$thn_awal = substr($tmt_awal,0,4);

	$tmt_awal = $tgl_awal . "-" . $bln_awal . "-" . $thn_awal;

	$tgl_akhir = substr($tmt_selesai,8,2);
	$bln_akhir = substr($tmt_selesai,5,2);
	$thn_akhir = substr($tmt_selesai,0,4);

	$tmt_selesai = $tgl_akhir . "-" . $bln_akhir . "-" . $thn_akhir;
?>

<p>
	<table>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
			<td>:</td>
			<td><?php echo $nama; ?></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIP</td>
			<td>:</td>
			<td><?php echo $nip; ?></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pangkat, Golongan Ruang</td>
			<td>:</td>
			<td><?php echo $pangkat; ?></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
			<td>:</td>
			<td><?php echo $jabatan; ?></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit Kerja</td>
			<td>:</td>
			<td><?php echo $unit_kerja; ?></td>
		</tr>
	</table>
</p>

<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selama  <?php echo $lama_cuti ?> hari kerja terhitung mulai tanggal <?php echo $tmt_awal; ?>  s/d  <?php echo $tmt_selesai; ?> dengan ketentuan sebagai berikut :
</p>

<div style="margin-left:40px;">
<ol>	
	<li>Sebelum menjalankan , wajib menyerahkan pekerjaan kepada atasan langsungnya;</li>
	<li>Setelah selesai menjalankan, wajib melaporkan diri kepada atasan langsungnya dan 
bekerja kembali <br/>
sebagaimana biasa.</li>
</ol>
</div>
<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian surat izin  ini dibuat untuk dapat digunakan sebagaimana mestinya.
</p>

<br/>
					<p align="center">An. Kepala<br/>
			,</p><br/><br/><br/><br/><br/><br/>
			
			<?php
				switch($pangkat){
					case 'I/a' : 
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/b' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/c' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/d' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/a' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/b' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/c' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/d' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'III/a' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/b' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/c' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/b' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/c' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/d' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					default :
								$ttd = "Dwi Roman Pujo Prasetyo, S.H., M.M.";
								$jbtn = "Kaban BKPP Kota Bogor";
								$pgkt = "Pembina Tk.I";
								$nip = "195807161993031001";
								break;
				}
			?>
			<p align="center"><u><?php echo $ttd; ?></u><br/>
			<br/>
			NIP. <?php echo $nip; ?> </p>
			
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tembusan disampaikan kepada :
<div style="margin-left:40px;">
<ol>
	<li>Yth. Inspektur Kota Bogor</li>
	<li>Yth. Kepala Bagian Hukum Setda Kota Bogor;</li>
	<li>Pegawai Negeri Sipil yang bersangkutan.</li>
</ol>
</div>

			
</div>
</body>	
</html>


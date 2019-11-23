<html>
<head>
	<title>SK KGB Kota Bogor</title>
	<style>
		@media print {
			.noPrint {
				display:none;
			  }
		}
		
		body{
			font-family: "Arial";			
		}
		td{
			font-size: 10pt;
		}
	</style>	
</head>
<body>
<?php 
	if(!isset($sk)) redirect('kgb/registrasi');
	setlocale(LC_TIME, 'ind');
	setlocale(LC_MONETARY, 'ind');
?>
<div class="noPrint">
<a class="noPrint" href="#" onClick="window.print()">Cetak</a> | <a class="noPrint" href="#" onClick="history.back()">Kembali</a>
</div>
<div style="min-height:4cm">&nbsp;</div>
<div style="max-width:800px; bg-color:red">
<table width="100%">	
	<tr>
		<td>Nomor</td>
		<td>:</td>
		<td><?php echo $sk->no_sk ?></td>
		<td rowspan="4">
			Bogor, <?php echo strftime('%d %B %Y', strtotime($sk->tgl_sk)); ?><br/>
			Kepada<br/>
			Yth. Kepala Badan Pengelolaan Keuangan <br/>dan Aset Daerah Kota Bogor</br>
			di<br/>
			<u>Bogor</u>
		</td>
	</tr>
	<tr>
		<td>Sifat</td>
		<td>:</td>
		<td>-</td>
		
	</tr>
	<tr>
		<td>Lampiran</td>
		<td>:</td>
		<td>-</td>
		
	</tr>
	<tr>
		<td>Perihal</td>
		<td>:</td>
		<td><u>Pemberitahuan Kenaikan Gaji Berkala</u></td>
		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2">
			<p>Dengan ini diberitahukan, bahwa berhubung dengan telah dipenuhinya masa kerja dan syarat-syarat lainnya kepada:</p>
			<table>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?php echo $pegawai->nama ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td>:</td>
					<td><?php echo $pegawai->tempat_lahir ?>, <?php echo strftime('%d %B %Y', strtotime($pegawai->tgl_lahir)); ?></td>
				</tr>
				<tr>
					<td>N I P</td>
					<td>:</td>
					<td><?php echo $pegawai->nip_baru ?></td>
				</tr>
				<tr>
					<td>Pangkat-Gol/Ruang</td>
					<td>:</td>
					<td><?php echo $pegawai->pangkat ?> - <?php echo $pegawai->golongan ?></td>
				</tr>
				<tr>
					<td>Unit Kerja</td>
					<td>:</td>
					<td><?php echo $pegawai->nama_baru ?></td>
				</tr>
				<tr>
					<td>Gaji Pokok Lama</td>
					<td>:</td>
					<td>Rp. <?php echo number_format($dasar_sk->gaji, 0, ',','.').",-"; ?>
					</td>
				</tr>
			</table>
			<p><strong>ATAS DASAR SKEP TERAKHIR TENTANG GAJI/PANGKAT YANG DITETAPKAN : </strong></p>
			<table>
				<tr>
					<td>Oleh</td>
					<td>:</td>
					<td><?php echo $dasar_sk->pemberi_sk ?></td>
				</tr>
				<tr>
					<td>Tanggal dan Nomor</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($dasar_sk->tgl_sk)); ?>; <?php echo $dasar_sk->no_sk ?></td>
				</tr>
				<tr>
					<td>Mulai Berlaku Tanggal</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($dasar_sk->tmt)); ?></td>
				</tr>
				<tr>
					<td>Masa Kerja Golongan</td>
					<td>:</td>
					<td><?php echo explode(',',$dasar_sk->keterangan)[1]; ?> Tahun <?php echo explode(',',$dasar_sk->keterangan)[2]; ?> Bulan</td>
				</tr>				
			</table>
			<p><strong>DIBERIKAN KENAIKAN GAJI BERKALA HINGGA MEMPEROLEH :</strong></p>
			<table>
				<tr>
					<td>Gaji Pokok Baru</td>
					<td>:</td>
					<td>Rp. <?php echo number_format($sk->gaji, 0, ',','.').",-"; ?></td>
				</tr>				
				<tr>
					<td>Mulai Berlaku Tanggal</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($sk->tmt)); ?></td>
				</tr>
				<tr>
					<td>Masa Kerja Golongan</td>
					<td>:</td>
					<td><?php echo explode(',',$sk->keterangan)[1]; ?> Tahun <?php echo explode(',',$sk->keterangan)[2]; ?> Bulan</td>
				</tr>	
			</table>
			
			<p>Diharapkan agar sesuai dengan <?php echo $sk->peraturan ?> Tahun <?php echo $sk->tahun ?> tentang 
			Perubahan <?php echo $sk->perubahan ?> atas PP Nomor 7 Tahun 1977 tentang Peraturan Gaji Pegawai Negeri Sipil,
			kepada pegawai tersebut dibayarkan penghasilan berdasarkan gaji pokok baru.</p>
			
			<p>
				Keterangan:<br/>
				a. Yang bersangkutan adalah Calon/Pegawai Negeri Sipil pada Pemerintah Kota Bogor<br/>
				b. Kenaikan Gaji Berkala yang akan datang jika memenuhi syarat-syarat yang 
				diperlukan pada tanggal: 
				<strong>
				<?php 
					echo date_format(date_add(date_create($sk->tmt),date_interval_create_from_date_string("2 years")), 'd-m-Y'); 
				?></strong><br/>
			</p>
			
			<table width="100%">
				<tr>
					<td width="50%">&nbsp;</td>
					<td align="center">
						<strong><?php 
						echo $atas_nama."<br/>";
						if(strpos(strtolower($pengesah->jabatan),'pada'))
							echo substr($pengesah->jabatan, 0, strpos(strtolower($pengesah->jabatan), 'pada')); 
						else
							echo $pengesah->jabatan;
						?></strong><br/><br/><br/><br/>
						<strong><u><?php echo strtoupper($pengesah->nama) ?></u></strong><br/>
						<?php echo $pengesah->pangkat." - ".$pengesah->pangkat_gol; ?><br/>						
						NIP. <?php echo $pengesah->nip_baru ?>
					</td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td>Tembusan</td>
		<td>:</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">
			1. Kepala Kantor Regional III BKN di Bandung;<br/>
			2. Kepala Kantor Cabang PT. TASPEN (Persero) di Bogor;<br/>
			3. Kepada Kepala Badan Kepegawaian Pendidikan dan Pelatihan Kota Bogor;<br/>
			4. Kepada yang bersangkutan;
		</td>		
	</tr>
</table>
</div>

</body>
</html>

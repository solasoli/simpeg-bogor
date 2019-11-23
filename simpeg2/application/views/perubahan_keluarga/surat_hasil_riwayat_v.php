<?php
	date_default_timezone_set("Asia/Jakarta");
	ob_start();
	
	$i = 1;
						
?>
<html>
<head></head>
<body>
<div style="margin-top:200px;margin-left:60px;">
		<div style="margin-left:480px">Bogor,<u><?php echo date('d').' '.$bulan.' '.$tahun?></u></div>
		<br/>
		<table>
			<tr>
				<td>Nomor</td>
				<td> :</td>
				<td>Isi Otomatis</td>
				<td width="170"></td>
				<td><div style="margin-left:48px;">Kepada</div></td>
			</tr>
			<tr>
				<td>Sifat</td>
				<td> :</td>
				<td></td>
				<td width="170"></td>
				<td>Yth. <div style="margin-left:25px;">Kepala Badan Pengelolaan Keuangan</div></td>
			</tr>
			<tr>
				<td>Lampiran</td>
				<td> :</td>
				<td></td>
				<td width="170"></td>
				<td><div style="margin-left:48px;">Dan Aset Daerah Kota Bogor</div></td>
			</tr>
			<tr>
				<td>Perihal</td>
				<td> :</td>
				<td><u><b>Perubahan Keluarga</b></u></td>
				<td width="170"></td>
				<td><div style="margin-left:48px;">Di -</div></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><u></u></td>
				<td width="170"></td>
				<td><div style="margin-left:85px;">B O G O R</div></td>
			</tr>
		</table>
	
		<div style="margin-left:45px;">
			<p>Dengan ini diberitahukan bahwa Pegawai Negeri Sipil yang namanya tersebut di bawah ini :
			</p>
			<div style="margin-left:30px;">
				<table>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><?php echo $data_pegawai->nama;?></td>
					</tr>
					<tr>
						<td>NIP</td>
						<td>:</td>
						<td><?php echo $data_pegawai->nip_baru;?></td>
					</tr>
					<tr>
						<td>Pangkat/Gol Ruang</td>
						<td>:</td>
						<td><?php echo $data_pegawai->pangkat_gol;?></td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>:</td>
						<td><?php echo $data_pegawai->jabatan;?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:</td>
						<td><?php echo $unit_kerja->nama_baru;?></td>
					</tr>
				</table>
			</div>
			<p>Telah diadakan perubahan keluarga dengan jenis perubahan sebagai berikut :<br/><br/>
				<?php 
					  $jum = $si->num_rows();
					  if($si->num_rows() > 0)
					  {
						  $data_si = $si->row();
				?>
						<b><?php echo $i;$i++?>. Penambahan</b> 1(satu) orang istri bernama <b><?php echo $data_si->nama?></b>
						Tempat/tanggal Lahir : <?php echo $data_si->tempat_lahir;?>, <?php echo $data_si->tgl_lahir;?> berdasarkan Akta Nikah <br/>
						Nomor: <?php echo $data_si->akte_menikah;?> dari Kepala KUA Kecamtan Bogor Utara tanggal <br/><?php echo $data_si->tgl_menikah;?>.<br/>
				<?php
					 }
					  if($jum_anak >1)
					  {
				?>
						<b><?php echo $i;?>. Penambahan</b> 2 (dua) orang Anak bernama : <b><?php echo $anak1->nama;?></b> Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir?>, <br/>
						<?php echo $anak1->tgl_lahir ?>berdasarkan Akta Kelahiran Nomor: 6879/2004 dari Kepala Dinas Kependudukan dan Catatan Sipil Kota <br>
						&nbsp;&nbsp;&nbsp;&nbsp;dan bernama : <b><?php echo $anak2->nama; ?></b> Tempat/tanggal lahir : <?php echo $anak2->tempat_lahir;?>, <?php echo $anak2->tgl_lahir?>
						&nbsp;&nbsp;&nbsp;&nbsp;berdasarkan Akta Kelahiran <br/>
						&nbsp;&nbsp;&nbsp;&nbsp;Nomor : 02184/UM-WNI/2012 dari Kepala Dinas Kependudukan dan Catatan Sipil Kota Bogor tanggal <br/>
						&nbsp;&nbsp;&nbsp;&nbsp;28 Februari 2012. Berdasarkan surat dari Camat Bogor Utara Kota Bogor  tanggal, 29 Januari 2015 perihal, <br/>
						&nbsp;&nbsp;&nbsp;&nbsp;Usulan Perubahan Keluarga sehingga menjadi :
				<?php
					  }
					  else if ($jum_anak == 1)
					  {
				?>
						<b><?php echo $i;?>. Penambahan</b> 1(satu) orang Anak bernama : <b><?php echo $anak1->nama?></b><br/>
						Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir;?>, <?php echo $anak1->tgl_lahir?> berdasarkan Akta Kelahiran<br/>
						Nomor: 6879/2004 dari Kepala Dinas Kependudukan dan Catatan Sipil Kota <br>
						Berdasarkan surat dari <br/>
						Camat Bogor Utara Kota Bogor  tanggal, 29 Januari 2015 perihal, Usulan <br/>
						Perubahan Keluarga sehingga menjadi :
				<?php
					  }
				?>
			</p>
			<table>
				<tr>
					<td></td>
					<td>1</td>
					<td>Orang Pegawai</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $jum?></td>
					<td>Orang Istri/Suami</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $jum_anak?></td>
					<td>Orang Anak</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5" width="1000px"><hr/></td>
				</tr>
				
				<tr>
					<td>Jumlah</td>
					<td><?php echo $jum+$jum_anak+1;?></td>
					<td>Orang</td>
					<td width="250px"></td>
					<td></td>
				</tr>
			</table>
			<p>Demikian Surat pemberitahuan ini dibuat sebagai bahan pertimbangan lebih lanjut.</p>
		</div>
</div>
</body>
</html>
<?php
	date_default_timezone_set("Asia/Jakarta");
	ob_start();
	
	$i = 1;
	
	//$r = $si->row();
?>
<html>
<head></head>
<body>
<div style="margin-top:200px;margin-left:60px;">
		<div style="margin-left:427px">Bogor, <u><?php echo $tanggal." ".$bulan." ".$tahun;?></u></div>
		<br/>
		<table>
			<tr>
				<td>Nomor</td>
				<td> :</td>
				<td></td>
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
						<td><?php echo $data_pegawai->pangkat_gol;
										$pangkat_gol =$data_pegawai->pangkat_gol; ?></td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>:</td>
						<td><?php echo $data_pegawai->jabatan;?></td>
					</tr>
					<tr>
						<td>Unit Kerja</td>
						<td>:</td>
						<td><?php 
						if($unit_kerja != NULL)
							echo $unit_kerja->nama_baru;
						else 
							echo "-";
				
						?></td>
					</tr>
				</table>
			</div>
			<p>Telah diadakan perubahan keluarga dengan jenis perubahan sebagai berikut :<br/>
				<?php 
						
						  $jum = $si->num_rows();
						  if($si->num_rows() > 0)
						   {
								$data_si = $si->row();
								if($js == 1)
								{
				?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;$i++?>. &nbsp;Penambahan</b> 1(satu) orang suami/istri bernama <b><?php echo $data_si->nama?></b> Tempat/tanggal Lahir : <?php echo $data_si->tempat_lahir;?>, <br/>
										<div style="margin-left:19px;margin-top:3px;margin-bottom:3px;">
										<?php echo $data_si->tgl_lahir;?> berdasarkan Akta Nikah Nomor: <?php echo $data_si->akte_menikah;?> dari Kepala KUA Kecamtan Bogor Utara<br/>
										 <div style="margin-top:3px;">tanggal <?php echo $data_si->tgl_menikah;?>.</div>
										 </div>
									</div>
				<?php
								}
								else if($js == -1)
								{
						  
				?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;$i++?>. &nbsp;Pengurangan</b> 1(satu) orang suami/istri bernama <b><?php echo $data_si->nama?></b> Tempat/tanggal Lahir : <?php echo $data_si->tempat_lahir;?>, <br/>
										<div style="margin-left:19px;margin-top:3px;margin-bottom:3px;">
										<?php echo $data_si->tgl_lahir;?> berdasarkan Akta Nikah Nomor: <?php echo $data_si->akte_menikah;?> dari Kepala KUA Kecamtan Bogor Utara<br/>
										 <div style="margin-top:3px;">tanggal <?php echo $data_si->tgl_menikah;?>.</div>
										 </div>
									</div>
				<?php
								 }
						   }
							if($jum_anak >1 AND $jum_anak <=2)
							{
								if($js == 1)
								{
				?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;?>. &nbsp;Penambahan</b> 2 (dua) orang Anak bernama : <b><?php echo $anak1->nama;?></b> Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir?>, <br/>
										<div style="margin-left:19px;margin-top:3px;">
										<?php echo $anak1->tgl_lahir ?>berdasarkan Akta Kelahiran Nomor: 6879/2004 dari Kepala Dinas Kependudukan dan <br/> 
										<div style="margin-top:3px;">Catatan Sipil Kota dan bernama : <b><?php echo $anak2->nama; ?></b> Tempat/tanggal lahir : <?php echo $anak2->tempat_lahir;?>, <?php echo $anak2->tgl_lahir?></div>
										<div style="margin-top:3px;">berdasarkan Akta Kelahiran Nomor : 02184/UM-WNI/2012 dari Kepala Dinas Kependudukan dan</div>
										<div style="margin-top:3px;">Catatan Sipil Kota Bogor tanggal 28 Februari 2012. Berdasarkan surat dari Camat Bogor Utara </div>
										<div style="margin-top:3px;">Kota Bogor  tanggal, 29 Januari 2015 perihal,Usulan Perubahan Keluarga sehingga menjadi : </div>
										</div>
									</div>
				<?php
								}
								else if($js == -1)
								{
									
					?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;?>. &nbsp;Pengurangan</b> 2 (dua) orang Anak bernama : <b><?php echo $anak1->nama;?></b> Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir?>, <br/>
										<div style="margin-left:19px;margin-top:3px;">
										<?php echo $anak1->tgl_lahir ?>berdasarkan Akta Kelahiran Nomor: 6879/2004 dari Kepala Dinas Kependudukan dan <br/> 
										<div style="margin-top:3px;">Catatan Sipil Kota dan bernama : <b><?php echo $anak2->nama; ?></b> Tempat/tanggal lahir : <?php echo $anak2->tempat_lahir;?>, <?php echo $anak2->tgl_lahir?></div>
										<div style="margin-top:3px;">berdasarkan Akta Kelahiran Nomor : 02184/UM-WNI/2012 dari Kepala Dinas Kependudukan dan</div>
										<div style="margin-top:3px;">Catatan Sipil Kota Bogor tanggal 28 Februari 2012. Berdasarkan surat dari Camat Bogor Utara </div>
										<div style="margin-top:3px;">Kota Bogor  tanggal, 29 Januari 2015 perihal,Usulan Perubahan Keluarga sehingga menjadi : </div>
										</div>
									</div>
					<?php
								}
							}
								
						
							else if ($jum_anak == 1)
							{
								if($js == 1)
								{
					?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;?>. Penambahan</b> 1(satu) orang Anak bernama : <b><?php echo $anak1->nama?></b>Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir;?>,
										<div style="margin-left:19px;margin-top:3px;">
										<?php echo $anak1->tgl_lahir?> berdasarkan Akta Kelahiran Nomor: 6879/2004 dari Kepala Dinas Kependudukan<br/>
										<div style="margin-top:3px;"> dan Catatan Sipil Kota Berdasarkan surat dari Camat Bogor Utara Kota Bogor tanggal,</div>
										 <div style="margin-top:3px;"> 29 Januari 2015 perihal, Usulan Perubahan Keluarga sehingga menjadi :</div>
										</div>
									</div>
				<?php
								}
								
								else if($js == -1)
								{
				?>
									<div style="margin-left:35px;margin-top:3px;">
										<b><?php echo $i;?>. Pengurangan</b> 1(satu) orang Anak bernama : <b><?php echo $anak1->nama?> </b>Tempat/tanggal lahir : <?php echo $anak1->tempat_lahir;?>,
										<div style="margin-left:19px;margin-top:3px;">
										<?php echo $anak1->tgl_lahir?> berdasarkan Akta Kelahiran Nomor: 6879/2004 dari Kepala Dinas Kependudukan<br/>
										<div style="margin-top:3px;"> dan Catatan Sipil Kota Berdasarkan surat dari Camat Bogor Utara Kota Bogor tanggal,</div>
										 <div style="margin-top:3px;"> 29 Januari 2015 perihal, Usulan Perubahan Keluarga sehingga menjadi :</div>
										</div>
									</div>
				<?php
								}
							}
				?>
			</p>
			<div style="margin-left:160px;">
			<table>
						<tr>
							<td></td>
							<td><?php if($js == 1)
									  {
								?>
										1
								<?php
									  }
								?>
							</td>
							<td><?php if($js == 1)
									  {
								?>
										Orang Pegawai
								<?php
									  }
								?>
							</td>
							<td width="500px"> &nbsp;</td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
						</tr>
				<tr>
					<td></td>
					<td><?php echo $jum?></td>
					<td>Orang Istri/Suami</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $jum_anak?></td>
					<td>Orang Anak</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="60" ><hr /></td>
				</tr>
				
				<tr>
					<td>Jumlah</td>
					<td><?php 
							if($js == 1)
								echo $jum+$jum_anak+1;
							else if($js == -1)
								echo $jum+$jum_anak+0;
						?>
					</td>
					<td>Orang</td>
					<td width="250px"></td>
					<td></td>
				</tr>
			</table>
			</div>
			<p>Demikian Surat pemberitahuan ini dibuat sebagai bahan pertimbangan lebih lanjut.</p>
			<div style="margin-left:370px;">
				<p align="center"><br>
				<?php 
					$r = $pengesah->row();
					echo $pgs;
				?>
				<br> 
				<br/><br/><br/>
				<u><b><?php echo $r->gelar_depan; 
				echo " ";
				echo $r->nama.", "; 
				echo " ";
				echo $r->gelar_belakang;?></b></u><br/>
				<br/>
				NIP. <?php echo $r->nip_baru;?>
				</p>
			</div>
			<b><u>Tembusan : </u></b>
			<p>1. Yth. Inspektur Kota Bogor<br/>
			   2. Yth. Camat Bogor Utara Kota Bogor<br/>
			   3. Pegawai Negeri Sipil yang bersangkutan
			</p>
		</div>
</div>
</body>
</html>
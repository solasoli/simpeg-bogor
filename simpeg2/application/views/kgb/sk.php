<?php
	if(!isset($sk)) redirect('kgb/registrasi');
	setlocale(LC_TIME, 'ind');
	setlocale(LC_MONETARY, 'ind');
?>
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
			font-size: 9.7pt;
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
		<td rowspan="4" style="padding-left: 150px;">
			Bogor, <?php echo $this->format->tanggal_indo($sk->tgl_sk);//echo strftime('%d %B %Y', strtotime($sk->tgl_sk)); ?><br/>
			Kepada<br/>
			Yth. Kepala Badan Pengelolaan Keuangan <br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dan Aset Daerah Kota Bogor</br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>B O G O R</u>
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
			<br/>
			<p>Dengan ini diberitahukan, bahwa berhubung dengan telah dipenuhinya masa kerja dan syarat-syarat lainnya kepada:</p>
			<table>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<?php
						$pegawai_full = $pegawai->gelar_depan ? $pegawai->gelar_depan.' '.$pegawai->nama : $pegawai->nama;
						$pegawai_full .= $pegawai->gelar_belakang ? ', '.$pegawai->gelar_belakang : '' ;
					?>
					<td><?php echo $pegawai_full ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td>:</td>
					<td><?php echo $pegawai->tempat_lahir ?>, <?php echo $this->format->tanggal_indo($pegawai->tgl_lahir) ?></td>
				</tr>
				<tr>
					<td>N I P</td>
					<td>:</td>
					<td><?php echo $pegawai->nip_baru ?></td>
				</tr>
				<tr>
					<td>Pangkat-Gol/Ruang</td>
					<td>:</td>
					<td><?php echo $pegawai->status_pegawai == 'CPNS' ? ' - ' : $pegawai->pangkat ?> - <?php echo $pegawai->golongan ?></td>
				</tr>
				<tr>
					<td>Unit Kerja</td>
					<td>:</td>
					<td><?php echo (strpos($pegawai->nama_baru, "Staf") === FALSE) ? $pegawai->nama_baru : "Sekretariat Daerah" ?></td>
				</tr>
				<tr>
					<td>Gaji Pokok Lama</td>
					<td>:</td>
					<td><?php
							if($pegawai->status_pegawai == 'CPNS'){
								echo "80% x Rp. ".$this->format->currency($dasar_sk->gaji).",- = Rp. ".$this->format->currency($dasar_sk->gaji*0.8).",-";
							}else{
								echo $dasar_sk->gaji ? "Rp. ".number_format($dasar_sk->gaji, 0, ',','.').",-" : "kosong";
							} ?>
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
					<td><?php echo strftime('%d-%m-%Y', strtotime($dasar_sk->tmt)); //echo $this->format->tanggal_indo($dasar_sk->tmt);?></td>
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
					<td><?php
							if($pegawai->status_pegawai == 'CPNS'){
								echo "80% x Rp. ".$this->format->currency($sk->gaji).",- = Rp. ".$this->format->currency($sk->gaji*0.8).",-";
							}else{
								echo "Rp. ".number_format($sk->gaji, 0, ',','.').",-";
							} ?>
					</td>
				</tr>
				<tr>
					<td>Mulai Berlaku Tanggal</td>
					<td>:</td>
					<td><?php echo strftime('%d-%m-%Y', strtotime($sk->tmt)); //echo $this->format->tanggal_indo($sk->tmt);//?></td>
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
					$tahun_kerja = explode(',',$sk->keterangan)[1];
					if(
						((
							$pegawai->golongan == 'I/a' ||
							$pegawai->golongan == 'I/b' ||
							$pegawai->golongan == 'I/c' ||
							$pegawai->golongan == 'I/d'
						) && $tahun_kerja >= 27) ||

						((
							$pegawai->golongan == 'II/a' ||
							$pegawai->golongan == 'II/b' ||
							$pegawai->golongan == 'II/c' ||
							$pegawai->golongan == 'II/d'
						) && $tahun_kerja >= 33) ||

						((
							$pegawai->golongan == 'III/a' ||
							$pegawai->golongan == 'III/b' ||
							$pegawai->golongan == 'III/c' ||
							$pegawai->golongan == 'III/d'
						) && $tahun_kerja >= 32) ||

						((
							$pegawai->golongan == 'IV/a' ||
							$pegawai->golongan == 'IV/b' ||
							$pegawai->golongan == 'IV/c' ||
							$pegawai->golongan == 'IV/d' ||
							$pegawai->golongan == 'IV/e'
						) && $tahun_kerja >= 32)
					)
						echo "MAKSIMAL";
					else
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
						<?php
							$pengesah_full = $pengesah->gelar_depan ? $pengesah->gelar_depan.' '.strtoupper($pengesah->nama) : strtoupper($pengesah->nama);
							$pengesah_full .= $pengesah->gelar_belakang ? ', '.$pengesah->gelar_belakang : '' ;
						/*	if($pengesah->gelar_belakang){
								$pengesah_full = $pengesa
							}
						*/
						?>
						<strong>
						<?php if($pengesah->nip_baru): ?>
							<?php if($pengesah->flag_pensiun == 99 ) { ?>
								<?php echo $pengesah_full ?><br/>
							<?php }else{ ?>
								<u><?php echo $pengesah_full ?></u><br/>
							<?php } ?>

							<?php echo $pengesah->flag_pensiun == 99 ? "" : $pengesah->pangkat." - ".$pengesah->pangkat_gol; ?><br/>
							<?php echo $pengesah->flag_pensiun == 99 ? "" : "NIP. ".$pengesah->nip_baru ?>
						<?php else: ?>
							<?php echo $pengesah_full ?>
						<?php endif; ?>
						</strong><br/>
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
			3. Kepada yang bersangkutan;
		</td>
	</tr>
</table>
</div>
</body>
</html>

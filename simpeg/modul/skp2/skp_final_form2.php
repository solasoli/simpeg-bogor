<?php 
	$pegawai = $obj_pegawai->get_obj($_GET['idp']);
	//$penilai = $skp->get_penilai($pegawai);
	$lastSkp = $skp->get_akhir_periode($_GET['idp'], $_GET['tahun']);
	$penilai = $obj_pegawai->get_obj($lastSkp->id_penilai);
	$atasan_penilai = $obj_pegawai->get_obj($lastSkp->id_atasan_penilai);
	//$atasan_penilai = $skp->get_penilai($penilai);
	//$perilaku = $skp->get_skp_by_id($_GET['idskp']);
	
	
?>
<div class="row hidden-print">
	<div class="col-md-12">
		<button class="btn btn-info" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></button>
	</div>
</div>
<div class="row text-center">
	<div class="col-md-12">
		<span>
			<img src="<?php echo BASE_URL?>images/garuda.jpg" style="width:120px; height:120px">
		</span>
		<h3>
		PENILAIAN PRESTASI KERJA<br>PEGAWAI NEGERI SIPIL
		</h3>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
	<table class="table table-noborder" style="margin:0px;border-top:0px">
		<tr>
			<td></td>
			<td class="text-right">JANGKA WAKTU PENILAIAN</td>
		</tr>
		<tr>
			<td>PEMERINTAH KOTA BOGOR</td>
				<td class="text-right"><?php 
					echo $format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $_GET['tahun'])->awal)
					." s.d ".$format->tanggal_indo($lastSkp->akhir) ;
				?></td>
		</tr>
	</table>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered">
			<tr>
				<td rowspan="6" width="2%">1.</td>
				<td colspan="2">YANG DINILAI</td>				
			</tr>
			<tr>
				<td width="38%">a. Nama</td>
				<td><?php echo $pegawai->nama_lengkap ?></td>				
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo $pegawai->nip_baru ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td><?php echo isset($lastSkp->gol_pegawai)? $lastSkp->gol_pegawai : $pegawai->pangkat." - ".$pegawai->pangkat_gol ?></td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $lastSkp->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $pegawai->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="6">2.</td>
				<td colspan="2">PEJABAT PENILAI</td>				
			</tr>
			<tr>
				<td>a. Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>				
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo $penilai->nip_baru ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td><?php echo isset($lastSkp->gol_penilai)? $lastSkp->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol ?></td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $lastSkp->jabatan_penilai ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $penilai->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="6">3.</td>
				<td colspan="2">ATASAN PEJABAT PENILAI</td>				
			</tr>
			<tr>
				<td>a. Nama</td>
				<td><?php echo $atasan_penilai->nama_lengkap ?></td>				
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo $atasan_penilai->nip_baru ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td>
					<?php echo isset($lastSkp->gol_atasan_penilai)? $lastSkp->gol_atasan_penilai : $atasan_penilai->pangkat." - ".$atasan_penilai->pangkat_gol ?>
					
				</td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $obj_pegawai->get_jabatan($atasan_penilai) ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $atasan_penilai->nama_baru ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="page-break"></div>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered">
			<tr>
				<td width="2%" rowspan="11">4.</td>
				<td colspan="4">UNSUR YANG DINILAI</td>
				<td class="text-center">Jumlah</td>
			</tr>
			<tr>
				<td colspan="4">a. Sasaran Kerja Pegawai (SKP) <?php echo round($skp->get_nilai_capaian_rata2($_GET['idp'], $_GET['tahun']),2) ?> x 60%</td>
				<td class="text-center"><?php echo $nilai_skp = round($skp->get_nilai_capaian_rata2($_GET['idp'], $_GET['tahun']) * 0.6 , 2) ?></td>
			</tr>
			<tr>
				<td rowspan="9">b. Perilaku Kerja</td>
				<td>1. Orientasi pelayanan</td>
				<td class="text-center"><?php echo $lastSkp->orientasi_pelayanan ?></td>
				<td class="text-center"><?php echo isset($lastSkp->orientasi_pelayanan) ? $skp->sebutan_capaian($lastSkp->orientasi_pelayanan) : "-"?></td>
				<td></td>
			</tr>
			<tr>				
				<td>2. Integritas</td>
				<td class="text-center"><?php echo $lastSkp->integritas ?></td>
				<td class="text-center"><?php echo isset($lastSkp->integritas) ? $skp->sebutan_capaian($lastSkp->integritas) : "-"?></td>
				<td></td>
			</tr>
			<tr>				
				<td>3. Komitmen</td>
				<td class="text-center"><?php echo $lastSkp->komitmen ?></td>
				<td class="text-center"><?php echo isset($lastSkp->komitmen) ? $skp->sebutan_capaian($lastSkp->komitmen) : "-"; ?></td>
				<td></td>
			</tr>
			<tr>				
				<td>4. Disiplin</td>
				<td class="text-center"><?php echo $lastSkp->disiplin ?></td>
				<td class="text-center"><?php echo isset($lastSkp->disiplin) ? $skp->sebutan_capaian($lastSkp->disiplin) : "-"; ?></td>
				<td></td>
			</tr>
			<tr>				
				<td>5. Kerjasama</td>
				<td class="text-center"><?php echo $lastSkp->kerjasama ?></td>
				<td class="text-center"><?php echo isset($lastSkp->kerjasama) ? $skp->sebutan_capaian($lastSkp->kerjasama) : "-" ?></td>
				<td></td>
			</tr>
			<tr>				
				<td>6. Kepemimpinan</td>
				<td class="text-center"><?php echo $lastSkp->kepemimpinan ? $lastSkp->kepemimpinan : "-" ?></td>
				<td class="text-center"><?php echo isset($lastSkp->kepemimpinan) ? $skp->sebutan_capaian($lastSkp->kepemimpinan) : "-" ?></td>
				<td></td>
			</tr>
			<tr>				
				<td>Jumlah</td>
				<td class="text-center"><?php echo $lastSkp->jumlah_perilaku ?></td>
				<td></td>
				<td></td>
			</tr>
			<tr>				
				<td>Nilai rata-rata</td>
				<td class="text-center"><?php echo number_format($lastSkp->rata2_perilaku,2) ?></td>				
				<td class="text-center"><?php echo $skp->sebutan_capaian($lastSkp->rata2_perilaku) ?></td>
				<td></td>
			</tr>
			<tr>				
				<td>Nilai Perilaku Kerja</td>
				<td colspan="2" class="text-center"><?php echo number_format($lastSkp->rata2_perilaku,2) ?> x 40%</td>								
				<td class="text-center"><?php echo $nilai_perilaku = number_format(($lastSkp->rata2_perilaku * 0.4),2) ?></td>
			</tr>
			<tr>
				<td colspan="5">NILAI PRESTASI KERJA</td>
				<td class="text-center">
					<?php echo $nilai_akhir = number_format(($nilai_skp + $nilai_perilaku),2) ?>
					<br>(<?php echo $skp->sebutan_capaian($nilai_akhir) ?>)
				</td>
			</tr>
			<tr>
				<td colspan="6">
					<div class="row">
						<div class="col-sm-12">
							5. KEBERATAN DARI PEGAWAI NEGERI SIPIL <br>YANG DINILAI (APABILA ADA)
						</div>						
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="editable" id="keberatan" style="height:300px"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-right">tanggal, .........</div>
					</div>					
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="page-break"></div>

<div class="row">
	<div class="col-sm-12">
	<table class="table table-bordered">
		<tr>
			<td>
				<div class="row">
					<div class="col-sm-12">
						6. TANGGAPAN PEJABAT PENILAI<br>ATAS KEBERATAN
					</div>						
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="editable" id="keberatan" style="height:300px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-right">tanggal, .........</div>
				</div>					
			</td>
		</tr>
		<tr>
			<td>
				<div class="row">
					<div class="col-sm-12">
						7. KEPUTUSAN ATASAN<br>PEJABAT PENILAI ATAS KEBERATAN
					</div>						
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="editable" id="keberatan" style="height:300px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-right">tanggal, .........</div>
				</div>					
			</td>
		</tr>
	</table>
	</div>
</div>
<div class="page-break"></div>
<div class="row">
	<div class="col-sm-12">
	<table class="table table-bordered">
		<tr>
			<td colspan="2">
				<div class="row">
					<div class="col-sm-12">
						8. REKOMENDASI<br>
					</div>						
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="editable" id="keberatan" style="height:300px"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 text-right">tanggal, .........</div>
				</div>					
			</td>
		</tr>
		<tr>			
			<td style="height:150px;vertical-align:middle" class="text-center">
				<div class="col-xs-6 col-xs-offset-6">
					9. DIBUAT TANGGAL, <span style="font-color:#fff"></span>
					<br>PEJABAT PENILAI,
					<br><br><br><br>
					<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
					<br>NIP. <?php echo $penilai->nip_baru ?>
				</div>			
				<div class="col-xs-6">
					10. DITERIMA TANGGAL, 
					<br>PEGAWAI YANG DINILAI,
					<br><br><br><br>
					<span style="text-decoration:underline"><strong><?php echo $pegawai->nama_lengkap ?></strong></span>
					<br>NIP. <?php echo $pegawai->nip_baru ?>
				</div>			
				<div class="col-xs-6 col-xs-offset-6">
					11. DITERIMA TANGGAL, 
					<br>ATASAN PEJABAT YANG MENILAI,
					<br><br><br><br>
					<span style="text-decoration:underline"><strong><?php echo $atasan_penilai->nama_lengkap ?></strong></span>
					<br>NIP. <?php echo $atasan_penilai->nip_baru ?>
				</div>
			</td>
		</tr>
	</table>
	</div>
</div>
<script>
	$(document).ready(function(){
	
		$(".in").removeClass("in");
		$("#collapseThree").addClass("in");
	});
</script>

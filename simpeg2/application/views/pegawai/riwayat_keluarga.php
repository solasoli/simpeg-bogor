<!--<div class="grid fluid">-->
<div class="row">	
	<div class="span12">
	<fieldset>
		<legend>
			<h2>Data Keluarga
				<!--<span class=" place-right"><a href="#" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
			</h2>			
		</legend>
			<table class='table hovered' >
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Tempat, Tgl Lahir</th>
						<th>Pekerjaan</th>
						<th>Jenis Kelamin</th>
						<th>Status Tunjangan</th>
					</tr>					
				</thead>
				<tbody>
					<?php if($istri_){ ?>
					<tr>
						<td></td>
						<td colspan="5"><strong><?php echo $pegawai->jenis_kelamin == 1 ? "Istri :" : "Suami" ?></strong></td>						
					</tr>
                    <?php $x=1; foreach($istri_ as $istri){ ?>
					<tr>
						<td></td>
						<td><?php echo $istri->nama ?></td>
						<td><?php echo $istri->tempat_lahir.", ".$this->format->tanggal_indo($istri->tgl_lahir) ?></td>
						<td><?php echo $istri->pekerjaan ? $istri->pekerjaan : "-" ?></td>
						<td><?php echo $istri->jk ? ($istri->jk == "1" ? "Laki-laki" : "Perempuan") : "-" ?></td>
						<td><?php echo $istri->dapat_tunjangan == "1" ? "Dapat" :	 "Tidak" ?></td>
					</tr>
                        <?php } ?>
                    <?php } ?>
					
					<?php if($anaks){ ?>
					<tr>
						<td></td>
						<td colspan="5"><strong>Anak :</strong></td>						
					</tr>
					
					<?php } ?>
					<?php $x=1; foreach($anaks as $anak){ ?>
					<tr>
						<td><?php echo $x++ ?></td>
						<td><?php echo $anak->nama ?></td>
						<td><?php echo $anak->tempat_lahir.", ".$this->format->tanggal_indo($anak->tgl_lahir) ?></td>
						<td><?php echo $anak->pekerjaan ? $anak->pekerjaan : "-" ?></td>
						<td><?php echo $anak->jk ? ($anak->jk == "1" ? "Laki-laki" : "Perempuan") : "-" ?></td>
						<td><?php echo $anak->dapat_tunjangan == "1" ? "Dapat" :	 "Tidak" ?></td>
					</tr>
					<?php } ?> 
					<?php if(isset($istri) && !$istri && !$anaks) { ?>
					<tr>
						<td colspan="6" class="text-center text-alert">Tidak Ada Data yang dapat ditampilkan</td>
					</tr>
					<?php } ?>
					
				</tbody>
			</table>
		</fieldset>
	</div>
</div>

<!--</div>--><!-- end grid -->



<!-- end of file riwayat_keluarga.php -->
<!-- location .app/views/pegawai/ -->

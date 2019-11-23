<div class="row">
<legend><h2>Riwayat Pendidikan</h2></legend>
<table class="table">
	<thead>
		<tr>
			<th>No</th>
			<th>Tingkat Pendidikan</th>
			<th>Lembaga Pendidikan</th>
			<th>Jurusan</th>
			<th>Tahun Lulus</th>
			<th>No. STTB/Ijazah</th>
			<th>Tempat</th>
			<th>Kepala Sekolah/Direktur/Dekan/Promotor</th>
			<!--<th>Berkas</th>-->
		</tr>
	</thead>
	<tbody>
		<?php $x=1; foreach($pendidikans as $pend){ ?>
		<tr>
			<td><?php echo $x++."."; ?></td>
			<td><?php echo $pend->tingkat_pendidikan ?></td>			
			<td><?php echo $pend->lembaga_pendidikan ?></td>
			<td><?php echo $pend->jurusan_pendidikan ?></td>
			<td><?php echo $pend->tahun_lulus ?></td>
			<td></td>
			<td></td>
			<td></td>
			<!--<td>
				<?php if($pend->id_berkas <> 0) { ?> 
					
				<a href="#"><span class="icon-download-2"></span></a></td>
				
				<?php } ?>-->
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
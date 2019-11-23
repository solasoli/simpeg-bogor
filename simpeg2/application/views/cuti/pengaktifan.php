<div>
	<p><h2>Pegawai yang akan habis masa CLTN-nya </h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Golongan</th>
			<th>Jabatan</th>
			<th>SKPD</th>
			<th>Jenis Cuti</th>
			<th>Akhir CLTN</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($cltn)): ?>
		<?php $i = 1; ?>
		<?php foreach($cltn as $cut): ?>
		<tr>
			<td><?php echo $i++ ?></td>
			<td><?php echo $cut->nama ?></td>
			<td><?php echo $cut->nip_baru ?></td>
			<td><?php echo $cut->pangkat_gol ?></td>
			<td><?php echo $cut->jabatan ?></td>
			<td><?php echo $cut->nama_baru ?></td>
			<td><?php echo $cut->deskripsi ?></td>
			<td><?php echo $cut->tmt_selesai ?></td>
			<td><a href="#" class="button default icon-checkmark">&nbsp;AKTIFKAN</a></td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="7">Tidak ada data yang dapat disajikan</td>
		</tr>
		<?php endif; ?>
	</tbody>
	</table>
</div>

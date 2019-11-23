<div>
<h2>Daftar PNS yang mengambil cuti</h2>

<table class="table bordered hovered" id="daftar_pegawai_cuti">
<thead>
	<tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Nama</th>
		<th rowspan="2">NIP</th>
		<th rowspan="2">Jabatan</th>
		<th rowspan="2">Jenis Cuti</th>
		<th rowspan="2">No. Keputusan</th>
		<th colspan="2">TMT</th>
		<th rowspan="2">Unit Kerja</th>
	</tr>
	<tr>
		<th>Awal</th>
		<th>Selesai</th>
	</tr>
</thead>
<tbody>
<?php if(sizeof($cuti) > 0): ?>
	<?php $i=1; ?>
	<?php foreach($cuti as $cut): ?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td><?php echo $cut->nama ?></td>
		<td><?php echo $cut->nip_baru ?></td>
		<td><?php echo $cut->jabatan ?></td>
		<td><?php echo $cut->deskripsi ?></td>
		<td><?php echo $cut->no_keputusan ?></td>
		<td><?php echo $cut->tmt_awal ?></td>
		<td><?php echo $cut->tmt_selesai ?></td>
		<td><?php echo $cut->nama_baru ?></td>
	</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr>
		<td colspan="9"><i>Tidak ada data</i></td>
	</tr>
<?php endif; ?>
</tbody>
</table>
</div>
<script>
	$(function(){
		$('#daftar_pegawai_cuti').dataTable();
	
	});
</script>
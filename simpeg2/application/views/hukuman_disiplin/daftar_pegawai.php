<h2>Daftar Pegawai yang Dijatuhi Hukuman</h2>

<table class="table bordered striped" id="daftar_pegawai_hukdis">
<thead>
	<tr>
		<th>No</th>
		<th>Nama</th>
		<th>NIP</th>
		<th>Tingkat Hukuman</th>
		<th>Jenis</th>
		<th>Nomor Kep</th>
		<th>Tgl. Hukuman</th>
		<th>TMT</th>
		<th>Unit Kerja</th>
	</tr>
</thead>
<tbody>
<?php if(sizeof($hukuman) > 0): ?>
	<?php $i=1; ?>
	<?php foreach($hukuman as $huk): ?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td><?php echo $huk->nama ?></td>
		<td><?php echo $huk->nip_baru ?></td>
		<td><?php echo $huk->tingkat_hukuman ?></td>
		<td><?php echo $huk->deskripsi ?></td>
		<td><?php echo $huk->no_keputusan ?></td>
		<td><?php echo $huk->tgl_hukuman ?></td>
		<td><?php echo $huk->tmt ?></td>
		<td><?php echo $huk->nama_baru ?></td>
	</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr class="error">
		<td colspan="9"><i>Tidak ada data</i></td>
	</tr>
<?php endif; ?>
</tbody>
</table>
<script>
	$(function(){
		$('#daftar_pegawai_hukdis').dataTable();
	
	});
</script>

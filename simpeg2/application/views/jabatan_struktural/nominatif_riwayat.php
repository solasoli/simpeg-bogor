<h2>NOMINATIF RIWAYAT JABATAN</h2>

<table class="table bordered striped" id="daftar_pejabat">
<thead>
	<tr>
		<th>Nama</th>
		<th>NIP</th>
		<th>Golongan</th>
		<th>Eselon</th>
		<th>Jabatan</th>
		<th>Unit Kerja</th>
		<th>Tgl Masuk</th>
		<th>Tgl Keluar</th>
	</tr>
</thead>
<tbody>
<?php if(sizeof($rekap) > 0): ?>
	<?php $i=1; $nama= $nip = $pangkat = $eselon = '';?>
	<?php foreach($rekap as $huk): ?>	
	<tr>
		<td><?php echo $nama === $huk->nama ? '' : $huk->nama ?></td>
		<td><?php echo $nip === $huk->nip ? '' : $huk->nip ?></td>
		<td><?php echo $huk->pangkat_gol ?></td>
		<td><?php echo $huk->eselon?></td>
		<td><?php echo $huk->jabatan ?></td>
		<td><?php echo $huk->unit_kerja ?></td>
		<td><?php echo $huk->tgl_masuk ?></td>
		<td><?php echo $huk->tgl_keluar ?></td>
	</tr>
	<?php 
		$nama = $huk->nama; 
		$nip = $huk->nip;	
		$pangkat = $huk->pangkat_gol;
		$eselon = $huk->eselon;
	?>
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
	/*$('#daftar_pejabat').dataTable();

	});*/
</script>

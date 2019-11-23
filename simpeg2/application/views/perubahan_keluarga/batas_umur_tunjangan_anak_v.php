
<div class="container">
<h3>Batas Umur Tunjangan Anak</h3>
<hr/>
<table class="table bordered" id="batas_umur">
	<thead>
		<tr>
			<th>Nama Anggota Keluarga</th>
			<th>Usia</th>
			<th>Nama Pegawai</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($batas->result() as $r)
		{
	?>
		<tr>
			<td><?php echo $r->nama?></td>
			<td><?php echo $r->usia_anak?></td>
			<td><?php echo $r->nama_peg?></td>
		</tr>
	<?php
		}
	?>
	</tbody>
</table>
</div>
<script>
	$('#batas_umur').dataTable();
</script>
<div style="margin-left:10%;margin-right:10%;">
<br/>
<table class="table striped">
	<thead>
		<tr>
			<th>NIP</th>
			<th>Nama Pegawai</th>
			<th>Aksi</th>
		</tr>
	<thead>
<?php foreach($keyword->result() as $r)
	  {
?>	<tbody>
		<tr>
			<td align="center"><?php echo $r->nip_baru?></td>
			<td align="center"><?php echo $r->nama?></td>
			<td align="center"><a class="button primary" href="<?php echo base_url();?>perubahan_keluarga/data_pegawai_by_id/<?php echo $r->id_pegawai?>">Pilih</a></td>
		</tr>
	</tbody>
<?php
	 }
?>
</table>
</div>
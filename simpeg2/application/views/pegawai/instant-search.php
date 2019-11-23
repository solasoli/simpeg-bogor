<?php 
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Cache-Control: max-age=86400"); 
  
  
echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="btn-search"></button>
</div>
<?php echo form_close(); ?>

<div>
<?php if(sizeof($pegawai)): ?>
	<?php echo form_open($landing); ?>
	<table class="table bordered">
	<thead>
		<th>No</th>
		<th>Nama</th>
		<th>NIP</th>
		<th>Golongan</th>
		<th>Jabatan</th>
		<th>SKPD</th>
		<th>Foto</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
	<?php $no = 1; ?>
	<?php foreach($pegawai as $p): ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $p->nama; ?></td>
		<td><?php echo $p->nip_baru; ?></td>
		<td><?php echo $p->pangkat_gol; ?></td>
		<td><?php echo $p->jabatan; ?></td>
		<td><?php echo $p->nama_baru; ?></td>
		<td align="center"><img style="max-height:100px" src="../../../../simpeg/foto/<?php echo $p->id_pegawai ?>.jpg?<?php echo time(); ?>" alt="No Photo"/><br />
       <a href ="<?php echo site_url()."pegawai/uploader/".$p->id_pegawai."/$keyword"; ?>">Upload Foto</a>
        </td>
		<td><a href ="<?php echo site_url().$landing."/".$p->id_pegawai; ?>">Pilih</a></td>
	</tr>
	<?php $no++; ?>
	<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo form_close(); ?>
<?php else: ?>

<?php endif; ?>
</div>
<!--  End of file instant-search.php -->
<!--  Location: ./application/views/pegawai/instant-search.php  -->

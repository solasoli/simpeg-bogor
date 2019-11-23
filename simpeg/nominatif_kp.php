<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">NOMINATIF KENAIKAN PANGKAT</a>    
  </div>
</div>
<?php
include("konek.php");

$q = 	"select nama, nip, eselon, jabatan, golongan, tmt_golongan, tgl_lahir, jenjang_pendidikan from report_duk
where id_j > 0
order by eselon ASC, golongan desc, tmt_golongan desc, tgl_lahir asc, level_p asc";
				
$rs = mysqli_query($mysqli,$q);
$i = 1;
?>
<table class="table table-bordered table-striped">
<thead>
	<th>No</th>
	<th>Nama</th>
	<th>NIP</th>
	<th>Eselon</th>
	<th>Jabatan</th>
	<th>Golongan</th>
	<th>TMT Gol</th>
	<th>Tgl Lahir</th>
	<th>Pendidikan</th>		
</thead>	
<tbody>
	<?php while ($r = mysqli_fetch_array($rs)): ?>
		<tr>
			<td><?php echo $i ?></td>
			<td><?php echo $r[nama] ?></td>
			<td><?php echo $r[nip] ?></td>
			<td><?php echo $r[eselon] ?></td>
			<td><?php echo $r[jabatan] ?></td>
			<td><?php echo $r[golongan] ?></td>
			<td><?php echo $r[tmt_golongan] ?></td>
			<td><?php echo $r[tgl_lahir] ?></td>
			<td><?php echo $r[jenjang_pendidikan] ?></td>	
		</tr>
		<?php $i++; ?>
	<?php endwhile; ?>
</tbody>
</table>
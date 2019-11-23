<a href="rekappejabat.php" target="_blank"> Export Data Pejabat</a>
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">NOMINATIF PEJABAT STRUKTURAL KOTA BOGOR</a>    
  </div>
</div>
<?php


$q = "select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, concat(\"'\", nip_baru) as nip_baru, j.eselon, j.jabatan, pangkat_gol, uk.nama_baru 
from pegawai p 
inner join jabatan j on p.id_j=j.id_j
inner join pendidikan_terakhir t on p.id_pegawai= t.id_pegawai 
inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
where p.id_j > 0
order by uk.nama_baru ASC, eselon ASC, pangkat_gol desc";				
$rs = mysqli_query($mysqli,$q);
$i = 1;
?>
<table class="table table-bordered table-striped">
<thead>
	<th rowspan="2" style="background-color:orange">No</th>
	<th rowspan="2" style="background-color:orange">Nama</th>
	<th rowspan="2" style="background-color:orange">NIP</th>
	<th rowspan="2" style="background-color:orange">Eselon</th>
	<th rowspan="2" style="background-color:orange">Jabatan</th>
	<th rowspan="2" style="background-color:orange">Golongan</th>
	<th rowspan="2" style="background-color:orange">SKPD</th>	
</thead>	
<tbody>
	<?php while ($r = mysqli_fetch_array($rs)): ?>
		<tr>
			<td><?php echo $i ?></td>
			<td><?php echo $r['nama'] ?></td>
			<td><?php echo $r['nip_baru'] ?></td>
			<td><?php echo $r['eselon'] ?></td>
			<td><?php echo $r['jabatan'] ?></td>
			<td><?php echo $r['pangkat_gol'] ?></td>
			<td><?php echo $r['nama_baru'] ?></td>
		</tr>
		<?php $i++; ?>
	<?php endwhile; ?>
</tbody>
</table>
<H1>DAFTAR PEJABAT FUNGSIONAL</H1>

<?php 
$qDaftar = "SELECT  p.nama, p.jabatan, p.pangkat_gol
FROM pegawai p 
where flag_pensiun =0 and jenjab like '%struktural%' and id_j is null
ORDER by pangkat_gol desc, p.jabatan";
$rDaftar = mysqli_query($mysqli,$qDaftar);
$no=1;
?>
<table BORDER="1" >
<thead>
	<th>NO</th>
	<th>NAMA</th>
	<th>Jabatan</th>
	<th>Golongan</th>
</thead>
<tbody>
<? while($r = mysqli_fetch_array($rDaftar)): ?>
	<tr>
		<td><?php echo $no++?></td>
		<td><?php echo $r[nama]; ?></td>
		<td><?php echo $r[jabatan]; ?></td>
		<td><?php echo $r[pangkat_gol]; ?></td>
	</tr>
<? endwhile; ?>
</tbody>
</table>
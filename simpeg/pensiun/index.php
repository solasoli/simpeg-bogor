

<?php
include "../konek.php";

$qPensiun = "SELECT nama, pangkat_gol, nip_baru, DATE_ADD( tgl_lahir, INTERVAL 56 YEAR ) AS tgl_pensiun, u.nama_baru
FROM pegawai p
INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE LEFT( DATE_ADD( tgl_lahir, INTERVAL 56 YEAR ) , 4 ) 
BETWEEN 2013 
AND 2014 
AND jenjab LIKE  '%struktural%'
ORDER BY  `tgl_pensiun` ASC 
			";
$rsPensiun = mysql_query($qPensiun);
?>
<b><font algn ="center" >--DATA PENSIUN PEGAWAI STRUKTURAL--</font></b>
</br>
</br>
<table border="1" class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>Nama</td>
			<td>Pangkat</td>
			<td>NIP</td>
			<td>Tgl Pensiun</td>
			<td>SKPD</td>
		</tr>
	</thead>
	<tbody>
		<?php while($rPensiun = mysql_fetch_array($rsPensiun)): ?> 	
		<tr>
			<td><?php echo $rPensiun[nama] ?></td>
			<td><?php echo $rPensiun[pangkat_gol] ?></td>
			<td><?php echo $rPensiun[nip_baru] ?></td>
			<td><?php echo $rPensiun[tgl_pensiun] ?></td>
			<td><?php echo $rPensiun[nama_baru] ?></td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>
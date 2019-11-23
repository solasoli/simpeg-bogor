<?php
include_once "../konek.php";
$awal = $_POST['awal'];
$akhir = $_POST['akhir'];

$q = "SELECT t.id_j, s.tmt, s.id_pegawai, j.jabatan, p.nama, p.nip_baru, p.pangkat_gol, CONCAT(UCASE(p.tempat_lahir), ', ', DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') ) AS ttl, 
			DATE_FORMAT((p.tgl_lahir + INTERVAL 56 YEAR + INTERVAL 1 MONTH), '1-%m-%Y') AS tmt_pensiun						
		FROM sk s INNER JOIN
		(
			SELECT j.id_j, MAX(s.tmt) AS max_tmt FROM jabatan j 
			INNER JOIN sk s ON j.id_j = s.id_j
			WHERE j.tahun = 2011 AND s.id_kategori_sk = 10
			GROUP BY j.id_j
			ORDER BY s.id_j
		) AS t ON t.id_j = s.id_j AND s.tmt = t.max_tmt
		INNER JOIN jabatan j ON j.id_j = s.id_j
		INNER JOIN pegawai p ON p.id_pegawai = s.id_pegawai
		WHERE j.tahun = YEAR(CURDATE()) AND p.flag_pensiun = 0 AND (((YEAR(p.tgl_lahir + INTERVAL 56 YEAR + INTERVAL 1 MONTH)) >= $awal) AND  ((YEAR(p.tgl_lahir + INTERVAL 56 YEAR + INTERVAL 1 MONTH)) <= $akhir))
		GROUP BY t.id_j
		ORDER BY p.pangkat_gol DESC";
		
$rs = mysql_query($q);

if($rs != ''){
?>
	<div id="content">
	<table border="1">
			<thead>			
				<td>No</td>
				<td>Nama</td>
				<td>NIP</td>
				<td>TTL</td>
				<td>Golongan</td>
				<td>Jabatan</td>
				<td>TMT Pensiun</td>
			</thead>
	<?php
	$i = 1;
	while($r = mysql_fetch_array($rs)){
		?>
			<tr>			
				<td><?php echo $i; ?></td>
				<td><?php echo $r[nama]; ?></td>
				<td><?php echo $r[nip_baru]; ?></td>
				<td><?php echo $r[ttl]; ?></td>
				<td><?php echo $r[pangkat_gol]; ?></td>
				<td><?php echo $r[jabatan]; ?></td>
				<td><?php echo $r[tmt_pensiun]; ?></td>
			</tr>
		<?php		
		$i++;
	}
	?>
	</div>
	</table>
	<?php
}
?>
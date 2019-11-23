<?php include "berkala_navbar.php"; ?>
<div class="page-header">
	<h1>Nominatif KGB <br/><small>Daftar pegawai yang dapat mengajukan kenaikan gaji berkala tahun <?php echo date("Y"); ?></small></h1>
</div>

<div>
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>No</td>
				<td>Nama</td>
				<td>NIP</td>
				<td>Golongan</td>
				<td>TMT</td>
				<td>Unit Kerja</td>				
			</tr>
		</thead>
		<tbody>
			
			<?php
				// LIST SEMUA PENGAJUAN KENAIKAN GAJI BERKALA
				$qNominatif = 	"SELECT p.nama, p.nip_baru, p.pangkat_gol, s.tmt, DATE_ADD(s.tmt, INTERVAL 2 YEAR) AS tmt_proses,
									u.nama_baru, s.id_pegawai
								FROM sk s
								INNER JOIN
								(
									SELECT id_pegawai, MAX(tmt) AS max_tmt
									FROM sk
									WHERE id_kategori_sk = 9
									GROUP BY id_pegawai
								)AS t ON s.id_pegawai = t.id_pegawai AND s.tmt = t.max_tmt
								INNER JOIN pegawai p ON p.id_pegawai = t.id_pegawai
								INNER JOIN current_lokasi_kerja c ON c.id_pegawai = t.id_pegawai
								INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
								WHERE (DATE_FORMAT(tmt, '%Y') + 2) = '2012'
								ORDER BY u.nama_baru ASC, tmt_proses, nama";
																   
				$rsNominatif = mysqli_query($mysqli,$qNominatif);
				$i = 1;
				while($nominatif = mysqli_fetch_array($rsNominatif))
				{
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><a href="../admin/index2.php?id=<?php echo $nominatif[id_pegawai]; ?>" target="_blank" ><?php echo $nominatif[nama]; ?></a></td>
						<td><?php echo $nominatif[nip_baru]; ?></td>
						<td><?php echo $nominatif[pangkat_gol]; ?></td>
						<td><?php echo $nominatif[tmt_proses]; ?></td>
						<td><?php echo $nominatif[nama_baru]; ?></td>				
					</tr>		
					<?php	
					$i++;
				}				
			?>					
		</tbody>
	</table>
</div>
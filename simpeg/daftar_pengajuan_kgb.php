<?php include "berkala_navbar.php"; ?>
<div class="page-header">
	<h1>Daftar KGB <br/><small>Daftar pegawai yang sudah mengajukan kenaikan gaji berkala tahun <?php echo date("Y"); ?></small></h1>
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
				$qListPengajuan = "SELECT p.id_pegawai, nama, nip_baru, pangkat_gol, tmt_proses, nama_baru
							       FROM pengajuan peng
								   INNER JOIN pegawai p ON p.id_pegawai = peng.id_pegawai
								   INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
								   INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
								   WHERE id_proses = 2
								   ORDER BY tmt_proses, nama_baru, nama, pangkat_gol ASC";								   
				$qrsListPengajuan = mysqli_query($mysqli,$qListPengajuan);
				$i = 1;
				while($pengajuan = mysqli_fetch_array($qrsListPengajuan))
				{
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><a href="../admin/index2.php?id=<?php echo $pengajuan[id_pegawai]; ?>" target="_blank" ><?php echo $pengajuan[nama]; ?></a></td>
						<td><?php echo $pengajuan[nip_baru]; ?></td>
						<td><?php echo $pengajuan[pangkat_gol]; ?></td>
						<td><?php echo $pengajuan[tmt_proses]; ?></td>
						<td><?php echo $pengajuan[nama_baru]; ?></td>				
					</tr>		
					<?php	
					$i++;
				}				
			?>
					
		</tbody>
	</table>
</div>


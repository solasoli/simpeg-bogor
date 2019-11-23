<!-- Tab Content of Riwayat Diklat -->

<table  class="hurup table table-bordered">
	<tr>
	  <td>No</td>
	  <td>Jenis Diklat</td>
	  <td>Nama Diklat</td>
	  <td>Tanggal Diklat</td>
	  <td>Jml Jam</td>
	  <td>Penyelenggara</td>
	  <td>No.STTPL</td>
	  <td>Sertifikat</td>
	</tr>
	<?php

		$qRiwayatDiklat = "select diklat.*,dj.jenis_diklat, DATE_FORMAT(tgl_diklat,'%d-%m-%Y') as tgl_diklat2
						from diklat
						inner join diklat_jenis dj on dj.id_jenis_diklat = diklat.id_jenis_diklat
						where id_pegawai = $od order by tgl_diklat asc";
		$rsRiwayatDiklat = mysqli_query($mysqli, $qRiwayatDiklat);
		$no = 1;
	?>
	<?php while($rRiwayatDiklat = mysqli_fetch_array($rsRiwayatDiklat)): ?>

	<tr>
		<td><?php echo $no++; ?> </td>
		<td><?php echo $rRiwayatDiklat['jenis_diklat']; ?></td>
		<td><?php echo $rRiwayatDiklat['nama_diklat']; ?></td>
		<td><?php echo $rRiwayatDiklat['tgl_diklat2']; ?></td>
		<td><?php echo $rRiwayatDiklat['jml_jam_diklat'] ?></td>
		<td><?php echo $rRiwayatDiklat['penyelenggara_diklat'] ?></td>
		<td><?php echo $rRiwayatDiklat['no_sttpl'] ?></td>
		<td>
			<?php
			if ($rRiwayatDiklat['id_berkas'] == 0 or $rRiwayatDiklat['id_berkas'] == ''):
				echo "-";
			else:
				echo("<a href='http://103.14.229.15/simpeg/berkas.php?idb=".basename($rRiwayatDiklat['id_berkas'])."' target='_blank' >View</a>");
			endif;
				?>

		</td>
	</tr>
	<?php endwhile; ?>
	<!-- tr>
		<td>+</td>
		<td>
			<select name="jns_diklat" id="jns_diklat" class="form-control">
				<?php
				/*
				$qdj2=mysqli_query($mysqli, "SELECT * FROM `diklat_jenis` ");
				while($data2=mysqli_fetch_array($qdj2))
					echo("<option value=$data2[0]>$data2[1]</option>");
*/
				?>
			</select>

		</td>
		<td><input class="form-control" name="nama_diklat" type="text" /></td>
		<td><input name="tgl_diklat" type="text"  class=tcal style=width:90px; /></td>
		<td><input class="form-control" name="jumlah_jam" type="text"   /></td>
		<td><input class="form-control" name="penyelenggara" type="text"    /></td>
		<td><input class="form-control" name="no_sttpl" type="text" style="width: 100px;" /></td>
		<td><input type=file name=filediklat id=filediklat /></td>
	</tr -->
</table>

		<!-- End of Tab Content of Riwayat Jabatan -->

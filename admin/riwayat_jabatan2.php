<!-- Tab Content of Riwayat Jabatan -->

				<table border="0" cellpadding="3" cellspacing="0" class="hurup">
					<tr>
					  <td>No </td>
					  <td>Jabatan</td>
					  <td>Unit Kerja</td>
					  <td>No. Surat Keputusan</td>
					  <td>Tgl SK</td>
					  <td>TMT</td>
					</tr>
					<?php
						$qRiwayatJabatan = "SELECT *
									  FROM riwayat_mutasi_kerja r
									  INNER JOIN unit_kerja u ON u.id_unit_kerja = r.id_unit_kerja
									  INNER JOIN sk s ON s.id_sk = r.id_sk
										INNER JOIN jabatan j on j.id_j = r.id_j
									  WHERE r.id_pegawai =  $id";

						//$qRiwayatJabatan = "select * from riwayat_kerja where id_pegawai =$id order by tgl_masuk ASC";
						$rsRiwayatJabatan = mysqli_query($con,$qRiwayatJabatan);
						$no = 1;
					?>
					<?php while($rRiwayatJabatan = mysqli_fetch_array($rsRiwayatJabatan)): ?>

					<tr>
						<td><?php echo $no++; ?> </td>
						<td  ;>
							<input type="hidden" name="id_riwayat_kerja<?=$no-1?>" value="<?=$rRiwayatJabatan[0]?>"/>
							<input name="nama_jabatan<?=$no-1?>" value="<?php echo $rRiwayatJabatan['jabatan']?>"	 type="text" />
						</td>
						<td>
							<input  name="unit_kerja<?=$no-1?>"  type="text" value="<?php echo $rRiwayatJabatan['nama_baru']; ?>" />
						</td>
						<td>
							<input  name="no_sk<?=$no-1?>"  type="text" value="<?php echo $rRiwayatJabatan['no_sk']; ?>" />
						</td>
						<td>
							<input name="tahun_masuk<?=$no-1?>" type="text" value="<?php echo ($rRiwayatJabatan['tgl_sk'] === '1970-01-01' || $rRiwayatJabatan['tgl_sk'] === NULL ? NULL : $format->date_dmY($rRiwayatJabatan['tgl_sk']) ) ?>" />
						</td>
						<td>
							<input name="tahun_keluar<?=$no-1?>"  type="text" value="<?php echo ($rRiwayatJabatan['tmt'] === '1970-01-01' || $rRiwayatJabatan['tmt'] === NULL ? NULL : $format->date_dmY($rRiwayatJabatan['tmt']) ) ?>" />
						</td>
					</tr>
					<?php endwhile; ?>
					<tr>
						<td>+</td>
						<td><input name="nama_jabatan" type="text" /></td>
						<td><input name="unit_kerja" type="text"   /></td>
						<td><input name="no_sk" type="text"   /></td>
						<td><input name="tahun_masuk" type="text"   class="tcal" id="tglMasukJab"/></td>
						<td><input name="tahun_keluar" type="text" class="tcal" id="tglKeluarJab" /></td>
					</tr>
				</table>

		<!-- End of Tab Content of Riwayat Jabatan -->
		<h4>jabatan fungsional umum</h4>
		<table border="0" cellpadding="3" cellspacing="0" class="hurup">
			<tr>
				<td>No </td>
				<td>Jabatan</td>
				<td>Unit Kerja</td>
				<td>No. Surat Keputusan</td>
				<td>Tahun Masuk</td>
				<td>Tahun Keluar</td>
			</tr>
			<?php
				$qRiwayatJabatan = "SELECT *
								FROM jfu_pegawai r
								left JOIN sk s ON s.id_sk = r.id_sk
								WHERE r.id_pegawai =  $id";

				//$qRiwayatJabatan = "select * from riwayat_kerja where id_pegawai =$id order by tgl_masuk ASC";
				$rsRiwayatJabatan = mysqli_query($con,$qRiwayatJabatan);
				$no = 1;
			?>
			<?php while($rRiwayatJabatan = mysqli_fetch_array($rsRiwayatJabatan)): ?>

			<tr>
				<td><?php echo $no++; ?> </td>
				<td>
					<input type="hidden" name="id_riwayat_kerja<?=$no-1?>" value="<?=$rRiwayatJabatan[0]?>"/>
					<input name="nama_jabatan<?=$no-1?>" value="<?php echo $rRiwayatJabatan['jabatan']?>"	 type="text" />
				</td>
				<td>
					<input  name="unit_kerja<?=$no-1?>" style="width: 500px;" type="text" value="<?php echo $rRiwayatJabatan['3']; ?>" />
				</td>
				<td>
					<input  name="no_sk<?=$no-1?>" style="width: 250px;" type="text" value="<?php echo $rRiwayatJabatan['4']; ?>" />
				</td>
				<td>
					<input name="tahun_masuk<?=$no-1?>" style="width: 100px;" type="text" value="<?php echo ($rRiwayatJabatan['7'] === '1970-01-01' || $rRiwayatJabatan['7'] === NULL ? NULL : $format->date_dmY($rRiwayatJabatan['7']) ) ?>" />
				</td>
				<td>
					<input name="tahun_keluar<?=$no-1?>" style="width: 100px;" type="text" value="<?php echo ($rRiwayatJabatan['8'] === '1970-01-01' || $rRiwayatJabatan['8'] === NULL ? NULL : $format->date_dmY($rRiwayatJabatan['8']) ) ?>" />
				</td>
			</tr>
			<?php endwhile; ?>
			<tr>
				<td>+</td>
				<td><input name="nama_jabatan" type="text" /></td>
				<td><input name="unit_kerja" type="text"  style="width: 500px;" /></td>
				<td><input name="no_sk" type="text"  style="width: 250px;" /></td>
				<td><input name="tahun_masuk" type="text"  style="width: 100px;" class="tcal" id="tglMasukJab"/></td>
				<td><input name="tahun_keluar" type="text"  style="width: 100px;" class="tcal" id="tglKeluarJab" /></td>
			</tr>
		</table>

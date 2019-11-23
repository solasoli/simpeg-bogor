<h2>Data Keluarga</h2>

<?
	if($ata["status_kawin"] == "Belum Menikah") // status pegawai masih lajang
	{
		echo "Status pernikahan anda $ata[status_kawin]. <br/>";
	}
	else
	{
		// mengambil data pasangan hidup
		$pasangan = "Suami";
		if ($ata["jenis_kelamin"] == "L")
		{
			$pasangan = "Istri";
		}
		
		?>
		<?php if($ata["nama_istri"] != ""): ?>
		<table>
			<tr>
				<td>Nama <? echo $pasangan; ?></td>
				<td>:</td>
				<td><? echo $ata["nama_istri"]; ?></td>
			</tr>
			<tr>
				<td>Tempat, Tanggal Lahir</td>
				<td>:</td>
				<td><? echo "$ata[tempat_lahir_istri], ".toShortDate($ata["tgl_lahir_istri"]); ?></td>
			</tr>
		</table>
		<br />
		<?php endif ?>
			
		<?
		
		
		
		$sql = "select
					pegawai.nama_istri,
					pegawai.tempat_lahir_istri,
					pegawai.tgl_lahir_istri,
					anak.nama_anak,
					anak.tempat_lahir as tempat_lahir_anak,
					anak.tgl_lahir as tgl_lahir_anak
				from pegawai
				join anak on pegawai.id_pegawai=anak.id_pegawai
				where anak.id_pegawai = $ata[0];";
				
		$result = mysqli_query($mysqli,$sql);

		if(mysqli_num_rows($result) > 0)
		{
			?>
			<h2>Anak</h2>
			<table border="1" style="border-collapse:collapse;"  cellpadding="5">
				<tr>
					<td>Nama Anak</td>
					<td>Tempat Lahir</td>
					<td>Tanggal Lahir</td>
				</tr>
				<?
				while($r = mysqli_fetch_array($result))
				{
					?>
					<tr>
						<td><? echo $r[nama_anak]; ?></td>
						<td><? echo $r[tempat_lahir_anak]; ?></td>
						<td><? echo toShortDate($r[tgl_lahir_anak]); ?></td>
					</tr>
					<?
				}
				?>
			</table>
			<?
		}
	}
?>
<br />
<br />
<? echo $footer_note; ?>
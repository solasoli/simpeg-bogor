--- RIWAYAT PEKERJAAN ---
<?

	$sql = "select

			  jabatan,

			  unit_kerja,

			  tahun_masuk,

			  tahun_keluar

			from riwayat_kerja

			where id_pegawai = $ata[0]

			order by id_riwayat_kerja ;";

			//echo("$sql");

	$result = mysqli_query($mysqli,$sql);

	if(mysqli_num_rows($result) > 0)

	{

		?>

		<h2>Riwayat Kerja </h2>

		<table cellpadding="5" border="1" style="border-collapse:collapse">

		<tr>

			<td style="background-color:blue"><font color="white">Jabatan</td>
			
			<td style="background-color:blue"><font color="white">Unit Kerja</td>

			<td style="background-color:blue"><font color="white">Tahun Masuk</td>

			<td style="background-color:blue"><font color="white">Tahun Keluar</td>

			<!--<td>Keterangan</td>-->
		</tr>

		<?

		while($r = mysqli_fetch_array($result))

		{

		?>

			<tr>

				<td><? echo $r[jabatan]; ?></td>

				<td><? echo $r[unit_kerja]; ?></td>

				<td><? echo $r[tahun_masuk]; ?></td>

				<td><? echo $r[tahun_keluar]; ?></td>

			</tr>

		<?

		}

		?>
		</table>

		<?

	}

	else

	{

		echo "Tidak ada riwayat mutasi kerja.";

	}

?>

<br/>

<br/>

<? echo $footer_note; ?>


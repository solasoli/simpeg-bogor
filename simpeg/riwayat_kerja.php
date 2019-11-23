<?

	$sql = "select

			  riwayat_mutasi_kerja.id_pegawai,

			  sk.no_sk,

			  sk.tgl_sk,

			  unit_kerja.nama_baru,

			  riwayat_mutasi_kerja.jabatan,

			  riwayat_mutasi_kerja.keterangan

			from riwayat_mutasi_kerja

			inner join sk on riwayat_mutasi_kerja.id_sk = sk.id_sk

			inner join kategori_sk on sk.id_kategori_sk = kategori_sk.id_kategori_sk

			inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja

			where riwayat_mutasi_kerja.id_pegawai = $ata[0]

			order by sk.tgl_sk ;";

			//echo("$sql");

	$result = mysqli_query($mysqli,$sql);

	if(mysqli_num_rows($result) > 0)

	{

		?>

		<h2>Riwayat Kerja </h2>

		<table cellpadding="5" border="1" style="border-collapse:collapse">

		<tr>

			<td>Unit Kerja</td>

			<td>Jabatan</td>

			<td>Nomor SK</td>

			<td>Tanggal SK</td>

			<!--<td>Keterangan</td>-->
		</tr>

		<?

		while($r = mysqli_fetch_array($result))

		{

		?>

			<tr>

				<td><? echo $r[nama_baru]; ?></td>

				<td><? echo $r[jabatan]; ?></td>

				<td><? echo $r[no_sk]; ?></td>

				<td><? echo toShortDate($r[tgl_sk]); ?></td>

				<!--<td><? echo $r[keterangan]; ?></td>-->
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


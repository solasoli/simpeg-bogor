<h2>Pendidikan dan Pelatihan</h2>

<h2>Pendidikan Formal</h2>

<?

	// Menampilkan data pendidikan formal (dari tabel penddikan)

	$sql = "select 

				lembaga_pendidikan,

				tingkat_pendidikan,

				jurusan_pendidikan,

				tahun_lulus 

			from pendidikan

			where id_pegawai = $ata[0]

			order by tahun_lulus desc";

			

	$result = mysqli_query($mysqli,$sql);



	if(mysqli_num_rows($result) > 0)

	{

		?>

		<table border="1" style="border-collapse:collapse;" cellpadding="5" >

			<tr>

				<td>Lembaga Pendidikan</td>

				<!--<td>Tingkat Pendidikan</td>-->

				<td>Jurusan Pendidikan</td>

				<td>Tahun Lulus</td>

			</tr>

			<?

			while($r = mysqli_fetch_array($result))

			{

				?>

				<tr>

					<td><? echo $r[lembaga_pendidikan]; ?></td>

					<!--<td><? echo $r[tingkat_pendidikan]; ?></td>-->

					<td><? echo $r[jurusan_pendidikan]; ?></td>

					<td><? echo $r[tahun_lulus]; ?></td>

				</tr>

				<?

			}

			?>

		</table>

		<?

	}

	else

	{

		echo "Anda tidak memliliki data pendidikan formal.<br/><br/>

			  <font color='red'>Mohon maaf, atas ketidakvalidan data ini. 

			  Kemungkinan anda belum melengkapi data pendidikan anda di BKPP.</font><br />";

			  

	}

	

?>





<br/>

<br/>

<h2>Pendidikan Informal/ Pelatihan</h2>

<br/>

<br/>

<?

	// Menampilkan data pendidikan informal dan pelatihan (dar tabel diklat)

	$sql = "select 

				jenis_diklat,

				nama_diklat,

				tgl_diklat,

				jml_jam_diklat,

				keterangan_diklat 

			from diklat

			where id_pegawai = $ata[0]

			order by tgl_diklat desc";

			

	$result = mysqli_query($mysqli,$sql);



	if(mysqli_num_rows($result) > 0)

	{

		?>

		<table border="1" style="border-collapse:collapse;" cellpadding="5" >

			<tr>

				<td>Jenis</td>

				<td>Nama</td>

				<td>Tanggal</td>

				<td>Jumlah jam</td>

				<td>Keterangan</td>

			</tr>

			<?

			while($r = mysqli_fetch_array($result))

			{

				?>

				<tr>

					<td><? echo $r[jenis_diklat]; ?></td>

					<td><? echo $r[nama_diklat]; ?></td>

					<td><? echo toShortDate($r[tgl_diklat]); ?></td>

					<td><? echo $r[jml_jam_diklat]; ?></td>

					<td><? echo $r[keterangan_diklat]; ?></td>

				</tr>

				<?

			}

			?>

		</table>

		<?

	}

	else

	{

		echo "Anda tidak memliliki data pendidikan informal ataupun pelatihan.<br/><br/>";

	}

	

?>



<br/>

<? echo $footer_note; ?>

	
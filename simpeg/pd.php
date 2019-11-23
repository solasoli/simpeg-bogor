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

				<td style="background-color:blue"><font color="white">Lembaga Pendidikan</font></td>

				<!--<td>Tingkat Pendidikan</td>-->

				<td  style="background-color:blue"><font color="white">Jurusan Pendidikan</font></td>

				<td  style="background-color:blue"><font color="white">Tahun Lulus</font></td>
				<td  style="background-color:blue"align="center"><font color="white">Pilih Ijasah</font></td>
				<td  style="background-color:blue"><font color="white">upload Ijasah</font></td>

			</tr>

			<?

			while($r = mysqli_fetch_array($result))

			{

				?>

				<tr>
				<form method="post" enctype="multipart/form-data" action="">
					<td><? echo $r[lembaga_pendidikan]; ?></td>

					<!--<td><? echo $r[tingkat_pendidikan]; ?></td>-->

					<td><? echo $r[jurusan_pendidikan]; ?></td>

					<td><? echo $r[tahun_lulus]; ?></td>
					<td align ="center"><input type="file" name="ijasah" /></td>
					<td align ="center"><input type="submit" name="btnUpload" value="Upload" /></td>
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
<h2>Penghargaan</h2>

<?

	$sql = "select 

				nama_penghargaan,

				pemberi_penghargaan,

				tgl_penghargaan,

				keterangan 

			from penghargaan

			where id_pegawai = $ata[0]

			order by tgl_penghargaan desc";

			

	$result = mysqli_query($mysqli,$sql);



	if(mysqli_num_rows($result) > 0)

	{

		?>

		<table border="1" style="border-collapse:collapse;" >

			<tr>

				<td>Nama Penghargaan</td>

				<td>Pemberi Penghargaan</td>

				<td>Tanggal Perolehan</td>

				<td>Keterangan</td>

			</tr>

			<?

			while($r = mysqli_fetch_array($result))

			{

				?>

				<tr>

					<td><? echo $r[nama_penghargaan]; ?></td>

					<td><? echo $r[pemberi_penghargaan]; ?></td>

					<td><? echo toShortDate($r[tgl_penghargaan]); ?></td>

					<td><? echo $r[keterangan]; ?></td>

				</tr>

				<?

			}

			?>

		</table>

		<?

	}

	else

	{

		echo "Tidak terdapat data penghargaan yang pernah diperoleh.<br />";

			  

	}

?>

<br/>

<? echo $footer_note; ?>
<h2>Sertifikat</h2>
<b><font size= "3px" >---DATA SERTIFIKAT-- </font></b>
</br>
</br>
<?

	$sql = "select 

				nama_sertifikat,

				lembaga_pembuat_sertifikat,

				tgl_sertifikat,

				keterangan 

			from sertifikat

			where id_pegawai = $ata[0]

			order by tgl_sertifikat  desc";

			

	$result = mysqli_query($mysqli,$sql);

	

	if(mysqli_num_rows($result) > 0)

	{

		?>

		<table border="1" style="border-collapse:collapse;" >

			<tr>

				<td>Nama Sertifikat</td>

				<td>Lembaga Pembuat Sertifikat</td>

				<td>Tanggal Sertifikat</td>

				<td>Keterangan</td>

			</tr>

			<?

			while($r = mysqli_fetch_array($result))

			{

				?>

				<tr>

					<td><? echo $r[nama_sertifikat]; ?></td>

					<td><? echo $r[lembaga_pembuat_sertifikat]; ?></td>

					<td><? echo toShortDate($r[tgl_sertifikat]); ?></td>

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

		echo "Tidak terdapat data sertifikat yang pernah diperoleh.<br />";

			  

	}

?>



<br/>

<? echo $footer_note; ?>
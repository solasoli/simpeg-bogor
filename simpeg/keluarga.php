<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
-->
</style><h2>Data Keluarga</h2>
<b><font size= "3px" >---DATA KELUARGA-- </font></b>
</br>
</br>
<?
	if($ata["status_kawin"] != "Menikah") // status pegawai masih lajang/ janda/ duda
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
		<table border="1" style="border-collapse:collapse;"  cellpadding="5">
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
		
		
		
		
	} //#############
	$sql = "select
					pegawai.nama_istri,
					pegawai.tempat_lahir_istri,
					pegawai.tgl_lahir_istri,
					anak.nama_anak,
					anak.tempat_lahir as tempat_lahir_anak,
					anak.tgl_lahir as tgl_lahir_anak,id_anak
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
					
					<td>Delete</td>
				</tr>
				<?
				while($r = mysqli_fetch_array($result))
				{
					?>
					<tr>
						<td><? echo $r[nama_anak]; ?></td>
						<td><? echo $r[tempat_lahir_anak]; ?></td>
						<td><? echo toShortDate($r[tgl_lahir_anak]); 
						
						
						
						?></td>
						<?
						echo(" 
		    <td nowrap><a href=index2.php?x=formkeluarga.php&ha=$r[6]>hapus</a></td>");
						
						?>
					</tr>
					<?
				}
				?>
			</table>
			<p>
  <?
		}
?>
  <br />
  <br />
  <? echo $footer_note; ?></p>
  <?
  $qkel=mysqli_query($mysqli,"select count(*) from keluarga where id_pegawai=$ata[0]");
 
  $tung=mysqli_fetch_array($qkel);
  if($tung[0]>0)
  {
  ?>
			<!--<table width="500" border="0" cellspacing="0" cellpadding="5">-->
			<table class="table-bordered">	
  <tr>
    <td><div align="center">Status Keluarga </div></td>
    <td nowrap="nowrap"><div align="center">Nama</div></td>
    <td nowrap="nowrap"><div align="center">Tempat Lahir </div></td>
    <td><div align="center">Pekerjaan </div></td>
	<td><div align="center">Jenis Kelamin </div></td>
	<td><div align="center">Tanggal Lahir </div></td>
	<td><div align="center">Keterangan </div></td>
	<td><div align="center">Edit </div></td>
	<td><div align="center">Hapus </div></td>
  </tr>
  <?
  $qk=mysqli_query($mysqli,"select * from keluarga where id_pegawai=$ata[0] order by id_status"); 
   $i=1;
   while($ta=mysqli_fetch_array($qk))
  {
  $qs=mysqli_query($mysqli,"select status_keluarga from status_kel where id_status=$ta[2] ");
  $sta=mysqli_fetch_array($qs);
  $tgl=substr($ta[5],8,2);
  $bln=substr($ta[5],5,2);
  $thn=substr($ta[5],0,4);
if($i%2==0)
echo("<tr>");
else
echo("<tr bgcolor=#f0f0f0>");
echo(" 
    <td>$sta[0] </td>
    <td>$ta[3]</td>
    <td>$ta[4]</td>
	<td>$ta[6]</td>
	<td>$ta[7]</td>
    <td>$tgl-$bln-$thn</td>
	 <td>$ta[8]</td>
	    <td><a href=index2.php?x=formkeluarga.php&e=$ta[0]>edit</a></td>
		    <td><a href=index2.php?x=formkeluarga.php&h=$ta[0]>hapus</a></td>
  </tr>");
  
  $i++;
  }
  
  ?>
</table>
<?
}
?>

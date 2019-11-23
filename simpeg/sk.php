<?php
//print_r($_SESSION);

$q = "SELECT * FROM pegawai WHERE id_pegawai = $_SESSION[id_pegawai]";
$result = mysqli_query($mysqli,$q);
$r = mysqli_fetch_array($result);

$nip_baru = $r[nip_baru];


$q = "SELECT * FROM sk 
	INNER JOIN kategori_sk ON kategori_sk.id_kategori_sk = sk.id_kategori_sk
	WHERE id_pegawai = $_SESSION[id_pegawai]";
$result = mysqli_query($mysqli,$q);


?>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:436px;
	top:14px;
	width:307px;
	height:237px;
	z-index:1;
	visibility: hidden;
}
-->
</style>

<table border="1" style = "border: 1px 1px 1px 1px; border-collapse: collapse;" cellpadding="5">
	<tr>
		<td>
		Kategori SK
		</td>
		<td>
		Nomor SK
		</td>
		<td>
		TMT
		</td>
		<td>
		Arsip Digital
		</td>
	</tr>
	<?php
	if($_FILES["file"]["size"]>0)
	include("upload_file.php");
	
	
	while($r = mysqli_fetch_array($result))
	{
		?>
		<tr>
		<td>
		<?php echo $r[nama_sk]; ?>
		</td>
		<td>
		<?php echo $r[no_sk]; ?>
		</td>
		<td>
		<?php echo substr($r[tmt], 9,2)."/".substr($r[tmt], 5,2)."/".substr($r[tmt], 0,4); ?>
		</td>
		<td>
		<?php
		if(file_exists("sk/$nip_baru"."-"."$r[id_sk].jpg"))
		{
			?>
			<a onclick="window.open('<?php echo "sk/$nip_baru"."-"."$r[id_sk].jpg";?>', 'SK', 'toolba=no, status=no, menubar=no')" href="#"> Lihat </a>&nbsp;&nbsp;&nbsp;
			<?php
		}
		else if(file_exists("sk/$nip_baru"."-"."$r[id_sk].pdf"))
		{
			?>
			<a onclick="window.open('<?php echo "sk/$nip_baru"."-"."$r[id_sk].pdf";?>', 'SK', 'toolba=no, status=no, menubar=no')" href="#"> Lihat </a>&nbsp;&nbsp;&nbsp;
			<?php
		}
		?>
		<form action="index2.php" method="post"
		enctype="multipart/form-data">
		<input type="file" name="file" id="file" />
		<input name="x" type="hidden" id="x" value="sk.php" />
		<input type="hidden" name="filename" value="<?php echo "$nip_baru"."-"."$r[id_sk]."; ?>" />
		<input type="submit" name="submit" value="Submit" />
		</form>	
		</td>
	</tr>
		<?php
	}
?>
</table>
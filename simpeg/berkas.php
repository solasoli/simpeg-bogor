<style>
.break { page-break-before: always; }
</style>
<?php
include("konek.php");
extract($_GET);
$qb = mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$idb");
//echo("select file_name from isi_berkas where id_berkas=$idb");

echo("<table border=0 cellpadding=0 cellspacing=0 width=100%>");

while($alay=mysqli_fetch_array($qb))
{
$asli=basename($alay[0]);

$ext = explode(".",$asli);

	if($ext[1] == 'jpg' || $ext[1] == 'jpeg'){
		//print_r($asli);
		echo("<tr class='break'><td align='center'><img src=./berkas/$asli  height=100% /></td></tr>");
	}else{
		echo "<a href='./berkas/$asli'>download</a>";
	}
}
echo("</table>");
?>

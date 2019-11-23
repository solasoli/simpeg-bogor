<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from temp");
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select count(*) from pegawai where nip_lama='$data[1]' or nip_baru='$data[1]'");
$ata=mysqli_fetch_array($q1);	
if($ata[0]>0)	
{
$q2=mysqli_query($mysqli,"select * from pegawai where nip_lama='$data[1]' or nip_baru='$data[1]'");
$ta=mysqli_fetch_array($q2);
mysqli_query($mysqli,"update temp set id_pegawai=$ta[0] where id=$data[0]");
//echo("udpate temp set id_pegawai=$ta[0] where id=$data[0]<br>");
}
}

?>
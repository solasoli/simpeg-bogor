<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from riwayat_mutasi_kerja where id_riwayat>=43317 order by id_riwayat ");
$i=1;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$data[4]");
$cek=mysqli_fetch_array($q1);
mysqli_query($mysqli,"update riwayat_mutasi_kerja set jabatan='$cek[0]' where id_riwayat=$data[0]");	
	$i++;
}
$g=$i-1;
echo("$g rows afffected");
?>
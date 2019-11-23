<?
include("konek.php");
$q=mysqli_query($mysqli,"SELECT nip_lama, length( nip_baru ),id_pegawai
FROM `pegawai`
WHERE length( nip_baru ) <10 ");

while($data=mysqli_fetch_array($q))
{

$q1=mysqli_query($mysqli,"select count(*) from konversi_nip where nip_lama='$data[0]'");




$cek=mysqli_fetch_array($q1);


if($cek[0]>0)
{

$q2=mysqli_query($mysqli,"select * from konversi_nip where nip_lama='$data[0]'");
$ceg=mysqli_fetch_array($q2);
//echo("select * from konversi_nip where nip_lama='$data[0]'<br>");

mysqli_query($mysqli,"update pegawai set nip_baru='$ceg[2]' where id_pegawai=$data[2]");
echo("update pegawai set nip_baru='$ceg[2]' where id_pegawai=$data[2]<br>");
mysqli_query($mysqli,"update konversi_nip set id_pegawai=$data[2],flag=1 where nip_lama='$data[0]'");
echo("update konversi_nip set id_pegawai=$data[2],flag=1 where nip_lama='$data[0]'<br>");

}

}
echo("done");

?>
<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from mus2 where id_pegawai>0");
$i=0;
while($data=mysqli_fetch_array($q))
{
$cek=substr($data['karpeg'],-1);

$q1=mysqli_query($mysqli,"select no_karpeg from pegawai where id_pegawai=$data[id_pegawai]");
$cek2=mysqli_fetch_array($q1);

if(is_numeric($cek) and !is_numeric($cek2[0]))
{
mysqli_query($mysqli,"update pegawai set no_karpeg=$data[karpeg] where id_pegawai=$data[id_pegawai]");	
$i++;
}
}
echo("$i rows affected");
?>
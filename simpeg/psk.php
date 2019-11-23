<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from pegawai where flag_pensiun=0");
$i=0;
$j=0;
$k=0;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$data[0] and id_kategori_sk=5 and id_berkas>0");
$cek=mysqli_fetch_array($q1);

if($cek[0]>0)
{
$q2=mysqli_query($mysqli,"select * from sk where id_pegawai=$data[0] and id_kategori_sk=5 and id_berkas>0 order by tmt desc");
$cok=mysqli_fetch_array($q2);

$bon=explode(",","$cok[7]");
//echo("$bon<br>");
if($bon[0]==$data['pangkat_gol'])
{


$i++;
}
else
{
echo("$bon[0] $data[nama] $data[pangkat_gol]<br>");
if($bon[0]!='-')
{
$qsk=mysqli_query($mysqli,"Select * from golongan where golongan='$bon[0]'");
$sk=mysqli_fetch_array($qsk);

$qp=mysqli_query($mysqli,"Select * from golongan where golongan='$data[pangkat_gol]'");
$p=mysqli_fetch_array($qp);

if($sk[0]>$p[0])
{
mysqli_query($mysqli,"update pegawai set pangkat_gol='$bon[0]' where id_pegawai=$data[0]");
$j--;
}
}


$j++;

}
}



}
echo ("done $i");
?>
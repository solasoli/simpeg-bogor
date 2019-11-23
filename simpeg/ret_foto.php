<?
include("konek.php");
extract($_GET);
$q=mysqli_query($mysqli,"select count(*) from pegawai where nip_baru like '%$nip%' or nip_lama like '%$nip%'");
$cek=mysqli_fetch_array($q);
if($cek[0]!=0)
{
$q1=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_baru like '%$nip%' or nip_lama like '%$nip%'");
$foto=mysqli_fetch_array($q1);
if (file_exists("./foto/$foto[0].jpg")) 
{

include("./foto/$foto[0].jpg");
}
else
{
$q2=mysqli_query($mysqli,"select jenis_kelamin from pegawai where nip_baru like '%$nip%' or nip_lama like '%$nip%'");
$kosong=mysqli_fetch_array($q2);
if($kosong[0]=='L')
{

include("./images/male.jpg");

}
else
include("./images/female.jpg");
}
}


?>
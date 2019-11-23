<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from  tempo   ");
while($data=mysqli_fetch_array($q))
{
/*$ganti=trim($data[1]);
echo("$data[1]jadi $ganti<br>");
mysqli_query($mysqli,"update tempo set nama='$ganti' where id=$data[0]");	
$nama=addslashes("$data[1]");
*/
$qc=mysqli_query($mysqli,"select id_pegawai from pegawai where nama like '%$data[1]%' or nip_baru like '%$data[2]%' or nip_lama like '%$data[2]%'");
//echo("select id_pegawai from pegawai where nama like '%$data[1]%' or nip_baru like '%$data[2]%'<br>");	
$cek=mysqli_fetch_array($qc);

if($cek[0]!=NULL)
mysqli_query($mysqli,"update tempo set id_pegawai=$cek[0] where id=$data[0]");
//("update tempo set id_pegawai=$cek[0] where id=$data[0]<br>");	
/*
$qc=mysqli_query($mysqli,"Select id_unit_kerja from unit_kerja where nama_baru like '$data[3]%' and tahun=2010");
//echo("Select id_unit_kerja from unit_kerja where nama_baru like '$data[3]%' and tahun=2010<br>");
$cek=mysqli_fetch_array($qc);

$qc2=mysqli_query($mysqli,"Select id_unit_kerja from unit_kerja where nama_baru like '$data[4]%' and tahun=2011");
$cek2=mysqli_fetch_array($qc2);
if($cek[0]!=NULL  and $cek2[0]!=NULL)
mysqli_query($mysqli,"update tempo set lama='$cek[0]',baru='$cek2[0]' where id=$data[0]");
*/
}
echo("done");

?>
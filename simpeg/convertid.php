<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from kepang where id_pegawai=0");
while($data=mysqli_fetch_array($q))
{
	//nama like '$nama[0] $nama[1]%' or
$nama=explode(" ","$data[2]");
$qc=mysqli_query($mysqli,"select count(*) from pegawai where nama like '$nama[0] $nama[1]%'");
$cek=mysqli_fetch_array($qc);

if($cek[0]>0)
{
$qd=mysqli_query($mysqli,"select id_pegawai from pegawai where nama like '$nama[0] $nama[1]%'");
$dek=mysqli_fetch_array($qd);
mysqli_query($mysqli,"update kepang set id_pegawai=$dek[0] where id_kepang=$data[0]");
}

}
echo("done");

?>
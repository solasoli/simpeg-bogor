<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from kepang order by id_kepang");
while($data=mysqli_fetch_array($q))
{
	$q1=mysqli_query($mysqli,"select count(*) from pegawai where nip_baru ='$data[3]' or nip_lama='$data[3]'");
	$cek=mysqli_fetch_array($q1);
	if($cek[0]>0)
	{
		$q2=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_baru ='$data[3]' or nip_lama='$data[3]'");
	$ada=mysqli_fetch_array($q2);
		mysqli_query($mysqli,"update kepang set id_pegawai=$ada[0] where id_kepang=$data[0]");
	}
	else
	{
		
		$q3=mysqli_query($mysqli,"select id_pegawai from pegawai where nama like '%$data[2]%'");
	$ada2=mysqli_fetch_array($q3);
		mysqli_query($mysqli,"update kepang set id_pegawai=$ada2[0] where id_kepang=$data[0]");
		
		
	}
}
?>
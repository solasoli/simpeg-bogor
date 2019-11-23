<?
include("konek.php");
$q=mysqli_query($mysqli,"select id_j,id_bos from jabatan where tahun=2011 and (eselon not like 'IIA' or eselon not like 'IIB') ");
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select id_riwayat from  riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where id_j=$data[0] order by  tmt desc");	
	$cek=mysqli_fetch_array($q1);
	
	
	
}
?>
<?
include("konek.php");
$q=mysqli_query($mysqli,"Select * from kepang where id_kepang>853");
while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt) values ($data[1],5,'$data[6]','$data[8]','Gubernur Jawa Barat','Kepala BKD Propinsi Jawa Barat','$data[5],$data[9],$data[10]','$data[8]')");

mysqli_query($mysqli,"update pegawai set pangkat_gol='$data[5]' where id_pegawai=$data[1]");
 	
	
}

echo("done!");
?>
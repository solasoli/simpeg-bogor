<?
include("konek.php");

$q=mysqli_query($mysqli,"Select * from satya where id_pegawai>0");
while($data=mysqli_fetch_array($q))
{
	mysqli_query($mysqli,"insert into penghargaan (id_pegawai,nama_penghargaan,pemberi_penghargaan,tgl_penghargaan) values ($data[3],'Satyalancana Karya Satya $data[2] Tahun','Presiden RI','2011-08-27')");
	//mysqli_query($mysqli,"update satya sety flag=1 where id_pegawai=$data[3]");
}
echo("done");
?>
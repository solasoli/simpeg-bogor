<?

include("konek.php");
$q=mysqli_query($mysqli,"select * from pns ");
while($data=mysqli_fetch_array($q))
{
/*
$qc=mysqli_query($mysqli,"Select id_pegawai from pegawai where nip_baru like '%$data[2]%'");
$cek=mysqli_fetch_array($qc);
	
mysqli_query($mysqli,"update pns set id_pegawai=$cek[0] where id=$data[0]");

*/
$qc=mysqli_query($mysqli,"Select count(*) from sk where id_kategori_sk=7 and id_pegawai=$data[8]");
$cek=mysqli_fetch_array($qc);

if($cek[0]==0)
{
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,id_j,keterangan,pemberi_sk,pengesah_sk) values ($data[8],7,'821.45-133 Tahun 2011','$data[4]','$data[5]',0,'$data[7],$data[9],$data[9]','$data[6]','$data[6]') ");

mysqli_query($mysqli,"update pns set udah=1 where id=$data[0]");

}
}
echo("done");
?>
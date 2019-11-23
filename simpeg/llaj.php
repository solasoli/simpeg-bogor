<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from llaj where id_pegawai>0");
while($data=mysqli_fetch_array($q))
{

$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$data[8] and id_kategori_sk=6");
$f=mysqli_fetch_array($q1);
if($f[0]==0)
{
mysqli_query($mysqli,"insert into sk  (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt) values ($data[8],6,'$data[2]','$data[4]','-','-','$data[5],$data[6],$data[7]','$data[3]')");
mysqli_query($mysqli,"update llaj set udah=1  where id=$data[0]");	
}
elseif($f[0]==1)
{
$q2=mysqli_query($mysqli,"select * from sk where id_pegawai=$data[8] and id_kategori_sk=6");	
	$up=mysqli_fetch_array($q2);
mysqli_query($mysqli,"update sk set no_sk='$data[2]',tgl_sk='$data[4]',tmt='$data[3]',keterangan='$data[5],$data[6],$data[7]' where id_sk=$up[0]");	
mysqli_query($mysqli,"update llaj set udah=1  where id=$data[0]");	
}

}
echo("done.php");
?>
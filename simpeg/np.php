<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from mus2 where id_pegawai>0 and rubah=1");
$i=0;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select no_sk,tgl_sk,pemberi_sk,pengesah_sk from sk where tmt='$data[tmt]'");
$cek=mysqli_fetch_array($q1);
if(is_numeric(substr($cek[0],0,1)))
{
mysqli_query($mysqli,"insert into sk (no_sk,tgl_sk,pemberi_sk,pengesah_sk,id_kategori_sk,keterangan,tmt,id_pegawai) values ('$cek[0]','$cek[1]','$cek[2]','$cek[3]',5,'$data[gol]','$data[tmt]',$data[id_pegawai]");	
mysqli_query($mysqli,"update mus2 set rubah=2 where id_mus=$data[0]");
$i++;
}
}
echo("$i rows affected");
?>
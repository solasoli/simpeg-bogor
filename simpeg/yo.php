<?
include("konek.php"); 
$q=mysqli_query($mysqli,"select * from yo order by id");
while($data=mysqli_fetch_array($q))
{
if(substr($data[1],2,1)=='A')
$no="821.2.45 - 4 Tahun 2009";
elseif(substr($data[1],2,1)=='B')
$no="821.2.45 - 5 Tahun 2009";
else
$no="821.2.45 - 6 Tahun 2009";
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,tmt,id_j) values ($data[0],10,'$no','2009-01-15','Walikota Bogor','Walikota Bogor','2009-01-16',0)");
}
echo("done!");
?>
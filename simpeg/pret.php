<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from tu");
$i=1;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"Select id_pegawai from pegawai where nip_baru like '%$data[1]%' or  nip_lama like '%$data[1]%' ");
$ata=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"Select id_j from jabatan where jabatan like '%$data[3]%' and Tahun=2011");
$ta=mysqli_fetch_array($q2);

mysqli_query($mysqli,"update tu set id_pegawai=$ata[0],id_j=$ta[0] where id_aja=$data[0]");
echo("update tu set id_pegawai=$ata[0],id_j=$ta[0] where id_aja=$data[0]<br>");
$i++;
}
echo("$i rows affected");
?>

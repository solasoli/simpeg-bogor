<?
include("konek.php");

$q=mysqli_query($mysqli,"select * from jabatan where jabatan like '%Kepala Urusan Tata Usaha SM%' and tahun=2011");
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"update riwayat_mutasi_kerja set id_unit_kerja=$data[2] where id_j=$data[0]  ");




}
echo("done");
?>
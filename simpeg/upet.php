<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from sk where no_sk='821.2.45 - 154 Tahun 2010' order by no_sk");
$i=1;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"Select * from 	tu where id_pegawai=$data[1]");
$dor=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"Select * from 	jabatan where id_j=$dor[4]");
$jab=mysqli_fetch_array($q2);

mysqli_query($mysqli,"update sk set id_j=$dor[4] where id_sk=$data[0]");

$qp=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[1]");
$pg=mysqli_fetch_array($qp);

mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[1],$data[0],$jab[2],$dor[4],'$dor[1]','$pg[0]','Struktural','$jab[4]')");	

mysqli_query($mysqli,"update pegawai set jabatan='$jab[1]',eselonering='$jab[4]' where id_pegawai=$data[1]");
$i++;
	
}echo("$i rows affected");
?>
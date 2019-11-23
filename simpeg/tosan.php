<?
include("konek.php");

$q=mysqli_query($mysqli,"select * from sk where id_kategori_sk=1 and tmt='2011-01-01' and tgl_sk='2010-12-27'");

while($data=mysqli_fetch_array($q))
{
$qc=mysqli_query($mysqli,"select count(*) from riwayat_mutasi_kerja where id_sk=$data[0]");
$cek=mysqli_fetch_array($qc);


$qc2=mysqli_query($mysqli,"select count(*) from riwayat_mutasi_kerja where id_pegawai=$data[1] and id_sk=1");
$cek2=mysqli_fetch_array($qc2);


if($cek[0]==0 and $cek2[0]==1)
{


$q1=mysqli_query($mysqli,"select * from riwayat_mutasi_kerja where id_pegawai=$data[1] and id_sk=1");

$ata=mysqli_fetch_array($q1);
if($ata[3]<=4129)
{
$q3=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$ata[3] ");

$tau=mysqli_fetch_array($q3);
	
$q4=mysqli_query($mysqli,"select id_unit_kerja from unit_kerja where nama_baru  like '$tau[0]%' and tahun=2011 ");

//echo("select id_unit_kerja from unit_kerja where nama_baru  like '$ata[3]%' and tahun=2011 <br>");

$bau=mysqli_fetch_array($q4);
	
$ata[3]=$bau[0];	
}


$q2=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$data[1]");
$ta=mysqli_fetch_array($q2);


mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_sk,id_pegawai,id_unit_kerja,pangkat_gol,jenjab)
values ($data[0],$data[1],$ata[3],'$ta[pangkat_gol]','$ta[jenjab]')");


//echo("insert into riwayat_mutasi_kerja (id_sk,id_pegawai,id_unit_kerja,pangkat_gol,jenjab)
//values ($data[0],$data[1],$ata[3],'$ta[pangkat_gol]','$ta[jenjab]')<br>");

}


}
echo("done!");

?>
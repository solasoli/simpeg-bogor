<?
include("konek.php");

$q=mysqli_query($mysqli,"select id_pegawai,min(level_p) from pendidikan where jurusan_pendidikan like '%komputer%'group by id_pegawai ");
$i=0;
while($data=mysqli_fetch_array($q))
{

$qc=mysqli_query($mysqli,"select flag_pensiun from pegawai where id_pegawai=$data[0]");
$cek=mysqli_fetch_array($qc);
if($cek[0]==0)
$i++;

}
echo("orang teknik ada $i orang");

?>
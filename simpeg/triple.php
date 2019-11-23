<?

include("konek.php");
/*$q=mysqli_query($mysqli,"select * from (SELECT count(*) as jumlah,id_pegawai  FROM `sk` WHERE `keterangan` LIKE 'Temporary' AND `tmt` = '2011-01-01'  group  by id_pegawai ORDER BY count(*)  DESC) as crot where jumlah>1");


while($data=mysqli_fetch_array($q))
{


$q2=mysqli_query($mysqli,"select * from sk  WHERE `keterangan` LIKE 'Temporary' AND `tmt` = '2011-01-01' and id_pegawai=$data[1]");
//echo("select * from sk  WHERE `keterangan` LIKE 'Temporary' AND `tmt` = '2011-01-01' and id_peqawai=$data[1]<br>");
while($ata=mysqli_fetch_array($q2))
{
$q3=mysqli_query($mysqli,"select count(*) from riwayat_mutasi_kerja where id_sk=$ata[0]");
$ta=mysqli_fetch_array($q3);


if($ta[0]==0)
mysqli_query($mysqli,"delete from sk where id_sk=$ata[0]");


}


}*/

$q=mysqli_query($mysqli,"select nip_baru from pegawai where left(right(nip_baru,10),6)='201101' ");
while($data=mysqli_fetch_array($q))
{

$awal=substr($data[0],0,8);
$tgl=substr($awal,6,2);
$bln=substr($awal,4,2);
$thn=substr($awal,0,4);
mysqli_query($mysqli,"update pegawai set tgl_lahir='$thn-$bln-$tgl' where nip_baru=$data[0]");

}
echo("done");
?>
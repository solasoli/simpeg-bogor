<?

include("konek.php");



$q=mysqli_query($mysqli,"select * from temp order by id");

while($data=mysqli_fetch_array($q))

{



if($data[0]<24)

$tex="III/a";

elseif($data[0]>=24 and $data[0]<40)

$tex="II/c";

elseif($data[0]>=40 and $data[0]<148)

$tex="II/b";

else

$tex="II/a";



$q2=mysqli_query($mysqli,"select count(*) from pegawai where nip_lama='$data[1]'");



$ata=mysqli_fetch_array($q2);

if($ata[0]>0)

{



$q3=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_lama='$data[1]'");

$ta=mysqli_fetch_array($q3);







mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt) values ($ta[0],7,'831.45-154 Tahun 2009','2009-12-07','Walikota Bogor','Dra. Hj. Fetty Qondarsyah,M.Si','$tex','2010-01-01')");

//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemeberi_sk,pengesah_sk,keterangan,tmt) values ($ta[0],7,'831.45-149 Tahun 2009','2009-12-02','Walikota Bogor','Dra. Hj. Fetty Qondarsyah,M.Si','III/a','2010-01-01')<br>");

mysqli_query($mysqli,"update temp set flag=1 where id=$data[0]");

}

else

echo("nip $data[1] tidak ada<br>");





}

echo("done");

?>
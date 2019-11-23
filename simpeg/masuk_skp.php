<?php

include("konek.php");

$q=mysqli_query($mysqli,"select * from skp_header inner join pegawai on pegawai.id_pegawai=skp_header.id_pegawai where periode_awal like '2016%' and pegawai.id_j is null");

while($data=mysqli_fetch_array($q))

{



$np=($data[17]+$data[18]+$data[19]+$data[20]+$data[21])/5;



$perilaku=0.4*$np;



$q2=mysqli_query($mysqli,"select round(avg(nilai_capaian),2) from skp_target where id_skp=$data[0]");

$ata=mysqli_fetch_array($q2);



$uraian=0.6*($ata[0]);



$q3=mysqli_query($mysqli,"select count(*) from skp_tambahan_kreatifitas where id_skp=$data[0]");

$ta=mysqli_fetch_array($q3);



if($ta[0]==0)

$plus=0;

else if($ta[0]>0 and $ta[0]<=3)

$plus=1;

else if($ta[0]>3 and $ta[0]<=6)

$plus=2;

else if($ta[0]>6)

$plus=3;



$nilai_skp=$perilaku+$uraian+$plus;



if($nilai_skp>0)

mysqli_query($mysqli,"insert into nilai_skp (id_pegawai,nilai,tahun,online,id_j,id_skpd) values ($data[1],$nilai_skp,2016,0,0,$data[4])");



//echo("insert into nilai_skp (id_pegawai,nilai,tahun,online,id_j,id_skpd) values ($data[1],$nilai_skp,2016,0,0,$data[4]),<br>");





}

echo("done");



?>
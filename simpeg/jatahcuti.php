<?php
mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");	
mysqli_select_db("simpeg");
extract($_POST);
$skr=date("Y");
$n1=$skr-1;
$n2=$n1-1;
$qskr=mysqli_query($mysqli,"select count(*) from cuti_pegawai where (tmt_awal like '%$skr%' or tmt_selesai like '%$skr%') and id_pegawai=$idp ");
$qn1=mysqli_query($mysqli,"select count(*) from cuti_pegawai where (tmt_awal like '%$n1%' or tmt_selesai like '%$n1%') and id_pegawai=$idp ");
$qn2=mysqli_query($mysqli,"select count(*) from cuti_pegawai where (tmt_awal like '%$n2%' or tmt_selesai like '%$n2%') and id_pegawai=$idp ");
$qcb=mysqli_query($mysqli,"select count(*) from cuti_bersama where tanggal like '%$skr%'");
$now=mysqli_fetch_array($qskr);
$back=mysqli_fetch_array($qn1);
$long=mysqli_fetch_array($qn2);
$bersama=mysqli_fetch_array($qcb);

if($back[0]==0)
{
if($long[0]==0 and $now[0]==0)
$sisa=24-$bersama[0];	
elseif($long[0]>0 and $now[0]==0)
$sisa=18-$bersama[0];		
elseif($now[0]>0)
$sisa=12-$bersama[0];
}
else
$sisa=12-$bersama[0]-$now[0];
$data[] = array('sisana' => "$sisa");
echo json_encode($data);
?>
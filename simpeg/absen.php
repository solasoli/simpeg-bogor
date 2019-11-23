<?php
include("konek.php");
$q=mysqli_query($mysqli_query,"Select id_pegawai from oasys_attendance_log where date_time like '2013-05%' group by id_pegawai order by id_pegawai");
while($data=mysqli_fetch_array($q))
{
$qc=mysqli_query($mysqli_query,"select nama,id_unit_kerja from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where pegawai.id_pegawai=$data[0]");
//echo("select nama,id_unit_kerja pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where pegawai.id_pegawai=$data[0]");
$cek=mysqli_fetch_array($qc); 
//INSERT DULU BARU UPDATE
mysqli_query($mysqli_query,"insert into oasys_att_report values ('$cek[0]',$data[0],$data[0],'2013-05-01 00:00:00','HOLIDAY','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-',$cek[1])");

echo("insert into oasys_att_report values ('$cek[0]',$data[0],$data[0],'2013-05-01 00:00:00','HOLIDAY','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-','HOLIDAY','HOLIDAY','-','-','-','-','-',$cek[1])<br>");




for($i=1;$i<=31;$i++)
{
if($i<10)
$tgl="0"."$i";
else
$tgl=$i;
$qt=mysqli_query($mysqli_query,"select date_time from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2013-05-"."$tgl%'");
//echo("select date_time from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2013-05-"."$tgl'<br>");
$asup=mysqli_fetch_array($qt);
if($asup!=NULL)
{
$tok=substr($asup[0],11,5);
mysqli_query($mysqli_query,"update oasys_att_report set `$i`='$tok' where id_pegawai=$data[0] and date_time like '2013-05%'");
echo("update oasys_att_report set `$i`='$tok' where id_pegawai=$data[0] and date_time like '2013-05%'<br>");

}
}




}
echo("done");
?>
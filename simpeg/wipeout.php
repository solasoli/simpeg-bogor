<?php
include("konek.php");
$q=mysqli_query($mysqli,"select id_pegawai from pegawai where flag_pensiun=0 and id_pegawai<8529 order by id_pegawai");

while($data=mysqli_fetch_array($q))
{
for($i=2;$i<=7;$i++)
{
if($i<10)
$tgl="0$i";
else
$tgl=$i;

if($i!=5 and $i!=6)
{

$q2=mysqli_query($mysqli,"select count(*) from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2019-01-$tgl%'");	
	$cek=mysqli_fetch_array($q2);
	
	
$q6=mysqli_query($mysqli,"select count(*) from report_absensi where id_pegawai=$data[0] and tgl like '2019-01-$tgl%'");	
	$cek6=mysqli_fetch_array($q6);

$q7=mysqli_query($mysqli,"select count(*) from cuti_master where id_pegawai=$data[0] and tgl_usulan_cuti like '2019-01-$tgl%'");	
	$cek7=mysqli_fetch_array($q7);

	//kalo ga ada di tabel absen
	if($cek[0]==0 and $cek6[0]==0 and $cek7[0]==0)
	{
	mysqli_query($mysqli,"insert into oasys_attendance_log (date_time,status,id_pegawai) values('2019-01-".$tgl." 07:30:00','TERCATAT',$data[0])");
	mysqli_query($mysqli,"insert into oasys_attendance_log (date_time,status,id_pegawai) values('2019-01-".$tgl." 16:00:00','TERCATAT',$data[0])");	
	}
	else if($cek[0]==1)
	{
		$q3=mysqli_query($mysqli,"select id from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2019-01-$tgl%'");	
	$aya=mysqli_fetch_array($q3);
	mysqli_query($link,"update oasys_attendance_log set date_time='2019-01-".$tgl." 07:30:00' where id=$aya[0]");
	mysqli_query($mysqli,"insert into oasys_attendance_log (date_time,status,id_pegawai) values('2019-01-".$tgl." 16:00:00','TERCATAT',$data[0])");	
		
	}
	else
	{
		//masuk
		$q3=mysqli_query($mysqli,"select id,min(date_time) from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2019-01-$tgl%'");	
		
		$masuk=mysqli_fetch_array($q3);
		mysqli_query($link,"update oasys_attendance_log set date_time='2019-01-".$tgl." 07:30:00' where id=$masuk[0]");
		
		//pulang
		$q4=mysqli_query($mysqli,"select id,max(date_time) from oasys_attendance_log where id_pegawai=$data[0] and date_time like '2019-01-$tgl%'");	
		
		$pulang=mysqli_fetch_array($q4);
		mysqli_query($link,"update oasys_attendance_log set date_time='2019-01-".$tgl." 07:30:00' where id=$pulang[0]");
		
	}
	
}
}

}
echo("done");

?>
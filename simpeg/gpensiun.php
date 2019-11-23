<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
include("konek.php");
$qc=mysqli_query($mysqli,"select count(*) from pegawai where flag_pensiun=0");
$kaun=mysqli_fetch_array($qc);
$cur_year = date('Y');
$qc2=mysqli_query($mysqli,"select count(*) from pegawai where tgl_pensiun_dini like '$cur_year%' and flag_pensiun=1 ");
$kaun2=mysqli_fetch_array($qc2);

$jum=$kaun[0]+$kaun2[0];
?>

<table width="500" border="0" cellspacing="0" cellpadding="3" class="table">
  <tr>
    <td>Jumlah Pegawai</td>
    <?
	$bulan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
	$q1=mysqli_query($mysqli,"select count(*),left(tgl_pensiun_dini,7) as bulan from pegawai where tgl_pensiun_dini like '$cur_year%' group by left(tgl_pensiun_dini,7)");
	$kum=0;
	while($data=mysqli_fetch_array($q1))
	{
		$kum=$kum+$data[0];
		$prel=$jum-$kum;
		$panjang=($prel-9000)/5;
		echo("<td VALIGN=bottom align=center>$prel<br><img src=./images/BAR.gif width=10 height=$panjang /></td>");
		
		
		
	}
	
	?>
  </tr>
  <tr>
    <td>Bulan
    
    
    </td>
<?    for($i=1;$i<=12;$i++)
		echo("<td> $bulan[$i] </td>");

?>
  </tr>
</table>
</body>
</html>

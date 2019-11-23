
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 2px;
	margin-top: 2px;
	margin-right: 2px;
	margin-bottom: 2px;
}
body,td,th {
	font-family: tahoma;
	font-size: 14px;
}
</style>
</head>
<?  

include("konek.php");
$thn=date("Y");
extract($_POST);
extract($_GET);
if($thn==NULL)
$thn="2012";
//date("Y");

?>
<body>
<p align="center">Data pegawai Pemerintah Kota Bogor yang akan pensiun tahun <? echo($thn); ?></p>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>Bulan</td>
    <td>Januari</td>
    <td>Februari</td>
    <td>Maret</td>
    <td>April</td>
    <td>Mei</td>
    <td>Juni</td>
    <td>Juli</td>
    <td>Agustus</td>
    <td>September</td>
    <td>Oktober</td>
    <td>November</td>
    <td>Desember</td>
  </tr>
  <tr>
    <td>Eselonering</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  $q=mysqli_query($mysqli,"select eselon from jabatan where jabatan not like '%walikota%' group by eselon ");
  
  
  for($i=1;$i<=12;$i++)
	$sub[$i]=0;

  while($data=mysqli_fetch_array($q))
  {
	  
	echo("<tr><td>$data[0]  </td>");
	
		$i=1;
	while($i<=12)
	{
		
		if($i<10)
		$x="0$i";
		else
		$x="$i";
		
	$q1=mysqli_query($mysqli,"select count(*),left(tgl_pensiun_dini,7) from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where  eselon='$data[0]' and tgl_pensiun_dini like '$thn-$x%' group by left(tgl_pensiun_dini,7)");
	
	
	$ata=mysqli_fetch_array($q1);
	if($ata[0]!=NULL)
	$jum=$ata[0];
	else
	$jum=0;
	
	$sub[$i]=$sub[$i]+$jum[0];
	if($jum>0)
	echo("<td> <a href=fp.php?thn=$thn&bul=$x&s=$data[0]>$jum</a> </td>");
	else
	echo("<td> $jum </td>");
	
$i++;
	
	}
	
echo("</tr>");	
  }
  echo("<tr> <td> Staf pelaksana </td>");
  $j=1;
 while($j<=12)
 {
	  	if($j<10)
		$x="0$j";
		else
		$x="$j";
	
  $q2=mysqli_query($mysqli,"select count(*),left(tgl_pensiun_dini,7) from pegawai where  id_j=0 and tgl_pensiun_dini like '$thn-$x%' group by left(tgl_pensiun_dini,7)");
$coi=mysqli_fetch_array($q2);
if($coi[0]!=NULL)
	$cum=$coi[0];
	else
	$cum=0;
	$com[$j]=$cum;
	if($cum>0)
	echo("<td> <a href=fp.php?thn=$thn&bul=$x&s=s>$cum</a> </td>");
	else
	echo("<td> $cum </td>");
	
$j++;
}
echo("</tr><tr><td> Total </td>");
$gol=0;
for($z=1;$z<=12;$z++)
{
	$hah=$sub[$z]+$com[$z];
echo("<td>$hah</td>");
$gol=$gol+$hah;
}
  echo("</tr><tr> <td colspan=12 align=right> Total : </td> <td align=left> $gol</td></tr>");
  ?>
</table>
<?
if($bul!=NULL)
{
if(substr($bul,0,1)==0)
$bulo=substr($bul,1,1);	
	
$bulan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');	

if($s=='s')
{
$q7=mysqli_query($mysqli,"select nama,nip_baru,nip_lama,left(tgl_pensiun_dini,7),pangkat_gol,pangkat_gol from pegawai where  id_j=0 and tgl_pensiun_dini like '$thn-$bul%' ");
//echo("staf");
}
else
{
$q7=mysqli_query($mysqli,"select nama,nip_baru,nip_lama,left(tgl_pensiun_dini,7),jabatan.jabatan,pangkat_gol from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where  eselon='$s' and tgl_pensiun_dini like '$thn-$bul%'  ");
//echo("pejabat");
}
 

 

 echo("<br><div align=center>Pegawai Yang Akan Pensiun Bulan $bulan[$bulo] tahun $thn </div><br><table border=1 cellpadding=5  cellspacing=0 bordercolor=#000000 align=center><tr><td>No</td><td>Nama</td><td>Pangkat Golongan</td><td>NIP Baru</td><td>Jabatan</td></tr>");
$t=1;
while($co=mysqli_fetch_array($q7))
{
	if($s!='s')
	$jab=$co[4];
	else
	$jab='Staf Pelaksana';
	
	echo("<tr><td>$t</td><td>$co[0]</td><td>$co[5]</td><td>$co[1]</td><td>$jab</td></tr>");
$t++;	
}
echo("</table>");	
}

?>
</body>
</html>
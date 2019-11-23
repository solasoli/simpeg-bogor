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
</style>
</head>

<body>
<?
include("konek.php");
$q=mysqli_query($mysqli,"select nama,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pangkat_gol,eselon,jabatan.jabatan,id_pegawai from jabatan inner join pegawai on pegawai.id_j=jabatan.id_j where tahun=2011 and flag_pensiun=0 and jabatan.jabatan not like '%(w%' order by eselon  ");
?>


<table width="95%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
  <tr>
    <td rowspan="2">No</td>
    <td rowspan="2">NAMA</td>
    <td rowspan="2">NIP LAMA</td>
    <td rowspan="2">NIP BARU</td>
    <td rowspan="2">TANGGAL LAHIR</td>
    <td rowspan="2">JENIS KELAMIN</td>
    <td rowspan="2">TMT CPNS</td>
    <td rowspan="2">TMT PNS</td>
    <td rowspan="2">GOL RUANG</td>
    <td rowspan="2">TMT GOL RUANG</td>
    <td colspan="2">MASA KERJA</td>
    <td rowspan="2">ESELON</td>
    <td rowspan="2">Nama Jabatan</td>
    <td rowspan="2">Ket</td>
  </tr>
  <tr>
    <td>Tahun</td>
    <td>Bulan</td>
  </tr>
  <tr>
    <td align="center">1</td>
    <td align="center">2</td>
    <td align="center">3</td>
    <td align="center">4</td>
    <td align="center">5</td>
    <td align="center">6</td>
    <td align="center">7</td>
    <td align="center">8</td>
    <td align="center">9</td>
    <td align="center">10</td>
    <td align="center">11</td>
    <td align="center">12</td>
    <td align="center">13</td>
    <td align="center">14</td>
    <td align="center">15</td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  
  {
	  
	  $tgl=substr($data[3],8,2);
	  $bln=substr($data[3],5,2);
	  $thn=substr($data[3],0,4);
	  
	 $nip="'"."$data[2]";
	  echo("<tr>
    <td>$i</td>
    <td>$data[0]</td>
    <td>$data[1]</td>
    <td>$nip</td>
    <td>$tgl/"."$bln"."/$thn"."</td>");
	if($data[4]=='L')
	$jk=1;
	else
	$jk=2;
    echo("<td>$jk</td>");
	$pan=strlen($data[2]);
	if($pan>10)
	{
		  $t1=substr($data[2],14,1);
	  $b1=substr($data[2],12,2);
	  $th1=substr($data[2],8,4);
		$cpn="0$t1/"."$b1"."/$th1";
		
			$qd=mysqli_query($mysqli,"select keterangan,tmt from sk where id_pegawai=$data[8] and id_kategori_sk=6");	
	$doi=mysqli_fetch_array($qd);
	$plor=explode(",",$doi[0]);
	
	$taon=date("Y");
	$blan=date("m");
	if(substr($blan,0,1)=='0')
	$blan=substr($blan,-1);
	else
	$blan=$blan;
		 $b4=substr($doi[1],5,2);
		 if(substr($b4,0,1)=='0')
	$b4=substr($b4,-1);
	else
	$b4=$b4;
	
	  $th4=substr($doi[1],0,4);
	  
	  if($th4==NULL)
	  $th4=$th1;
	  
	  if($b4==NULL)
	  $b4=$b1;
	  
	if($plor[1]=='0' and $plor[2]=='0')
	{
	
	  
	  $a=(($taon*12)+$blan)-(($th4*12)+$b4);	  
	  $mkt=floor($a/12);
	  $mkb=$a-($mkt*12);
	}
	else
	{
		if(substr($plor[1],0,1)=='0')
		$t5=substr($plor[1],-1);
		else
		$t5=$plor[1];
		
		if(substr($plor[2],0,1)=='0')
		$b5=substr($plor[2],-1);
		else
		$b5=$plor[2];
		
		  $a=(($taon*12)+$blan)-(($th4*12)+$b4)+(($t5*12)+$b5);	  
	  $mkt=floor($a/12);
	  $mkb=$a-($mkt*12);
	}
	}
	else
	{
	$qc=mysqli_query($mysqli,"select tmt,keterangan from sk where id_pegawai=$data[8] and id_kategori_sk=6");	
	$coi=mysqli_fetch_array($qc);
	
	
	if($coi[0]!=NULL)
	{
	
		  $t1=substr($coi[0],8,2);
	  $b1=substr($coi[0],5,2);
	  $th1=substr($coi[0],0,4);
		$cpn="$t1/"."$b1"."/$th1";	
		
	}
	else
	$cpn="-";
	
	}
	
		$qd=mysqli_query($mysqli,"select tmt from sk where id_pegawai=$data[8] and id_kategori_sk=7");	
	$cod=mysqli_fetch_array($qd);	
	
	
		if($cod[0]!=NULL)
	{
	
		  $t2=substr($cod[0],8,2);
	  $b2=substr($cod[0],5,2);
	  $th2=substr($cod[0],0,4);
		$pn="$t2/"."$b2"."/$th2";	
		
	}
	else
	$pn="-";
	
	$qe=mysqli_query($mysqli,"select tmt from sk where id_pegawai=$data[8] and id_kategori_sk=5 order by tmt desc");	
	$coe=mysqli_fetch_array($qe);	
	
	
		if($coe[0]!=NULL)
	{
	
		  $t3=substr($coe[0],8,2);
	  $b3=substr($coe[0],5,2);
	  $th3=substr($coe[0],0,4);
		$pe="$t3/"."$b3"."/$th3";	
		
	}
	else
	$pe="-";
	
	
	
	if($mkt<10)
	$mkt="0"."$mkt";
	
	if($mkb<10)
	$mkb="0"."$mkb";
	
    echo("<td>$cpn</td>
    <td>$pn</td>
    <td>$data[5]</td>
    <td>$pe</td>
    <td>'$mkt 
	</td>
	<td>'$mkb</td>
    <td>$data[6]</td>
    <td>$data[7]</td>
    <td></td>
  </tr>");
	$i++;  
  }
  
  ?>
</table>
</body>
</html>
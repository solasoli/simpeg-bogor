<!DOCTYPE html> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Untitled Document</title>
<style type="text/css">
html {
	font-family:Verdana, Geneva, sans-serif;
    font-size: 12px;
}
.unbehaved-element {
	font-family:Verdana, Geneva, sans-serif;
    font-size: 1em;
}
@media(max-width: 1580px) {
  html {
	  font-family:Verdana, Geneva, sans-serif;
    font-size: 12px;
  }
  .unbehaved-element {
	  font-family:Verdana, Geneva, sans-serif;
    font-size: 1em; /* Fine tune unbehaved elements */
  }
}
@media(max-width: 320px) {
  html {
	  font-family:Verdana, Geneva, sans-serif;
    font-size: 8px;
  }
}
</style>

<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
<link href="assets/bootstrap/css/costums.css" rel="stylesheet">
</head>

<body>
<?php 
include("konek.php");
extract($_POST);
?>
<form id="form1" name="form1" method="post" action="eselonpangkat.php">
  <table width="500" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td colspan="2" align="center">Jumlah Pegawai Per Eselon dan Golongan</td>
    </tr>
    <tr>
      <td align="center">Eselon</td>
      <td align="center">Golongan</td>
    </tr>
    <tr>
      <td align="center"><label for="e"></label>
        <select name="e" id="e">
        <?php
		$q=mysqli_query($mysqli,"select eselon from jabatan where tahun=2011 and eselon not like '%kota%'  and eselon not like '%NS%' group by eselon ");
		while($a=mysqli_fetch_array($q))
		{
		if(@@$e==$a[0])	
		echo("<option value=$a[0] selected>$a[0] </a>");
		else
		echo("<option value=$a[0]>$a[0] </a>");
		
		}
		?>
      </select></td>
      <td align="center"><select name="g" id="g" onchange="document.forms[0].submit()">
       <?php
		$q1=mysqli_query($mysqli,"select pangkat_gol from pegawai where flag_pensiun=0 group by pangkat_gol" );
		while($b=mysqli_fetch_array($q1))
		{
		if(@@$g==$b[0])	
		echo("<option value=$b[0] selected>$b[0] </a>");
		else
		echo("<option value=$b[0]>$b[0] </a>");
		
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><?php
	   
      if(isset($e) and isset($g))
	  {
		  
		  
		$q3=mysqli_query($mysqli,"SELECT count(*) FROM pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where pegawai.id_j>0 and flag_pensiun=0 and pangkat_gol like '$g' and eselon like '$e'");  
		  $itung=mysqli_fetch_array($q3);
		  
		  echo("Pegawai Eselon $e dengan Golongan $g berjumlah $itung[0] pegawai");
	  }
	  ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="top">
      
      <?php
	  if($itung[0]>0)
	  {
	  $q4=mysqli_query($mysqli,"SELECT pegawai.id_pegawai,nama,pegawai.id_j,right(left(nip_baru,14),6),floor(datediff(curdate(),tgl_lahir)/365) as umur,jenis_kelamin FROM pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where pegawai.id_j>0 and flag_pensiun=0 and pangkat_gol like '$g' and eselon like '$e'
ORDER BY right(left(nip_baru,14),6)  ");
	  while($ata=mysqli_fetch_array($q4))
	  {
	  ?>
      
      <table border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td rowspan="8" align="center" valign="top">
          <?php
		  if(file_exists("./foto/$ata[0].jpg"))
		  {
			 ?> 
			  <img src="./foto/<?php echo("$ata[0]".".jpg"); ?>" width="100" />
			<?php
			  }
		  else
		  {
			  if($ata[5]=='L')
			  echo("<img src=./images/male.jpg");
			  else
			  echo("<img src=./images/female.jpg");
		  
		  }
		  ?>
          
          </td>
          <td nowrap>Nama: <?php echo("$ata[1]"); ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
        </tr>
        <tr>
          <td><?php $qj=mysqli_query($mysqli,"select * from jabatan where id_j=$ata[2] ");
		  $jab=mysqli_fetch_array($qj);
		  echo($jab['jabatan']);
		   ?></td>
          </tr>
        <tr>
          <td nowrap>Masa Kerja Golongan :
            <?php
          $qmkg=mysqli_query($mysqli,"select keterangan from sk where id_kategori_sk=5 and id_pegawai=$ata[0] order by tgl_sk desc ");
		  
		  $mkg=mysqli_fetch_array($qmkg);
		  $mk=explode(",",$mkg[0]);
		  echo("$mk[1] Tahun $mk[2] Bulan");
		  ?></td>
          </tr>
        <tr>
          <td nowrap>&nbsp;</td>
          </tr>
        <tr>
          <td>Pendidikan Terakhir</td>
          </tr>
        <tr>
          <td><?php
          $qp=mysqli_query($mysqli,"select * from pendidikan where id_pegawai=$ata[0] ");
		  $pen=mysqli_fetch_array($qp);
		  echo("$pen[3] $pen[2] Jurusan $pen[4]");
		  ?></td>
          </tr>
        <tr>
          <td nowrap>Umur:<?php echo("$ata[4] Tahun"); ?></td>
        </tr>
        </table>
      
      <?php
	  }
	  }
	  ?>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
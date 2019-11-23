<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: tahoma;
	font-size: 11px;
}
</style>
<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css" />
<script  src="extjs/ext-all-debug.js" type="text/javascript"></script>
</head>

<body>
<?

include("konek.php");
extract($_POST);
if(is_numeric($s))
{
$q=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol,jabatan.jabatan,jabatan.eselon, pegawai.id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where flag_pensiun=0 order by jabatan.eselon,pangkat_gol desc,right(left(nip_baru,16),8)");
//echo("isinya $s");
}
else
{
$q=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol,jabatan.jabatan,jabatan.eselon, pegawai.id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where flag_pensiun=0 and jabatan.eselon='$s' order by jabatan.eselon,pangkat_gol desc,right(left(nip_baru,16),8)");
}


?>

<table width="95%" border="1" cellspacing="0" bordercolor="#000000" cellpadding="3">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP Baru</td>
    <td>Golongan</td>
    <td>Tgl SK</td>
    <td>Tahun</td>
    <td>Bulan</td>
    <td>Jabatan</td>
    <td>Eselon</td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  $t1=substr($data[1],8,8);
	  $t2=substr($t1,6,2)."/".substr($t1,4,2)."/".substr($t1,0,4);
	  $thn=date("Y")-substr($t1,0,4);
	  $bln=date("m")-substr($t1,4,2);
	  
	  if($bln==-1)
	  {
		$bln=11;
		$thn--;  
		  
	  }
	  
	  if(strlen($data[1])<10)
	{
		$t2="-";
		  $thn="-";
	  $bln="-";
  }
  
  
  
  /* REVISI: 
  		Untuk tgl SK. Seharusnya adalah SK Pangkat terakhir. Bukan tmt SK CPNS yang dipotong dari NIP baru.
		Isi variable $t2 akan dirubah di sini
		by. Cunda 
  */
  require_once "lib/PegawaiRepository.php";
  $skPangkatTerakhir = getSkPangkatTerakhir($data["id_pegawai"]);
  if($skPangkatTerakhir != '')
	$t2 = substr($skPangkatTerakhir["tmt"], 8, 2)."/".substr($skPangkatTerakhir["tmt"], 5, 2)."/".substr($skPangkatTerakhir["tmt"], 0, 4);
  else
  	$t2 = '-';
  /* End of peritungan TMT SK pangkat terakhir */
  
  
	
	echo("  <tr>
    <td>$i</td>
    <td nowrap >$data[0]</td>
    <td>$data[1]</td>
    <td align=center>$data[2]</td>
    <td nowrap align=center>$t2</td>
    <td align=center>$thn</td>
    <td align=center>$bln</td>
    <td nowrap>$data[3]</td>
    <td>$data[4]</td>
  </tr>");
  $i++;  
	  
  }
  
  ?>
</table>

<div id="pejabatGrid"></div>
<script type="text/javascript">
var 
new Ext.panel.Panel({
	renderTo: 'pejabatGrid',
	title: 'Daftar Pejabat'
});

</script>


</body>
</html>
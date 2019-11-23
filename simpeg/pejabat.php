<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 12px;

	color: #000000;

}

-->

</style></head>



<body>

<p>

  <?

include("konek.php");





?>

</p>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">

  <tr>

    <td>no</td>

    <td>nama</td>
 <td>nip</td>
    <td>jabatan</td>

    <td>unit kerja </td>

    <td>pangkat golongan </td>

 
  </tr>

 

 <? $q=mysqli_query($mysqli,"SELECT jabatan,nama_baru,id_j from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where jabatan.tahun=2011 order by eselon");

//echo("SELECT jabatan,nama_baru,id_j from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where jabatan.tahun=2011 ");
 $i=1;

while($data=mysqli_fetch_array($q))

{


$q2=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where tmt like '2011%' and sk.id_j=$data[2] order by tmt desc");

$dat=mysqli_fetch_array($q2);


if($dat[0]!=NULL)
{echo("<tr>

    <td>$i</td>

    <td>$dat[0]</td>
  <td>$dat[1]</td>
    <td>$data[0]</td>

    <td>$data[1]</td>

    <td>$dat[2]</td>

 

  </tr>");

$i++;
}
}

  

  ?>

</table>

<p>&nbsp;</p>

</body>

</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>



</script>

<style type="text/css">



<!--

body,td,th {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 11px;

	color: #000066;

}

.gede {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 13px;

	color: #000000;

	font-weight: normal;

}

.kedip {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 13px;

	text-decoration: blink;

}

.pendek {

	width: 200px;

}

.latar {

	background-image: url(http://192.168.0.100/simpeg/images/middle.gif);

	background-repeat: repeat-y;

}

.sebling {

	color: #FF0000;

	font-family: Verdana, Arial, Helvetica, sans-serif;

	width: 200px;

}

a:link {

	color: #666666;

	text-decoration: none;

}

a:visited {

	text-decoration: none;

	color: #666666;

}

a:hover {

	text-decoration: none;

	color: #FF0000;

}

a:active {

	text-decoration: none;

	color: #666666;

}

a {

	font-weight: bold;

}





#pret {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 8px;

	opacity: 0.99;

	width: 500px;

}

.please {

	font-family: Tahoma, Verdana;

	font-size: 12px;

	color: #000000;

	opacity:0.99;

}



.carol {

	background-color:#F0f0f0;

}



.carol:hover{

	background-color:#FFFFCC;

}



.carol a{

	font-weight:100;

	color:#0000FF;

}



.carol a:hover {

font-weight:500;

color:#333333;

background-color:#FF0000;

}





-->

</style>



</head>



<body >

<?



include("konek.php"); 

$q=mysqli_query($mysqli,"select nama,nama_baru,pegawai.id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pangkat_gol from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where status_aktif not like '%pensiun%' and flag_pensiun=0 and (unit_kerja.id_unit_kerja>=37 and unit_kerja.id_unit_kerja<=501) or (unit_kerja.id_unit_kerja>=579 and unit_kerja.id_unit_kerja>=622 and unit_kerja.id_unit_kerja<>354)   group by id_pegawai,nip_lama,nip_baru  order by nama_baru ");

?>



<table width="700" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000066">

  <tr>

    <td>No</td>

    <td>Nama</td>

    <td>NIP LAMA </td>

    <td nowrap="nowrap">NIP BARU </td>

    <td nowrap="nowrap">SKPD</td>

  </tr>

  <?

$i=1;

 while($data=mysqli_fetch_array($q))

 {

 

 echo("<tr>

 <td>$i</td>

 <td nowrap>$data[0]</td>

 <td >&nbsp;$data[3]</td>

 <td nowrap>&nbsp;$data[4]</td>

 <td nowrap>$data[1]</td>

 </tr>");

 $i++;

 }

  

  

  ?>

</table>

<?

$total=$i-1;

echo($total);

?>

</body>

</html>


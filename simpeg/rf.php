<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 11px;

}

.style1 {color: #FFFFFF}

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

#Layer1 {

	position:absolute;

	left:0px;

	top:0px;

	width:100%;

	height:85px;

	z-index:1;

	visibility: <?

	include("konek.php");

	$rf=$_REQUEST['rf'];

$final=$_REQUEST['final'];

$u=$_REQUEST['u'];

	$qc=mysqli_query($mysqli,"select * from (Select count(*) as jum,id_next from pegawai group by id_next)as y where jum>1  and id_next>0");

	$cek=mysqli_fetch_array($qc);

	

	if($cek[0]==0 and $final==1)

	echo("visible");

	else

	echo("hidden");

	?>;

}

.ganda {

	text-decoration: blink;

	color: #FF0000;

}

-->

</style></head>



<body>

<?





$q=mysqli_query($mysqli,"select id_next from pegawai where id_next>0 group by id_next order by id_next");



?>





<div id="Layer1">

  <p>&nbsp;</p>

  <form id="form1" name="form1" method="post" action="ekspor.php">

    <table width="400" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F0F0F0">

      <tr>

        <td><table width="400" border="0" align="center" cellpadding="5" cellspacing="0">

          <tr>

            <td colspan="4" bgcolor="#FFFFFF">

            <div align="center">FORM LAMPIRAN SK </div></td>

          </tr>

          <tr>

            <td width="122" bgcolor="#f0f0f0">Nomor SK </td>

            <td width="22" bgcolor="#F0F0F0"><div align="center">:</div></td>

            <td width="226" colspan="2" bgcolor="#f0f0f0"><label>

              <input name="nsk" type="text" id="nsk" size="35" />

            </label></td>

          </tr>

          <tr>

            <td bgcolor="#FFFFFF">Tanggal</td>

            <td bgcolor="#FFFFFF"><div align="center">:</div></td>

            <td colspan="2" bgcolor="#FFFFFF"><input name="t1" type="text" id="t1" size="35" /></td>

          </tr>

          <tr>

            <td nowrap="nowrap" bgcolor="#f0f0f0">Nomor Baperjakat </td>

            <td bgcolor="#F0F0F0"><div align="center">:</div></td>

            <td colspan="2" bgcolor="#f0f0f0"><input name="nb" type="text" id="nb" size="35" /></td>

          </tr>

          <tr>

            <td bgcolor="#FFFFFF">Tanggal</td>

            <td bgcolor="#FFFFFF"><div align="center">:</div></td>

            <td colspan="2" bgcolor="#FFFFFF"><input name="t2" type="text" id="t2" size="35" /></td>

          </tr>

          <tr>

            <td bgcolor="#F0F0F0">&nbsp;</td>

            <td bgcolor="#F0F0F0">&nbsp;</td>

            <td bgcolor="#F0F0F0"><label>

              <input type="submit" name="Submit" value="Submit" />

            </label></td>

            <td bgcolor="#F0F0F0"><div align="right"><a href="rf.php?u=<?  echo($u); ?>">[ close]</a></div></td>

          </tr>

        </table></td>

      </tr>

    </table>

  </form>

</div>

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

<td colspan="5"><?

if($cek[0]>0 and $final==1)

echo("<div align=center class=ganda> LAMPIRAN BELUM BISA  DIEKSPORT KARENA MASIH ADA CALON GANDA!</div>");

?> </td>

</tr>

   <tr>

        <td width="167" align="left" valign="bottom" bgcolor="#FFFFFF"><a href="rf.php?final=1&&u=<? echo($u);?>"><img  src="xl.gif" alt="d" border="0" align="middle" /> export ke excell </a></td>

        <td width="256" align="left" valign="bottom" bgcolor="#FFFFFF">

		<?

		

		

		//<a href="epor.php"><img  src="xl.gif" alt="d" border="0" align="middle" /> export hasil akhir </a>

		

		

		?>

		</td>

        <td width="281" align="left" valign="middle" bgcolor="#FFFFFF"><div align="right"><a href="struktur.php?u=<?  echo($u); ?>">[ close]</a></div></td>

        <td width="1" bgcolor="#FFFFFF"><div align="center"><a href="trees.php"></a> </div></td>

  </tr>

  <tr>

    <td colspan="3"><table width="700" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">

      <tr>

        <td><table width="700" border="0" align="center" cellpadding="5" cellspacing="0">

            <tr>

              <td bgcolor="#666666"><div align="center"><span class="style1">No</span></div></td>

              <td bgcolor="#666666"><span class="style1">Jabatan</span></td>

              <td bgcolor="#666666"><span class="style1">Sebelumnya</span></td>

              <td bgcolor="#666666"><span class="style1">Rencana</span></td>

              <td bgcolor="#666666"><div align="center"><span class="style1">Batalkan</span></div></td>

            </tr>

            <?

  $i=1;

  while($data=mysqli_fetch_array($q))

  {

  

  $qj=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$data[0]");

  $j=mysqli_fetch_array($qj);

 

 $ql=mysqli_query($mysqli,"select nama from pegawai where id_j=$data[0]");

  $l=mysqli_fetch_array($ql);

  

  if($l[0]==NULL)

  $l[0]="Jabatan ini kosong sebelumnya";

  

  if($i%2==1)

  echo("<tr>");

  else

  echo("<tr bgcolor=#f0f0f0>");

  

  $qc=mysqli_query($mysqli,"select count(*) from pegawai where id_next=$data[0]");

  $count=mysqli_fetch_array($qc);

  if($count[0]==1)

  {

  

  $qt=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_next=$data[0]");

  $nama=mysqli_fetch_array($qt); 

  echo("

    <td valign=top align=center>$i</td>

    <td valign=top align=left>$j[0]</td>

    <td valign=top align=left>$l[0]</td>

    <td valign=top align=left>$nama[0]</td>

	 <td valign=top align=center><a href=del.php?idn=$nama[1]&&u=$u>Batalkan</a></td>

  </tr>

  ");

  

  }	

  else

  {

  

  $qt=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_next=$data[0]");

  $ro=1;

  while($nama=mysqli_fetch_array($qt))

  { 

  if($i%2==1)

  echo("<tr>");

  else

  echo("<tr bgcolor=#f0f0f0>");

  

  if($ro==1)

  echo("<td valign=top align=center>$i</td>

    <td valign=top align=left>$j[0]</td>

    <td valign=top align=left>$l[0]</td>

    <td valign=top align=left>$nama[0]</td>

	 <td valign=top align=center><a href=del.php?idn=$nama[1]&&u=$u>Batalkan</a></td>

  </tr>");

  else

  echo("<td valign=top align=center></td>

    <td valign=top align=left></td>

    <td valign=top align=left></td>

    <td valign=top align=left>$nama[0]</td>

	 <td valign=top align=center><a href=del.php?idn=$nama[1]&&u=$u>Batalkan</a></td>

  </tr>");

  $ro++;

  }

  }

  

  $i++;

  

  }

  

  ?>

        </table></td>

      </tr>

    </table></td>

  </tr>

</table>

</body>

</html>


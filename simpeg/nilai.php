<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<script type="text/javascript" src="datetimepicker_css.js"></script>

<style type="text/css">

<!--

body,td,th {

	font-family: Tahoma;

	font-size: 12px;

}

-->

</style></head>



<body>

<?

$tot=$_REQUEST['tot'];

$yo=$_REQUEST['demo1'];

$tgl=substr($yo,0,2);

$bln=substr($yo,3,2);

$thn=substr($yo,6,4);

$tg=$thn."-".$bln."-".$tgl;

if($tot!=NULL)

{

for($i=1;$i<=$tot;$i++)

{$peg=$_REQUEST["peg"."$i"];

$ap=$_REQUEST["ap"."$i"];

$jk=$_REQUEST["jk"."$i"];



if($ap==0 or $jk<8)

{



$qe2=mysqli_query($mysqli,"select count(*) from nilai where id_pegawai=$peg");

$e2=mysqli_fetch_array($qe2);

if($e2[0]>0)

{

  $qe=mysqli_query($mysqli,"select * from nilai where id_pegawai=$peg  and tgl='$tg'");



  $e=mysqli_fetch_array($qe);

   if($e[4]<>$tg) 

   mysqli_query($mysqli,"insert into nilai (id_pegawai,apel,jamkerja,tgl) values ($peg,$ap,$jk,'$tg')");

   else

   mysqli_query($mysqli,"update nilai set  apel=$ap,jamkerja=$jk where id_pegawai=$peg and tgl='$tg'");







}

   else

mysqli_query($mysqli,"insert into nilai (id_pegawai,apel,jamkerja,tgl) values ($peg,$ap,$jk,'$tg')");





}



else

mysqli_query($mysqli,"delete from nilai where id_pegawai=$peg and tgl='$tg'");



}



}





?>

<form id="form2" name="form2" method="post" action="">

  <input name="x" type="hidden" id="x" value="nilai.php" />

  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td><div align="left">pilih tanggal :

          <input name="demo1" type="text" id="demo1" value="<? $saiki=date("d-m-Y"); 

		

		if($yo==NULL)

		echo($saiki);

		else

		echo($yo);

		

		 ?>" size="25" maxlength="25" />

          <a href="javascript:NewCssCal('demo1','ddmmyyyy')"><img

                                                        src="images/cal.gif" alt="Pick a date" width="16" height="16" hspace="5" border="0" /></a>

          <input type="submit" name="Submit2" value="Tampilkan " />

      </div></td>

    </tr>

  </table>

</form>

<? if($yo!=NULL)

{

?>

<form id="form1" name="form1" method="post" action="">

  <input name="x" type="hidden" id="x" value="nilai.php" />

  <input name="demo1" type="hidden" id="demo1" value="<? echo($yo); ?>" />

  <table width="400" border="0" align="center" cellpadding="3" cellspacing="0">

    <tr>

      <td align="left" nowrap="nowrap"><label>

        <div align="left">tgl absensi : </div>

        </label></td>

      <td align="left" nowrap="nowrap"><? echo($yo); ?></td>

      <td colspan="3" align="left" nowrap="nowrap"><input type="submit" name="Submit3" value="Simpan" /></td>

    </tr>

    <tr>

      <td bgcolor="#f0f0f0"><div align="center">no</div></td>

      <td bgcolor="#f0f0f0"><div align="left">nip</div></td>

      <td bgcolor="#f0f0f0"><div align="left">nama</div></td>

      <td bgcolor="#f0f0f0"><div align="center">apel pagi </div></td>

      <td nowrap="nowrap" bgcolor="#f0f0f0">jam kerja </td>

    </tr>

	<?

	$qid=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_lama=$_SESSION[user] or nip_baru=$_SESSION[user]");

	$id=mysqli_fetch_array($qid);

	

		$result = mysqli_query($mysqli,"SELECT nama_baru,riwayat_mutasi_kerja.id_unit_kerja from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja

				=unit_kerja.id_unit_kerja where id_pegawai=$id[0] order by id_riwayat desc");

				$r = mysqli_fetch_array($result);

				$unit = $r[0];

	

	

	$qavg=mysqli_query($mysqli,"select nip_baru,nama,pegawai.id_pegawai,nip_lama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] order by pangkat_gol desc ");

$j=0;

while($avg=mysqli_fetch_array($qavg))

{

$j++;



if($j%2==1)

    echo("<tr>");

	else

echo("<tr  bgcolor=#f0f0f0>");

	

	

		?>

      <td><div align="center"><? echo($j);  ?></div>        </td>

      <td><? if ($avg[0]==NULL or $avg[0]=='-' )

	  echo($avg[3]); 

	  else

	   echo($avg[0]); 

	   ?></td>

      <td nowrap="nowrap"><label><? echo($avg[1]);  ?></label></td>

      <td><div align="center">

        <select name="<? echo("ap$j"); ?>" id="<? echo("ap$j"); ?>">

          <option value="1">Hadir</option>

          <option value="0" <?

		  $qo=mysqli_query($mysqli,"select count(*) from nilai where id_pegawai=$avg[2] and apel=0 and tgl='$tg'");

		  $o=mysqli_fetch_array($qo);

		  

		  if($o[0]>0)

		  echo("selected");

		  ?> >Tidak Hadir</option>

          </select>

        <input name="<? echo("peg$j");  ?>" type="hidden" id="<? echo("peg$j"); ?>" value="<? echo($avg[2]); ?>" />

      </div></td>

      <td><div align="center">

        <select name="<? echo("jk$j"); ?>" id="<? echo("jk$j"); ?>">

         <?

		 for($d=8;$d>=1;$d--)

		 {

		 

		   $qo2=mysqli_query($mysqli,"select jamkerja from nilai where id_pegawai=$avg[2] and tgl='$tg'");

		  $o2=mysqli_fetch_array($qo2);

		  if($o2[0]==$d)

		  echo("<option value=$d selected>$d</option>");

		  else

		  echo("<option value=$d>$d</option>");

		  

		  }

          ?>

        </select>

      </div></td>

    </tr>

	<?

	}

	

	?>

    <tr>

      <td colspan="5"><label>

        <div align="center">

          <input type="submit" name="Submit" value="Simpan" />

        </div>

      </label></td>

    </tr>

  </table>

  <input name="tot" type="hidden" id="tot" value="<? echo($j); ?>" />

</form>

<?

}

?>

</body>

</html>


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

	color: #000099;

}

-->

</style></head>



<body>





<?





 include("konek.php"); 
$thn=$_REQUEST['thn'];
if($thn==NULL)
$thn=date("Y");


$q=mysqli_query($mysqli,"select jabatan.id_unit_kerja,nama_baru from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where nama_baru not like 'sma%' and  nama_baru not like 'smp%' and  nama_baru not like 'smk%' and nama_baru not like 'bagian%' and nama_baru not like 'UPTD%' and jabatan.tahun=$thn group by nama_baru");


?>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><form id="form2" name="form2" method="get" action="coro.php" >
      <div align="right">
        <select name="thn" id="thn" onChange="document.form2.submit();">
          <option value="2010" <? if($thn==2010) echo("selected"); ?> >2010</option>
          <option value="2011"  <? if($thn==2011) echo("selected"); ?>>2011</option>
        </select>
      </div>
    </form>    </td>
    <td nowrap="nowrap"><form id="form3" name="form3" method="post" action="struk.php?thn=<? echo($thn); ?>">
      <select name="u" id="u">
        <?

  while($data=mysqli_fetch_array($q))

  {

  

  if($u==$data[0])

    echo("<option value=$data[0] selected>$data[1]</option>");

	else

	echo("<option value=$data[0]>$data[1]</option>");

	

	

	

	}

  ?>
      </select>
        <input type="submit" name="Submit" value="Tampilkan" />
    </form>    </td>
  </tr>
</table>
</body>

</html>


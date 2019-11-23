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
	color: #000;
}

-->

</style></head>



<body>
<center><P> REKAP GOLONGAN</p><center>




<?



extract($_POST);

 include("konek.php"); 
$thn=$_REQUEST['thn'];
if($thn==NULL)
$thn=date("Y");


$q=mysqli_query($mysqli,"select * from unit_kerja where Tahun=2011 order by nama_baru");


?>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td nowrap="nowrap"><form id="form3" name="form3" method="post" action="rkpgol.php">
      <select name="u" id="u">
        <?

  while($data=mysqli_fetch_array($q))

  {

  

  if($u==$data[0])
    echo("<option value=$data[0] selected>$data[2]</option>");
	else
	echo("<option value=$data[0]>$data[2]</option>");

	

	

	

	}

  ?>
      </select>
        <input type="submit" name="Submit" value="Tampilkan" />
    </form>    </td>
  </tr>
</table>
<?

if($u!=NULL)
include("rkpgol.php");

?>
</body>

</html>


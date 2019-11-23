<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
<?
include("konek.php");
extract($_GET);
$q=mysqli_query($mysqli,"select nama,nip_baru,tempat_lahir,tgl_lahir,jenis_kelamin,agama,gol_darah,alamat,telepon,ponsel from pegawai where id_pegawai=$id");
$ata=mysqli_fetch_array($q);
	 	

?>
<table width="231" height="379" border="0" cellpadding="0" cellspacing="0" background="depan.png">
  <tr>
    <td align="center" valign="top"><table width="231" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="147">&nbsp;</td>
      </tr>
      <tr>
        <td height="161" align="center" valign="middle"><img src="./foto/<? echo("$id.jpg "); ?>"  width="121" height="162"/></td>
      </tr>
      <tr>
        <td height="27" valign="bottom"><div align="center"><? echo("$ata[0]"); ?></div></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center"><? echo("$ata[1]"); ?></div></td>
      </tr>
    </table></td>
  </tr>
</table>


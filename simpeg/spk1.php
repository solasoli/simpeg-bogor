<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
extract($_POST);
mysqli_query($mysqli,"insert into survey_pengkom (id_pegawai,butuh_magang) values ($idp,'$radio')");
if($radio=='tidak')
{
?>
<form id="form1" name="form1" method="post" action="index3.php#que1">
  <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="justify"><a name="que1" id="que1"></a></td>
    </tr>
    <tr>
      <td align="justify">&nbsp;</td>
    </tr>
    <tr>
      <td align="justify">&nbsp;</td>
    </tr>
    <tr>
      <td align="justify"><h3>Alasan  pegawai tidak membutuhkan program magang sebagai upaya peningkatan kompetensi</h3></td>
    </tr>
    <tr>
      <td align="center"><label for="alasan"></label>
      <textarea name="alasan" id="alasan" cols="30" rows="5"></textarea></td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="button" id="button" value="Simpan" />
      <input name="idp" type="hidden" id="idp" value="<?php echo $_SESSION['id_pegawai']; ?>" />
      <input name="x" type="hidden" id="x" value="spk2.php" /></td>
    </tr>
  </table>
</form>
<?php
}
else
{
?>
<form id="form1" name="form1" method="post" action="index3.php#que1">
  <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="center"><table width="50%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center"><a name="que1" id="que1"></a></td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><h3>Apakah kompetensi teknis diperlukan? </h3></td>
        </tr>
        <tr>
          <td align="center"><h3>Jika ya, jenis kompetensi teknis apa yang sesuai dengan program magang? </h3></td>
        </tr>
        <tr>
          <td align="left"><input type="radio" name="radio" id="radio" value="Kepegawaian" />
            <label for="radio"><strong>Kepegawaian</strong></label></td>
        </tr>
        <tr>
          <td align="left"><input type="radio" name="radio" id="radio" value="Perencanaan" />
            <strong> Perencanaan</strong></td>
        </tr>
        <tr>
          <td align="left"><input type="radio" name="radio" id="radio" value="IT" />
            <strong> TI (Teknologi Informasi)</strong></td>
        </tr>
        <tr>
          <td align="left"><input type="radio" name="radio" id="radio" value="Pertanian" />
            <strong> Pertanian</strong></td>
        </tr>
        <tr>
          <td align="left"><input type="radio" name="radio" id="radio" value="Kearsipan" />
            <strong> Kearsipan</strong></td>
        </tr>
        <tr>
          <td align="left">Lainnya...</td>
        </tr>
        <tr>
          <td align="center"><label for="lainnya"></label>
            <textarea name="lainnya" id="lainnya" cols="30" rows="5"></textarea></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td align="center"><h3>Apakah kompetensi manajerial diperlukan?  </h3></td>
        </tr>
        <tr>
          <td align="center"><h3>Jika ya, tempat magang apa yang diharapkan? </h3></td>
        </tr>
        <tr>
          <td align="center"><label for="alasan2"></label>
            <input type="radio" name="radio2" id="radio2" value="Kementrian lembaga pemerintahan" />
            <strong>Kementrian / Lembaga Pemerintahan</strong>
            <label for="radio2">
              <input type="radio" name="radio2" id="radio2" value="BUMN perusahaan swasta" />
              <strong> BUMN / Perusahaan Swasta</strong></label></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="button" id="button" value="Selesai" />
      <input name="idp" type="hidden" id="idp" value="<?php echo $_SESSION['id_pegawai']; ?>" />
      <input name="x" type="hidden" id="x" value="spk2.php" /></td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>
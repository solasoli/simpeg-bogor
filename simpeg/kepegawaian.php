<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
extract($_GET);
echo("isinya $id");

?>
<form id="form1" name="form1" method="post" action="">
  <table width="500" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td>Id Pegawai</td>
      <td><label for="textfield"></label>
      <input type="text" name="textfield" id="textfield" /></td>
      <td nowrap="nowrap">Unit Kerja</td>
      <td><select name="select5" id="select5">
      </select></td>
    </tr>
    <tr>
      <td>Nama </td>
      <td><input type="text" name="textfield2" id="textfield2" /></td>
      <td>Jenjab</td>
      <td><select name="select6" id="select6">
      </select></td>
    </tr>
    <tr>
      <td>Nama Pendek</td>
      <td><input type="text" name="textfield3" id="textfield3" /></td>
      <td>Jabatan</td>
      <td><input type="text" name="textfield10" id="textfield10" /></td>
    </tr>
    <tr>
      <td>Agama</td>
      <td><label for="select"></label>
        <select name="select" id="select">
      </select></td>
      <td>Detail Jabatan</td>
      <td><input type="text" name="textfield11" id="textfield11" /></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td><select name="select2" id="select2">
      </select></td>
      <td>Atasan Langsung</td>
      <td><input type="text" name="textfield12" id="textfield12" /></td>
    </tr>
    <tr>
      <td>Status Pegawai</td>
      <td><select name="select3" id="select3">
      </select></td>
      <td>Eselonering</td>
      <td><input type="text" name="textfield13" id="textfield13" /></td>
    </tr>
    <tr>
      <td>Tempat Lahir</td>
      <td><input type="text" name="textfield4" id="textfield4" /></td>
      <td>Status Aktif</td>
      <td><select name="select7" id="select7">
      </select></td>
    </tr>
    <tr>
      <td>Tanggal Lahir</td>
      <td>&nbsp;</td>
      <td>Tgl Pensiun Reguler</td>
      <td><input type="text" name="textfield14" id="textfield14" /></td>
    </tr>
    <tr>
      <td>NIP Lama</td>
      <td><input type="text" name="textfield5" id="textfield5" /></td>
      <td>Masa Kerja Pasif</td>
      <td><input type="text" name="textfield15" id="textfield15" /></td>
    </tr>
    <tr>
      <td>NIP Baru</td>
      <td><input type="text" name="textfield6" id="textfield6" /></td>
      <td>Password </td>
      <td><input type="text" name="textfield16" id="textfield16" /></td>
    </tr>
    <tr>
      <td>N.P.W.P</td>
      <td><input type="text" name="textfield7" id="textfield7" /></td>
      <td>Keterangan</td>
      <td><input type="text" name="textfield17" id="textfield17" /></td>
    </tr>
    <tr>
      <td>No Karpeg</td>
      <td><input type="text" name="textfield8" id="textfield8" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No/Karis / Karsu</td>
      <td><input type="text" name="textfield9" id="textfield9" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Golongan/Ruang</td>
      <td><select name="select4" id="select4">
      </select></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center"><input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>
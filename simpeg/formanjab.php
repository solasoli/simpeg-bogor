<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="insertanjab.php">
  Jabatan : 
  <label><?php
  include("konek.php");
  $q=mysqli_query($mysqli,"select * from jabatan where tahun=2017 order by id_unit_kerja,eselon");
  ?>
  <select name="idj" id="idj">
  <?php
  while($data=mysqli_fetch_array($q))
  {
  echo("<option value=$data[0]>$data[1] </option>");
  
  }
  ?>
  </select>
  </label>
  <table width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
      <td width="5%">1</td>
      <td width="95%"><label>
        <input name="u1" type="text" id="u1" size="120"  />
      </label></td>
    </tr>
    <tr>
      <td>2</td>
      <td><input name="u2" type="text" id="u2" size="120"  /></td>
    </tr>
    <tr>
      <td>3</td>
      <td><input name="u3" type="text" id="u3" size="120"  /></td>
    </tr>
    <tr>
      <td>4</td>
      <td><input name="u4" type="text" id="u4" size="120"  /></td>
    </tr>
    <tr>
      <td>5</td>
      <td><input name="u5" type="text" id="u5" size="120"  /></td>
    </tr>
    <tr>
      <td>6</td>
      <td><input name="u6" type="text" id="u6" size="120"  /></td>
    </tr>
    <tr>
      <td>7</td>
      <td><input name="u7" type="text" id="u7" size="120"  /></td>
    </tr>
    <tr>
      <td>8</td>
      <td><input name="u8" type="text" id="u8" size="120"  /></td>
    </tr>
    <tr>
      <td>9</td>
      <td><input name="u9" type="text" id="u9" size="120"  /></td>
    </tr>
    <tr>
      <td>10</td>
      <td><input name="u10" type="text" id="u10" size="120"  /></td>
    </tr>
    <tr>
      <td>11</td>
      <td><input name="u11" type="text" id="u11" size="120"  /></td>
    </tr>
    <tr>
      <td>12</td>
      <td><input name="u12" type="text" id="u12" size="120"  /></td>
    </tr>
    <tr>
      <td>13</td>
      <td><input name="u13" type="text" id="u13" size="120"  /></td>
    </tr>
    <tr>
      <td>14</td>
      <td><input name="u14" type="text" id="u14" size="120"  /></td>
    </tr>
    <tr>
      <td>15</td>
      <td><input name="u15" type="text" id="u15" size="120"  /></td>
    </tr>
    <tr>
      <td><label>
        <input type="submit" name="button" id="button" value="Simpan" />
      </label></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>

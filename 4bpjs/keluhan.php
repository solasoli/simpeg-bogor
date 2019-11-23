<?php
if(isset($_SESSION['id']))
{ 

$id=$_SESSION['id'];
$unit=$_SESSION['unit'];
$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$id");
$pro=mysqli_fetch_array($qpro);

$qun=mysqli_query($link,"select nama_baru from unit_kerja where id_unit_kerja=$unit");
$un=mysqli_fetch_array($qun);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">

.avatar {
    float: left;
    margin-top: 0em;
    margin-right: 0em;
    position: relative;

    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;

    -webkit-box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
    -moz-box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
    box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
}
</style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Pengaduan Aset</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->


    <form name="form1" method="post" action="user.php" enctype="multipart/form-data">
      <table align="center" width="300" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td nowrap>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td nowrap>Jenis Aset</td>
          <td>:</td>
          <td><label>
          <input type="text" name="aset" id="aset"  list="lisaset" placeholder="ketik aset ..">
          <datalist id="lisaset">
<?php 

$qry=mysqli_query($link,"SELECT kode,barang From kode_barang");
while ($t=mysqli_fetch_array($qry)) {
echo "<option value='$t[kode] $t[barang]'>";
}
?>
</datalist>
          
          </label></td>
        </tr>
        <tr>
          <td nowrap>Keluhan</td>
          <td>:</td>
          <td><label>
          <textarea style="width:60%" name="keluhan" id="keluhan" cols="45" rows="5"></textarea>
          </label></td>
        </tr>
        <tr>
          <td nowrap>Unggah Foto</td>
          <td>:</td>
          <td><label>
          <input type="file" name="gambar" id="gambar">
          </label></td>
        </tr>
        <tr>
          <td><input type="hidden" name="x" id="x" value="insertkeluhan.php"></td>
          <td colspan="2"><label>
            <input type="submit" name="button" id="button" value="Kirim">
          </label></td>
        </tr>
      </table>
</form>
</body>
</html>

<?php
}
else
echo("direc access not allowed");
?>
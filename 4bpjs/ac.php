<!DOCTYPE html>
<html>
<head>
<title>Autocomplete With PHP MYSQL HTML5 datalist</title>
</head>
<body>
<div align="center">
<h2>Create Autocomplete PHP MYSQL HTML5</h2>
<form name="tes" id="tes" action="tangkap.php" method="post" enctype="multipart/form-data">
<input type="text" id="isi" name="isi" list="propinsi" placeholder="Riau, etc" size="50">
<datalist id="propinsi">
<?php 
include "koneksi.php";
$qry=mysqli_query($link,"SELECT kode,barang From kode_barang");
while ($t=mysqli_fetch_array($qry)) {
echo "<option value='$t[kode] $t[barang]'>";
}
?>
</datalist>
<input type="submit">
</form>
</div>
</body>
</html>
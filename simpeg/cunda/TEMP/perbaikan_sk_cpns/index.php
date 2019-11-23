<html>
<head>
<style>
body{
font-size: 10pt;
}
</style>
</head>
<body>
PERBAIKAN SK CPNS. Upload file csv sesuai dengan format yang diberikan.
<form action="upload_file.php" method="post"
enctype="multipart/form-data">
Id Unit Kerja<input type="text" name="id_unit_kerja" />
<label for="file">Filename:</label>
<input type="file" name="file" id="file" />
<input type="submit" name="submit" value="Submit" />
</form>
</body>
</html> 
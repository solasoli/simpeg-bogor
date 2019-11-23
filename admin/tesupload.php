<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label for="nama"></label>
  <input type="file" name="nama" id="nama" />
  <input type="submit" name="button" id="button" value="Submit" />
</form>
<?php
extract($_POST);
if(isset($_FILES['nama']))
move_uploaded_file($_FILES['nama']['tmp_name'],"bisa.jpg");

?>
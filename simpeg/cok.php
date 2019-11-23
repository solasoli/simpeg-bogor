<form action="" method="post" enctype="multipart/form-data" name="go" id="go">
  <label>
  <input name="g" type="file" id="g" />
  </label>
  <label>
  <input type="submit" name="Submit" value="Submit" />
  </label>
</form>
<?
$g=$_FILES['g'];

echo($g['type']);
?>

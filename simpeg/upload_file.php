<?php
if (($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "application/pdf") and $_FILES["file"]["size"]<500000  )
  
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
  {   
	if(file_exists("sk/". $_POST[filename]."jpg"))
			unlink("sk/". $_POST[filename]."jpg");
	if(file_exists("sk/". $_POST[filename]."pdf"))
			unlink("sk/". $_POST[filename]."pdf");
			
	if($_FILES["file"]["type"] == "image/jpeg")
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "sk/" . $_POST[filename]."jpg");
	}
	else if ($_FILES["file"]["type"] == "application/pdf")
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "sk/" . $_POST[filename]."pdf");
	}
  }
}
else
{
	echo "Tipe File tidak sesuai atau ukuran file terlalu besar";
}
?> 
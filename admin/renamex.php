<?php
	//echo filetype("../simpeg/Berkas/195807211982031007-74802-135567")."<br>";  // file
	$files_list = "";
	$uploaddir = "../simpeg/Berkas/";
	if ($handle = opendir("../simpeg/Berkas/")) {
		while (false !== ($file = readdir($handle))) { 
			//if ($file != "." && $file != "..") {
				//$files_list .= $file . ","; 				
			//}
			if(filetype("../simpeg/Berkas/".$file)=='file'){
				$ext = pathinfo("../simpeg/Berkas/".$file, PATHINFO_EXTENSION);
				if($ext=='tmp'){
					$uploadfile = $uploaddir . basename($file);
					$files_list .= $file ."+".$uploadfile. ",";
					//rename($uploadfile, "../simpeg/Berkas/".basename($file).".pdf");
				}
			}
		}

    closedir($handle); 
	} 
	printf($files_list); 
?>
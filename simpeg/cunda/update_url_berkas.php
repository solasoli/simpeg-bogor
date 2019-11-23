<?php
mysql_connect("simpeg.db.kotabogor.net", "simpeg", "Madangkara2017") or die;
mysql_select_db("simpeg");

if ($handle = opendir('../Berkas/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
        	$a = explode("-", $entry);
			$id_isi_berkas = explode(".", $a[2]);
			
			$path = addslashes("\\\\simpegserver\htdocs\simpeg\Berkas\\".$entry);
			
			$q = "UPDATE isi_berkas
			 	  SET file_name = '$path'
			 	  WHERE id_berkas = $a[1] AND id_isi_berkas = $id_isi_berkas[0]";
            
            mysql_query($q);	
            
			echo "$q <br/>";
        }
    }
    closedir($handle);
	
}
echo "<hr /> DONE!";
?>
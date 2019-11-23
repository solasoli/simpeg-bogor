<?php
    //langkah4 disimpan di server
    //update dan gak ada insert, delete karena emang password gak mungin dihapus cuma diupdate gabung untuk pegawai aja di server
    require_once("konek.php");
    $table1 = 'pegawai';
    $table2 = 'temp_pegawai';
   
    $q=mysqli_query($mysqli,"select * from $table2 order by id_pegawai");
   
    //update
    while($data=mysqli_fetch_array($q))   
    {
        $q2=mysqli_query($mysqli,"select count(*) from $table1 where $table1.id_pegawai = $data[id_pegawai]");
        $q2=mysqli_fetch_array($q2);
        $query1="UPDATE $table1 SET password ='$data[password]' WHERE id_pegawai=$data[id_pegawai] and timestamp < '$data[timestamp]' ";
        mysqli_query($mysqli,$query1);
		echo $query1;
		
    }
   
    echo("done!");
?>
<?php
//langkah4 disimpan diserver
//update,insert,hapus belum bisa gabung untuk keluarga aja di server
    require_once("konek.php");
    $table1 = 'keluarga';
    $table2 = 'temp_keluarga';
   
    $q=mysqli_query($mysqli,"select * from $table2 order by id_pegawai");
   
//update
    while($data=mysqli_fetch_array($q))   
    {
        $q2=mysqli_query($mysqli,"select count(*) from $table1 where $table1.id_keluarga = $data[id_keluarga]");
        $q2=mysqli_fetch_array($q2);
       
        if($q2[0]>0){
        $query1="UPDATE $table1 SET nama='$data[nama]' WHERE id_pegawai=$data[id_pegawai] and id_keluarga=$data[id_keluarga] and timestamp < '$data[timestamp]' ";
        mysqli_query($mysqli,$query1);
		echo $query1;
		}
        else{
       
        $query = "INSERT INTO $table1 ( id_keluarga,id_pegawai,id_status, nama,tempatlahir,tgl_lahir,pekerjaan,jk, keterangan, timestamp)
                                Values ('$data[id_keluarga]','$data[pegawai]','$data[id_status]' ,'$data[nama]','$data[tempatlahir]','$data[tgl_lahir]','$data[pekerjaan]','$data[jk]','$data[keterangan]' '$data[timestamp]')";
        mysqli_query($mysqli,$query);
        echo $query;
           }
    }
    echo("done!");
?>
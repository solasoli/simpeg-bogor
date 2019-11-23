<?php
extract($_POST);
mysqli_query($link,"insert into respond (id_pengaduan,id_pegawai,respond,tgl_respond) values ($id,$_SESSION[id],'$respon',CURDATE())");
$ida=mysqli_insert_id($link);
mysqli_query($link,"update pengaduan set status=1 where id=$id");

$pail=$_FILES['poto'];
if($pail['size']>0)
{
$nama=$ida.".jpg";
mysqli_query($link,"update respond set file_respond='$nama' where id=$ida");
move_uploaded_file($pail['tmp_name'],"./respond/".$nama);
}
include("adminkeluhan.php")
?>
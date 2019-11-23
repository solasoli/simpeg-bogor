<?php



mysqli_connect("localhost","simpeg_root","51mp36");

mysqli_select_db("simpeg");

$q=mysqli_query($mysqli,"select * from pegawai");

while($data=mysqli_fetch_array($q))

{

$filename="./foto/$data[0].jpg";

if (file_exists($filename)) {

rename("./foto/$data[0].jpg", "./foto/$data[14].jpg");



}

}

?>
<?php
mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
mysqli_select_db("simpeg");
$i=3056;
$q=mysqli_query($mysqli,"select * from jabatan2016 order by id_j ");
while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"update jabatan2016 set id_j=$i where id_j=$data[0]");
mysqli_query($mysqli,"update jabatan2016 set id_bos=$i where id_bos=$data[9]");

$i++;
}
echo("done");
?>
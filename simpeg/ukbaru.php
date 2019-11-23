<?php
mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
mysqli_select_db("simpeg");
$i=4784;
$q=mysqli_query($mysqli,"select * from unit_kerja2016 order by id_unit_kerja ");
while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"update unit_kerja2016 set id_unit_kerja=$i where id_unit_kerja=$data[0]");


$i++;
}
echo("done");
?>
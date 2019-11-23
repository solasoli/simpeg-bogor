<?php
include("konek.php");
extract($_POST);
$q=mysqli_query($mysqli,"select id_unit_kerja from jabatan where id_j=$idj");
$unit=mysqli_fetch_array($q);

$q2=mysqli_query($mysqli,"select id from anjab_master where id_j=$idj");
$anjab=mysqli_fetch_array($q2);


for($i=1;$i<=15;$i++)
{
$urai=$_POST["u".$i];
if(strlen($urai)>5)
{

mysqli_query($mysqli,"insert into anjab_uraian (id_anjab,uraian,id_skpd) values ($anjab[0],'$urai',$unit[0])");

}


}
echo("<div align=center>uraian berhasil diinput silahkan input jabatan selanjutnya </div>");
include("formanjab.php");
?>
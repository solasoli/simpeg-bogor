<?php 
include("konek.php");
extract($_GET);
$k=mysqli_query($mysqli,"select jurusan,akreditasi 
				from akreditasi where jurusan like '%$q%' and institusi like '%$ins%' group by jurusan ");
while($ata=mysqli_fetch_array($k))
{

$data[] = array(
'label' => $ata[0], 
'value' =>$ata[0],
'akre' =>$ata[1]

);

}
echo json_encode($data);
?>


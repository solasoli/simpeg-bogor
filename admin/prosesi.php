<?php 
include("koncil.php");
extract($_GET);
$k=mysqli_query($con,"select institusi from akreditasi where institusi like '%$q%' group by institusi ");
while($ata=mysqli_fetch_array($k))
{

$data[] = array(
'label' => $ata[0], 
'value' =>$ata[0]

);

}
echo json_encode($data);
?>


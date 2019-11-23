<?php 
include("konek.php");
extract($_GET);
$k=mysql_query("select institusi from akreditasi where institusi like '%$q%' group by institusi ");
while($ata=mysql_fetch_array($k))
{

$data[] = array(
'label' => $ata[0], 
'value' =>$ata[0]

);

}
echo json_encode($data);
?>


<?php
include("konek.php");
$q=mysqli_query($mysqli,"select reg,nip,nama from download order by id");
while($data=mysqli_fetch_array($q))
{
?>
<a href="https://epupns1.bkn.go.id/report/cetakan?noReg=<?php echo $data[0]; ?>" > <?php echo $data[1]; echo " $data[2]"; ?></a><br>
<?php
}

?>
<?php
session_start();
extract($_POST);

require_once("../../konek.php");
include_once("commentLib.php");

$start = null;
if($start == NULL)
	$start = 0;

$q = "SELECT * FROM post 
		INNER JOIN pegawai WHERE (pegawai.id_pegawai=post.id_pegawai)
		AND (parent_id IS NULL OR  parent_id = 0)
		ORDER BY pinned DESC, kapan DESC LIMIT $start,20";

$result = mysqli_query($mysqli,$q);
?>

<?php
require_once("commentsView.php");
?>

<?php if(mysqli_num_rows($result) > 0): ?>
	<div id="nextPost" style="height=200px; text-align:center; font-weight: bold; font-size: 12pt;"><a id="olderPost" onClick="return loadOlderPost(<?php echo $start+10; ?>);" href="#">Lihat posting sebelumnya</a></div>
<?php endif ?>
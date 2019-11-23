<!DOCTYPE html>
<?php
require_once("../../konek.php");

function CountChilds($parentID)
{
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
	$q = "SELECT COUNT(*) FROM post WHERE parent_id=$parentID";
	$result = mysqli_query($mysqli,$q);
	
	$r = mysqli_fetch_array($result);
	
	if($r[0] > 0)
		return "($r[0])";
}
?>

<?php while($r = mysqli_fetch_array($result)): ?>
	<div style="padding-bottom:5px">
	<table style="width:100%;" >

		<tr id="post_container_<?php echo $r['id_post'] ?>">			
			<?php if(!@$childComment): ?>
				<td width="77">
			<?php else: ?>
			<td width="30">
			<?php endif ?>
				<?php echo getImage($r['id_pegawai'], @$childComment) ?>
			</td>			
			<td style="color: black; background-color: #E9ECFE; padding: 5px 5px 5px 15px;" >
				<?php
					//$nama_full = $r['nama'];
					$nama_full = @$r[gelar_depan] ? @$r[gelar_depan].' '.@$r[nama] : @$r[nama];
					$nama_full .= @$r[gelar_belakang] ? ', '.@$r[gelar_belakang] : '' ;
				?>				
				<b><a href="index3.php?x=home3.php&&id=<?php echo $r['id_pegawai'] ?>"><?php echo $nama_full."<br/>" ?></b></a><br/>
				<?php echo $r['msg'] ?>				
				<br/><br/>
				
				
				<div style="color: #929292"><?php echo displayDate($r['kapan']); ?>
					<?php if(!@$childComment): ?>
						<a href="#" onClick="return GetChildComments(<?php echo $r['id_post'] ?>);" style="color: #4D76B2; text-decoration: none;">Komentari <?php echo CountChilds($r['id_post']); ?></a>
					<?php endif ?>		
					<?php if(($r['id_pegawai'] == $_SESSION['id_pegawai']) || ($_SESSION['user'] == '198506182010011007')): ?>
						| <a href="#" onClick="return DeleteComment(<?php echo $r['id_post'] ?>, '#post_container_<?php echo $r['id_post'] ?>');" style="color: #4D76B2; text-decoration: none;">Hapus </a>
					<?php endif ?>
				</div>
				<div id="post_<?php echo $r['id_post'] ?>"></div>
			</td>
		</tr>		
	</table>
	</div>
<?php endwhile ?>

<?php if(isset($childComment)): ?>
<div id="childCommentBox_<?php echo $parentID ?>"></div>
<script type='text/javascript'>
	$(document).ready(function(){
		var d = "#childCommentBox_<?php echo $parentID ?>";
		$(d).ready(function(){
			$(d).html($(d).html() + "<textarea class='commentBox' id='txtChildComment_<?php echo $parentID ?>'></textarea> " + 
									"<input class='commentButton' type='button' value='Kirim' id='btnSendChildComment_<?php echo $parentID ?>' onClick='return AddChildComment(txtChildComment_<?php echo $parentID ?>, btnSendChildComment_<?php echo $parentID ?>, <?php echo $parentID ?>);' />");
			
			$("#txtChildComment_<?php echo $parentID ?>").focus();
		});
	});				
</script>
<?php endif ?>
</html>

<script type="text/javascript">
	function loadComments()
	{
		$("#commentContainer").hide();
		$.post('cunda/comment/getTop10Comments.php', {  }, function(data){				
			$("#commentContainer").html(data);
			$("#commentContainer").show('slow');
		});
	}
	
	function loadLastComments()
	{
		//$("#commentContainer").hide();
		$.post('cunda/comment/getLastComment.php', { }, function(data){
			$("#commentContainer").html(data + $("#commentContainer").html());
			//$("#commentContainer").show('slow');
		});
	}
	
	function loadOlderPost(startPosition)
	{
		//alert(startPosition);
		$("#nextPost").remove();
		$("#commentContainer").html($("#commentContainer").html() + "<br/><div align=center><img id='litleLoading' src='images/litleLoading.gif' /></div>");
		$.post('cunda/comment/getTop10Comments.php', { start: startPosition }, function(data){			
			$("#commentContainer").html($("#commentContainer").html() + data);
			$("#litleLoading").remove();
		});
		return false;
	}
	
	function GetChildComments(parentID)
	{
		var comp = "#post_" + parentID;
		var old = $(comp).html();
		$(comp).html($(comp).html() + "<img src='images/litleLoading.gif' />");
		$.post('cunda/comment/getChildComments.php', { childComment: true, parentID: parentID }, function(data){
			$(comp).html(old + data);
		});
		return false;
	}
	
	function AddChildComment(textbox, senderButton, parentID)
	{		
		if($(textbox).val() != "")
		{
			if($(senderButton).val() != 'Mengirim...')
			{
				$(textbox).attr('style', 'background-color: #C9C9C9');
				$(textbox).attr('readonly', 'true');
				
				$.post('cunda/comment/addComment.php', { id_pegawai: <?php echo $_SESSION['id_pegawai'] ?>, message: $(textbox).val(), parent_id: parentID }, function(data){
						$(senderButton).val('Kirim');
						$(textbox).attr('style', 'background-color: white');
						$(textbox).removeAttr('readonly');
						$(textbox).val("Silahkan ketik pesan atau komentar anda di sini.");
						$("#post_" + parentID).html('');
						GetChildComments(parentID);						
					});
			}
		}
	}
	
	function DeleteComment(postID, senderElement)
	{
		if(confirm('Anda yakin akan menghapus komentar ini?'))
		{
			$.post('cunda/comment/deleteComment.php', { id_post: postID }, function(data){
				$(senderElement).hide('slow');			
			});
			
		}
		return false;
	}
	
	$(document).ready(function(){
		loadComments();
		
		
		$("#txtComment").focus(function(){
			if($("#txtComment").val() == "Silahkan ketik pesan atau komentar anda di sini.")
			{
				$("#txtComment").val('');
			}
		});
		
		$("#txtComment").focusout(function(){
			if($("#txtComment").val() == "")
			{
				$("#txtComment").val("Silahkan ketik pesan atau komentar anda di sini.");
			}
		});
		
		$("#btnSend").click(function(){
			if(!(($("#txtComment").val() == "") || ($("#txtComment").val() == "Silahkan ketik pesan atau komentar anda di sini.")))
			{
				if($("#btnSend").val() != 'Mengirim...')
				{
					$("#btnSend").val('Mengirim...');
					$("#txtComment").attr('style', 'background-color: #C9C9C9');
					$("#txtComment").attr('readonly', 'true');
					
					//alert($(<?php echo $_SESSION['id_pegawai'] ?>));
					$.post('cunda/comment/addComment.php', { id_pegawai: <?php echo $_SESSION['id_pegawai'] ?>, message: $("#txtComment").val()}, function(data){
						//alert(data);
						$("#btnSend").val('Kirim');
						$("#txtComment").attr('style', 'background-color: white');
						$("#txtComment").removeAttr('readonly');
						$("#txtComment").val("Silahkan ketik pesan atau komentar anda di sini.");
						loadLastComments();
						
					});
				}			
			}					
		});
	});
</script>

<style>
.commentBox{
	border: solid 1px grey;
	color: grey;
	width: 100%;
}

.commentButton{
	border: solid 1px black;
	background-color: #4D76B2;
	font-weight:bold;
	color: white;	
	height: 25;
}

#commentContainer, tr{
	font-family: tahoma;
	font-size: 10pt;
	vertical-align: top;
	text-align: left;
}
</style>

<div id="comment">
	<textarea id="txtComment" name="post" class="commentBox form-control" placeholder="Silahkan ketik pesan atau komentar anda di sini.." class="form-control"></textarea>
	<input class="btn btn-info pull-right" type="button" value="Kirim" id="btnSend" />
	<br/>
	<br/>
	<br/>
	<div id=commentContainer>		
	</div>
</div>

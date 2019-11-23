<script type="text/javascript" src="jquery.js"></script>
<?php include 'db.php' ?>

<div>
NIP:
<input id="txtNip" type="text" name="nip" />
<input id="btnSearch" type="button" value="cari" />
</div>

<div id="biodata" style="border: 1px gray solid; min-height:100px">

</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#btnSearch").click(function(){
		$("#biodata").html("Loading...");
		$.post('search.php', { nip: $("#txtNip").val() }, function(data){
			$("#biodata").html(data);
		});
	});
});
</script>
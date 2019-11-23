$(document).ready(function(){
	$('#tblPejabat').html("Loading...");
	$.post('cunda/daftar_pejabat/getAll.php', {}, function(data){		
		$('#tblPejabat').html(data);
	});
	
	$("#ExportToExcel").submit(function(){
		$("#data").val(
			$("#tblPejabat").html()
		);
	});
});
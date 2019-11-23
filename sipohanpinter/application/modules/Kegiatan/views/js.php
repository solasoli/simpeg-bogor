<!--  js.php -->
<script type="text/javascript">
	$(document).ready(function(){
			$("#simpan").click(function(e){
				//e.preventDefault();
				data = $("#isian").serializeArray();
				alert(data);
			//
				return false;
			});
	});
</script>

<script type="text/javascript" src="../jquery.js">
</script>

<script type="text/javascript" >
	$(document).ready(function(){
		
		
		$.post('data.php', { pilihan: 1 }, function(data){
			$('#kombobok').html(data);	
		});

	});
</script>
		
<select id="kombobok">
</select>
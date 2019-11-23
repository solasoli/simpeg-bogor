<script src="<?php echo base_url()?>assets/autocomplete/jquery.autocomplete.js"></script>
<form class="input-control text" method="post">
    <input type="text" name="pencarian" id="cari" placeholder="Cari Nama Pegawai/NIP"/>
    <button class="btn-search" id="pencarian"></button>
</form>

<div id="hasil_pencarian">
	</div>

<script>
	$(document).ready(function(){
	$('#cari').keyup(function(){
		$('#cari').autocomplete({
			serviceUrl: 'perubahan_keluarga/cari',
			onSelect: function (suggestion) {
			alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
		}
	});
	});

		$('#pencarian').click(function(){
			$.ajax({
				url: "<?php echo base_url().'perubahan_keluarga/perubahan_keluarga_admin'?>",
				type: "post",
				data: "keyword="+('#pencarian').val(),
				success: function(data){
					$('#hasil_pencarian').html(data)
				}
			});
		});
	});
</script>
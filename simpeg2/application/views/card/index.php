<?php $landing = "card/cetak"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="container-fluid hidden-print">
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="button btn-search"></button>
</div>
<?php echo form_close(); ?>
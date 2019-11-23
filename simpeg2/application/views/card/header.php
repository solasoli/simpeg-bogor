<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
function panjul(x) {
$.ajax({
  type: "GET",
  url: "<?php echo base_url()."card/tglcetak/";?>"+x,
  success: function(data){
  		if(data==1){
			window.print();
		}else{
			alert('Sudah pernah cetak di tahun ini');
			window.print();
		}
  }
});
}


</script>
<div class="navbar bg-crimson hidden-print">
	<div class="navbar-content">
		<span class="pull-menu"></span>
		<ul class="element-menu">
			<li><?php
			if(isset($id_pegawai))
			echo ("<a href=# onclick=panjul($id_pegawai);> Cetak</a>");
			else {
							echo anchor("card/cetak/", "Cetak");
			}

			 ?></li>
			<li><?php echo anchor("card/daftar", "Daftar cetak Kartu Tahun ".date("Y")); ?></li>
			<li><?php echo anchor("kgb/registrasi", "Registrasi"); ?></li>
			<li><?php echo anchor("kgb/laporan", "Laporan"); ?></li>
		</ul>
	</div>
</div>
<!--  End of file header.php -->
<!--  Location: ./application/views/card/header.php  -->

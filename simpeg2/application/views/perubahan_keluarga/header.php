<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="navbar bg-crimson">
	<div class="navbar-content">
		<span class="pull-menu"></span>	
		<ul class="element-menu">
			<!--<li><?php echo anchor("perubahan_keluarga", "Rekapitulasi"); ?></li>-->
			<li><?php echo anchor("perubahan_keluarga/perubahan_keluarga_admin", "Perubahan Keluarga"); ?></li>	
			<li>
				<a href="<?php echo base_url() . "perubahan_keluarga/daftar_pengajuan_perubahan" ?> ">
				Daftar Pengajuan Perubahan
				<?php 
					if($jumlah_notifikasi > 0){
						echo "<span class='bg-blue fg-white'>&nbsp; " . $jumlah_notifikasi . " &nbsp;</span>" ;
					}
				?>
				
				</a>
				
			</li>
			<li><?php echo anchor("perubahan_keluarga/laporan", "Laporan"); ?></li>	
			<li><?php echo anchor("perubahan_keluarga/batas_umur_tunjangan_anak", "Batas Umur Tunjangan Anak"); ?></li>
			
		</ul>					
	</div>
</div>
<!--  End of file header.php -->
<!--  Location: ./application/views/kgb/header.php  -->

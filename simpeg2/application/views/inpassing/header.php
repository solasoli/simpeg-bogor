<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="horizontal-menu bg-crimson compact">
	<div class="navbar-content ">		
		<ul class="element-menu">
		<?php if($this->uri->segment(2)=='gaji') { ?>
			<li class="fg-white"><?php echo anchor("inpassing", "pengaturan"); ?></li>
			<li><?php //echo anchor_popup("pdf/inpassing_gaji", "cetak inpassing",array()); ?></li>	
		<?php } elseif($this->uri->segment(1)=='inpassing') { ?>
			<li><?php echo anchor("inpassing/rekap_jfu","Rekap") ?></li>
			<li><?php echo anchor("inpassing/jfu","JFU") ?></li>
			<li><?php echo anchor("pdf/nominatif_inpassing_jfu","Nominatif",array('target'=>'_blank')) ?></li>
		<?php } ?>
		</ul>					
	</div>
</div>
<!--  End of file header.php -->
<!--  Location: ./application/views/inpassing/header.php  -->

<?php

	include "stat_class.php";
	
	$stat = new Stat_class();
?>
<div class="row">
	<div class="col-md-8 wells">
		<!--ul class="nav nav-pills">
		  <li role="presentation" class="active"><a href="#golongan">Golongan</a></li>
		  <!--li role="presentation"><a href="#">Pendidikan</a></li>
		  <li role="presentation"><a href="#">Messages</a></li-->
		</ul-->
		
		<div id="golongan">
			<?php include "stat_gol.php" ?>
		</div>
	</div>
</div>

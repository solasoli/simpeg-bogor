<div class="row">
	<div class="col-md-12 center">
		<?php 

			if (file_exists("./foto/$_SESSION[id_pegawai].jpg")) 
				echo("<img src=./foto/$_SESSION[id_pegawai].jpg width=100 hspace=10 id='photobox'/>");
			else if (file_exists("./foto/$_SESSION[id_pegawai].JPG")) 
				echo("<img src=./foto/$_SESSION[id_pegawai].JPG width=100 hspace=10 id='photobox'/>"); 

		?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Kabar SIMPEG</strong></div>
			<div class="panel-body">
										
			</div>
		</div>						
	</div>					
</div><!-- end row-fluid lig in -->
<div class="row">
	<div class="col-md-12 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Agenda</strong></div>
			<div class="panel-body">bla..bla..</div>
		</div>
	</div>
</div><!-- end row-fluid agenda -->
<div class="row clearfix">
	<div class="col-md-12 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Links</strong></div>
			<div class="panel-body">
				<ul>
					<li><a href="#">Pemerintah Kota Bogor</a></li>
					<li><a href="#">BKPP Kota Bogor</a></li>
					<li><a href="#">BKN</a></li>
				</ul>
			</div>
		</div>
	</div>
</div><!-- end row links -->
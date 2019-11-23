<?php
	
	$uk = new Unit_kerja();
	
?>

<div class="row">
	<ul class="nav nav-tabs" >   
		<li><a href="#tk"  data-toggle="tab">TK</a></li>
		<li><a href="#sd"  data-toggle="tab">SD</a></li>
		<li><a href="#smp"  data-toggle="tab">SMP</a></li>
		
		
				
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tk">
			<h4>Daftar Kepala Sekolah TK di Lingkungan Pemerintah Kota Bogor</h4>
			<table class="table table-bordered" id="list_kepsek">
				<tr><th>No.</th><th>Nama</th><th>NIP</th><th>Nama Sekolah</th></tr>
				<?php 
					$x = 1;
					foreach($uk->get_list_kepala_sekolah('TK') as $kepsek){
					
						echo "<tr><td>".$x++."</td><td>".$kepsek->nama_lengkap."</td><td>".$kepsek->nip_baru."</td><td>".$kepsek->nama_baru."</td></tr>";
					}
				?>
			</table>
		</div>
		<div class="tab-pane" id="sd">
			<h4>Daftar Kepala Sekolah TK di Lingkungan Pemerintah Kota Bogor</h4>
			<table class="table table-bordered" id="list_kepsek">
				<tr><th>No.</th><th>Nama</th><th>NIP</th><th>Nama Sekolah</th></tr>
				<?php 
					$x = 1;
					foreach($uk->get_list_kepala_sekolah('SD') as $kepsek){
					
						echo "<tr><td>".$x++."</td><td>".$kepsek->nama_lengkap."</td><td>".$kepsek->nip_baru."</td><td>".$kepsek->nama_baru."</td></tr>";
					}
				?>
			</table>
		</div>
		<div class="tab-pane" id="smp">
			<h4>Daftar Kepala Sekolah TK di Lingkungan Pemerintah Kota Bogor</h4>
			<table class="table table-bordered" id="list_kepsek">
				<tr><th>No.</th><th>Nama</th><th>NIP</th><th>Nama Sekolah</th></tr>
				<?php 
					$x = 1;
					foreach($uk->get_list_kepala_sekolah('SMP') as $kepsek){
					
						echo "<tr><td>".$x++."</td><td>".$kepsek->nama_lengkap."</td><td>".$kepsek->nip_baru."</td><td>".$kepsek->nama_baru."</td></tr>";
					}
				?>
			</table>
		</div>		
		
	</div><!-- tab content -->    
	
</div><!-- end of row-->

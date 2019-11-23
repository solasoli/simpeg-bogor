 <div class="panel-group hidden-print" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseConfig"><span class="glyphicon glyphicon-home">
				</span> SKP Home</a>
			</h5>
		</div>
		<div id="collapseConfig" class="panel-collapse collapse in">
			<div class="panel-body">
				<table class="table">
					<tr>
						<td>
							<span class="glyphicon glyphicon-home text-primary"></span><a href="index.php"> Home</a>
						</td>
					</tr>
					<?php if($_SESSION['id_pegawai'] == 11301) { ?>
					<tr>
						<td>
							<span class="glyphicon glyphicon-wrench text-primary"></span><a href="index.php?page=pengaturan"> Pengaturan</a>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<td>
							<span class="glyphicon glyphicon-search text-primary"></span><a href="index.php?page=monitoring"> Monitoring</a>
						</td>
					</tr>					
					<tr>
						<td>
							<span class="glyphicon glyphicon-question-sign text-primary"></span><a href="index.php?page=faq"> F.A.Q</a>
						</td>
					</tr>									
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
				</span> Sasaran Kerja</a>
			</h5>
		</div>
		<div id="collapseOne" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr>
						<td>
							<span class="glyphicon glyphicon-pencil text-primary"></span><a href="index.php?page=listofskp"> Formulir Target Kerja</a>
						</td>
					</tr>
					<tr>
						<td>
							<span class="glyphicon glyphicon-flash text-primary"></span><a href="index.php?page=listofrealisasi"> Realisasi Target Kerja</a>
						</td>
					</tr>					
				</table>
			</div>
		</div>
	</div>	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-check">
				</span> Pengukuran</a>
			</h5>
		</div>
		<div id="collapseTwo" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<tr>
						<td>
							<a href="index.php?page=listofsubordinate&t=review"><span class="glyphicon glyphicon-user"></span> Review Target</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href="index.php?page=listofsubordinate&t=reviewrealisasi"><span class="glyphicon glyphicon-user"></span> Review Realisasi</a>
						</td>
					</tr>					
					<tr>
						<td>
							<a href="index.php?page=listofsubordinate&t=perilaku"><span class="glyphicon glyphicon-user"></span> Penilaian Perilaku</a>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h5 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-file">
				</span> Laporan</a>
			</h5>
		</div>
		<div id="collapseThree" class="panel-collapse collapse">
			<div class="panel-body">
				<table class="table">
					<!--tr>
						<td>
							<a href="index.php?page=los2&t=final&idp=<?php //echo $pegawai->id_pegawai ?>"><span class="glyphicon glyphicon-print"></span> Cetak Laporan</a>							
						</td>
					</tr-->
					<tr>
						<td>
							<a href="index.php?page=los&t=final&idp=<?php echo $pegawai->id_pegawai ?>"><span class="glyphicon glyphicon-print"></span> Cetak Penilaian Akhir</a>							
						</td>
					</tr>
					<tr>
						<td>
							<a href="index.php?page=listofsubordinate&t=final"><span class="glyphicon glyphicon-print"></span> Cetak Penilaian Staf</a>	
						</td>
					</tr>								
				</table>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Pengukuran Sasaran Kerja Pegawai</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR PENGUKURAN SASARAN KERJA <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered table-responsive">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Pangkat/Gol.ruang</th>
					<th>Jabatan</th>
					<th>Status Penilaian SKP</th>
					<th class="hidden-print">Aksi Review</th>
				</tr>				
			</thead>
			<tbody>
				<tr class="danger">
					<td>1.</td>
					<td>Aden Odalisman</td>
					<td>Penata Muda Tk. I/IIIb</td>
					<td>Pengelola data informasi kepegawaian</td>
					<td><span class="text-danger">Belum Mengajukan</span></td>
					<td class="hidden-print">
						<a href="index.php?page=pengukuran" class="btn btn-primary btn-sm">nilai</a>
					</td>
				</tr>
				<tr>
					<td>1.</td>
					<td>Vicky Vitriandi</td>
					<td>Pangatur Tk. I/IId</td>
					<td>Pengelola data informasi kepegawaian</td>
					<td><span class="text-primary">Belum Review</span></td>
					<td class="hidden-print">
						<a href="index.php?page=pengukuran" class="btn btn-primary btn-sm">nilai</a>
					</td>
				</tr>
				<tr class="success">
					<td>2.</td>
					<td>Cunda Dwi Sespandana</td>
					<td>Pangatur Tk. I/IId</td>
					<td>Pengelola data informasi kepegawaian</td>
					<td><span class="text-success">Sudah di Review</span></td>
					<td class="hidden-print">
						<a href="#" class="btn btn-success btn-sm">nilai ulang</a>
					</td>
				</tr>				
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()">cetak</a>		
	</div>	
</div>


<script>
	
	$(document).ready(function(){
	
			$(".in").removeClass("in");
			$("#collapseTwo").addClass("in");
	});

</script>

<div class="row">
	<div class="col-md-8">
		<h3>Riwayat PAK</h3>
	</div>
	<div class="col-md-4 ">
		<div class="button-group pull-right pull-down">
			<button onclick="tambah()" class="btn btn-info">BARU</button>
		</div>
	</div>
</div>


<div>

<div class="panel panel-default">
	<div class="panel-body">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>NO</th>
					<th>PERIODE</th>
					<th>JABATAN</th>
					<th>ANGKA KREDIT</th>
					<th>STATUS</th>
					<th>AKSI</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<!----------------------------------->
<div class="modal fade" id="popup" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Buat Sasaran Kerja Pegawai</h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="newskpform">					
					<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-4 ">
						<h4>Data Dasar</h4>
						<div class="form-group">
							<label for="penilai">NIP</label>
							<div class="form-inline">
								<input type='text' name='nip' id='nip' class='form-control' value='<?php echo $_SESSION['profil']->nip ?>'>
								<a id="cari_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_pegawai" id="id_penilai" value=""/>
							</div>						
						</div>
						<div class="form-group">
							<label for="nama_penilai">Nama Penilai</label>						
							<input type='text' name='nama_penilai' id='nama_penilai' class='form-control' readonly value='<?php echo $_SESSION['profil']->nama ?>'> 
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol</label>
							<input type="text" name="gol_penilai" id="gol_penilai" class="form-control" value="<?php echo $_SESSION['profil']->pangkat." - ".$_SESSION['profil']->golongan ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan</label>
							<input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo $_SESSION['profil']->jabatan ?>">
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja</label>						
							<input type='text' name='unit_keja' id='unit_kerja' class='form-control' value='<?php echo $_SESSION['profil']->opd ?>'>
							<input type="hidden" name="id_unit_kerja" id="id_unit_kerja" value=""/>
												
						</div>
					</div>
					<div class="col-md-1 "></div>
					<div class="col-md-4">
						<h4>Data PAK Baru</h4>
						<div class="form-group">
							<label for="periode_awal">Periode Awal Penilaian</label>
							<div class="form-inline">
								<input type='text' name='periodeAwal' id='periodeAwal' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value=''> 
							</div>						
						</div>
						<div class="form-group">
							<label for="periode_awal">Periode Akhir Penilaian</label>
							<div class="form-inline">
								<input type='text' name='periodeAwal' id='periodeAwal' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value=''> 
							</div>
						</div>					
						
					</div>
					</div>
														
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">SIMPAN</a>
				<a class="btn btn-danger" data-dismiss="modal">BATAL</a>
			</div>
		</div>
	</div>
</div>
<!----------------------------------->
<script type="text/javascript">
	$(document).ready(function(){
		$(".tanggal").combodate({
			minYear: 2010,
			maxYear: <?php echo date('Y'); ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");
	});
	
	function tambah(){
		$("#popup").modal("show");
	}
</script>
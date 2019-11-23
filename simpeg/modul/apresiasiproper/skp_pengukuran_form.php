<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Formulir Sasaran Kerja Pegawai</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">FORMULIR SASARAN KERJA <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered ">
			
			<tr>
				<td rowspan="2" class="text-center"><strong>NO</strong></td>
				<td colspan="2" class="text-center" rowspan="2"><strong>I. KEGIATAN TUGAS</strong></td>
				<td rowspan="2" class="text-center"><strong>AK</strong></td>
				<td colspan="4" class="text-center"><strong>TARGET</strong></td>
				<td rowspan="2" class="text-center"><strong>AK</strong></td>
				<td colspan="4" class="text-center"><strong>REALISASI</strong></td>
				<td class="tex-center" rowspan="2"><strong>PENGHITUNGAN</strong></td>
				<td class="tex-center" rowspan="2"><strong>NILAI CAPAIAN SKP</strong></td>
				<td class="hidden-print">Aksi</td>
			</tr>
			<tr>
				<!-- target -->
				<td>Kuantitas</td>
				<td>Kualitas</td>
				<td>Waktu</td>
				<td>Biaya</td>
				<!-- end target -->
				<!-- realisasi -->
				<td>Kuantitas</td>
				<td>Kualitas</td>
				<td>Waktu</td>
				<td>Biaya</td>
				<!-- end of realisasi -->
				<td class="hidden-print"><span class="glyphicon glyphicon-cog"></span></td>
			</tr>
			<!-- ini baris uraian tugas -->
			<tr>
				<td>1</td>
				<td colspan="2">Membuat Aplikasi Penilaian Prestasi Kerja Pegawai Negeri Sipil</td>
				<td>0</td>
				<td>1 Modul</td>
				<td>100 %</td>
				<td>2 Bulan</td>
				<td>~</td>
				<!-- end of target -->
				<!-- realisasi -->
				<td>0</td>
				<td>1 Modul</td>
				<td>100 %</td>
				<td>2 Bulan</td>
				<td>~</td>
				<td>{hitungan}</td>
				<td>{capaian}</td>
				<td style="padding-right:0px" class="hidden-print">
					<a href="#skp_add_form" data-toggle="modal"><small><span data-toggle="tooltip" title="edit" class="glyphicon glyphicon-check"></span></small></a>
					
					<a href="#" data-toggle="tooltip" title="hapus"><small><span class="glyphicon glyphicon-remove"></span></small></a>
				</td>
			</tr>
			<!-- akhir uraian tugas -->
			<!-- TUGAS TAMBAHAN -->
			<tr>
				<td></td>
				<td colspan="14">II. TUGAS TAMBAHAN DAN KREATIFITAS</td>
			</tr>
			<tr>
				<td>1.</td>
				<td colspan="2">Tugas Tambahan</td>
				<td></td>
				<td colspan="4"></td>
				<td></td>
				<td colspan="4"></td>
				<td>Penghitungan</td>
				<td>Nilai</td>
				<td class="hidden-print">
					<a href="#"><small><span class="glyphicon glyphicon-check"></span></small></a>
				</td>
			</tr>
			<!-- end of TUGAS TAMBAHAN -->
		</table>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()">cetak</a>		
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tambah Uraian Tugas<h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal">
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Uraian Tugas</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="inputUraian" placeholder="Uraian Tugas">
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Angka Kredit</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="inputUraian" placeholder="Angka Kredit">
						</div>
					</div>
					<div class="form-group">
						<label for="inputKuantitas" class="col-sm-3 control-label">Kuantitas</label>
						<div class="col-sm-5">
							<input type="txt" class="form-control" id="inputKuantitas" placeholder="Kuantitas">							
						</div>
						<div class="col-sm-4">
							<select class="form-control">
							  <option>Kali</option>
							  <option>Kegiatan</option>
							  <option>Dokumen</option>							  
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Kualitas (%)</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="inputUraian" placeholder="Kualitas">
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Waktu</label>
						<div class="col-sm-5">
							<input type="txt" class="form-control" id="inputUraian" placeholder="waktu">
						</div>
						<div class="col-sm-4">
							<input type="txt" class="form-control" id="inputUraian" placeholder="waktu" value="Bulan">
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Biaya</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="inputUraian" placeholder="Biaya">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary">Simpan</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

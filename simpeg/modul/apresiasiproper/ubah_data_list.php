<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Ubah Data SKP</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">LIST REVIEW SASARAN KERJA <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th>No.</th>
					<th>Periode</th>
					<th>Pejabat Penilai</th>
					<th>Atasan Pejabat Penilai</th>
					<th>Status</th>
					<th class="hidden-print">Aksi</th>
				</tr>				
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_skp($pegawai->id_pegawai);
					$x=1;
					if(mysql_num_rows($list_skp) > 0){
					while($each_skp = mysql_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++; ?>.</td>
					<td><?php echo $format->tanggal_indo($each_skp->periode_awal)." s.d ".$format->tanggal_indo($each_skp->periode_akhir) ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_penilai)->nama_lengkap ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_atasan_penilai)->nama_lengkap ?></td>
					<!-- 
						status pengajuan 0 belum mengajukan
					-->
					<td><span class="text-danger"><?php echo $skp->get_status($each_skp->status_pengajuan)->status ?></span></td>
					<td class="hidden-print">
						<a href="index.php?page=ubah_data&idskp=<?php echo $each_skp->id_skp ?>" class="btn btn-primary btn-xs">ubah</a>
						<a href="#" id="hapus" idskp="<?php echo $each_skp->id_skp ?>"  
							<?php //if($each_skp->status_pengajuan >= 3) echo "disabled='disabled'"; ?>class="btn btn-danger btn-xs">hapus</a>
					</td>
				</tr>
				<?php
					}}else{
						echo "<tr class='text-center danger'><td colspan=6>tidak ada skp yang ditemukan</td></tr>";
					}
				?>					
			</tbody>
		</table>
	</div>
		
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="test" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">TEST</div>
			<div class="modal-body">ini body</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Buat Sasaran Kerja Pegawai</h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="newskpform">					
					<div class="table-responsive">						
						<table class="table table-bordered">							
							<tr>
								<td width="5%">1.</td>
								<td colspan="2" width="45%"><strong>Pejabat Penilai</strong></td>
								<td width="5%">2.</td>
								<td colspan="2" width="45%"><strong>Atasan Pejabat Penilai</strong></td>
							</tr>
							<tr>
								<td></td>
								<td width="15%">Nama</td>
								<td><?php echo $penilai->nama_lengkap ?></td>
								<td></td>
								<td width="15%">Nama</td>
								<td><?php echo $atasan_penilai->nama_lengkap ?></td>
							</tr>
							<tr>
								<td></td>
								<td>NIP</td>
								<td><?php echo $penilai->nip_baru ?></td>
								<td></td>
								<td>NIP</td>
								<td><?php echo $atasan_penilai->nip_baru ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Pangkat/Gol</td>
								<td><?php echo $penilai->pangkat_gol ?></td>
								<td></td>
								<td>Pangkat/Gol</td>
								<td><?php echo $atasan_penilai->pangkat_gol ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Jabatan</td>
								<td><?php echo $obj_pegawai->get_jabatan($penilai) ?></td>
								<td></td>
								<td>Jabatan</td>
								<td><?php echo $obj_pegawai->get_jabatan($atasan_penilai) ?></td>
							</tr>
							<tr>
								<td></td>
								<td>Unit Kerja</td>
								<td><?php echo $penilai->nama_baru ?></td>
								<td></td>
								<td>Unit Kerja</td>
								<td><?php echo $atasan_penilai->nama_baru ?></td>
							</tr>													
						</table>						
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Periode Awal Penilaian :</label>
						<div class="col-sm-3">
							<input type="text" class="form-control datepicker" id="periodeAwal">
						</div>
						<label for="inputUraian" class="col-sm-3 control-label">Periode Akhir Penilaian :</label>
						<div class="col-sm-3">
							<input type="text" class="form-control datepicker" id="periodeAkhir" >
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Berikutnya</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

<script>
	
	$(document).ready(function(){
	
		$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd'
		});
		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");
				
		$("a#hapus").on("click", function(){
						
			idskp = $(this).attr('idskp');
			del = confirm("yakin akan hapus "+idskp);
			if(del == true){				
				$(this).closest('tr').remove();
				$.post("skp.php",{aksi:"delSkp", idskp: idskp});										 
				
			}else{
				//alert("kela kela, can yakin yeuh tong waka di apus");
				return false;
			}
		});
		
		
	});
	
	
	
	
	function berikutnya(){
		
		var tambah = "<tr><td>2.</td><td>1 Jan 2013 - 31 Des 2013</td><td>hehe</td>"+
					+"<td>haha</td>"+
					+"<td><span class='text-danger'></span></td>"+
					+"<td class='hidden-print'></td></tr>";
					
		
		
		var id_pegawai 						= "<?php echo $pegawai->id_pegawai ?>";
		var gol_pegawai						= "<?php echo $pegawai->pangkat." - ".$pegawai->pangkat_gol ?>";
		var jabatan_pegawai					= "<?php echo $obj_pegawai->get_jabatan($pegawai)?>";
		var id_unit_kerja_pegawai			= "<?php echo $pegawai->id_unit_kerja ?>";
		var id_penilai						= "<?php echo $penilai->id_pegawai ?>";
		var gol_penilai						= "<?php echo $penilai->pangkat." - ".$penilai->pangkat_gol ?>";
		var jabatan_penilai					= "<?php echo $obj_pegawai->get_jabatan($penilai)?>";
		var id_unit_kerja_penilai			= "<?php echo $penilai->id_unit_kerja ?>";
		var id_atasan_penilai				= "<?php echo $atasan_penilai->id_pegawai ?>";
		var gol_atasan_penilai				= "<?php echo $atasan_penilai->pangkat." - ".$atasan_penilai->pangkat_gol ?>";
		var jabatan_atasan_penilai			= "<?php echo $obj_pegawai->get_jabatan($atasan_penilai)?>";
		var id_unit_kerja_atasan_penilai	= "<?php echo $atasan_penilai->id_unit_kerja ?>";
		var periode_awal					= $("#periodeAwal").val();
		var periode_akhir					= $("#periodeAkhir").val();
		
		var dua = "<tr><td>2.</td><td>"+periode_awal+" - "+periode_akhir+"</td><td><?php echo $penilai->nama ?></td><td><?php echo $atasan_penilai->nama ?></td><td></td><td></td></tr>";
		
		if(periode_awal.length <= 6 || periode_akhir.length <= 6){
			alert("Harap mengisi periode penilaian");
			$("#periodeAwal").focus();
			
		}else{
		
		
			$.post("skp.php", { aksi:	 "tambahSkp", 
								id_pegawai: id_pegawai , 
								gol_pegawai: gol_pegawai,
								jabatan_pegawai: jabatan_pegawai,
								id_unit_kerja_pegawai: id_unit_kerja_pegawai,
								id_penilai : id_penilai,
								gol_penilai : gol_penilai,
								jabatan_penilai: jabatan_penilai,
								id_unit_kerja_penilai : id_unit_kerja_penilai,
								id_atasan_penilai : id_atasan_penilai,
								gol_atasan_penilai : gol_atasan_penilai,
								jabatan_atasan_penilai : jabatan_atasan_penilai,
								id_unit_kerja_atasan_penilai : id_unit_kerja_atasan_penilai,
								id_unit_kerja_atasan_penilai : id_unit_kerja_atasan_penilai,
								periode_awal : periode_awal,
								periode_akhir : periode_akhir
								})
			.done(function(data){
								
				$("#skp_add_form").modal("hide");
				$("#listskp tr:last").after(dua);
				window.location.replace("index.php?page=formulir&idskp="+data);
						
			  });
		}
	}
	
	
	
	
</script>
<script src="skp.js"></script>

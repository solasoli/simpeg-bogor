<div class="panel panel-default">
	<div class="panel-heading hidden-print">		
		<!--h5 class="panel-title">Realisasi Sasaran Kerja Pegawai</h5-->
		 <h5 class="clearfix">
			<span class="glyphicon glyphicon-pencil"></span>
			<span class="left">Realisasi Sasaran kerja pegawai  <?php echo $obj_pegawai->get_obj($idp)->nama?></span>				   
		</h5>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>PENILAIAN SASARAN KERJA PEGAWAI</strong></h5>
	</div>
	<div id="draftrealisasi" class="draft visible-print">
		<h1><strong>-- D R A F T -- D R A F T --</strong></h1>
	</div>
	<div class="panel-body">
		<div>
			Jangka Waktu Penilaian : <?php echo $format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_awal)." s.d. ".$format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_akhir) ?>
		</div>
		<div>
		<table class="clearfix table table-bordered">
			
			<tr>
				<td rowspan="2" class="text-center">NO</td>
				<td rowspan="2" class="text-center">I. KEGIATAN TUGAS</td>
				<td rowspan="2" class="text-center">AK</td>	
				<td colspan="4" class="text-center">TARGET</td>
				<td rowspan="2" class="text-center">AK</td>
				<td colspan="4" class="text-center">REALISASI</td>
				<td class="text-center" rowspan="2">PENGHI-<br>TUNGAN</td>
				<td class="text-center" rowspan="2">NILAI <br>CAPAIAN SKP</td>
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
			<?php
				$list_target = $skp->get_target($_GET['idskp']);
				$x = 1;
				while($target = mysql_fetch_object($list_target)){
					if($result = $skp->get_target_history($target->id_skp_target)){
						$history = mysql_fetch_object($result);
					}else
						$history = "";
			?>
			<tr >
				<td><?php echo $x++ ?></td>
				<td>
					<span <?php 
						
							if(($target->kuantitas == 0) && ($target->kualitas == 0)) echo "style='text-decoration:line-through'" ?>>
							<?php echo $target->uraian_tugas ?>
							
					</span>
				</td>
				<td class="text-center"><?php echo $target->angka_kredit ?></td>
				<td class="text-center">
					<?php 
						if($history != "" && ($history->kuantitas != $target->kuantitas)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->kuantitas."</span><br>" ;
							echo $target->kuantitas." ".$target->kuantitas_satuan;
						}else{
							echo $target->kuantitas." ".$target->kuantitas_satuan;
						}
					?>
				</td>
				<td class="text-center">
					<?php 
						if($history != "" && ($history->kualitas != $target->kualitas)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->kualitas."</span><br>" ;
							echo $target->kualitas;
						}else{
							echo $target->kualitas;
						}
					?> %
				</td>
				<td class="text-center">
					<?php 
						if($history != "" && ($history->waktu != $target->waktu)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->waktu."</span><br>" ;
							echo $target->waktu." ".$target->waktu_satuan;
						}else{
							echo $target->waktu." ".$target->waktu_satuan;
						} 
					?>
				</td>
				<td class="text-center">
					<?php 
						if($history != "" && ($history->biaya != $target->biaya)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->biaya."</span><br>" ;
							echo $target->biaya;
						}else{
							echo $target->biaya;
						}
					?>
				</td>
				<!-- end of target -->
				<!-- realisasi -->
				<td class="text-center"><?php echo $target->real_angka_kredit ?></td>
				<td class="text-center"><?php echo $target->real_kuantitas." ".$target->kuantitas_satuan ?></td>
				<td class="text-center"><?php echo $target->real_kualitas?> %</td>
				<td class="text-center"><?php echo $target->real_waktu." ".$target->waktu_satuan ?></td>
				<td class="text-center"><?php echo $target->real_biaya ?></td>
				<td class="text-center"><?php echo $target->hitung_nilai ?></td>
				<td class="text-center"><?php echo $target->nilai_capaian ?></td>
				<td style="padding-right:0px" class="hidden-print">
					<a href="#" onclick="insert_realisasi(<?php echo $target->id_skp_target ?>)" class="btn btn-info btn-reviewreal btn-xs">
						<small><span data-toggle="tooltip" title="edit" class="glyphicon glyphicon-check btn-reviewreal"></span></small>
					</a>										
				</td>
			</tr>
			<?php } ?>
			<!-- akhir uraian tugas -->
			<!-- TUGAS TAMBAHAN -->
			<tr>
				<td></td>
				<td colspan="13">II. TUGAS TAMBAHAN DAN KREATIFITAS</td>
				<td class="hidden-print">
					<a href="#tugasTambahanModal" class="btn btn-info btn-reviewreal btn-xs" data-toggle="modal" id="btnAddTambahan">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</td>
			</tr>
			<tr>
				<td>a.</td>
				<td colspan="12">
					Tugas Tambahan					
				</td>
				<td class="text-center">
					<strong><?php echo $skp->get_nilai_tambahan($_GET['idskp'],'TAMBAHAN') ?></strong>
				</td>
				<td class="hidden-print">					
				</td>				
			</tr>
			<?php
				$list_tambahan = $skp->get_tambahan_kreatifitas($_GET['idskp'],'TAMBAHAN');				
				while($tambahan = mysql_fetch_object($list_tambahan)){
			?>
			<tr>
				<td ></td>
				<td colspan="11"><?php echo $tambahan->tugas_tambahan ?></td>				
				<td></td>
				<td></td>
				<td class="hidden-print">
					<a href="#" id="btnHapusTambahan" idtambahan="<?php echo $tambahan->id_tambahan_kreatifitas ?>" class="btn btn-danger btn-reviewreal btn-xs"><small><span class="glyphicon glyphicon-remove"></span></small></a>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td >b.</td>
				<td colspan="13">Kreatifitas</td>				
				<td class="hidden-print">
					<a href="#" class="btn btn-info btn-reviewreal btn-xs" id="btnAddKreatifitas"><span class="glyphicon glyphicon-plus"></span></a>
				</td>
			</tr>
			<!-- end of TUGAS TAMBAHAN -->
			<tr>
				<td></td>
				<td colspan="11" class="text-center">NILAI CAPAIAN SKP</td>
				<td></td>
				<td class="text-center"><strong><?php echo $skp->get_nilai_capaian($_GET['idskp'])->rata2_nilai_skp ?></strong></td>
				<td class="hidden-print"></td>
			</tr>
		</table>
		</div>
		<div class="penandatangan visible-print">
			<table class="table table-noborder">
				<tr>
					<td width="70%"></td>
					<td class="text-center">
						Bogor, <?php echo $format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_akhir) ?> 
						<br>Pejabat Penilai,	
						<br><br><br><br><br> 
						<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$penilai->nip_baru ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-warning btn-reviewreal" type="button" onclick="setStatus(5)">Koreksi</a>
		<a href="#" class="btn btn-success btn-reviewreal" type="button" onclick="setStatus(6)">Setuju</a>
		<a href="#" class="btn btn-danger hide" id="btn-cancelAcc" type="button" onclick="setStatus(4)">Batalkan Persetujuan</a>
		<a href="#" class="btn btn-primary" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Realisasi Target No. 1<h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="formRealisasi">					
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Angka Kredit</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="realAngkaKredit" name="realAngkaKredit" value="0">
						</div>
					</div>
					<div class="form-group">
						<label for="inputKuantitas" class="col-sm-3 control-label">Kuantitas</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="realKuantitas" placeholder="Kuantitas" name="realKuantitas">							
						</div>						
					</div>
					<div class="form-group">
						<label for="realKualitas" class="col-sm-3 control-label">Kualitas (%)</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="realKualitas" name="realKualitas" placeholder="Kualitas">
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Waktu</label>
						<div class="col-sm-5">
							<input type="txt" class="form-control" id="realWaktu" name="realWaktu" placeholder="waktu">
						</div>						
					</div>
					<div class="form-group">
						<label for="realBiaya" class="col-sm-3 control-label">Biaya</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="realBiaya" name="realBiaya">
							<input type="hidden" name="aksi" id="aksi">
							<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">
							<input type="hidden" name="idtarget" id="idtarget">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" onclick="simpan_realisasi()">Simpan</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="tugasTambahanModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tugas Tambahan<h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form" id="tugasTambahanForm">					
					<div class="form-group">
						<label for="tugasTambahan" class=" control-label">Tugas Tambahan</label>
						<div class="">
							<input type="txt" class="form-control" id="tugasTambahan" name="tugastambahan">
							<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">
							<input type="hidden" value="TAMBAHAN" name="jenis">			
							<input type="hidden" value="saveTambahan" name="aksi">				
						</div>
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" id="btnTugasTambahan">Simpan</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>		
</div>
<script>
	
	$(document).ready(function(){
	
			$(".in").removeClass("in");
			$("#collapseTwo").addClass("in");
			
			$("#btnTugasTambahan").on("click",function(){
				
				$.post("skp.php", $("#tugasTambahanForm").serialize())
				.done(function(data){
					//alert(data);
					window.location.reload();
				})
			});
			
			$("a#btnHapusTambahan").on("click",function(){
						
				idtambahan = $(this).attr('idtambahan')
				del = confirm("yakin akan hapus "+idtambahan);
				if(del == true){				
					$(this).closest('tr').remove();
					$.post("skp.php",{aksi: "delTambahan", idtambahan: idtambahan});										 
					
				}else{
					alert("kela kela, can yakin yeuh tong waka di apus");
					return false;
				}
			});
	});
	
	
	function insert_realisasi(idtarget){
		
		$("#idtarget").val(idtarget);
		$.post("skp.php", {
			aksi: "getUraianTarget",
			idtarget: idtarget
			})
		.done(function(data){
			obj = JSON.parse(data);
			//alert(obj.uraian_tugas);
			$("#realAngkaKredit").val(obj.real_angka_kredit);
			$("#realKuantitas").val(obj.real_kuantitas);
			$("#realKualitas").val(obj.real_kualitas);
			$("#realWaktu").val(obj.real_waktu);
			$("#realBiaya").val(obj.real_biaya);
			//alert(obj.real_kuantitas);
			$("#skp_add_form").modal("show");	
		});
		
		$("a#hapusTambahan").on("click",function(){
						
			idtarget = $(this).attr('idtambahan')
			del = confirm("yakin akan hapus "+idtarget);
			if(del == true){				
				$(this).closest('tr').remove();
				$.post("skp.php",{aksi: "delTambahan", idtarget: idtarget});										 
				
			}else{
				alert("kela kela, can yakin yeuh tong waka di apus");
				return false;
			}
		});
		
	}
	
	function simpan_realisasi(){
		
		var idtarget = $("#idtarget").val();
		
		$("#aksi").val("saveRealisasi");
		
		$.post("skp.php",$("#formRealisasi").serialize())
		 .done(function(data){			
			//alert(idtarget);
			
			window.location.reload();
		});
		
	}
	
	

</script>
<script src="skp.js"></script>

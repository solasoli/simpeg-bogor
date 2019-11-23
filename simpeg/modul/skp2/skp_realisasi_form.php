<?php
	//ppk = penilaian prestasi kerja
	$ppk = $skp->get_skp_by_id($_GET['idskp']);
				
	if(isset($ppk->id_penilai_realisasi)){
		$penilai = $obj_pegawai->get_obj($ppk->id_penilai_realisasi);
		$atasan_penilai = $obj_pegawai->get_obj($ppk->id_atasan_penilai_realisasi);
		
	}else{
		$penilai = $obj_pegawai->get_obj($ppk->id_penilai);
		$atasan_penilai = $skp->get_penilai($penilai);
	}
?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<!--h5>Realisasi Sasaran Kerja Pegawai</h5-->
			<h5 class="clearfix">				
				<span class="left">REALISASI SASARAN KERJA PEGAWAI</span>
				<form class="panel-form right" action="">
					<a href="#" id="btnUbahPenilai" class="btn btn-primary btn-real btn-revisi-add"><span>Ubah Penilai Realisasi</span></a>
					<a href="#" id="btnPenyesuaianTarget" onclick="setStatus(7)" class="btn btn-warning btn-real btn-revisi-add"><span class="icomoon-icon-flag"></span>Penyesuaian Target</a>
					<a href="#" onclick="setStatus(3)" class="btn btn-warning btn-revisi-done hidden"><span class="icomoon-icon-cancel"></span>Selesai Penyesuaian</a>
					
					<!--a class="btn btn-default btn-xs dropdown-toggle btn-revisi-toggle" data-toggle="dropdown" href="#">
						<span class="icon16 icomoon-icon-info"></span> 
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">						
						<li></li>
						<li></li>					
					</ul-->
				</form>			   
			</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>PENILAIAN SASARAN KERJA PEGAWAI</strong></h5>
	</div>
	<div id="draftrealisasi" class="draft visible-print">
		<h1><strong>-- D R A F T -- D R A F T --</strong></h1>
	</div>
	<div class="panel-body">
		<div>
			Jangka Waktu Penilaian : <?php echo $format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_awal)." s.d ".$format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_akhir) ?>
			<a href="#" onclick="revisi_periode(<?php echo $_GET['idskp'] ?>)" class="btn btn-warning btn-xs hidden btn-revisi">revisi</a>										
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
					<span <?php if(($target->kuantitas == 0) && ($target->kualitas == 0)) echo "style='text-decoration:line-through'" ?>>
					<?php echo $target->uraian_tugas ?>
					</span>
				</td>
				<td class="text-center"><?php echo $target->angka_kredit ?></td>
				<td class="text-center">
					<?php 
					
						if($history != "" && ($history->kuantitas != $target->kuantitas)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->kuantitas."</span><br>" ;
							echo $target->kuantitas." ".$target->kuantitas_satuan ;
						}else{
							echo $target->kuantitas." ".$target->kuantitas_satuan ;
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
							echo $target->waktu." ".$target->waktu_satuan ;
						}else{
							echo $target->waktu." ".$target->waktu_satuan ;
						}
					?>
				</td>
				<td class="text-center">
					<?php 
						if($history != "" && ($history->biaya != $target->biaya)){
							if($history != "" ) echo "<span style='text-decoration:line-through'>".$format->currency($history->biaya)."</span><br>" ;
							echo $format->currency($target->biaya);
						}else{
							echo $format->currency($target->biaya);
						}
					?>
				</td>
				<!-- end of target -->
				<!-- realisasi -->
				<td class="text-center"><?php echo $target->real_angka_kredit ?></td>
				<td class="text-center"><?php echo $target->real_kuantitas." ".$target->kuantitas_satuan ?></td>
				<td class="text-center"><?php echo $target->real_kualitas?> %</td>
				<td class="text-center"><?php echo $target->real_waktu." ".$target->waktu_satuan ?></td>
				<td class="text-center"><?php echo $format->currency($target->real_biaya) ?></td>
				<td class="text-center"><?php echo $target->hitung_nilai ?></td>
				<td class="text-center"><?php echo $target->nilai_capaian ?></td>
				<td style="padding-right:0px" class="hidden-print">
					<a href="#" onclick="insert_realisasi(<?php echo $target->id_skp_target ?>)" class="btn btn-info btn-real btn-xs">
						<small><span data-toggle="tooltip" title="Entri Realisasi" class="glyphicon glyphicon-check"></span></small>
					</a>
					<a href="#" onclick="revisi_target(<?php echo $target->id_skp_target ?>)" class="btn btn-warning btn-xs hidden btn-revisi">revisi</a>										
				</td>
			</tr>
			<?php } ?>
			<!-- akhir uraian tugas -->
			<!-- TUGAS TAMBAHAN -->
			<tr>
				<td></td>
				<td colspan="13">II. TUGAS TAMBAHAN DAN KREATIFITAS</td>
				<td class="hidden-print">
					<a href="#tugasTambahanModal" class="btn btn-info btn-real btn-xs" data-toggle="modal" id="btnAddTambahan">
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
					<?php echo $skp->get_nilai_tambahan($_GET['idskp'],'TAMBAHAN') ?>
				</td>
				<td class="hidden-print"></td>				
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
					<a href="#" id="btnHapusTambahan" idtambahan="<?php echo $tambahan->id_tambahan_kreatifitas ?>" class="btn btn-danger btn-real btn-xs"><small><span class="glyphicon glyphicon-remove"></span></small></a>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td >b.</td>
				<td colspan="13">Kreatifitas</td>				
				<td class="hidden-print">
					<a href="#" class="btn btn-info btn-real btn-xs" id="btnAddKreatifitas"><span class="glyphicon glyphicon-plus"></span></a>
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
		<a href="#" class="btn btn-success btn-real" type="button" onclick="setStatus(4)">Ajukan realisasi</a>
		<a href="#" onclick="setStatus(3)" class="btn btn-warning " id="btnBatalAjukanRealisasi">Batalkan Realisasi</a>
		<a href="#" class="btn btn-primary" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
		<span class="pull-right ">
			STATUS : <strong><span class="danger"><?php echo $skp->get_status($skp->get_skp_by_id($_GET['idskp'])->status_pengajuan)->status ?></span></strong>
		</span>
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4><span class="glyphicon glyphicon-check"></span> Entri Realisasi Sasaran Kerja</h4>
				<div id="headReal"></div>				
			</div>
			<div class="modal-body">				
				<form role="form" class="form-horizontal" id="formRealisasi">					
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label"></label>
						<div class="col-sm-3">
							<label>Target</label>
						</div>
						<div class="col-sm-6">
							<label>Realisasi</label>
						</div>
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Angka Kredit</label>
						<div class="col-sm-3" id="targetAK"></div>
						<div class="col-sm-3">
							<input type="txt" class="form-control" id="realAngkaKredit" name="realAngkaKredit" value="0">
						</div>
						
					</div>
					<div class="form-group">
						<label for="inputKuantitas" class="col-sm-3 control-label">Kuantitas</label>
						<div class="col-sm-3" id="targetKuantitas"></div>
						<div class="col-sm-3">
							<input type="txt" class="form-control" id="realKuantitas" placeholder="Kuantitas" name="realKuantitas">							
						</div>												
					</div>
					<div class="form-group">
						<label for="realKualitas" class="col-sm-3 control-label">Kualitas (%)</label>
						<div class="col-sm-3" id="targetKualitas"></div>
						<div class="col-sm-3">
							<input type="txt" class="form-control" id="realKualitas" name="realKualitas" placeholder="Kualitas">
						</div>						
					</div>
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">Waktu</label>
						<div class="col-sm-3" id="targetWaktu"></div>
						<div class="col-sm-3">
							<input type="txt" class="form-control" id="realWaktu" name="realWaktu" >
						</div>											
					</div>
					<div class="form-group">
						<label for="realBiaya" class="col-sm-3 control-label">Biaya</label>
						<div class="col-sm-3" id="targetBiaya"></div>
						<div class="col-sm-3">
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
<!-- +++++++++++++++++++++++++++++++++++++ -->
<!-- form penyesuaian target -->
<div class="modal fade" id="skp_revisi_target" role="dialog">
	<form id="formRevisiTarget" role="form" class="form-horizontal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> 
					Penyesuaian target kerja pegawai<br>					
				<h5>
			</div>
			<div class="modal-body">
				
				<div id="uraianAwal"></div>
				<table class="table">
					<thead class="text-center">
					<tr>
						<th></th>
						<th>Sebelum Penyesuaian</th>
						<th>Setelah Penyesuaian</th>
					</tr>
					</thead>
					<tr>
						<td>Angka Kredit</td>
						<td id="angkaKreditAwal" class="text-center"></td>
						<td>
							<input type="text" class="form-control" name="inputAK" id="revInputAK">							
						</td>
					</tr>
					<tr>
						<td>Kuantitas</td>
						<td id="kuantitasAwal" class="text-center"></td>
						<td>
							<input type="hidden" name="inputUraian" id="revInputUraian">
							<input type="text" class="form-control" name="inputKuantitas" id="revInputKuantitas">
							<input type="hidden" name="inputKuantitasSatuan" id="revInputKuantitasSatuan">
						</td>
					</tr>
					<tr>
						<td>Kualitas</td>
						<td id="kualitasAwal" class="text-center"></td>
						<td>
							<input type="text" class="form-control" name="inputKualitas" id="revInputKualitas">
							<input type="hidden" name="inputKualitasSatuan" id="revInputKualitasSatuan">
						</td>
					</tr>
					<tr>
						<td>Waktu</td>
						<td id="waktuAwal" class="text-center"></td>
						<td>
							<input type="text" class="form-control" name="inputWaktu" id="revInputWaktu">
							<input type="hidden" id="revInputWaktuSatuan" name="inputWaktuSatuan">
						</td>
					</tr>
					<tr>
						<td>Biaya</td>
						<td id="biayaAwal" class="text-center"></td>
						<td>
							<input type="text" class="form-control" name="inputBiaya" id="revInputBiaya">
							<input type="hidden" name="aksi" id="aksiRevisi" value="">
							<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">
							<input type="hidden" name="idtarget" id="idtargetRevisi">
							<input type="hidden" name="inputUrutan" id="inputUrutan">
						</td>
					</tr>
					<tr>
						<td>Alasan Penyesuaian</td>
						<td colspan="2">
							<textarea class="form-control" rows="3" name="alasanpenyesuaian"></textarea>
						</td>
					</tr>
				</table>	
			</div>
			<div class="modal-footer">		
				<a onclick="simpan_revisi()" class="btn btn-primary">Simpan</a>		
				<button class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
	</form>
</div>

<!-- end of penyesuaian target -->
<!-- form penyesuaian periode -->
<div class="modal fade" id="skp_revisi_periode" role="dialog">	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> 
					Penyesuaian Periode SKP<br>					
				<h5>
			</div>
			<div class="modal-body">				
				<form role="form" class="form-horizontal" id="formRevisiPeriode">					
					<div class="form-group">
						<label for="revPeriodeAkhir" class="col-sm-3  control-label">Periode Akhir</label>
						<div class="col-sm-3 ">
							<input type="txt" class="form-control datepicker" id="revPeriodeAkhir" name="revPeriodeAkhir">
							<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">									
							<input type="hidden" value="updatePeriode" name="aksi">				
						</div>
					</div>					
				</form>
				</form>
			</div>
			<div class="modal-footer">		
				<a onclick="update_periode()" class="btn btn-primary">Simpan</a>		
				<button class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>	
</div>

<!-- end of penyesuaian target -->
<script>
	$(document).ready(function(){
	
			$(".in").removeClass("in");
			$("#collapseOne").addClass("in");
			
			$("#btnTugasTambahan").on("click",function(){				
				$.post("skp.php", $("#tugasTambahanForm").serialize())
				.done(function(data){					
					window.location.reload();
				})
			});
			
			$("a#btnHapusTambahan").on("click",function(){
						
				idtambahan = $(this).attr('idtambahan')
				del = confirm("yakin akan hapus tugas tambahan? ref:"+idtambahan);
				if(del == true){				
					$(this).closest('tr').remove();
					$.post("skp.php",{aksi: "delTambahan", idtambahan: idtambahan})
					 .done(function(data){window.location.reload()});					
				}else{					
					return false;
				}
			});
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd'
			});
			
			$('#tugasTambahanForm').on("keyup keypress", function(e) {
			  var code = e.keyCode || e.which; 
			  if (code  == 13) {               
				e.preventDefault();
				return false;
			  }
			});
	});
	
	function revisi_target(idtarget){
		$.post("skp.php",{aksi: "getUraianTarget", idtarget:idtarget})
		 .done(function(data){
			obj = JSON.parse(data);
			$("#aksiRevisi").val("revisiTarget");
			$("#idtargetRevisi").val(idtarget);	
			
			$("#revInputUraian").val(obj.uraian_tugas);		
			$("#uraianAwal").html(obj.uraian_tugas);
			$("#angka_kredit").html(obj.angka_kredit);
			$("#revInputAK").val(obj.angka_kredit);
			
			$("#kuantitasAwal").html(obj.kuantitas +" "+obj.kuantitas_satuan);
			$("#revInputKuantitas").val(obj.kuantitas);
			
			$("#revInputKuantitasSatuan").val(obj.kuantitas_satuan);
			$("#kualitasAwal").html(obj.kualitas +" %");
			$("#revInputKualitas").val(obj.kualitas);
			$("#waktuAwal").html(obj.waktu);
			$("#revInputWaktu").val(obj.waktu);
			$("#revInputWaktuSatuan").val(obj.waktu_satuan);
			$("#biaya").html(obj.biaya);
			$("#revInputBiaya").val(obj.biaya);
			
			$("#inputUrutan").val(obj.urutan);
			$("#skp_revisi_target").modal("show");
		});			
	}
	
	function revisi_periode(idskp){
		
		$.post("skp.php",{aksi: "getSkpById", idskp:idskp, json:'TRUE'})
		  .done(function(data){
			obj = JSON.parse(data);
			$("#revPeriodeAkhir").val(obj.periode_akhir);
			$("#skp_revisi_periode").modal("show");			
		});
	}
	
	function update_periode(){
		$.post("skp.php",$("#formRevisiPeriode").serialize())
		 .done(function(data){			
			//alert(data);
			window.location.reload();
		});
	}
	
	function simpan_revisi(){
		
		$.post("skp.php",$("#formRevisiTarget").serialize())
		 .done(function(data){			
			window.location.reload();
		});				
	}
	
	function insert_realisasi(idtarget){
		
		$("#idtarget").val(idtarget);
		$.post("skp.php", {
			aksi: "getUraianTarget",
			idtarget: idtarget
			})
		.done(function(data){
			obj = JSON.parse(data);			
			$("#headReal").html(obj.uraian_tugas);
			$("#targetAK").html(obj.angka_kredit);
			$("#targetKuantitas").html(obj.kuantitas);
			$("#targetKualitas").html(obj.kualitas);
			$("#targetWaktu").html(obj.waktu);
			$("#targetBiaya").html(obj.biaya);
			
			$("#realAngkaKredit").val(obj.real_angka_kredit);
			$("#realKuantitas").val(obj.real_kuantitas);
			$("#realKualitas").val(obj.real_kualitas);
			$("#realWaktu").val(obj.real_waktu);
			$("#realBiaya").val(obj.real_biaya);			
			$("#skp_add_form").modal("show");	
		});
		
		$("a#hapusTambahan").on("click",function(){						
			idtarget = $(this).attr('idtambahan')
			del = confirm("yakin akan hapus "+idtarget);
			if(del == true){				
				$.post("skp.php",{aksi: "delTambahan", idtarget: idtarget})
				 .done(function(){
					$(this).closest('tr').remove();
					window.location.reload();
				});
			}else{				
				return false;
			}
		});		
	}
	
	function simpan_realisasi(){
		
		var idtarget = $("#idtarget").val();		
		$("#aksi").val("saveRealisasi");		
		$.post("skp.php",$("#formRealisasi").serialize())
		 .done(function(data){						
			window.location.reload();
		});		
	}	

</script>
<script src="skp.js"></script>

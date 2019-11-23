<?php 

	$perilaku = $skp->get_skp_by_id($_GET['idskp']);
	
	if(isset($perilaku->id_penilai_realisasi)){
		$penilai = $obj_pegawai->get_obj($perilaku->id_penilai_realisasi);
		//$atasan_penilai = $obj_pegawai->get_obj($perilaku->id_atasan_penilai_realisasi);
		
	}else{
		$penilai = $obj_pegawai->get_obj($perilaku->id_penilai);
		//$atasan_penilai = $perilaku->get_penilai($penilai);
	}
?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Buku Catatan Penilaian Perilaku <?php echo $obj_pegawai->get_obj($_GET['idp'])->nama_lengkap ?></h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">BUKU CATATAN PENILAIAN PERILAKU <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered">
			<thead>
				<tr class="text-center">
					<th>No</th>
					<th width="15%" class="text-center">Tanggal</th>
					<th colspan="3" style="width='30%" class="text-center">Uraian</th>
					<th  class="text-center">Nama/Nip dan Paraf Pejabat Penilai</th>
				</tr>		
			</thead>	
			<tbody>
				<tr>
					<td rowspan="9">1</td>
					<td rowspan="9" width="20%"><?php echo $format->tanggal_indo($perilaku->periode_awal) ?> s.d <br><?php echo $format->tanggal_indo($perilaku->periode_akhir) ?></td>
					<td colspan="3">
						Penilaian SKP sampai dengan <?php echo $format->tanggal_indo($perilaku->periode_akhir) ?> = <?php echo $skp->get_nilai_capaian($_GET['idskp'])->rata2_nilai_skp ?> , <br>
						sedangkan penilaian perilaku kerjanya adalah sebagai berikut :	
					</td>
					<td rowspan="9" style="vertical-align:middle" class="text-center">
						<span><?php  echo $perilaku->jabatan_penilai ?></span>
						<br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
						<br>
						<span>NIP. <?php echo $penilai->nip_baru ?></span>
					</td>
				</tr>
				<tr>
					
					<td width="10%">				
						Orientasi Pelayanan  </td>
					<td class="text-center"><?php echo $perilaku->orientasi_pelayanan ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->orientasi_pelayanan) ?>)</td>					
				</tr>
				<tr>					
					<td>						
						Integritas  </td>
					<td class="text-center"><?php echo $perilaku->integritas ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->integritas) ?>)</td>
					
				</tr>
				<tr>					
					<td>						
						komitmen  </td>
					<td class="text-center"><?php echo $perilaku->komitmen ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->komitmen) ?>)</td>
					
				</tr>
				<tr>
					<td>						
						Disiplin  </td>
					<td class="text-center"><?php echo $perilaku->disiplin ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->disiplin) ?>)</td>
					
				</tr>
				<tr>					
					<td>						
						Kerjasama  </td>
					<td class="text-center"><?php echo $perilaku->kerjasama ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->kerjasama) ?>)</td>
					
				</tr>
				<tr>					
					<td>						
						Kepemimpinan  </td>
					<td class="text-center"><?php echo $perilaku->kepemimpinan ? $perilaku->kepemimpinan : "-" ?></td>
					<td class="text-center"><?php echo $perilaku->kepemimpinan ? "(".$skp->sebutan_capaian($perilaku->kepemimpinan).")" : "-" ?></td>
					
				</tr>
				<tr>
					<td>						
						JUMLAH  </td>
					<td class="text-center"><?php echo $perilaku->jumlah_perilaku ?></td>
					<td></td>
					
				</tr>
				<tr>
					<td>						
						Nilai Rata-rata  </td>
					<td class="text-center"><?php echo number_format($perilaku->rata2_perilaku,2) ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->rata2_perilaku) ?>)</td>					
				</tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">
		<a href="#skp_perilaku_form" data-toggle="modal" class="btn btn-primary btn-perilaku">berikan penilaian</a>
		<a href="index.php?page=listofperilaku" class="btn btn-warning">kembali</a>		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>		
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_perilaku_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Penilaian Perilaku PNS<h5>
			</div>
			<form role="form" class="form-horizontal" id="perilakuForm">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">						
							<div class="form-group">
								<label for="inputOrientasiPelayanan" class="col-sm-6 control-label">Orientasi Pelayanan</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" id="orientasipelayanan" name="orientasipelayanan" value="<?php echo $perilaku->orientasi_pelayanan ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputIntegritas"  class="col-sm-6 control-label">Integritas</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" name="integritas" id="inputIntegritas" value="<?php echo $perilaku->integritas ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputKomitmen" class="col-sm-6 control-label">Komitmen</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" name="komitmen" id="inputKomitmen" value="<?php echo $perilaku->komitmen ?>">							
								</div>						
							</div>
							<div class="form-group">
								<label for="inputDisiplin" class="col-sm-6 control-label">Disiplin</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" name="disiplin" id="inputDisiplin" value="<?php echo $perilaku->disiplin ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="inputKerjasama" class="col-sm-6 control-label">Kerjasama</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" name="kerjasama" id="inputKerjasama" value="<?php echo $perilaku->kerjasama ?>">
								</div>						
							</div>
							<div class="form-group">
								<label for="inputKepemimpinan" class="col-sm-6 control-label">Kepemimpinan</label>
								<div class="col-sm-6">
									<input type="txt" class="form-control" name="kepemimpinan" <?php echo isset($obj_pegawai->get_obj($_GET['idp'])->id_j) ? "" : "readonly"; ?> id="inputKepemimpinan" value="<?php echo $perilaku->kepemimpinan ?>">
									<input type="hidden" name="aksi" id="aksi" value="savePerilaku">
									<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">
								</div>
							</div>
						
					</div>
					<div class="col-md-6">
						<h4>Keterangan :</h4>
						<ol type="a">
							<li>91 - Keatas  : Sangat Baik</li>
							<li>76 - 90      : Baik</li>
							<li>61 - 75      : Cukup</li>
							<li>51 - 60      : Kurang</li>
							<li>50 - kebawah : Buruk</li>
						</ol>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a id="btnPerilaku" class="btn btn-primary" value="simpan">simpan</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
			</form>
		</div>
	</div>
</div>
<!-- MODAL PENILAIAN -->

<script>
	
	$(document).ready(function(){
	
		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");
				
	});
	
	$("#btnPerilaku").on("click",function(){
				
		$.post("skp.php", $("#perilakuForm").serialize())		
		.done(function(data){
			//alert(data);
			window.location.reload();
		});
		
	});
	
	

</script>
<script src="skp.js"></script>

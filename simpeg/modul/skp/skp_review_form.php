<div id="onPrint">

</div>
<?php

	$bawahan = $obj_pegawai->get_obj($_GET['idp']);
?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Review Sasaran Kerja Pegawai</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">SASARAN KERJA PEGAWAI</h5>
	</div>
	<div id="drafttarget" class="draft visible-print">
		<h1><strong>-- D R A F T -- D R A F T --</strong></h1>
	</div>
	<div class="panel-body" id="printtest">
		<div class="">
		<table class="clearfix table table-bordered ">
			<tr>
				<td width="2%"><strong>NO</strong></td>
				<td colspan="2" width="48%"><strong>I. PEJABAT PENILAI</strong></td>
				<td width="2%"><strong>NO</strong></td>
				<td colspan="5" width="48%"><strong>I. PEGAWAI NEGERI SIPIL YANG DINILAI</strong></td>
			</tr>
			<tr>
				<td>1.</td>
				<td width="10%">Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>
				<td>1.</td>
				<td width="10%">Nama</td>
				<td colspan="4"><?php echo $bawahan->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>2.</td>
				<td>NIP</td>
				<td><?php echo $penilai->nip_baru ?></td>
				<td>2.</td>
				<td>NIP</td>
				<td colspan="4"><?php echo $bawahan->nip_baru ?></td>
			</tr>
			<tr>
				<td>3.</td>
				<td>Pangkat/Gol.ruang</td>
				<td><?php echo isset($theSkp->gol_penilai) ? $theSkp->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol; //echo $theSkp->gol_penilai ?></td>
				<td>3.</td>
				<td>Pangkat/Gol.ruang</td>
				<td colspan="4"><?php echo isset($theSkp->gol_pegawai) ? $theSkp->gol_pegawai : $bawahan->pangkat." - ".$bawahan->pangkat_gol; ?></td>
			</tr>
			<tr>
				<td>4.</td>
				<td>Jabatan</td>
				<td><?php echo $obj_pegawai->get_jabatan($penilai) ?></td>
				<td>4.</td>
				<td>Jabatan</td>
				<td colspan="4"><?php echo $theSkp->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td><?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_penilai)->nama_baru ?></td>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_pegawai)->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="2" class="text-center"><strong>NO</strong></td>
				<td colspan="2" class="text-center" rowspan="2"><strong>III. URAIAN TUGAS</strong></td>
				<td rowspan="2" class="text-center"><strong>AK</strong></td>
				<td colspan="5" class="text-center"><strong>TARGET</strong></td>
			</tr>
			<tr>
				<td>Kuantitas</td>
				<td>Kualitas</td>
				<td>Waktu</td>
				<td>Biaya</td>
				<td class="hidden-print"><span class="glyphicon glyphicon-cog"></span></td>
			</tr>
			<!-- ini baris uraian tugas -->
			<?php
				$list_target = $skp->get_target($_GET['idskp']);
				$x = 1;
				while($target = mysqli_fetch_object($list_target)){
			?>
			<tr>
				<td><?php echo $x++ ?></td>
				<td colspan="2" class="editable"><?php echo $target->uraian_tugas ?></td>
				<td><?php echo $target->angka_kredit ?></td>
				<td><?php echo $target->kuantitas." ".$target->kuantitas_satuan ?></td>
				<td><?php echo $target->kualitas ?> %</td>
				<td><?php echo $target->waktu." ".$target->waktu_satuan ?></td>
				<td>~</td>
				<td style="padding-right:0px" class="hidden-print">
					<a href="#skp_review_butir_form" value="1" data-toggle="modal">
						<small><span data-toggle="tooltip" title="edit" class="glyphicon glyphicon-edit"></span></small>
					</a>
				</td>
			</tr>
			<?php } ?>
			<tr class="review">
				<td colspan="9"><strong>Catatan Pejabat Penilai :</strong></td>
			</tr>
			<tr class="review">
				<td colspan="9">
					<form>
						<div class="editable col-md-11 review" id="reviewPenilai">
							<?php
								echo $skp->get_skp_by_id($_GET['idskp'])->review;
							?>

						</div>
						<div class="hidden-print col-md-1">
							<a class="btn btn-info btn-reviewtarget" id="btnSimpanReviewSkp">simpan</a>
						</div>
					</form>
				</td>
			</tr>
			<!-- akhir uraian tugas -->
		</table>
		</div>
		<div class="penandatangan visible-print">
			<table class="table table-noborder">
				<tr>
					<td class="text-center" width="30%">
						<br>Pejabat Penilai,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$penilai->nip_baru ?>
					</td>
					<td width="40%"></td>
					<td class="text-center">
						Bogor, <?php echo $format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_awal) ?>
						<br>Pegawai yang dinilai,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $bawahan->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$bawahan->nip_baru ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="panel-footer hidden-print">
		<a href="#" class="btn btn-warning btn-reviewtarget" type="button" onclick="setStatus(2)">Koreksi</a>
		<a href="#skp_add_form" data-toggle="modal" class="btn btn-primary btn-reviewtarget" onclick="setStatus(3)">setuju</a>
		<a href="#" class="btn btn-info" type="button" id="cetak" onclick="window.print()"><span data-toggle="tooltip" title="print" class="glyphicon glyphicon-print"></a>
		<a class="btn btn-warning" type="button" id="btnExport">Export</a>
		<a href="#" class="btn btn-danger hide" id="btn-cancelTarget" type="button" onclick="setStatus(1)">Batalkan Persetujuan Target</a>
		<span class="pull-right">
			status : <span class="danger"><?php echo $skp->get_status($skp->get_skp_by_id($_GET['idskp'])->status_pengajuan)->status ?></span>
		</span>
	</div>
</div>
<!-- catatan per butir kegiatan -->


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_review_butir_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Review per butir kegiatan<h5>
			</div>
			<div class="modal-body">
				<form role="form" >
					<div class="form-group">
						<label for="inputUraian" >Catatan Penilai</label>
						<textarea rows="3" class="form-control" id="inputReviewGlobal" ></textarea>
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

<script>
	$(document).ready(function(){

	$("#btnExport").click(function (e) {
		//window.open('data:application/vnd.ms-excel,' + $('#printtest').html());
		//e.preventDefault();
		window.open('<?php echo BASE_URL."modul/skp/skp_review_form_xlsx.php&idskp=".$_GET['idskp'] ?>');
	});

		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");
		$(".review").addClass("hidden-print");


	});

	tinymce.init({
			selector: "div.editable",
			inline:true

		});
	tinymce.init({
			selector: "textarea"
		});

	$("#btnSimpanReviewSkp").on('click',function(data){

		var content = tinyMCE.get('reviewPenilai').getContent();
		//$("#reviewPenilai").val();
		//alert(isi);
		$.post("skp.php",{
			aksi:"saveReviewSkp",
			review: content,
			idskp: "<?php echo $_GET['idskp'] ?>"
		})
		.done(function(e){
			alert(e);
		});

	});

</script>
<script src="skp.js"></script>

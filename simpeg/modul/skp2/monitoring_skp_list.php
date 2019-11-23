<?php

	$opd = new Unit_kerja;
?>
<div class="panel panel-default hidden-print" >
	<div class="panel-heading">
		<div class="panel-title">Pencarian Penilaian Prestasi</div>
	</div>
	<div class="panel-body" style="padding:10px">
		<form role="form" class="form-horizontal"  id="formCariSkp">			
			<div class="form-group">
				<label for="inputUraian" class="col-sm-3 control-label">Unit Kerja</label>
				<div class="col-sm-9">
					<input type="txt" class="form-control" id="nama_opd" name="nama_opd" placeholder="Cari Unit Kerja"
					value ="<?php if(isset($_GET['uk'])){ echo $opd->get_unit_kerja($_GET['uk'])->nama_baru; } ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="inputUraian" class="col-sm-3 control-label">Periode Penilaian</label>
				<div class="col-sm-9">
					<input type="txt" class="form-control" id="inputUraian" name="inputUraian" >
				</div>
			</div>
		</form>
	</div>
	<div class="panel-footer">
		<a href="#" class="btn btn-primary">GO!</a>
	</div>
</div>

<?php if(isset($_GET['uk'])){ ?>

<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Monitoring Penilaian Prestasi Kerja</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR MONITORING <br> PENILAIAN PRESTASI KERJA PNS</h5>
	</div>
	<div class="panel-body">		
		<table class="clearfix table table-bordered table-striped table-hover" style="border-collapse:collapse;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>NIP</th>
					<th>Pangkat/Gol.ruang</th>
					<th>Jabatan</th>										
				</tr>				
			</thead>
			<tbody>
				<?php							
					
					$x=1;
					$daftar = $opd->daftar_pegawai($_GET['uk']);	
					while($pnses = mysql_fetch_object($daftar)) {
						$pns = $obj_pegawai->get_obj($pnses->id_pegawai);
				?>				
				<tr data-toggle="collapse" data-target="<?php echo ".".$pns->id_pegawai ?>">
					<td><?php echo $x++; ?></td>
					<td><?php echo $pns->nama_lengkap ?></td>
					<td><?php echo $pns->nip_baru ?></td>
					<td><?php echo $pns->pangkat." - ".$pns->pangkat_gol ?></td>
					<td><?php echo $obj_pegawai->get_jabatan($pns) ?></td>
				</tr>	
					
				<?php if($skp_list =  $skp->get_skp($pns->id_pegawai)){ ?>
						
					<?php while($theSkp = mysql_fetch_object($skp_list)){ ?>		
							
						<tr><td colspan="8" class="hiddenRow"><div class="collapse <?php echo $pns->id_pegawai ?>">
							Periode : <?php echo $theSkp->periode_awal." - ".$theSkp->periode_awal.", Status :".$skp->get_status($theSkp->status_pengajuan)->status ?>
							<a href="#"  onclick="show_skp(<?php echo $theSkp->id_skp ?>)" class="btn btn-primary btn-xs pull-right">lihat</a>
						</div></td></tr>
						
					<?php }} else{
							echo " Tidak ada data ";
						}
						
					?>		
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>		
	</div>	
</div>
<?php } ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="modal fade " id="uraian" role="dialog">
	<div class="modal-dialog " style="width: 95%">
		<div class="modal-content">
			<div class="modal-header">
				MONITORING PENILAIAN PRESTASI KERJA				
			</div>
			<div class="modal-body" id="skp_konten">BOO</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-dismiss="modal">tutup</a>
			</div>
		</div>
	</div>
</div>





<script>
	
	$(document).ready(function(){
	
		$('.collapse').on('show.bs.collapse', function () {
			$('.collapse.in').collapse('hide');
		});
		
		//
		$(".in").removeClass("in");
		$("#collapseConfig").addClass("in");
		
						
		$( "input[name='nama_opd']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
                    window.location.replace("index.php?page=monitoring&uk="+ui.item.id);
                                           
			}
		});
	});
	
	function show_skp(id){
		var aksi = null;
		$("#skp_konten").load("monitoring_kegiatan.php", {idskp:id, aksi:aksi } );		
		$("#uraian").modal("show");
	}

</script>
<script src="skp.js"></script>

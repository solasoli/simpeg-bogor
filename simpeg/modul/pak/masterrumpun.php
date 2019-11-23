<?php $rumpuns = $objPAK->get_rumpun_all(); ?>

<h3 class="page-title">RUMPUN JABATAN FUNGSIONAL</h3>

<div class="btn-group" role="group" aria-label="...">
  <button type="button" class="btn btn-default" onclick="tambah()" >TAMBAH</button>
  <button type="button" class="btn btn-default">Middle</button>
  <button type="button" class="btn btn-default">Right</button>
</div>

<div class="responsive-table">
	<table class="table table-bordered" id="table-rumpun">
		<thead>
			<tr>
				<th>No</th>
				<th>Rumpun JFT</th>
				<th>AKSI</th>
			</tr>			
		</thead>
		<tbody>			
			<?php $no=1;foreach($rumpuns as $rumpun){ ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $rumpun->rumpun ?> </td>
				<td>
					<a class="btn btn-primary btn-xs">EDIT</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<div class="modal fade " id="popup" role="dialog">
	<div class="modal-dialog " >
		<div class="modal-content">
			<div class="modal-header">
				TAMBAH RUMPUN				
			</div>
			<div class="modal-body" id="skp_konten">
				<form class="form">
					<div class="form-group">
						<label for="inputUraian" class="col-sm-3 control-label">RUMPUN</label>
						<div class="col-sm-9">
							<input type="txt" class="form-control" id="rumpun" name="rumpun" placeholder="rumpun JFT">
						</div>
					</div>
				</form>
			</div>
			<br>
			<div class="modal-footer">
				<a class="btn btn-danger" data-dismiss="modal">tutup</a>
			</div>
		</div>
	</div>
</div>
<!--+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->
<script type="text/javascript">
	$("document").ready(function(){
		
	});
	
	function tambah(){
		$("#popup").modal("show");
	}
	
</script>
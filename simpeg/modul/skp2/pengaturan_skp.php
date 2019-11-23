<?php

	$opd = new Unit_kerja;
	echo "<pre>";
	//print_r($penilai);
	echo "</pre>";
	
	//echo "penilai : ".$penilai->nama;
?>

<div class="panel panel-default hidden-print" >
	<div class="panel-heading">
		<div class="panel-title">Pengaturan</div>
	</div>
	<div class="panel-body" style="padding:10px">
		<form role="form" class="form-horizontal"  id="formPenilai" name="formPenilai">
			<div class="form-group">
				<label for="selectOpd" class="col-sm-3 control-label">Pejabat Penilai</label>
				<div class="col-sm-5">
					<!--input type="txt" class="form-control" id="inputUraian" name="inputUraian" placeholder="Uraian Tugas"-->
					<select class="form-control" name="penilai" id="penilai">
						<?php 
							$penilai = $skp->get_penilai($pegawai);
							if($penilai){
								echo "<option value=".$penilai->id_j.">".$penilai->jabatan."</option>";
							}else{
								echo "<option>--Pilih--</option>";
							}
														
							foreach($opd->get_list_jabatan($pegawai->id_unit_kerja) as $jab){
								
								echo "<option value='".$jab->id_j."'>".$jab->jabatan."</option>";
							}
														
						?>						
					</select>					
				</div>
			</div>
			<div class="form-group">
				<label for="selectOpd" class="col-sm-3 control-label">Pejabat Penilai</label>
				<div class="col-sm-5">
					<input type="txt" class="form-control" id="inputUraian" name="inputUraian" placeholder="pejabat penilai">							
				</div>
			</div>			
		</form>
	</div>
	<div class="panel-footer">
		<a id="btnPenilai" onclick="simpan()" name="btnPenilai" class="btn btn-primary">Simpan</a>
	</div>
</div>

<script src="skp.js"></script>
<script>
	
	function simpan(){
		//alert("test");
		var penilai = $("#penilai").val();
		alert(penilai);
	}
</script>

<a class="btn btn-primary" onclick="show_modal()">Tambah</a>
<div class="modal fade" id="sk_add" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tambah SK </h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="form_sk">					
					<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-6 ">
						<div class="form-group">
							<label for="penilai">Jenis SK</label>
							 <select name="jnk" id="jnk" class="form-control">
								<?php
								 $qks2=mysql_query("SELECT * FROM `kategori_sk`");
								while($da=mysql_fetch_array($qks2))
								echo("<option value=$da[0]>$da[1]</option>");
								?>
						   </select>						
						</div>
						<div class="form-group">
							<label for="nama_penilai">NO SK</label>						
							<input type='text' name='no_sk' id='no_sk' class='form-control' > 
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol</label>
							 <select class="form-control" name="gol_sk_<? echo($k); ?>" id="gol_sk_<? echo($k); ?>" style="width:160px;" >
								<option value="">Silahkan Pilih</option>
								<?php
									foreach ($arrGol as $optGol){
										if($optGol['val']==$cu[gol]) {
											echo("<option value=" . $optGol['val'] . " selected>" . $optGol['title'] . "</option>");
										}else{
											echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">							
							<label for="Masa Kerja">Masa Kerja Tahun</label>							
							<input type=text id=thn_mkg name=thn_mkg class="col-md-1 form-control" /> 							
						</div>
						<div class="form-group">							
							<label for="Masa Kerja">Masa Kerja Bulan</label>
							<input type=text id=bln_mkg name=bln_mkg class="col-md-1 form-control" />
						</div>
						
						</div>				
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Simpan</a>
				<a class="btn btn-danger" data-dismiss="modal">Batal</a>
			</div>
		</div>
	</div>
</div>
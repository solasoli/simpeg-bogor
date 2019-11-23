
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Ubah Keluarga</h4>
			</div>
			<div class="modal-body">
				
					
					<!--div class="input-group date">
						<input type="text" class="form-control" value="01-01-2016" id="datepicker">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>
					</div-->
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $keluarga->nama?>" name="nama">
					</div>
				</div>
				<div class="form-group">
					<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
					<div class="col-sm-8">
						<input type="text" class="form-control " value="<?php echo $keluarga->tempat_lahir ?>" name="tempat_lahir" >									
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
					<div class="col-sm-8 date">
						<input id="dp_tgl_lahir" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_lahir; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lahir">
					</div>
				</div>
				<div class="form-group">
					<label for="tempat_lahir" class="col-sm-4 control-label">NIK</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $keluarga->nik ?>" name="nik">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_menikah" class="col-sm-4 control-label" >Tanggal Menikah</label>
					<div class="col-sm-8" >
						<input id="dp_tgl_menikah" name="dp_tgl_menikah" type="text" class="form-control datepicker" value="<?php echo $keluarga->tgl_menikah //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_menikah">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_menikah" class="col-sm-4 control-label" >Akte Menikah</label>
					<div class="col-sm-8" >
						<input type="text" class="form-control datepicker" value="<?php echo $keluarga->akte_menikah ?>" name="akte_menikah">
					</div>
				</div>
				
				<div class="form-group">
					<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
					</div>
				</div>
				<div class="form-group">
					<label for="jk" class="col-sm-4 control-label">Jenis Kelamins</label>
					<div class="col-sm-8">
					
					<select name="jk" class="form-control">
							<option value=1 <?php if($keluarga->jk==1) echo " selected";  ?>>Laki-laki</option>
							<option value=2 <?php if($keluarga->jk==2) echo " selected";  ?>>Perempuan</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_menikah" class="col-sm-4 control-label" >Tanggal Cerai</label>
					<div class="col-sm-8" >
						<input id="dp_tgl_cerai" type="text" class="form-control datepicker" value="<?php echo $keluarga->tgl_cerai //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_menikah">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_menikah" class="col-sm-4 control-label" >Akte Cerai</label>
					<div class="col-sm-8" >
						<input type="text" class="form-control datepicker" value="<?php echo $keluarga->akte_cerai ?>" name="akte_cerai">
					</div>
				</div>
				<div class="form-group">
					<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $keluarga->keterangan ?>" name="keterangan">
					</div>		
				</div>
				
				<div class="form-group">
					<label for="dapat_tunjangan" class="col-sm-4 control-label">Dapat Tunjangan</label>			
					<div class="col-sm-8">
					<select name="dapat_tunjangan"  id="dapat_tunjangan" class="form-control">
						<?php
							 if($keluarga->dapat_tunjangan == 1 || $keluarga->dapat_tunjangan == 0){
								 echo "<option value='".$keluarga->dapat_tunjangan."'>".($keluarga->dapat_tunjangan == 1 ? 'Dapat' : 'Tidak dapat' )."</option>";
							 }else{
								 echo "<option>Pilih</option>";
							 }					
						?>
						<option value=0>Tidak dapat tunjangan</option>
						<option value=1>Dapat tunjangan</option>
					</select>	
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="btnCetakSkum" onclick="openCetakSKUM();" type="button" class="btn btn-info">Cetak</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			</div>
		</div>

	</div>
</div>
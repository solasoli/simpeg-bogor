<?php

	$cpns = $obj_pegawai->get_cpns($pegawai->id_pegawai);
	list($gol_cpns,$thn_cpns,$bln_cpns) = explode(',', $cpns->keterangan);
	$mk = $obj_pegawai->hitung_masakerja($cpns->tmt, $thn_cpns, $bln_cpns);
	$mk_gol = $obj_pegawai->hitung_masakerja_golongan($mk,$gol_cpns, $pegawai->pangkat_gol);
	
	
?>

<!-- Build page from here: -->
</br>
<div class="row col-md-12">
	<div class="col-md-7">		
		<!--form class="form-horizontal" role="form"-->
			<div class="form-group">
				<label class="col-md-4 control-label" for="nama">Nama Lengkap</label>
				<div class="col-md-8">
					<input name="n" class="form-control" id="n" type="text" value="<?php echo $pegawai->nama ?>" />                                   
				</div>
			</div><!-- End .form-group  -->			
			<div class="form-group">
				<label class="col-md-4 control-label" for="gelar_depan">Gelar</label>
				<div class="col-md-4">
					<input class="form-control"  name="gelar_depan" id="gelar_depan" type="text" value="<?php echo $pegawai->gelar_depan ?>" placeholder="gelar depan"/>
				</div>
				<div class="col-md-4">
					<input class="form-control"  name="gelar_belakang" id="gelar_belakang" type="text" value="<?php echo $pegawai->gelar_belakang ?>" placeholder="gelar belakang"/>
				</div>
			</div><!-- End .form-group  -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="nl">NIP Lama</label> 
				<div class="col-md-8">
					<input class="form-control" id="nl" name="nl" type="text" value="<?php echo $pegawai->nip_lama ?>" />
				</div>
			</div><!-- End .form-group  -->
			
			<div class="form-group">
				<label class="col-md-4 control-label" >NIP Baru</label>
				<div class="col-md-8">
					<input class="form-control" id="nb" name="nb" type="text" value="<?php echo $pegawai->nip_baru ?>" />
				</div>
			</div><!-- End .form-group  -->
			
			<div class="form-group">
				<label class="col-md-4 control-label" for="tl">Tempat, Tanggal Lahir</label>
				<div class="col-md-4">
					<input class="form-control" id="tl" name="tl" type="text" value="<?php echo $pegawai->tempat_lahir ?>" />
				</div>
				<div class="col-md-4">
					<input class="form-control"  type="text" id="tgl" name="tgl" value="<?php echo $pegawai->tgl_lahir ?>" />
				</div>
			</div><!-- End .form-group  -->
			
			<div class="form-group">
				<label class="col-md-4 control-label" >Agama</label>
				<div class="col-md-8">
					<input class="form-control"  id="a" name="a" type="text" value="<?php echo $pegawai->agama ?>" />
				</div>
			</div><!-- End .form-group  -->                           

			<div class="form-group">
				<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin</label>
				<div class="col-md-8">					
					<div class="radio">
						<label>
						<input type="radio" name="jk" id="jk1" value="L" <?php echo $pegawai->jenis_kelamin == 'L' ? 'checked' : ''?>>
						Laki-laki 
						</label>
					</div>
					<div class="radio">
						<label>
						<input type="radio" name="jk" id="jk2" value="P" <?php echo $pegawai->jenis_kelamin == 'P' ? 'checked' : ''?>>
						Perempuan
						</label>
					</div>
				</div>
			</div><!-- End .form-group  -->
			<div class="form-group">
				<label class="col-md-4 control-label" >No Telp / Ponsel</label>
				<div class="col-md-4">
					<input class="form-control"  type="text" value="<?php echo $pegawai->telepon?>" />
				</div> 
				<div class="col-md-4">
					<input class="form-control"  type="text" value="<?php echo $pegawai->ponsel ?>" />
				</div>
			</div><!-- End .form-group  -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="email">Email</label>
				<div class="col-md-8">
					<input class="form-control"  id="email" name="email" type="text" value="<?php echo $pegawai->email ?>" />
				</div>
			</div><!-- End .form-group  -->  							
			<div class="form-group">
				<label class="col-md-4 control-label" for="al">Alamat</label>
				<div class="col-md-8">
					<textarea class="form-control" name="al" id="al" rows="3" value="<?php echo $pegawai->alamat ?>" cols="5"><?php echo $pegawai->alamat ?></textarea>
				</div>
			</div><!-- End .form-group  -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="kota" >Kota</label>
				<div class="col-md-8">
					<input class="form-control"  type="text" id="kota" name="kota" value="<?php echo $pegawai->kota ?>" />
				</div>
			</div><!-- End .form-group  -->                         
			<div class="form-group">
				<label class="col-md-4 control-label" >Golongan Darah</label>
				<div class="col-md-8">
					<div class="radio-inline">
						<label>
						<input type="radio" name="darah" id="darah1" value="A" <?php echo $pegawai->gol_darah == 'A' ? 'checked' : ''?>>
						A 
						</label>
					</div>
					<div class="radio-inline">
						<label>
						<input type="radio" name="darah" id="darah2" value="B" <?php echo $pegawai->gol_darah == 'B' ? 'checked' : ''?>>
						B
						</label>
					</div>
					<div class="radio-inline">
						<label>
						<input type="radio" name="darah" id="darah3" value="AB" <?php echo $pegawai->gol_darah == 'AB' ? 'checked' : ''?>>
						AB
						</label>
					</div>
					<div class="radio-inline">
						<label>
						<input type="radio" name="darah" id="darah4" value="O" <?php echo $pegawai->gol_darah == 'O' ? 'checked' : ''?>>
						O
						</label>
					</div>
				</div>
			</div><!-- End .form-group  -->                        
			<div class="form-group">
				<label class="col-md-4 control-label" >No. Karpeg</label>
				<div class="col-md-8">
					<input class="form-control"  id="karpeg" name="karpeg" type="text" value="<?php echo $pegawai->no_karpeg ?>" />
				</div>
			</div><!-- End .form-group  -->
			<div class="form-group">
				<label class="col-md-4 control-label" >NPWP</label>
				<div class="col-md-8">
					<input class="form-control"  type="text" id="npwp" name="npwp" value="<?php echo $pegawai->npwp ?>"/>
				</div>
			</div><!-- End .form-group  -->  
			
						

		<!--/form-->
	  
	</div><!-- End .span10 -->
	<div class="col-md-5">		
		<div class="row">
			<div class="col-md-12">
				<?php
				if(file_exists("../simpeg/foto/$od.jpg")){
					echo "
						<div align=center>
							<img src='./foto/$od.jpg' width='100px' />
						</div>";
				}
				?>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12 table-responsive">
				
				<!--form class="form-horizontal" role="form"-->
				<table class="table table-striped table-bordered table-hover">					
						<tr>
							<td class="col-md-5"><strong>Pangkat, Gol/ruang</strong></td>
							<td><?php echo $pegawai->pangkat_gol ?></td>
						</tr>
						<tr>
							<td><label class="control-label">Berlaku TMT</label></td>
							<td><?php echo "-" ?></td>
						</tr>						
						<tr>
							<td><label class="control-label">Masa Kerja Seluruh</label></td>
							<td><?php echo $mk['tahun'] .' Tahun, '.$mk['bulan'].' Bulan'?></td>
						</tr>
						<tr>
							<td><label class="control-label">Masa Kerja Gol</label></td>
							<td><?php echo $mk_gol['tahun'] .' Tahun, '.$mk_gol['bulan'].' Bulan'?></td>
						</tr>
						<tr>
							<td><label class="control-label">Jenjang jabatan</label></td>
							<td></td>
						</tr>
						<tr>
							<td><label class="control-label">Jabatan</label></td>
							<td><span><?php echo $obj_pegawai->get_jabatan($pegawai) ?></span></td>
						</tr>
						<tr>
							<td><label class="control-label">TMT Jabatan</label></td>
							<td></td>
						</tr>
						<tr>
							<td><label class="control-label">Unit Kerja</label></td>
							<td><span><?php echo $obj_pegawai->get_unit_kerja($pegawai->id_pegawai)->nama_unit_kerja ?></span></td>
						</tr>
						<tr>
							<td><label class="control-label">Pendidikan terakhir</label></td>
							<td></td>
						</tr>
						<tr>
							<td><label class="control-label">Status pegawai</label></td>
							<td><?php echo $pegawai->status_pegawai ?></td>
						</tr>
						<tr>
							<td><label class="control-label">Jenis Pegawai</label></td>
							<td><?php echo $pegawai->jenis_pegawai ?></td>
						</tr>
						<tr>
							<td><strong>Tgl Pensiun Reguler</strong></td>
							<td><?php echo $obj_pegawai->get_pensiun($pegawai) ?></td>
						</tr>
				</table>
				<!--/form-->
			</div>
		</div>
	</div>
</div><!-- End .row -->
				

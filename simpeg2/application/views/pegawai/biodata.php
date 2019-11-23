<!--<div class="grid fluid">-->
<div class="row">
	<div class="span6">
	<fieldset>
		<legend><h2>Biodata</h2></legend>
		<table class="table hovered" >
			<tr>
				<th class="span4 text-right">Nama</th>
				<td><?php echo $pegawai->nama ?></td>
				<td></td>
			</tr>	
			<tr>
				<th class="span4 text-right">Gelar depan</th>
				<td><?php echo ($pegawai->gelar_depan==''?'-':$pegawai->gelar_depan); ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Gelar belakang</th>
				<td><?php echo $pegawai->gelar_belakang ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Tempat, Tanggal Lahir</th>
				<td><?php echo $pegawai->tempat_lahir.", ".$pegawai->tgl_lahir ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Agama</th>
				<td><?php echo $pegawai->agama ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Jenis Kelamin</th>
				<td><?php echo $pegawai->jenis_kelamin == '1' ? 'Laki-laki' : 'Perempuan'  ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">No. Telepon</th>
				<td><?php echo $pegawai->telepon  ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">No. Ponsel</th>
				<td><?php  echo $pegawai->ponsel ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">NPWP</th>
				<td><?php echo $pegawai->NPWP ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Email</th>
				<td><?php echo $pegawai->email ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Alamat</th>
				<td><?php echo $pegawai->alamat ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Kota</th>
				<td><?php echo $pegawai->kota ?></td>
				<td></td>
			</tr>
			<tr>
				<th class="text-right">Golongan darah</th>
				<td><?php echo $pegawai->gol_darah ?></td>
				<td></td>
			</tr>
		</table>
		</fieldset>	
	</div>
	
	<div class="span6">
	<fieldset>
		<legend><h2 class="text-right">Data Kepegawaian</h2></legend>
			<table class='table hovered' >
				<tr>
					<th class="text-right">NIP</th>
					<td><?php echo $pegawai->nip_baru ?></td>
					<td align="right"></td>
				</tr>
				<tr>
					<th class="text-right">NIP Lama</th>
					<td><?php echo $pegawai->nip_lama ?></td>
					<td align="right"></td>
				</tr>
				<tr>
					<th class="text-right">Pangkat, Golongan/ruang</th>
					<td><?php echo $this->pegawai->get_pangkat_gol($pegawai->id_pegawai)->pangkat_gol ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">TMT</th>
					<td><?php echo $this->format->tanggal_indo($this->pegawai->get_pangkat_gol($pegawai->id_pegawai)->tmt) ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">Rumpun Jabatan</th>
					<td><?php echo $pegawai->jenjab ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">Jabatan</th>
					<td><?php echo $this->jabatan->get_jabatan_pegawai($pegawai->id_pegawai);  ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">eselonering</th>
					<td><?php echo ($pegawai->id_j == ''?'-':($this->jabatan->get_jabatan($pegawai->id_j)->eselon)); ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">Jabatan Atasan</th>
					<td>
                        <?php
                        if (isset($atasan) and $atasan!=NULL and sizeof($atasan) > 0 and $atasan != '') {
                            foreach ($atasan as $lsdata) {
                                $nip_baru_atsl = $lsdata->nip_baru_atsl;
                                $nama_atsl = $lsdata->nama_atsl;
                                $gol_atsl = $lsdata->gol_atsl;
                                $jabatan_atsl = $lsdata->jabatan_atsl;
                            }
                            echo $jabatan_atsl.' (<strong>'.$nama_atsl.'</strong> NIP: '.$nip_baru_atsl.')';
                        }else{
                            echo 'Atasan tidak ditemukan';
                        }
                        ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">Unit Kerja</th>
					<td><?php echo $this->skpd->get_by_id($pegawai->id_unit_kerja)->nama_baru." (".$pegawai->id_unit_kerja.") " ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">OPD</th>
					<td><?php echo $this->skpd->get_by_id($pegawai->id_skpd)->nama_baru." (".$pegawai->id_skpd.") " ?></td>
					<td></td>
				</tr>
				<tr>
					<th class="text-right">id pegawai</th>
					<td><?php echo $pegawai->id_pegawai ?></td>
					<td></td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>

<!--</div>--><!-- end grid -->



<!-- end of file biodata.php -->
<!-- location .app/views/pegawai/ -->
